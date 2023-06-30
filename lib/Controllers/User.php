<?php

namespace INY\Training\Controllers;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Error;
use INY\Training\Services\Example1\UpdaterUser;

/**
 * class User
 *
 * @package INY\Training\Controllers
 */
class User extends Controller
{
    /**
     * @param array $fieldList
     *
     * @return bool
     */
    public function updateCurrentUserAction(array $fieldList): bool
    {
        $updaterUser = new UpdaterUser($fieldList);
        $isUpdate = $updaterUser->updateCurrenUser();

        if ($isUpdate) {
            foreach ($updaterUser->getErrorList() as $errorMessage) {
                $this->addError(new Error($errorMessage, 400));
            }
        }

        return $isUpdate;
    }
}
