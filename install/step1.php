<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CMain $APPLICATION
 */

use Bitrix\Main\Localization\Loc;

?>

<form action="<?= $APPLICATION->GetCurPage() ?>" name="form1" method="post"> <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANG ?>" />
    <input type="hidden" name="id" value="iny.training" />
    <input type="hidden" name="install" value="Y" />
    <input type="hidden" name="step" value="2" />

    <hr />
    <div>
        <input type="submit" name="install" value="<?= Loc::getMessage('MOD_INSTALL') ?>" />
    </div>
</form>
