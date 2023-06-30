<?php

namespace INY\Training\Services\Example3;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use INY\Training\Services\Example2\User;

/**
 * class UserCustom
 *
 * @package INY\Training\Services\Example3
 */
class UserCustom extends User
{
    /**
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getUser(): array
    {
        $result = parent::getUser();

        $result['NAME'] = 'Ха я тебя скастомизировал';

        return $result;
    }
}
