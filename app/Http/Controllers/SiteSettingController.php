<?php

namespace App\Http\Controllers;

use App\DataTables\SiteSettingDataTable;
use App\Http\Requests\CreateSiteSettingRequest;
use App\Http\Requests\UpdateSiteSettingRequest;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Storage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Flash;

class SiteSettingController extends AppBaseController
{
    /**
     * Display a listing of the SiteSetting.
     */
    public function index(SiteSettingDataTable $siteSettingDataTable)
    {
        return $siteSettingDataTable->render('site_settings.index');
    }


    /**
     * Show the form for creating a new SiteSetting.
     */
    public function create()
    {
        return view('site_settings.create');
    }

    /**
     * Store a newly created SiteSetting in storage.
     */
    public function store(CreateSiteSettingRequest $request)
    {
        $input = $request->all();
        $logoPath = $request->logo_path;
        $bigPhoto = $request->big_photo;
        if ($logoPath) {
            $logoFile = Storage::disk('logo')->put("", $logoPath);
            $input['logo_path'] = $logoFile;
        }
        if ($bigPhoto) {
            $filePath = Storage::disk('logo')->put("", $bigPhoto);
            $input['big_photo'] = $filePath;
        }
        $siteSetting = SiteSetting::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/siteSettings.singular')]));

        return redirect(route('siteSettings.index'));
    }


    /**
     * Display the specified SiteSetting.
     */
    public function show($id)
    {
        /** @var SiteSetting $siteSetting */
        $siteSetting = SiteSetting::find($id);

        if (empty($siteSetting)) {
            Flash::error(__('models/siteSettings.singular') . ' ' . __('messages.not_found'));

            return redirect(route('siteSettings.index'));
        }

        return view('site_settings.show')->with('siteSetting', $siteSetting);
    }

    /**
     * Show the form for editing the specified SiteSetting.
     */
    public function edit($id)
    {
        /** @var SiteSetting $siteSetting */
        $siteSetting = SiteSetting::find($id);

        if (empty($siteSetting)) {
            Flash::error(__('models/siteSettings.singular') . ' ' . __('messages.not_found'));

            return redirect(route('siteSettings.index'));
        }

        return view('site_settings.edit')->with('siteSetting', $siteSetting);
    }

    /**
     * Update the specified SiteSetting in storage.
     */
    public function update(UpdateSiteSettingRequest $request, SiteSetting $siteSetting)
    {
        $input = $request->all();

        $file = $request->logo_path;
        if ($file) {
            $filePath = Storage::disk('logo')->put("", $file);
            $input['logo_path'] = $filePath;
        }
        $bigPhoto = $request->big_photo;
        if ($bigPhoto) {
            $filePath = Storage::disk('logo')->put("", $bigPhoto);
            $input['big_photo'] = $filePath;
        }

        $siteSetting->update($input);



        Flash::success(__('messages.updated', ['model' => __('models/siteSettings.singular')]));

        return redirect(route('siteSettings.index'));
    }

    /**
     * Remove the specified SiteSetting from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var SiteSetting $siteSetting */
        $siteSetting = SiteSetting::find($id);

        if (empty($siteSetting)) {
            Flash::error(__('models/siteSettings.singular') . ' ' . __('messages.not_found'));

            return redirect(route('siteSettings.index'));
        }

        $siteSetting->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/siteSettings.singular')]));

        return redirect(route('siteSettings.index'));
    }
}
