<?php

return array (
  'singular' => 'التصريح',
  'plural' => 'التصاريح',
  'attachments'=> 'الملفات المؤرشفة على التصريح',
  'add_new_attachment'=>'رفع ملف جديد على التصريح',
  'validations' =>[
    'deleteWorkOrdersPermitNotAllowed' =>'لا يمكن حذف التصريح الا ان تكون حالته جديد أو ملغى فقط '
  ],
  'status' =>[
    'New' =>'جديد',
    'WaitingForPayment' =>'منتظر السداد',
    'PaidAndIssued' =>'تم الاصدار',
    'UnderWay' =>'قيد التنفيذ',
    'UnderDelivery' =>'قيد التسليم',
    'InitialDelivery' =>'تم التسليم المبدئي',
    'FinalDelivery' =>'تم التسليم النهائى',
    'Canceled' =>'ملغي',
    'Rejected' =>'مرفوض',
    'WaitingForProcess' => 'محول الي اعادة الوضع'
  ],
  'fields' =>
  array (
    'id' => 'الكود',
    'is_mission' => 'النوع',
    'mission_id' => 'المهمة',
    'permit_number' => 'رقم التصريح',
    'work_orders_permit_type_id' => 'نوع التصريح',
    'work_order_id' => 'رقم أمر العمل',
    'sadad_number' => 'رقم إحالة السداد',
    'issued_amount' => 'مبلغ الاصدار',
    'total_amount' => 'مبلغ التصريح',
    'total_extend_amount' => 'مبلغ التمديد',
    //'total_extend_amount' => 'مبلغ التمديد',
    'total_fines_amount' => 'مبلغ الغرامة',
    'clearance_sdad_amount' =>  'مبلغ التسليم',

    'period' => 'مدة التصريح',
    'ext_period' => 'مدة التمديد',
    'issue_date' => 'تاريخ الإصدار',
    'start_date' => 'تاريخ البداية',
    'end_date' => 'تاريخ النهاية',
    'from' => 'من',
    'to' => 'الى',
    'amount' => 'المبلغ',
    'notes' => 'ملاحظات',
    'refuse_reason' => 'سبب الرفض',
    'fine_reason' => 'سبب الغرامة',
    'status' => 'الحالة',
    'created_at' => 'تاريح الإنشاء',
    'updated_at' => 'تاريخ التحديث',
    'balady_id' => 'البلدية',
    'district_id' => 'الحى',
    'street' => 'الشارع',
    'work_order_number' => 'رقم أمر العمل',
    'from_issue_date' => 'من تاريخ الاصدار',
    'to_issue_date' => 'الى تاريخ الاصدار',
    'from_end_date' => 'من تاريخ الانتهاء',
    'to_end_date' => 'الى تاريخ الانتهاء',
    'status' => 'حالة التصريح',
    'work_order_status' => 'حالة أمر العمل',
    'from_restablish_convert_date' => 'من تاريخ تحويل',
    'to_restablish_convert_date' => 'الي تاريخ تحويل'

  ),
);
