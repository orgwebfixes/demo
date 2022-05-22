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

    'accepted'             => ':attribute સ્વીકારવામાં આવો જોઈએ.',
    'active_url'           => ':attribute માન્ય URL નથી.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => ':attribute માત્ર અક્ષરો સમાવી શકે છે.',
    'alpha_dash'           => ':attribute માત્ર અક્ષરો, નંબરો, અને ડેશો સમાવી શકે છે.',
    'alpha_num'            => ':attribute માત્ર અક્ષરો અને સંખ્યાઓ સમાવી શકે છે.',
    'array'                => ':attribute ઝાકઝમાળ હોવા જ જોઈએ.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute ફિલ્ડ સાચું કે ખોટું હોવુ જોઈએ.',
    'confirmed'            => ':attribute ખાતરી સાથે મેળ ખાતું નથી.',
    // 'date'                 => ':attribute માન્ય તારીખ નથી.',
    'date_format'          => 'જન્મ તારીખ ફોર્મેટ ડી-એમ-વાય સાથે મેળ ખાતું નથી .',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => 'ઇમેઇલ માન્ય ઇમેઇલ સરનામું હોવું જ જોઈએ',
    'exists'               => 'પસંદ :attribute ફિલ્ડ અમાન્ય છે.',
    // 'filled'               => 'The :attribute field is required.',
    'image'                => ':attribute છબી હોવી જોઈએ.',
    'in'                   => 'પસંદ :attribute ફિલ્ડ અમાન્ય છે.',
    'integer'              => ':attribute પૂર્ણાંક હોવું જોઈએ.',
    'ip'                   => ':attribute માન્ય IP સરનામું હોવું જોઈએ.',
    'json'                 => ':attribute માન્ય JSON સ્ટ્રિંગ હોવી જોઈએ.',
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
    'not_in'               => 'પસંદ :attribute ફિલ્ડ અમાન્ય છે.',
    'regex'                => ':attribute ફોર્મેટ અમાન્ય છે',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => ':attribute શબ્દમાળા હોવી જોઈએ.',
    'timezone'             => ':attribute માન્ય ઝોન હોવા જ જોઈએ.',
    'unique'               => ':attribute પહેલેથી જ લેવામાં આવી છે',
    'url'                  => ':attribute ફોર્મેટ અમાન્ય છે',

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
    'validate_field' => 'પાસવર્ડ :attribute ખૂબ નબળો છે અને એક અથવા વધુ મોટા, નાના , આંકડાકીય, અને વિશિષ્ટ અક્ષર (! @ # $ % ^ & *) જ સમાવતું હોવું જોઈએ .
',
    'custom' => [
        'city_id' => [
            'required' => 'શહેરનું નામ ફિલ્ડ ફરજિયાત છે.',
        ],
        'date_of_birth' => [
            'date' => 'તારીખ ફિલ્ડ ફરજિયાત છે.',
        ],
    ],

    'validate_is_default_yes' => 'ઓછામાં ઓછા એક કર મૂળભૂત હોવૂ જોઈએ.',
    'validate_prevent_is_default_change' => 'ઓછામાં ઓછા એક કર મૂળભૂત હોવૂ જોઈએ.',
    'validate_form_document'=>'The Form Document Already Exist',
    'validate_currentpassword'=>'વર્તમાન પાસવર્ડ ખોટો છે',
    'validate_otp'=>'તમે અમાન્ય OTP દાખલ કરેલ છે',
    'validate_commission'=>'ઓપરેટર કામ કમિશન 65% કરતાં વધારે ન હોઈ શકે.',
    'validate_commission_but_user'=>'ઓપરેટર કામ ઓનલાઇન કમિશન મૂલ્ય 65% કરતાં વધારે ન હોઈ શકે.',
    'validate_commission_urban'=>'ઓપરેટર કામ કમિશન 60% કરતાં વધારે ન હોઈ શકે.',
    'validate_commission_but_user_urban'=>'ઓપરેટર કામ ઓનલાઇન કમિશન મૂલ્ય 60% કરતાં વધારે ન હોઈ શકે.',

    'validate_amount'=>'રકમ વોલેટ બેલેન્સ કરતાં મોટો ન હોવી જોઇએ',
    'validate_greater' => 'રકમ 0 કરતાં મોટી હોવી જ જોઈએ.',
    'validate_credential' =>'Invalid Email/PSK ID',
    'validate_ifcs' => 'માન્ય IFSC કોડ દાખલ કરો .',
    'validate_operator' => 'કૃપા કરીને માન્ય ઓપરેટર પસંદ કરો.',
    'validate_circle' => 'કૃપા કરીને માન્ય ક્ષેત્ર પસંદ કરો.',
    'prevent_district' => 'જિલ્લા વપરાશમાં છે, તે અપડેટ કરી શકો નહિ.',
    'prevent_state' => 'રાજ્ય વપરાશમાં છે,તે અપડેટ કરી શકો નહિ.',
    'prevent_taluka' => 'તાલુકા વપરાશમાં છે,તે અપડેટ કરી શકો નહિ.',

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
