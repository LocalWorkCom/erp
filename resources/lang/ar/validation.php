<?php
return [
    'required' => ' :attribute مطلوب.',
    'email' => ':attribute يجب أن يكون بريدًا إلكترونيًا صالحًا.',
    'date_format' => ':attribute يجب أن يتطابق مع التنسيق :format.',
    'string' => ':attribute يجب أن يكون نصًا.',
    'max' => ':attribute لا يمكن أن يكون أكبر من :max حرفًا.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'unique' => 'عفوا  :attribute مأخوذ مسبقا',
    'name' => ' :attribute مطلوب.',
    'phone' => ' :attribute مطلوب.',
    'image' => ':attribute مطلوبة.',
    'country_id' => ' :attribute مطلوب.',
    'same' => ':attribute لا تتطابق ',
    'unauthenticated_title' => 'لا يمكن الدخول',
    'unauthenticated_msg' => 'لا يمكنك الدخول',
    'exists' => ':attribute غير موجود',
    'integer' => ':attribute يجب ان يكون أرقام',
    'validator_title' => 'تصحيح',
    'validator_msg' => 'تصحيح الرسايل',
    'is_remind' => ':attribute مطلوب',
    'sku' => ':attribute مطلوب',
    'reason' => ':attribute مطلوب',
    'order_detail_id' => ':attribute مطلوب',
    'order_id' => ':attribute مطلوب',
    'order_status' => ':attribute مطلوب',
    'payment_method' => ':attribute مطلوب',
    'paid' => ':attribute مطلوب',
    'notfound' => 'عفوا هذا المستخدم غير موجود بالأبليكشن',
    'latitute' => [
        'required' => 'حقل خط العرض مطلوب.',
        'numeric' => 'يجب أن يكون خط العرض رقمًا صالحًا.',
        'regex' => 'يجب أن يكون خط العرض رقمًا عشريًا صالحًا.',
    ],
    'longitute' => [
        'required' => 'حقل خط الطول مطلوب.',
        'numeric' => 'يجب أن يكون خط الطول رقمًا صالحًا.',
        'regex' => 'يجب أن يكون خط الطول رقمًا عشريًا صالحًا.',
    ],
    'max' => [
        'string' => 'يجب ألا يزيد :attribute عن :max حرفًا.',
        'numeric' => 'يجب ألا يزيد :attribute عن :max.',
    ],
    'min' => [
        'string' => 'يجب ألا يقل :attribute عن :min حرفًا.',
        'numeric' => 'يجب ألا يقل :attribute عن :min.',
    ],
    'between' => [
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'string' => 'يجب أن يكون :attribute بين :min و :max حرفًا.',
    ],
    'boolean' => ':attribute يجب أن يكون 1 أو 0.',
    'in' => 'هذه القيمة غير صحيحة',
    'product_expired' => 'هذا المنتج منتهى الصلاحية ',
    'product_not_enough' => 'هذا المنتج غير كافى ',
    'product_not_instore' => 'هذا المنتج غير موجود فى المخزن',
    'NoChange' => 'لا يوجد تحديث',
    'NoChangeMessage' => 'لا يوجد تحديث للبيانات',
    'NotExist' => 'غير موجود',
    'NotExistMessage' => 'غير موجود',
    'NotAllow' => 'لا يمكن حذفه',
    'NotAllowMessage' => 'لا يمكن حذفه لانه حدثت عليه عمليات',
    'NotHavePermeation' => 'لا يمكن حذفه او تعديله',
    'NotHavePermeationMessage' => 'لا يمكن حذفه او تعديله لانه حدثت عليه عمليات',
    'NotDate' => 'لا يمكن التعديل او الحذف ',
    'NotDateMessage' => 'لا يمكن حذفه او تعديله لان التاريخ بعد تاريخ اليوم',
    'NotAddMore' => 'ولا يمكن إضافة المزيد',
    'NotAddMoreMessage' => 'ولا يمكن أن نضيف أكثر من ذلك',
    'NotAvailable' => 'ولا يمكن الإضافة ',
    'NotAvailableMessage' => 'ولا يمكن أن نضيف لانه غير متاح',
    'NotClosingMessage' => 'لا يمكن إضافته، لديك عجز ... الرجاء إصلاحه',
    'NoLeaveMessage' => 'لا يمكن إضافته، ليس لديك رصيد اجازات',
    'barcode' => ':attribute مطلوب ',
    'main_image' => ':attribute مطلوبة',
    'main_unit_id' => ':attribute مطلوبة',
    'mimes' => 'نوع الملف يجب ان يكون png ,jpeg, jpg',
    'image' => 'يجب ان يكون الملف المرسل صورة وليس ملف',
    'is_have_expired' => ':attribute مطلوب',
    'code_size' => ':attribute مطلوب',
    'size_id' => ':attribute مطلوب',
    'color_id' => ':attribute مطلوب',
    'unit_id' => ':attribute مطلوب',
    'factor' => ':attribute مطلوب',
    'type' => ':attribute مطلوب',
    'branch_id' => ':attribute مطلوب',
    'details' => ':attribute مطلوب',
    'quantity' => ':attribute مطلوب',
    'total' => ':attribute مطلوب',
    'recipe_addon_id' => ':attribute مطلوب',
    'price' => ':attribute مطلوب',
    'DataExist' => 'موجود بالفعل',
    'DataExistMessage' => 'موجود بالفعل',
    'regex' => 'صيغة :attribute غير صحيحة.',
    'date' => ':attribute يجب أن يكون تاريخًا صالحًا.',
    'unique_within_duration' => ':attribute موجود بالفعل لنفس المدة الزمنية',
    'discount_exceeds_100' => 'قيمة الخصم لا يجب ان تتعدى نسبة 100',
    'active_offer_conflict' => 'يوجد عرض فعال بنفس الاسم',
    'The dish_id field must be a number' => 'يجب ان يكون رقم الطبق رقم صحيح',
    'offer_linked_error' => "لا يمكن المسح, هذا العرض مرتبط بسلايدر",

    'attributes' => [

        'EnterCode' => 'أدخل كود الدوله',
        'ArabicCurrency' => 'أدخل العمله بالعربيه',
        'EnglishCurrency' => 'أدخل العمله بالأنجليزيه',
        'CurrencyCode' => 'أدخل كود العمله',
        'phone_code' => 'أدخل كود الهاتف',
        'flag' => 'يرجى تحميل علم الدوله',
        'length' => 'أدخل عدد أرقام الهاتف',
        'email' => 'البريد الإلكتروني',
        'address' => 'العنوان',
        'city' => 'المدينة',
        'state' => 'المحافظة',
        'password' => 'كلمة المرور',
        'name' => 'الاسم',
        'phone' => 'رقم الهاتف',
        'country_id' => 'الدوله',
        'password_confirm' => 'تأكيد كلمه المرور',
        'size_id' => 'المقاس',
        'color_id' => 'اللون',
        'unit_id' => 'الوحدة',
        'product_id' => 'المنتج',
        "name_ar" => "الأسم بالعربيه",
        "hexa_code" => "الكود بالهكسا",
        "name_en" => "الأسم بالأنجليزيه",
        "description_ar" => "الوصف بالعربيه",
        "description_en" => "الوصف بالأنجليزيه",
        'currency_ar' => 'العمله بالعربى',
        'currency_en' => 'العمله بالأنجليزيه',
        'currency_code' => 'كود العمله',
        'code' => 'كود الدوله',
        'category_id' => 'اسم الفئة',
        "product" => "المنتج",
        "store" => "المخزن",
        'amount' => 'الكميه',
        "price" => "السعر",
        "date" => "التاريخ",
        'latitute' => 'خط العرض',
        'longitute' => 'خط الطول',
        'manager_name' => 'اسم المدير',
        'opening_hours' => 'ساعات العمل',
        'is_freeze' => 'حالة التجميد',
        'contact_person' => 'الشخص المسؤول',
        'image' => 'الصورة',
        'main_image' => 'الصورة الاساسية',
        'is_remind' => 'تذكرة',
        'sku' => 'كود حفظ المخزن',
        'barcode' => 'باركود',
        'main_unit_id' => 'الوحدة الاساسية',
        'is_have_expired' => 'المنتج لديه تاريخ صلاحية',
        'code_size' => 'كود المقاس',
        'factor' => 'المعامل',
        'is_active' => 'صالح',
        'image_path' => 'الصورة',
        'reason' => 'السبب',
        'order_detail_id' => 'رقم الطلب',
        'order_id' => 'رقم الطلب',
        'order_status' => 'حالة الطلب',
        'payment_method' => 'طريقة الدفع',
        'paid' => 'المدفوع',
        'type' => 'النوع',
        'delivery_fees' => 'رسوم التوصيل',
        'note' => 'الملاحظة',
        'table_id' => 'رقم الطاولة',
        'coupon_code' => 'قسيمة الخصم',
        'details' => 'تفاصيل',
        'quantity' => 'الكمية',
        'total' => 'السعر الكلي',
        'recipe_id' => 'اسم الوصفة',
        'addons' => 'لاضافات',
        'recipe_addon_id' => 'اضافات الوصفة',
        'type_en' => 'اسم النظام بالأنجليزيه',
        'type_ar' => 'اسم النظام بالعربيه',
        'value_earn' => 'نسبه كسب النقاط',
        'value_redeem' => 'الحد الاقصى لنسبه خصم النقاط',
        'branch_id' => 'الفرع',
        'point_redeem' => 'نسبه تقيم النقطه للخصم',
        'discount_value' => 'قيمة الخصم',
        'count' => 'الكمية',
        'image_ar' => 'الصورة بالعربي',
        'image_en' => 'الصورة بالانجليزي',
        'branches' => 'الفروع',
        'branches.*' => 'فرع',
        'type_id' => 'اسم النوع',
        'active' => 'الفعالية',
        'value' => 'القيمة',
        'min_limit' => 'الحد الادنى',
        'max_limit' => 'الحد الاقصى',
        'auth.name' => 'الاسم',

    ],
    'countryCodeExists' => 'كود الدولة غير صالح.',
    'email_or_phone.required' => 'البريد الإلكتروني أو رقم الهاتف مطلوب.',
    'password.required' => 'كلمة المرور مطلوبة.',
    'country_code.required_if' => 'رمز البلد مطلوب عند تسجيل الدخول باستخدام رقم الهاتف.',
    'country_code.required' => 'رمزالبلد مطلوب',
    'passwordMatch' => 'كلمة المرور لا تتطابق مع سجلاتنا',
    'emailDoesntExist' => 'البريد الإلكتروني غير موجود.',
    'phoneDoesntExist' => 'رقم الهاتف مع رمز البلد غير موجود.',
    'newPasswordRequired' => 'كلمة المرور الجديدة مطلوبة.',
    'confirmPassword' => 'تأكيد كلمة المرور مطلوب.',
    'confirmPasswordSame' => 'تأكيد كلمة المرور يجب أن يطابق كلمة المرور الجديدة.',
    'newOldPassword' => 'لا يمكن أن تكون كلمة المرور الجديدة هي نفس كلمة المرور الحالية',
    //web
    'Correct' => 'صحيح',
    'Alert' => 'تنبيه',
    'Delete' => 'نعم, احذف',
    'Cancel' => 'الغاء',
    'EnterBrand' => 'يجب اختيار براند',
    'EnterBranch' => 'يجب اختيار فرع',
    'EnterFloor' => 'يجب اختيار دور',
    'EnterPartition' => 'يجب اختيار منطقة دور',
    'EnterTableNumber' => 'يجب اختيار رقم طاولة',
    'EnterDepartment' => 'يجب اختيار قسم',
    'EnterCapacity' => 'يجب اختيار سعة',
    'EnterEmployee' => 'يجب اختيار الموظف',
    'EnterImage' => 'يجب اختيار صورة',
    'EnterUnit' => 'يجب اختيار وحدة',
    'EnterCurrency' => 'يجب اختيار عملة',
    'EnterCategory' => 'يجب اختيار الفئة',
    'EnterCountry' => 'يجب اختيار الدولة',
    'EnterFlag' => 'يجب الاختيار لا يمكن ان تكون فارغة',
    'EnterDish' => 'يجب اختيار طبق',
    'EnterOffer' => 'يجب اختيار عرض',
    'EnterArabicName' => 'يجب ادخال الاسم بالعربي',
    'EnterEnglishName' => 'يجب ادخال الاسم بالانجليزي',
    'EnterHexaCode' => 'يجب ادخال الكود بالهكسا ',
    'EnterArabicDesc' => 'يجب ادخال الوصف بالعربي',
    'EnterEnglishDesc' => 'يجب ادخال الوصف بالانجليزي',
    'EnterArabicQue' => 'يجب ادخال السؤال بالعربي',
    'EnterEnglishQue' => 'يجب ادخال السؤال بالانجليزي',
    'EnterArabicAns' => 'يجب ادخال الاجابة بالعربي',
    'EnterEnglishAns' => 'يجب ادخال الاجابة بالانجليزي',
    'EnterBarcode' => 'يجب ادخال الباركود',
    'EnterPrice' =>  'يجب ادخال السعر',
    'EnterMaxLimit' =>  'يجب ادخال الحد الاقصى',
    'EnterMinLimit' =>  'يجب ادخال الحد الادني',
    'Entercode' => 'يجب ادخال الكود',
    'EnterDiscountValue' => 'يجب ادخال قيمة الخصم',
    'EnterMinimumSpend' => 'يجب ادخال الحد الادني لقيمة الشراء',
    'EnterUsageLimit' => 'يجب ادخال حد الاستخدام',
    'EnterStartDate' => 'يجب ادخال تاريخ البدء',
    'EnterEndDate' => 'يجب ادخال تاريخ الانتهاء',
    'DeleteConfirm' => 'هل انت متأكد من حذف هذا العنصر؟',
    'EnterLeaveType' => 'يجب اختيار انواع الاجازات',
    'EnterMinmum' => 'يجب ادخال الحد الادنى',
    'EnterMaxmum' => 'يجب ادخال الحد الاقصى',
    'EnterIsActive' => 'يجب ادخال علامة التقييم فعال ام لا',
    'EnterNameAr' => 'يجب ادخال الاسم بالعربيه ',
    'EnterNameEn' => 'يجب ادخال الاسم بالانجليزية ',
    'EnterValidEmail' => 'ادخل البريد الاكتلاوني',
    'EnterValidPhone' => 'ادخل رقم الهاتف',
    'EnterAddress' => 'ادخل العنوان',
    'EnterCity' => 'ادخل المدينة',
    'EnterState' => 'ادخل المحافظة',
    'EnterCountryCode' => 'ادخل رمز الدولة',
    'EnterValidAddressPhone' => 'ادخل رقم هاتف العنوان',
    'The category have relation' => 'هذا التصنيف له علاقه بمنتج',

    'EnterClosingHour' => 'ادخل وقت الاغلاق',
    'EnterOpeningHour' => 'ادخل وقت الفتح',
    'EnterPhone' => 'ادخل رقم الهاتف',
    'EnterLongitude' => 'أدخل خط الطول',
    'EnterLatitude' => 'أدخل خط العرض',
    'EnterEnglishAddress' => 'أدخل العنوان بالانجليزية',
    'EnterArabicAddress' => 'أدخل العنوان بالعربية',


    'custom' => [
        'name.required' => 'الاسم مطلوب ولا يمكن تركه فارغاً.',
        'permissions_ids.required' => 'الصلاحية مطلوبة ولا يمكن تركها فارغة.',
        'permissions_ids.*.exists' => 'الصلاحية المحددة غير موجودة.',
        'nameapart' => [
            'required' => 'اسم الشقة مطلوب.',
        ],
        'numapart' => [
            'required' => 'رقم الشقة مطلوب.',
        ],
        'phoneapart' => [
            'required' => 'رقم هاتف الشقة مطلوب.',
            'phone' => 'يجب أن يكون رقم الهاتف صحيحاً.',
        ],
        'country_code_apart' => [
            'required' => 'يرجى اختيار رمز الدولة للشقة.',
        ],
        'phone' => [
            'length' => 'يجب أن يتكون :attribute من :length رقمًا بالضبط.',
            'numeric' => 'يجب أن يكون :attribute رقماً فقط.',

        ],
        'auth.nameweb' => 'الاسم',
        'auth.name' => 'الاسم',

        'auth.emailweb' => 'البريد الإلكتروني',
        'auth.password' => 'كلمة المرور',
        'auth.phoneplace' => 'الهاتف',
        'auth.country_code' => 'رمز الدولة',
        'auth.date' => 'تاريخ الميلاد',
        'floorapart' => 'الطابق',
        'addressdetailapart' => 'تفاصيل العنوان',
        'markapart' => 'علامة',
        'namevilla' => 'اسم الفيلا',
        'villanumber' => 'رقم الفيلا',
        'addressdetailvilla' => 'تفاصيل العنوان للفيلا',
        'phonevilla' => 'رقم الهاتف للفيلا',
        'country_code_villa' => 'رمز الدولة للفيلا',
        'nameoffice' => 'اسم المكتب',
        'numaoffice' => 'رقم المكتب',
        'addressdetailoffice' => 'تفاصيل العنوان للمكتب',
        'phoneoffice' => 'رقم الهاتف للمكتب',
        'country_code_office' => 'رمز الدولة للمكتب',
        'flooroffice' => 'الطابق للمكتب',
    ],
    'EnterName' => 'أدخل الأسم',
];
