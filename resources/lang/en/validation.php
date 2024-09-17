<?php
return [
    //add here the attributes of validation to translated
    'attributes' => [
        'email' => 'email address',
        'password' => 'password',
        'name' => 'name',
        'phone' => 'phone',
        'country_id' => 'country',
        "name_ar" => "name in arabic",
        "name_en" => "name in english",
        'currency_ar' => 'currency in arabic',
        'currency_en' => 'currency in english',
        'currency_code' => 'currency code',
        'code' => 'code',
        'hexa_code'=> 'color hexa code',
        'category_id'=>'category name',
        "product" =>'product',
        "store" => 'store',
        'amount' => 'amount',
        "price" =>'price',
        "date" => 'date',
    ],


    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'name' => 'The :attribute field is required.',
    'phone' => 'The :attribute field is required.',
    'country_id' => 'The :attribute field is required.',
    'exists'=>"The :attribute field doesn't exist",
    'unique'=>'The :attribute field must be unique.',
    'integer' => 'The :attribute field must be integer.',
    'date'=>'The :attribute field must be in correct date.',
];
