<?php
return [
    'work_order_general_status' => [
        '1' => [
            'class' => "badge-light-warning",
            'title' => "جديد",
        ],
        '2' => [
            'class' => "badge-light-warning",
            'title' => "لم يبدأ",
        ],
        '3' => [
            'class' => "badge-light-info",
            'title' => "جارى العمل",
        ],
        '4' => [
            'class' => "badge-light-success",
            'title' => "منفذ",
        ],
        '5' => [
            'class' => "badge-light-success",
            'title' => "تم التسليم",
        ],
        '6' => [
            'class' => "badge-light-danger",
            'title' => "متوقف - مؤقت",
        ],
        '7' => [
            'class' => "badge-light-danger",
            'title' => "ملغى",
        ],
        '8' => [
            'class' => "badge-light-info",
            'title' => "مؤرشف",
        ],
        '9' => [
            'class' => "badge-light-info",
            'title' => "متبقى البرنامج",
        ],
        '10' => [
            'class' => "badge-light-danger",
            'title' => "متوقف - نهائى",
        ]
    ],
    'work_order_drilling_status' => [
        '0' => [
            'class' => "badge-light-warning",
            'title' => "لم يبدأ",
        ],
        '1' => [
            'class' => "badge-light-info",
            'title' => "جارى العمل",
        ],
        '2' => [
            'class' => "badge-light-success",
            'title' => "منفذ",
        ]
    ],
    'work_order_electricity_status' => [
        '0' => [
            'class' => "badge-light-warning",
            'title' => "لم يبدأ",
        ],
        '1' => [
            'class' => "badge-light-info",
            'title' => "جارى العمل",
        ],
        '2' => [
            'class' => "badge-light-success",
            'title' => "منفذ",
        ]
    ],
    'work_order_permit_status' => [
        '1' => [
            'class' => "badge-light-warning",
            'title' => "مرسل - قيد التنسيق",
        ],
        '2' => [
            'class' => "badge-light-warning",
            'title' => "منتظر السداد",
        ],
        '3' => [
            'class' => "badge-light-primary",
            'title' => " تم السداد والاصدار",
        ],
        '4' => [
            'class' => "badge-light-info",
            'title' => "قيد التنفيذ",
        ],
        '5' => [
            'class' => "badge-light-info",
            'title' => "قيد التسليم",
        ],
        '6' => [
            'class' => "badge-light-success",
            'title' => " تم التسليم المبدئي",
        ],
        '7' => [
            'class' => "badge-light-success",
            'title' => " تم التسليم النهائى",
        ],
        '8' => [
            'class' => "badge-light-danger",
            'title' => "ملغي",
        ],
        '9' => [
            'class' => "badge-light-danger",
            'title' => "مرفوض",
        ],
        '10' => [
            'class' => "badge-light-info",
            'title' => "انتظار اعادة الوضع",
        ]
    ],
    "completion_certificate_status" =>[
        '1' => [
            'class' => "badge-light-success",
            'title' => "تم القبول",
        ],
        '2' => [
            'class' => "badge-light-danger",
            'title' => "تم الرفض",
        ],
        '3' => [
            'class' => "badge-light-info",
            'title' => "قيد التنسيق والاعتماد",
        ]
    ],
    "clearance_certificate_status" =>[
        '1' => [
            'class' => "badge-light-success",
            'title' => "تم القبول",
        ],
        '2' => [
            'class' => "badge-light-danger",
            'title' => "تم الرفض",
        ],
        '3' => [
            'class' => "badge-light-info",
            'title' => "قيد التنسيق والاعتماد",
        ]
    ],
    'work_order_permit_status_list' => [
        '1' => 'مرسل - قيد التنسيق',
        '2' => 'منتظر السداد',
        '3' => 'تم السداد والاصدار',
        '10' => 'محول الي اعادة الوضع',
        '4' => 'قيد التنفيذ',
        '5' => 'قيد التسليم',
        '6' => 'تم التسليم المبدئي',
        '7' => 'تم التسليم النهائى',
        '8' => 'ملغي',
        '9' => 'مرفوض',

    ],
    'completion_certificate_status_list' => [

        '1' => 'تم القبول',
        '2' => 'تم الرفض',
        '3' => 'قيد التنسيق والاعتماد',
    ],



    'asbuilt_status'=>[
        '0'=>'غير موجود',
        '1'=>'جاهز',
        '2'=>'تم الاعتماد من شركة الكهرباء',
    ],

    'assay_forms_status'=>[
        ''=>'اختر',
        '0'=>'غير جاهز',
        '1'=>'جاهز',
    ],

    'shift_number_list'=>[
        '0'=>'',
        '1'=>'الوردية الاولى',
        '2'=>'الوردية الثانية',
        '3'=>'الوردية الثالثة',
    ],
    'layer_worker_type_list' => [
        '1' => 'مقاول',
        '2' => 'موظف'
    ],
    'return_situation_layer_status_list' => [
        '1' => 'جديد',
        '2' => 'جاري العمل',
        '3' => 'مرسل إلى المختبر',
        '4' => 'منتهى'
    ],
    'lab_result_status_list' => [
        '1' => 'ناجح',
        '2' => 'راسب'
    ],
    'lab_result_status_list2' => [
        '1' => [
            'class' => "badge-light-success",
            'title' => "ناجح",
        ],
        '2' => [
            'class' => "badge-light-danger",
            'title' => "راسب",
        ],
    ],
    'achievement_cert_status_list' => [
        '1' => [
            'class' => "badge-light-success",
            'title' => "معتمد",
        ],
        '2' => [
            'class' => "badge-light-warning",
            'title' => "غير معتمد",
        ]
    ],
    'financial_due_status_list' => [
        '1' => [
            'class' => "badge-light-success",
            'title' => "معتمد",
        ],
        '2' => [
            'class' => "badge-light-warning",
            'title' => "غير معتمد",
        ]

    ],
    'assay_form' => [
        '1' => [
            'class' => "badge-light-info",
            'title' => "جديد",
        ],
        '2' => [
            'class' => "badge-light-success",
            'title' => "معتمد",
        ],
        '3' => [
            'class' => "badge-light-warning",
            'title' => "تم النقل",
        ],
    ],
    'general_work_opreation_status' => [
        '0' => [
            'class' => "badge-light-warning",
            'title' => "لم يبدأ التنفيذ",
        ],
        '1' => [
            'class' => "badge-light-info",
            'title' => "جارى التنفيذ",
        ],
        '2' => [
            'class' => "badge-light-success",
            'title' => "تم التنفيذ",
        ],
    ],
    'work_order_project_status' => [
        '0' => [
            'class' => "badge-light-warning",
            'title' => "لم يبدأ",
        ],
        '1' => [
            'class' => "badge-light-info",
            'title' => "قيد التنفيذ",
        ],
        '2' => [
            'class' => "badge-light-success",
            'title' => "تم التنفيذ واغلاق المشروع",
        ],
        '3' => [
            'class' => "badge-light-danger",
            'title' => "متوقف",
        ],
    ]
];
