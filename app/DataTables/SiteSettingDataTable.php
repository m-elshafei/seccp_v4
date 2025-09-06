<?php

namespace App\DataTables;

use App\Models\SiteSetting;
use Yajra\DataTables\Html\Column;
use App\DataTables\AppDataTable;

class SiteSettingDataTable extends AppDataTable
{
    function __construct() {
        $this->dataTableName = 'siteSettings';
        $this->actionViewBlade = 'site_settings.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SiteSetting $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SiteSetting $model)
    {
        return $model->newQuery();
    }


    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'index' => $this->getIndexCol(),
            'site_name_en' => new Column(['title' => __('models/siteSettings.fields.site_name_en'), 'data' => 'site_name_en']),
            'site_name_ar' => new Column(['title' => __('models/siteSettings.fields.site_name_ar'), 'data' => 'site_name_ar']),
            'site_alias' => new Column(['title' => __('models/siteSettings.fields.site_alias'), 'data' => 'site_alias', 'defaultContent' => '']), 
            'site_main_color' => new Column(['title' => __('models/siteSettings.fields.site_main_color'), 'data' => 'site_main_color', 'defaultContent' => '']),
            'site_font_name' => new Column(['title' => __('models/siteSettings.fields.site_font_name'), 'data' => 'site_font_name', 'defaultContent' => '']),
            'message_home_page' => new Column(['title' => __('models/siteSettings.fields.message_home_page'), 'data' => 'message_home_page']),
            // 'logo_path' => new Column(['title' => __('models/siteSettings.fields.logo_path'), 'data' => 'logo_path']),
            // 'big_photo' => new Column(['title' => __('models/siteSettings.fields.big_photo'), 'data' => 'big_photo']),
            'company_name' => new Column(['title' => __('models/siteSettings.fields.company_name'), 'data' => 'company_name'])
        ];
    }

    
}
