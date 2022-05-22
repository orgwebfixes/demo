<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\Models\ItemDesign;
use App\Models\Setting;
use App;
use Schema;
use Cache;
use Config;
use URL;
use Carbon\Carbon;
use App\Models\VaccumPlanner;
use App\Models\Transection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $timezone = Config::get('app.timezone', 'Asia/Calcutta');
        date_default_timezone_set($timezone);
        Validator::extend('less_than_or_equal', function ($attribute, $value, $parameters) {
            $other = \Input::get($parameters[0]);
            return isset($other) and floatval($value) <= floatval($other);
        });

        Validator::extend('check_design_no_exist', function ($attribute, $value, $parameters, $validator) {
            $design_no = $value;
            $result = ItemDesign::where('design_no', $design_no)->count();
            if ($result) {
                return true;
            }
            return false;
        });
        Validator::extend('validate_field_existing', function ($attribute, $value, $parameters, $validator) {
            $input = '';
            $count = 0;
            $input = \Input::get('diamond_items');
            foreach ($input as $key => $value) {
                if ($key != $parameters[0]) {
                    if ($value['diamond_id'] == $input[$parameters[0]]['diamond_id'] && $value['type'] == $input[$parameters[0]]['type']) {
                        $count++;
                    }
                }
            }
            if ($count) {
                return false;
            }
            return true;
        });
        Validator::extend('product_validate_field_existing', function ($attribute, $value, $parameters, $validator) {
            $input = '';
            $count = 0;
            $input = \Input::get('challlan_products');
            foreach ($input as $key => $value) {
                if ($key != $parameters[0]) {
                    if ($value['product_id'] == $input[$parameters[0]]['product_id']) {
                        $count++;
                    }
                }
            }
            if ($count) {
                return false;
            }
            return true;
        });
        Validator::extend('unique_with', function ($attribute, $value, $parameters, $validator) {
            $date = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
            $data = VaccumPlanner::where('type', $parameters[0])->where(\DB::raw("DATE_FORMAT(vaccum_planners.date,'%Y-%m-%d')"), '=', $date)->get()->pluck('id')->toArray();
            if (!empty($data)) {
                return false;
            }
            return true;
        });
        Validator::extend('validate_currentpassword', function ($attribute, $value, $parameters, $validator) {
            if (!empty($value)) {
                $object = App::make("App\Http\Controllers\UserController");
                $result = $object->checkCurrentPassword($value);
                if ($result) {
                    return true;
                } else {
                    return false;
                }
            }
        });
        Validator::extend('required_one', function ($attribute, $value, $parameters, $validator) {
            $input = \Input::get('other_items');
            if (array_sum(array_column($input, 'weight')) == 0) {
                return false;
            }
            return true;
        });
        Validator::extend('combination_unique_validation', function ($attribute, $value, $parameters, $validator) {
            $input = \Input::all();
            $transection = Transection::where('type', $input['type'])->where('bag_no', $input['bag_no'])->where(\DB::raw("DATE_FORMAT(transections.date,'%d-%m-%Y')"), $input['date'])->where('from_process_id', $input['from_process_id'])->where('to_process_id', $input['to_process_id'])->where('tounch_id', $input['tounch_id'])->where('account_id', $input['account_id'])->where('gross_weight', $input['trans_gross_weight'])->where('total_gross_weight', $input['total_gross_weight']);
            if ($parameters[0]) {
                $transection = $transection->where('id', '!=', $parameters[0]);
            }
            $transection = $transection->first();
            if ($transection) {
                return false;
            }
            return true;
        });

        if (Schema::hasTable('settings')) {
            $cached_settings = Cache::remember('settings', 15, function () {
                return Setting::pluck('value', 'name')->toArray();
            });
            $cached_settings = Setting::pluck('value', 'name')->toArray();
            Config::set('srtpl.settings', $cached_settings);
        }

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
