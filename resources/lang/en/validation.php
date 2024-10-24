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
        'hexa_code' => 'color hexa code',
        'category_id' => 'category name',
        "product" => 'product',
        "store" => 'store',
        'amount' => 'amount',
        "price" => 'price',
        "date" => 'date',
        'latitute' => 'latitude',
        'longitute' => 'longitude',
        'manager_name' => 'manager name',
        'opening_hours' => 'opening hours',
        'is_freeze' => 'freeze status',
        'contact_person' => 'contact person',
        'type_en'=>'Type name en',
        'type_ar'=>'type name ar',
        'value_earn'=>'value of earn',
        'value_redeem'=>'value of redeem',
        'branch_id'=>'branch',
        'point_redeem'=>'percent redeem of point ',

        'max' => [
            'string' => 'The :attribute may not be greater than :max characters.',
            'numeric' => 'The :attribute may not be greater than :max.',
        ],
        'min' => [
            'string' => 'The :attribute must be at least :min characters.',
            'numeric' => 'The :attribute must be at least :min.',
        ],
        'between' => [
            'numeric' => 'The :attribute must be between :min and :max.',
            'string' => 'The :attribute must be between :min and :max characters.',
        ],
        'boolean' => 'The :attribute field must be true or false.',

    ],

    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'name' => 'The :attribute field is required.',
    'phone' => 'The :attribute field is required.',
    'country_id' => 'The :attribute field is required.',
    'unauthenticated_title' => 'Unauthenticated title',
    'unauthenticated_msg' => 'Unauthenticated msg',
    'name' => 'The :attribute field is required.',
    'phone' => 'The :attribute field is required.',
    'country_id' => 'The :attribute field is required.',
    'exists' => "The :attribute field doesn't exist",
    'unique' => 'The :attribute field must be unique.',
    'integer' => 'The :attribute field must be integer.',
    'date_format' => 'The :attribute field must be in correct date.',
    'validator_title' => 'validation',
    'validator_msg' => 'validation messages',
    'product_expired' => 'This product is expired',
    'product_not_enough' => 'This product is not enough',
    'product_not_instore' => 'This product is not in store',
    'DataExist' => 'All ready Added',
    'DataExistMessage' => 'All ready Added',
    'is_active' => 'active',
    'image_path'=>'image'

];
