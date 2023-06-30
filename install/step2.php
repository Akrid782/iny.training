<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CMain $APPLICATION
 */

use Bitrix\Main\Localization\Loc;

CAdminMessage::ShowNote(Loc::getMessage('MOD_INST_OK'));
?>
<form action="<?= $APPLICATION->GetCurPage() ?>">
    <div>
        <input type="hidden" name="lang" value="<?= LANG ?>">
        <input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
    </div>
</form>
