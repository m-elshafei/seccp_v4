<?php

return [
    /***********التعريفات العامة */
    'commonScreens' => [
        'comp_name'=> 'التعريفات العامة',
        'comp_type'=> 1,
        'route_name'=> 'commonScreens',
        'prefix'=> '',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> ''

    ],
    'branches' => [
        'comp_name'=> 'الفروع',
        'comp_type'=> 3,
        'route_name'=> 'branches',
        'prefix'=> 'commonScreens',
        'model_name'=> '',
        'parent_route_name'=> 'commonScreens',
        'icon'=> ''
    ],
    'districts' => [
        'comp_name'=> 'الأحياء',
        'comp_type'=> 3,
        'route_name'=> 'districts',
        'prefix'=> 'commonScreens',
        'model_name'=> 'districts',
        'parent_route_name'=> 'commonScreens',
        'icon'=> ''
    ],
    'cities' => [
        'comp_name'=> 'المدن',
        'comp_type'=> 3,
        'route_name'=> 'cities',
        'prefix'=> 'commonScreens',
        'model_name'=> 'cities',
        'parent_route_name'=> 'commonScreens',
        'icon'=> ''
    ],
    'baladies' => [
        'comp_name'=> 'البلديات',
        'comp_type'=> 3,
        'route_name'=> 'baladies',
        'prefix'=> 'commonScreens',
        'model_name'=> 'baladies',
        'parent_route_name'=> 'commonScreens',
        'icon'=> ''
    ],
    'attachmentTypes' => [
        'comp_name'=> 'أنواع المرفقات',
        'comp_type'=> 3,
        'route_name'=> 'attachmentTypes',
        'prefix'=> 'commonScreens',
        'model_name'=> 'attachmentTypes',
        'parent_route_name'=> 'commonScreens',
        'icon'=> ''
    ],
     /********** ادارة المستخدمين*/
    'userManagement' => [
        'comp_name'=> 'ادارة المستخدمين',
        'comp_type'=> 1,
        'route_name'=> 'userManagement',
        'prefix'=> 'userManagement',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'users'
    ],
    'users' => [
        'comp_name'=> 'المستخدمين',
        'comp_type'=> 3,
        'route_name'=> 'users',
        'prefix'=> 'userManagement',
        'model_name'=> 'users',
        'parent_route_name'=> 'userManagement',
        'icon'=> ''
    ],
    'roles' => [
        'comp_name'=> 'صلاحيات المستخدمين',
        'comp_type'=> 3,
        'route_name'=> 'roles',
        'prefix'=> 'userManagement',
        'model_name'=> 'roles',
        'parent_route_name'=> 'userManagement',
        'icon'=> ''
    ],
    /********** الموظفين*/
    'employeesManagement' => [
        'comp_name'=> 'ادارة الموظفين',
        'comp_type'=> 1,
        'route_name'=> 'employeesManagement',
        'prefix'=> 'employeesManagement',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'briefcase'
    ],
    'departments' => [
        'comp_name'=> 'تعريف الادارات للشركة',
        'comp_type'=> 3,
        'route_name'=> 'departments',
        'prefix'=> 'employeesManagement',
        'model_name'=> '',
        'parent_route_name'=> 'employeesManagement',
        'icon'=> ''
    ],
    'jobs' => [
        'comp_name'=> ' تعريف الوظائف',
        'comp_type'=> 3,
        'route_name'=> 'jobs',
        'prefix'=> 'employeesManagement',
        'model_name'=> '',
        'parent_route_name'=> 'employeesManagement',
        'icon'=> ''
    ],
    'employees' => [
        'comp_name'=> ' الموظفين',
        'comp_type'=> 3,
        'route_name'=> 'employees',
        'prefix'=> 'employeesManagement',
        'model_name'=> '',
        'parent_route_name'=> 'employeesManagement',
        'icon'=> ''
    ],
    /********** تعريفات أوامر العمل*/
    'workOrdersDefinitions' => [
        'comp_name'=> 'تعريفات أوامر العمل',
        'comp_type'=> 1,
        'route_name'=> 'workOrdersDefinitions',
        'prefix'=> 'workOrdersDefinitions',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'clipboard'
    ],
    'electricalStationsTypes' => [
        'comp_name'=> 'أنواع المحطات',
        'comp_type'=> 3,
        'route_name'=> 'electricalStationsTypes',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'electricityDepartments' => [
        'comp_name'=> 'أقسام ش/الكهرباء',
        'comp_type'=> 3,
        'route_name'=> 'electricityDepartments',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'electricityCompanyEmployees' => [
        'comp_name'=> 'موظفي شركه الكهرباء',
        'comp_type'=> 3,
        'route_name'=> 'electricityCompanyEmployees',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'workTypes' => [
        'comp_name'=> 'أنواع العمل',
        'comp_type'=> 3,
        'route_name'=> 'workTypes',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'contractors' => [
        'comp_name'=> 'المقاولون',
        'comp_type'=> 3,
        'route_name'=> 'contractors',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'workOrdersTypes' => [
        'comp_name'=> 'أنواع أوامر العمل',
        'comp_type'=> 3,
        'route_name'=> 'workOrdersTypes',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'workOrdersStages' => [
        'comp_name'=> 'مراحل أوامر العمل',
        'comp_type'=> 3,
        'route_name'=> 'workOrdersStages',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'workOrdersPermitTypes' => [
        'comp_name'=> 'أنواع التصاريح',
        'comp_type'=> 3,
        'route_name'=> 'workOrdersPermitTypes',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'workOrdersProjects' => [
        'comp_name'=> 'مشاريع أوامر العمل',
        'comp_type'=> 3,
        'route_name'=> 'workOrdersProjects',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'emergencyIssuesTypes' => [
        'comp_name'=> 'انواع اعطال الطوارئ',
        'comp_type'=> 3,
        'route_name'=> 'emergencyIssuesTypes',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],

    /*************************************** */
    /********** ادارة أوامر العمل*/
    'workOrdersManagement' => [
        'comp_name'=> 'نظام أوامر العمل/عام',
        'comp_type'=> 1,
        'route_name'=> 'workOrdersManagement',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'clipboard'
    ],
    'workOrders' => [
        'comp_name'=> 'أوامر العمل - عام',
        'comp_type'=> 3,
        'route_name'=> 'workOrders',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersManagement',
        'icon'=> ''
    ],
    'workOrdersPermits' => [
        'comp_name'=> ' التصاريح',
        'comp_type'=> 3,
        'route_name'=> 'workOrdersPermits',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersManagement',
        'icon'=> ''
    ],
    /*********************************** */
    'DrillingManagement' => [
        'comp_name'=> 'ادارة التمديدات والحفر',
        'comp_type'=> 1,
        'route_name'=> 'DrillingManagement',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'codesandbox'
    ],
    'workOrdersDrilling' => [
        'comp_name'=> 'متابعة التمديدات والحفر',
        'comp_type'=> 3,
        'route_name'=> 'workOrdersDrilling',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> 'workOrder',
        'parent_route_name'=> 'DrillingManagement',
        'icon'=> ''
    ],
    'workOrdersDrillingProjects' => [
        'comp_name'=> 'متابعة المشاريع ',
        'comp_type'=> 3,
        'route_name'=> 'workOrdersDrillingProjects',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> 'workOrder',
        'parent_route_name'=> 'DrillingManagement',
        'icon'=> ''
    ],
    /*********************************** */
    'ElectricityManagement' => [
        'comp_name'=> 'ادارة الاعمال الكهربائية',
        'comp_type'=> 1,
        'route_name'=> 'ElectricityManagement',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'codesandbox'
    ],
    'workOrdersElectricity' => [
        'comp_name'=> 'متابعة الاعمال الكهربائية',
        'comp_type'=> 3,
        'route_name'=> 'workOrdersElectricity',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> 'workOrder',
        'parent_route_name'=> 'ElectricityManagement',
        'icon'=> ''
    ],
    /*********************************** */
    'ElectricityTowerManagement' => [
        'comp_name'=> 'ادارة أعمال الهوائى',
        'comp_type'=> 1,
        'route_name'=> 'ElectricityTowerManagement',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'codesandbox'
    ],
    'workOrdersElectricTowers' => [
        'comp_name'=> 'متابعة أعمال الهوائى',
        'comp_type'=> 3,
        'route_name'=> 'workOrdersElectricTowers',
        'prefix'=> 'workOrdersManagement',
        'model_name'=> 'workOrder',
        'parent_route_name'=> 'ElectricityTowerManagement',
        'icon'=> ''
    ],

    /*********************************** */
    'restablishWorkOrders' => [
        'comp_name'=> 'ادارة اعادة الوضع',
        'comp_type'=> 1,
        'route_name'=> 'restablishWorkOrders',
        'prefix'=> 'restablishWorkOrders',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'codesandbox'
    ],
    'layers' => [
        'comp_name'=> 'تعريف الطبقات',
        'comp_type'=> 3,
        'route_name'=> 'layers',
        'prefix'=> 'layers',
        'model_name'=> 'layers',
        'parent_route_name'=> 'restablishWorkOrders',
        'icon'=> ''
    ],
    'labs' => [
        'comp_name'=> 'تعريف المختبرات',
        'comp_type'=> 3,
        'route_name'=> 'labs',
        'prefix'=> 'labs',
        'model_name'=> '',
        'parent_route_name'=> 'restablishWorkOrders',
        'icon'=> ''
    ],
    // '36' => [
    //     'comp_name'=> 'شاشة إعادة الوضع',
    //     'comp_type'=> 3,
    //     'route_name'=> 'returnSituations',
    //     'prefix'=> 'returnSituations',
    //     'model_name'=> '',
    //     'parent_route_name'=> 'restablishWorkOrders',
    //     'icon'=> ''
    // ],
    'workOrderFollows' => [
        'comp_name'=> 'شاشة متابعة التصاريح',
        'comp_type'=> 3,
        'route_name'=> 'workOrderFollows',
        'prefix'=> 'workOrderFollows',
        'model_name'=> '',
        'parent_route_name'=> 'restablishWorkOrders',
        'icon'=> ''
    ],
     /********** ادارة الطوارئ*/
     'emergency' => [
        'comp_name'=> 'ادارة الطوارئ',
        'comp_type'=> 1,
        'route_name'=> 'emergency',
        'prefix'=> 'emergency',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'codesandbox'
    ],
    'emergencyMissions' => [
        'comp_name'=> 'مهمات الطوارئ',
        'comp_type'=> 3,
        'route_name'=> 'emergencyMissions',
        'prefix'=> 'emergency',
        'model_name'=> '',
        'parent_route_name'=> 'emergency',
        'icon'=> ''
    ],
     /********** المقايسات*/
    'stores' => [
        'comp_name'=> 'المقايسات',
        'comp_type'=> 1,
        'route_name'=> 'stores',
        'prefix'=> 'stores',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'codesandbox'
    ],
    'units' => [
        'comp_name'=> 'تعريف الوحدات',
        'comp_type'=> 3,
        'route_name'=> 'units',
        'prefix'=> 'stores',
        'model_name'=> '',
        'parent_route_name'=> 'stores',
        'icon'=> ''
    ],
    'itemsCategories' => [
        'comp_name'=> 'تصنيفات الاصناف',
        'comp_type'=> 3,
        'route_name'=> 'itemsCategories',
        'prefix'=> 'stores',
        'model_name'=> '',
        'parent_route_name'=> 'stores',
        'icon'=> ''
    ],
    'items' => [
        'comp_name'=> 'بنود الاصناف',
        'comp_type'=> 3,
        'route_name'=> 'items',
        'prefix'=> 'stores',
        'model_name'=> '',
        'parent_route_name'=> 'stores',
        'icon'=> ''
    ],
    'servicesCategories' => [
        'comp_name'=> 'أنواع بنود الاعمال',
        'comp_type'=> 3,
        'route_name'=> 'servicesCategories',
        'prefix'=> 'stores',
        'model_name'=> '',
        'parent_route_name'=> 'stores',
        'icon'=> ''
    ],
    'workOrderServices' => [
        'comp_name'=> 'بنود الاعمال',
        'comp_type'=> 3,
        'route_name'=> 'workOrderServices',
        'prefix'=> 'stores',
        'model_name'=> '',
        'parent_route_name'=> 'stores',
        'icon'=> ''
    ],
    'assayForms' => [
        'comp_name'=> 'المقايسات',
        'comp_type'=> 3,
        'route_name'=> 'assayForms',
        'prefix'=> 'stores',
        'model_name'=> '',
        'parent_route_name'=> 'stores',
        'icon'=> ''
    ],
    /********** ادارة المستخلصات*/
    'paymentClearances' => [
        'comp_name'=> 'ادارة المستخلصات',
        'comp_type'=> 1,
        'route_name'=> 'paymentClearances',
        'prefix'=> 'paymentClearances',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'codesandbox'
    ],
    'financialDueTypes' => [
        'comp_name'=> 'أنواع المستخلصات',
        'comp_type'=> 3,
        'route_name'=> 'financialDueTypes',
        'prefix'=> 'paymentClearances',
        'model_name'=> '',
        'parent_route_name'=> 'paymentClearances',
        'icon'=> ''
    ],
    'achievementCertificates' => [
        'comp_name'=> 'شهادة الانجاز',
        'comp_type'=> 3,
        'route_name'=> 'achievementCertificates',
        'prefix'=> 'paymentClearances',
        'model_name'=> '',
        'parent_route_name'=> 'paymentClearances',
        'icon'=> ''
    ],
    'financialDues' => [
        'comp_name'=> 'المستخلصات',
        'comp_type'=> 3,
        'route_name'=> 'financialDues',
        'prefix'=> 'paymentClearances',
        'model_name'=> '',
        'parent_route_name'=> 'paymentClearances',
        'icon'=> ''
    ],
     /********** اخرى*/
    'consultants' => [
         'comp_name'=> 'الاستشاريون',
         'comp_type'=> 3,
         'route_name'=> 'consultants',
         'prefix'=> 'workOrdersManagement',
         'model_name'=> '',
         'parent_route_name'=> 'workOrdersDefinitions',
         'icon'=> ''
    ],
    'missionTypes' => [
        'comp_name'=> 'أنواع مهمات الطوارئ',
        'comp_type'=> 3,
        'route_name'=> 'missionTypes',
        'prefix'=> 'emergency',
        'model_name'=> '',
        'parent_route_name'=> 'workOrdersDefinitions',
        'icon'=> ''
    ],
    'reports' => [
        'comp_name'=> 'التقارير العامة',
        'comp_type'=> 1,
        'route_name'=> 'reports',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'file-text'
    ],
    'workOrdersGeneralReport' => [
        'comp_name'=> 'متابعة أوامر العمل',
        'description'=> 'تقرير متابعة أوامر العمل',
        'comp_type'=> 4,
        'route_name'=> 'workOrdersGeneralReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'reports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.work_orders_reports.general_report.report",
            "reportFilterTemplate": "reports.work_orders_reports.general_report.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": ["view", "print", "download", "search"]
        }'
    ],
    'drillingWorkOrdersReport' => [
        'comp_name'=> 'تقارير أعمال الحفر',
        'comp_type'=> 1,
        'route_name'=> 'drillingWorkOrdersReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'file-text'
    ],
    'unfinishedDrillingWorkOrdersReport' => [
        'comp_name'=> 'أوامر العمل المستلمة',
        'description'=> 'تقرير عن حالة أعمال الحفر والتمديدات لأوامر العمل المستلمة فى فترة',
        'comp_type'=> 4,
        'route_name'=> 'unfinishedDrillingWorkOrdersReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'drillingWorkOrdersReport',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.drilling_work_orders.unfinished_work_orders.report",
            "reportFilterTemplate": "reports.drilling_work_orders.unfinished_work_orders.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": ["view", "print", "download", "search"]
        }'
    ],
    'finishedDrillingWorkOrdersReport' => [
        'comp_name'=> 'أوامر العمل المنفذة',
        'description'=> 'تقرير عن حالة أعمال الحفر والتمديدات المنفذة فى فترة',
        'comp_type'=> 4,
        'route_name'=> 'finishedDrillingWorkOrdersReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'drillingWorkOrdersReport',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.drilling_work_orders.finished_work_orders.report",
            "reportFilterTemplate": "reports.drilling_work_orders.finished_work_orders.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": ["view", "print", "download", "search"]
        }'
    ],
    'electricyReports' => [
        'comp_name'=> 'تقارير أعمال الكهرباء',
        'comp_type'=> 1,
        'route_name'=> 'electricyReports',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'file-text'
    ],
    'finishedElectricyWorkOrdersReport' => [
        'comp_name'=> 'أوامر العمل المنجزة',
        'description'=> 'تقرير أوامر العمل المنجزة لقسم الاعمال الكهربائية',
        'comp_type'=> 4,
        'route_name'=> 'finishedElectricyWorkOrdersReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'electricyReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.electricy_work_orders.finished_work_orders.report",
            "reportFilterTemplate": "reports.electricy_work_orders.finished_work_orders.filter",
            "font_name": "calibri",
            "font_size": "11",
            "title_background_color": "4CAF50",
            "orientation": "P",
            "reportButtons": [
                "view",
                "print",
                "download",
                "search"
            ]
        }'
    ],
    'electricyOperationsReport' => [
        'comp_name'=> 'التركيبات الكهربائية',
        'description'=> 'التقرير الفني لمعاملات التركيبات الكهربائية',
        'comp_type'=> 4,
        'route_name'=> 'electricyOperationsReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'electricyReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.electricy_work_orders.electricy_operations.report",
            "reportFilterTemplate": "reports.electricy_work_orders.electricy_operations.filter",
            "font_name": "calibri",
            "font_size": "11",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": [
                "view",
                "print",
                "download",
                "search"
            ]
        }'
    ],
    'electricyCountersReport' => [
        'comp_name'=> 'معاملات العدادات',
        'description'=> 'التقرير الفني لمعاملات العدادات',
        'comp_type'=> 4,
        'route_name'=> 'electricyCountersReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'electricyReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.electricy_work_orders.electricy_counters.report",
            "reportFilterTemplate": "reports.electricy_work_orders.electricy_counters.filter",
            "font_name": "calibri",
            "font_size": "11",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": [
                "view",
                "print",
                "download",
                "search"
            ]
        }'
    ],
    'electricTowersReports' => [
        'comp_name'=> 'تقارير أعمال الهوائى',
        'comp_type'=> 1,
        'route_name'=> 'electricTowersReports',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'file-text'
    ],
    'electricTowerWorkOrdersReport' => [
        'comp_name'=> 'تقرير المتابعة اليومى',
        'description'=> 'تقرير متابعة أعمال الهوائى',
        'comp_type'=> 4,
        'route_name'=> 'electricTowerWorkOrdersReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'electricTowersReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.electric_towers.electric_tower_opreations.report",
            "reportFilterTemplate": "reports.electric_towers.electric_tower_opreations.filter",
            "font_name": "calibri",
            "font_size": "11",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": [
                "view",
                "print",
                "download",
                "search"
            ]
        }'
    ],
    'permitReports' => [
        'comp_name'=> 'تقارير اعادة الوضع',
        'comp_type'=> 1,
        'route_name'=> 'permitReports',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'file-text'
    ],
    'workOrdersPermitReport' => [
        'comp_name'=> 'متابعة التصاريح',
        'description'=> 'تقرير بيان بوضع التصاريح فى فترة',
        'comp_type'=> 4,
        'route_name'=> 'workOrdersPermitReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'permitReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.permitFollow.work_orders_permits.report",
            "reportFilterTemplate": "reports.permitFollow.work_orders_permits.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": [
                "view",
                "print",
                "download",
                "search"
            ]
        }'
    ],

    
    'emergencyMissionsreports' => [
        'comp_name'=> 'تقارير أعمال الطوارئ',
        'description'=> 'تقارير أعمال الطوارئ',
        'comp_type'=> 1,
        'route_name'=> 'emergencyMissionsreports',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'file-text'
    ],
    'emergencyMissionsDailyReport' => [
        'comp_name'=> 'التقرير اليومى ',
        'description'=> 'التقرير اليومى ',
        'comp_type'=> 4,
        'route_name'=> 'emergencyMissionsDailyReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'emergencyMissionsreports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.emergency_missions.daily_missions.report",
            "reportFilterTemplate": "reports.emergency_missions.daily_missions.filter",
            "font_name": "calibri",
            "font_size": "11",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": [
                "view",
                "print",
                "download",
                "search"
            ]
        }'
    ],
    'financialDuesReports' => [
        'comp_name'=> 'تقارير المستخلصات',
        'description'=> 'تقارير المستخلصات',
        'comp_type'=> 1,
        'route_name'=> 'financialDuesReports',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'file-text'
    ],
    'ordersWithOutCertificatesReport' => [
        'comp_name'=> 'طلبات بدون شهادة',
        'description'=> 'تقرير الطلبات المنفذة على الطبيعة ولو يصدر لها شهادة انجاز ',
        'comp_type'=> 4,
        'route_name'=> 'ordersWithOutCertificatesReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'financialDuesReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.financial_dues.orders_with_out_certificates.report",
            "reportFilterTemplate": "reports.financial_dues.orders_with_out_certificates.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": ["view", "print", "download", "search"]
        }',  
    ],
    'ordersWithOutFinancialDuesReport' => [
        'comp_name'=> 'طلبات بدون مستخلص ',
        'description'=> 'تقرير الطلبات التى صدر لها شهادة انجاز ولم تدخل مستخلص ',
        'comp_type'=> 4,
        'route_name'=> 'ordersWithOutFinancialDuesReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'financialDuesReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.financial_dues.orders_with_out_financial_dues.report",
            "reportFilterTemplate": "reports.financial_dues.orders_with_out_financial_dues.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": ["view", "print", "download", "search"]
        }',  
    ],
    'finishedFinancialDuesReport' => [
        'comp_name'=> 'منتهى على الطبيعة ',
        'description'=> 'تقرير طلبات منتهية على الطبيعة وصادر لها شهادة ',
        'comp_type'=> 4,
        'route_name'=> 'finishedFinancialDuesReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'financialDuesReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.financial_dues.finished_financial_dues.report",
            "reportFilterTemplate": "reports.financial_dues.finished_financial_dues.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": ["view", "print", "download", "search"]
        }',  
    ],
    'allFinancialDuesReport' => [
        'comp_name'=> 'طلبات شامل مستلمة ',
        'description'=> 'تقرير طلبات شامل مستلمة من الشركة خلال فترة ',
        'comp_type'=> 4,
        'route_name'=> 'allFinancialDuesReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'financialDuesReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.financial_dues.all_financial_dues.report",
            "reportFilterTemplate": "reports.financial_dues.all_financial_dues.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": ["view", "print", "download", "search"]
        }',  
    ],
    'topManagementReports' => [
        'comp_name'=> 'تقارير الادارة العليا',
        'comp_type'=> 1,
        'route_name'=> 'topManagementReports',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> '',
        'icon'=> 'file-text'
    ],
    'allRecivedOrdersReport' => [
        'comp_name'=> 'اجمالى المعاملات الواردة ',
        'description'=> 'اجمالى المعاملات الواردة ',
        'comp_type'=> 4,
        'route_name'=> 'allRecivedOrdersReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'topManagementReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.top_management_reports.all_recived_orders.report",
            "reportFilterTemplate": "reports.top_management_reports.all_recived_orders.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": ["view", "print", "download", "search"]
        }',  
    ],
    'totalPermitAmountsReport' => [
        'comp_name'=> 'مبالغ التصاريح ',
        'description'=> 'بيان بالمبالغ المسددة على مستوى التصاريح ',
        'comp_type'=> 4,
        'route_name'=> 'totalPermitAmountsReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'topManagementReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.top_management_reports.total_permit_amounts.report",
            "reportFilterTemplate": "reports.top_management_reports.total_permit_amounts.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "L",
            "reportButtons": ["view", "print", "download", "search"]
        }',  
    ],
    'permitFinesAmountsReport' => [
        'comp_name'=> 'المخالفات ',
        'description'=> 'بيان بالمخالفات لكل موقع (التصاريح) ',
        'comp_type'=> 4,
        'route_name'=> 'permitFinesAmountsReport',
        'prefix'=> 'reports',
        'model_name'=> '',
        'parent_route_name'=> 'topManagementReports',
        'icon'=> '',
        'config'=>'{
            "reportTemplate": "reports.top_management_reports.permit_fines_amounts.report",
            "reportFilterTemplate": "reports.top_management_reports.permit_fines_amounts.filter",
            "font_name": "calibri",
            "font_size": "13",
            "title_background_color": "4CAF50",
            "orientation": "P",
            "reportButtons": ["view", "print", "download", "search"]
        }',  
    ],
    
];
