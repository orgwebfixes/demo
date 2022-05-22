<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute स्वीकार किया जाना चाहिए ।',
    'active_url'           => ':attribute एक मान्य URL नहीं है।',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute केवल अक्षर होहोना चाहिए।',
    'alpha_dash'           => ':attribute केवल अक्षर, संख्या, और डैश होहोना चाहिए।',
    'alpha_num'            => ':attribute केवल अक्षर और संख्या होहोना चाहिए।',
    'array'                => ':attribute एक सरणी होना चाहिए।',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'attribute फ़ील्ड सही है या गलत होना चाहिए।',
    'confirmed'            => ':attribute पुष्टि मेल नहीं खाता।',
    // 'date'                 => ':attribute मान्य दिनांक नहीं है।',
    'date_format'          => 'जन्म तिथि प्रारूप डी- एम- वाई मेल नहीं खाता।',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => 'ईमेल एक मान्य ईमेल पता होना चाहिए।',
    'exists'               => 'चयनित :attribute फ़ील्ड अमान्य है।',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => ':attribute पूर्णांक होना चाहिए।',
    'ip'                   => ':attribute मान्य IP पता होना चाहिए।',
    'json'                 => ':attribute वैध JSON तार होना चाहिए।',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'चयनित :attribute फ़ील्ड अमान्य है।',
    'regex'                => ':attribute प्रारूप अमान्य है।',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => ':attribute स्ट्रिंग होना चाहिए ।',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => ':attribute स्ट्रिंग होना चाहिए।',
    'timezone'             => ':attribute वैध फ़ील्ड में होना चाहिए।',
    'unique'               => ':attribute पहले से ही लिया जा चुका है।',
    'url'                  => ':attribute प्रारूप अमान्य है।',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'validate_field' => 'पासवर्ड :attribute भी कमजोर है और एक या अधिक अपरकेस , लोअरकेस , आंकिक , और विशेष चरित्र (! @ # $% ^ & *) होना चाहिए।',
    'custom' => [
        'city_id' => [
            'required' => 'शहर का नाम फ़ील्ड अनिवार्य है।',
        ],
        'date_of_birth' => [
            'date' => 'दिनांक फ़ील्ड अनिवार्य है।',
        ],
    ],

    'validate_is_default_yes' => 'कम से कम एक कर डिफ़ॉल्ट होना चाहिए।',
    'validate_prevent_is_default_change' => 'कम से कम एक कर डिफ़ॉल्ट होना चाहिए।',
    'validate_form_document'=>'The Form Document Already Exist',
    'validate_currentpassword'=>'वर्तमान पासवर्ड गलत है',
    'validate_otp'=>'आप अमान्य OTP प्रवेश किया है।',
    'validate_commission'=>'ऑपरेटर काम कमीशन 65% से अधिक नहीं हो सकता है।',
    'validate_commission_but_user'=>'ऑपरेटर काम ऑनलाइन कमीशन के मान 65% से अधिक नहीं हो सकता है।',
    'validate_commission_urban'=>'ऑपरेटर काम कमीशन 60% से अधिक नहीं हो सकता है।',
    'validate_commission_but_user_urban'=>'ऑपरेटर काम ऑनलाइन कमीशन के मान 60% से अधिक नहीं हो सकता है।',

    'validate_amount'=>'राशि वॉलेट राशि से अधिक नहीं होनी चाहिए।',
    'validate_greater' => 'राशि 0 से अधिक होना चाहिए।',
    'validate_ifcs' => 'वैध IFSC कोड दर्ज करें।।',
    'validate_operator' => 'कृपया वैध ऑपरेटर का चयन करें।',
    'validate_circle' => 'कृपया वैध क्षेत्र का चयन करें',
    'prevent_district' => 'जिला उपयोग में है, यह अद्यतन नहीं किया जा सकता है।',
    'prevent_state' => 'राज्य उपयोग में है, यह अद्यतन नहीं किया जा सकता है।',
    'prevent_taluka' => 'तालुका उपयोग में है, यह अद्यतन नहीं किया जा सकता है।',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
