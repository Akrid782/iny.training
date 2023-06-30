<?php

namespace INY\Training\Services\Example2;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\UserTable;

/**
 * class User
 *
 * @package INY\Training\Services\Example2
 */
class User
{
    /**
     * @param int $id
     */
    public function __construct(protected readonly int $id = 0)
    {
    }

    /**
     * @return array|bool
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getUser(): array|bool
    {
        return UserTable::query()
            ->setSelect(['*'])
            ->where('ID', '=', $this->id)
            ->setCacheTtl(3600)
            ->exec()
            ->fetch();
    }
}
