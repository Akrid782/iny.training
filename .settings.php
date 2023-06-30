<?php

use Bitrix\Main\Engine\CurrentUser;
use INY\Training\Services\Example2\User;

return [
    'services' => [
        'value' => [
            'employeeTraining.services.user.get' => [
                'className' => User::class,
            ],
            'employeeTraining.services.user.current.get' => [
                'className' => User::class,
                'constructorParams' => static function () {
                    return [CurrentUser::get()->getId()];
                },
            ],
            'employeeTraining.services.user.custom.get' => [
                'className' => User::class,
            ],
        ],
        'readonly' => true,
    ],
];
