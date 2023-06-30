<?php

namespace INY\Training\Events;

use INY\Training\Services\Example1\UpdaterUser;

/**
 * class UserHandler
 *
 * @package INY\Training\Events
 */
class UserHandler
{
    /**
     * @param array $fieldList
     *
     * @return bool
     */
    public static function onBeforeUserUpdate(array $fieldList): bool
    {
        global $APPLICATION;

        $updaterUser = new UpdaterUser($fieldList);
        if ($updaterUser->updateCurrenUser()) {
            $APPLICATION->throwException(implode('<br/>', $updaterUser->getErrorList()));

            return false;
        }

        return true;
    }
}
