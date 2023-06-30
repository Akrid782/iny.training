<?php

namespace INY\Training\Services\Example3;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\SystemException;

/**
 * class CustomerDI
 *
 * @package INY\Training\Services\Example3
 */
class CustomerDI
{
    /**
     * @return void
     */
    public static function runCustomization(): void
    {
        try {
            $serviceLocator = ServiceLocator::getInstance();

            $serviceLocator->addInstanceLazy('employeeTraining.services.user.custom.get', [
                'className' => UserCustom::class,
                'constructorParams' => static function () {
                    return [CurrentUser::get()->getId()];
                },
            ]);
        } catch (SystemException $exception) {
        }
    }
}
