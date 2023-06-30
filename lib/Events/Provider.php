<?php

namespace INY\Training\Events;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use INY\Training\Services\Example3\CustomerDI;

/**
 * class Provider
 *
 * @package INY\Training\Events
 */
class Provider
{
    /**
     * @return void
     * @throws LoaderException
     */
    public static function onPageStart(): void
    {
        Loader::includeModule('iny.training');
    }

    /**
     * @return void
     */
    public static function onProlog(): void
    {
        CustomerDI::runCustomization();
    }
}
