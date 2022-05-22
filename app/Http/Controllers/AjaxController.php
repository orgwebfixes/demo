<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\CityDatatable;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Flash;
use App\Repositories\GeneralRepo;

class AjaxController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->title = 'Ajax';
    }

    public function postStates($param = [])
    {
        if (request()->input('country_id')) {
            $country_id = request()->input('country_id');
        } elseif (old('country_id')) {
            $country_id = old('country_id');
        } elseif ($param && $param['country_id']) {
            $country_id = $param['country_id'];
        }

        if (isset($country_id)) {
            return State::where('country_id', $country_id)->pluck('name', 'id')->toArray();
        }
        return [];
    }

    public function postState($id = null)
    {
        if (request()->input('country_id')) {
            $id = request()->input('country_id');
        } elseif (old('country_id')) {
            $id = old('country_id');
        }
        if ($id) {
            return app(State::class)->where('country_id', $id)->lists('name', 'id')->toArray();
        }
        return [];
    }

    /**
     * get list of cities
     * @param  int $state_id [description]
     * @return array           list of city
     */
    public function postCities($state_id = null)
    {
        if (request()->input('state_id')) {
            $state_id = request()->input('state_id');
        } elseif (old('state_id')) {
            $state_id = old('state_id');
        }

        if ($state_id) {
            return app(City::class)->where(['state_id' => $state_id])->orderBy('name', 'asc')->lists('name', 'id')->toArray();
        }
        return [];
    }

    public function postCitiesasc($state_id = null)
    {
        $responce = [];
        if (request()->input('state_id')) {
            $state_id = request()->input('state_id');
        } elseif (old('state_id')) {
            $state_id = old('state_id');
        } elseif (request()->ajax('state_id')) {
            $state_id = request()->ajax('state_id');
        }
        if ($state_id) {
            $responce = app(City::class)->where(['state_id' => $state_id])->orderBy('name')->select('name as value', 'id as key')->get();
        }
        return $responce;
    }
}
