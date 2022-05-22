<?php

namespace App\Repositories;

use App;
use App\Models\Basic;
use App\Models\CountryCodes;
use App\Models\Currency;
use App\Models\CurrencyCodes;
use App\Models\LanguageCodes;
use App\Models\TimeZone;
use App\Models\Topic;
use DB;

class GeneralRepo
{
    protected $contactModel;

    /**
     * [validateTableDependency description]
     * @param  [type] $dependency [description]
     * @param  [type] $id         [description]
     * @return [type]             [description]
     */
    public function validateTableDependency($dependency, $id)
    {
        $msg = [];
        if (!empty($dependency) && !empty($id)) {
            foreach ($dependency as $k => $row) {
                $row = (object) $row;
                $model = app()->make($row->model);
                if (isset($row->csv) && $row->csv) {
                    if ($model->whereRaw("find_in_set('" . $id . "'," . $row->field . ')')->count()) {
                        $msg[] = $k;
                    }
                } elseif ($model->where($row->field, $id)->count()) {
                    $msg[] = $k;
                }
            }
            if (!empty($msg)) {
                $msg = implode(', ', $msg);
            }
        }
        return $msg;
    }


    /**
     * [getClients description]
     * @return [type] [description]
     */
    public function getClients()
    {
        $models = Basic::select(['id', 'name'])->where('status', '1')->get()->toArray();
        $tags = [];
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $tags[$value['id']] = $value['name'];
            }
        }
        return $tags;
    }

    /**
     * [getTicketStatus description]
     * @return [type] [description]
     */
    public function getTicketStatus()
    {
        $models = TicketStatus::select(['id', 'name'])->get()->toArray();
        $tags = [];
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $tags[$value['id']] = $value['name'];
            }
        }
        return $tags;
    }

    /**
     * [getAllCurrency description]
     * @return [type] [description]
     */
    public function getAllCurrency()
    {
        $models = Currency::select(['id', 'name'])->where('status',1)->get()->toArray();
        $tags = [];
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $tags[$value['id']] = $value['name'];
            }
        }
        return $tags;
    }

    /** Different status compare to active & deactive - It consist the suspend and active
     * [getStatusNew description]
     * @return [type] [description]
     */
    public static function getStatusNew()
    {
        return ['1' => 'Active', '0' => 'Suspend'];
    }

    /** getstatus
     */
    public static function getstatus()
    {
        return ['1' => 'Active', '0' => 'Inactive'];
    }


    /**
     * [getLanguageCodes description]
     * @return [type] [description]
     */
    public function getLanguageCodes()
    {
        $models = LanguageCodes::select(['code', 'language'])->orderBy('language', 'asc')->get()->toArray();
        $tags = [];
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $tags[$value['code']] = $value['language'];
            }
        }
        return $tags;
    }

    /**
     * [getClientsForNewPropertyCreate description]
     * @return [type] [description]
     */
    public function getClientsForNewPropertyCreate()
    {
        $models = Basic::select(['property_id', 'name'])->where('status', '1')->orderBy('name', 'asc')->get()->toArray();
        $tags = [];
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $tags[$value['property_id']] = $value['name'];
            }
        }
        return $tags;
    }

    /**
     * [getCurrencyCodes description]
     * @return [type] [description]
     */
    public function getCurrencyCodes()
    {
        $models = CurrencyCodes::select(['code', 'currency'])->orderBy('currency', 'asc')->get()->toArray();
        $tags = [];
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $tags[$value['code']] = $value['currency'];
            }
        }
        return $tags;
    }

    /**
     * [getCountryCodes description]
     * @return [type] [description]
     */
    public function getCountryCodes()
    {
        $models = CountryCodes::select(['code', 'country'])->orderBy('country', 'asc')->get()->toArray();
        $tags = [];
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $tags[$value['code']] = $value['country'];
            }
        }
        return $tags;
    }

    /**
     * [getTimeZone description]
     * @return [type] [description]
     */
    public function getTimeZone()
    {
        $models = TimeZone::select(['name'])->orderBy('name', 'asc')->get()->toArray();
        $tags = [];
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $tags[$value['name']] = $value['name'];
            }
        }
        return $tags;
    }

    /**
     * getActiveTopics function
     *
     * @return void
     * @date 26-04-2021
     * @author ketan savaliya <savaliya11.ketan@gmail.com>
     */
    public function getActiveTopics() {
        return Topic::where('status', 1)->pluck('name', 'id')->toArray();
    }
}
