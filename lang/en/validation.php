<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | following language lines contain default error messages used by
    | validator class. Some of these rules have multiple versions such
    | as size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute должны быть приняты.',
    'active_url' => ':attribute не является действительным URL.',
    'after' => ':attribute должна быть датой после :date.',
    'after_or_equal' => ':attribute должна быть датой после или равной :date.',
    'alpha' => ':attribute может содержать только буквы.',
    'alpha_dash' => ':attribute может содержать только буквы, цифры, тире и символы подчеркивания.',
    'alpha_num' => ':attribute может содержать только буквы и цифры.',
    'array' => ':attribute должен быть массивом.',
    'before' => ':attribute должна быть датой до :date.',
    'before_or_equal' => ':attribute должна быть датой, предшествующей или равной :date.',
    'between' => [
        'numeric' => ':attribute должен находиться между :min и :max.',
        'file' => ':attribute должен находиться между :min и :max kilobytes.',
        'string' => ':attribute должен находиться между :min и :max characters.',
        'array' => ':attribute должно быть между :min и :max items.',
    ],
    'boolean' => ':attribute поле должно быть истинным или ложным.',
    'confirmed' => ':attribute подтверждение не соответствует.',
    'date' => ':attribute не является действительной датой.',
    'date_equals' => ':attribute должна быть датой, равной :date.',
    'date_format' => ':attribute не соответствует формату :format.',
    'different' => ':attribute и :other должны быть разными.',
    'digits' => ':attribute должен быть :digits цифры.',
    'digits_between' => ':attribute должен находиться между :min и :max цифры.',
    'dimensions' => ':attribute имеет недопустимые размеры изображения.',
    'distinct' => ':attribute поле имеет дублирующее значение.',
    'email' => ':attribute должен быть действительный адрес электронной почты.',
    'exists' => 'выбранные :attribute недействителен.',
    'file' => ':attribute должен быть файлом.',
    'filled' => ':attribute поле должно иметь значение.',
    'gt' => [
        'numeric' => ':attribute должно быть больше, чем :value.',
        'file' => ':attribute должно быть больше, чем :value килобайты.',
        'string' => ':attribute должно быть больше, чем :value персонажи.',
        'array' => ':attribute должно быть больше, чем :value товары.',
    ],
    'gte' => [
        'numeric' => ':attribute должно быть больше или равно :value.',
        'file' => ':attribute должно быть больше или равно :value килобайты.',
        'string' => ':attribute должно быть больше или равно :value персонажи.',
        'array' => ':attribute должен быть :value предметы или более.',
    ],
    'image' => ':attribute должно быть изображением.',
    'in' => 'выбранные :attribute недействителен.',
    'in_array' => ':attribute поле не существует в :other.',
    'integer' => ':attribute должно быть целым числом.',
    'ip' => ':attribute должен быть действительным IP-адресом.',
    'ipv4' => ':attribute должен быть действительным адресом IPv4.',
    'ipv6' => ':attribute должен быть действительным IPv6-адресом.',
    'json' => ':attribute должна быть корректной строкой JSON.',
    'lt' => [
        'numeric' => ':attribute должно быть меньше, чем :value.',
        'file' => ':attribute должно быть меньше, чем :value килобайты.',
        'string' => ':attribute должно быть меньше, чем :value персонажи.',
        'array' => ':attribute должно быть меньше, чем :value товары.',
    ],
    'lte' => [
        'numeric' => ':attribute должно быть меньше или равно :value.',
        'file' => ':attribute должно быть меньше или равно :value kilobytes.',
        'string' => ':attribute должно быть меньше или равно :value characters.',
        'array' => ':attribute не должно быть больше, чем :value items.',
    ],
    'max' => [
        'numeric' => ':attribute не может быть больше, чем :max.',
        'file' => ':attribute не может быть больше, чем :max kilobytes.',
        'string' => ':attribute не может быть больше, чем :max characters.',
        'array' => ':attribute не может быть больше, чем :max items.',
    ],
    'mimes' => ':attribute должен быть файлом тип: :values.',
    'mimetypes' => ':attribute должен быть файлом типа: :values.',
    'min' => [
        'numeric' => ':attribute должно быть не менее :min.',
        'file' => ':attribute должно быть не менее :min килобайты.',
        'string' => ':attribute должен быть не менее :min персонажи.',
        'array' => ':attribute должен иметь как минимум :min товары.',
    ],
    'not_in' => 'выбранные :attribute недействителен.',
    'not_regex' => ':attribute формат недопустим.',
    'numeric' => ':attribute должно быть числом.',
    'present' => ':attribute поле должно присутствовать.',
    'regex' => ':attribute формат недопустим.',
    'required' => ':attribute поле обязательно.',
    'required_if' => ':attribute поле необходимо, когда :other это :value.',
    'required_unless' => ':attribute поле обязательно, если только :other находится в :values.',
    'required_with' => ':attribute поле необходимо, когда :values присутствует.',
    'required_with_all' => ':attribute поле необходимо, когда :values присутствуют.',
    'required_without' => ':attribute поле необходимо, когда :values не присутствует.',
    'required_without_all' => ':attribute поле требуется, если ни одно из :values присутствуют.',
    'same' => ':attribute и :other должен совпадать.',
    'size' => [
        'numeric' => ':attribute должен быть :size.',
        'file' => ':attribute должен быть :size килобайты.',
        'string' => ':attribute должен быть :size персонажи.',
        'array' => ':attribute must contain :size товары.',
    ],
    'starts_with' => ':attribute должен начинаться с одного из следующих слов: :values',
    'string' => ':attribute должно быть строкой.',
    'timezone' => ':attribute должна быть действительной зоной.',
    'unique' => ':attribute уже используется.',
    'uploaded' => ':attribute не удалось загрузить.',
    'url' => ':attribute формат недопустим.',
    'uuid' => ':attribute должен быть действительным UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'пользовательское сообщение',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
