<?php

namespace INY\Training\Services\Example4;

use Bitrix\Main;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\ORM\Query\Filter\ConditionTree;
use Bitrix\Main\ORM\Query\Query;

/**
 * class GoodCode
 *
 * @package INY\Training\Services\Example4
 */
class GoodCode
{
    public const CACHE_TIME = 3600;
    public const FIELD_DATA_CREATED = 'DATA_CREATED';

    /**
     * @return array
     * @throws Main\ArgumentException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     */
    public function execute(): array
    {
        $result = [];
        $resultUser = Main\UserTable::query()
            ->setSelect(['*'])
            ->where('ID', '=', CurrentUser::get()->getId())
            ->where(
                $this->getQueryFilter()
            )
            ->setCacheTtl(self::CACHE_TIME)
            ->exec();
        while ($user = $resultUser->fetch()) {
            if ($user['ACTIVE'] === 'Y') {
                $result[] = $user;
            }
        }

        return $result;
    }

    /**
     * @return ConditionTree
     * @throws Main\ArgumentException
     */
    protected function getQueryFilter(): ConditionTree
    {
        $nameList = ['Андрей', 'Леша', 'Коля', 'Маша'];

        return Query::filter()
            ->logic(Query::filter()::LOGIC_OR)
            ->where(
                self::FIELD_DATA_CREATED,
                ">",
                '12.12.2022'
            )
            ->whereIn('UF_NAME', $nameList)
            ->whereNotNull('GROUPS');
    }
}
