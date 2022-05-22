<?php

namespace App\Http\Controllers;

use App;
use AppHelper;
use App\Models\Setting;
use Cache;
use Centaur\AuthManager;
use Flash;
use Illuminate\Http\Request;
use Sentinel;

class SettingsController extends Controller
{
    protected $user;

    public function __construct(AuthManager $authManager)
    {
        parent::__construct();
        $this->title = 'Users Setting';
        view()->share('title', $this->title);
        AppHelper::setClass(__CLASS__);
        $this->middleware('sentinel.access:settings.view', ['only' => ['usersSettings', 'usersSettingsStore']]);
        $this->authManager = $authManager;
        view()->share('module_title', 'User Settings');
        view()->share('title', 'Admin User Settings');

        AppHelper::path('uploads/user/');
    }

    public function usersSettings()
    {
        $settings = $this->getSiteSettings();
        return view('admin.users.settings', compact('settings'));
    }

    public function usersSettingsStore(Request $request)
    {
        $input = AppHelper::getTrimmedData($request->except('save', 'save_exit', '_token'));
        $rules = [
            'project_title' => 'required',
            'company_name' => 'required',
        ];

        foreach ($input as $name => $value) {
            $this->checkSettingName($name);
            $this->updateByName($name, $value);
        }
        Cache::flush();
        session()->flash('success', $this->title . ' Updated Successfully');
        return redirect()->route('settings.index');
    }

    public function getSiteSettings()
    {
        $object = Setting::select([
            'name as name',
            'value as value',
        ]);
        $result = $object->get()->toArray();
        $data = [];
        if (!empty($result)) {
            foreach ($result as $name => $value) {
                $data[$value['name']] = $value['value'];
            }
        }
        return $data;
    }

    public function settingUpdate($id, $input)
    {
        return Setting::find($id)->update($input);
    }

    public function updateByName($name, $value)
    {
        return Setting::where('name', $name)->update(['value' => $value]);
    }

    public function checkSettingName($name)
    {
        $setting = Setting::where('name', $name)->get()->first();
        if (is_null($setting)) {
            $title = ucwords(str_replace('_', ' ', $name));
            $setting = Setting::create(['name' => $name, 'title' => $title]);
        }
        return $setting;
    }
}
