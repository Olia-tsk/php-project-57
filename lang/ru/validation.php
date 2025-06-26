<?php

return [
    'required'  => 'Это обязательное поле',
    'unique'    => 'Поле с таким именем уже существует',
    'confirmed' => ':attribute не совпадает.',
    'email' => ':attribute введён некорректно.',

    'min' => [
        'string' => ':attribute должен быть как минимум :min символов.',
    ],
    'attributes' => [
        'password' => 'Пароль',
    ],
];
