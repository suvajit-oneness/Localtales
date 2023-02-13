<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;

use Illuminate\Http\UploadedFile;
use App\Http\Controllers\BaseController;
use App\Contracts\SettingsContract;
use App\Models\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SettingController extends BaseController
{
    protected $SettingsRepository;

    /**
     * StateManagementController constructor.
     * @param SettingsRepository $SettingsRepository
     */

    public function __construct(SettingsContract $SettingsRepository)
    {
        $this->SettingsRepository = $SettingsRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
  /**
     * This method is for show settings
     *
     */
    public function index(Request $request)
    {
        $data = $this->SettingsRepository->listAll();
        return view('admin.settings.index', compact('data'));
    }
    /**
     * This method is for show settings details
     * @param  $id
     *
     */
     public function show($id)
    {
        $targetstate = $this->SettingsRepository->listById($id);
        $settings = $targetstate[0];

        $this->setPageTitle('Setting', 'Setting Details : '.$settings->key);
        return view('admin.settings.detail', compact('settings'));
    }
    /**
     * This method is for settings update
     *
     *
     */
    public function update(Request $request)
    {
        $request->validate([
            "key" => "required|string",
            "content" => "required|string"
        ]);

        $params = $request->except('_token');
        $storeData = $this->SettingsRepository->updateSettings($params);

        if (!$storeData) {
            return $this->responseRedirectBack('Error occurred while updating settings.', 'error', true, true);
        }
        return $this->responseRedirectBack('settings has been updated successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $targetstate = $this->SettingsRepository->updateStatus($params);

        if ($targetstate) {
            return response()->json(array('message'=>'Settings status has been successfully updated'));
        }
    }

}
