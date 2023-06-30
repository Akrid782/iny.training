<?php

namespace INY\Training\Services\Example1;

use Bitrix\Main\Engine\CurrentUser;
use CUser;

/**
 * class UpdaterUser
 *
 * @package INY\Training\Services\Example1
 */
class UpdaterUser
{
    protected array $errorList = [];

    /**
     * @param array $fieldList
     */
    public function __construct(protected readonly array $fieldList)
    {
    }

    /**
     * @return bool
     */
    public function updateCurrenUser(): bool
    {
        $user = new CUser();
        $isUpdate = $user->update(CurrentUser::get()->getId(), [
            ...$this->fieldList,
            ...['ACTIVE' => $this->isActive() ? 'Y' : 'N'],
        ]);

        if ($isUpdate === false) {
            $this->errorList[] = $user->LAST_ERROR;
        }

        return $isUpdate;
    }

    /**
     * @return array
     */
    public function getErrorList(): array
    {
        return $this->errorList;
    }

    /**
     * @return bool
     */
    protected function isActive(): bool
    {
        if (!$this->fieldList['LAST_NAME']) {
            return false;
        }

        return true;
    }
}
