<?php

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use INY\Training\Event;
use INY\Training\Events;

if (class_exists('iny_training')) {
    return;
}

/**
 * class iny_training
 */
class iny_training extends CModule
{
    public $MODULE_ID = 'iny.training';

    public $MODULE_VERSION;

    public $MODULE_VERSION_DATE;

    public $MODULE_NAME;

    public $MODULE_DESCRIPTION;

    public $PARTNER_URI;

    public $PARTNER_NAME;

    public $MODULE_GROUP_RIGHTS = 'N';

    protected string $MODULE_FOLDER;

    public function __construct()
    {
        $moduleVersion = [];

        include __DIR__ . '/version.php';

        $this->MODULE_VERSION = $moduleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $moduleVersion['VERSION_DATE'];

        $this->MODULE_NAME = Loc::getMessage('INY_TRAINING_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('INY_TRAINING_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('INY_TRAINING_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('INY_TRAINING_PARTNER_URI');

        $this->MODULE_FOLDER = __DIR__ . '/..';
    }

    /**
     * @return void
     */
    public function DoInstall(): void
    {
        global $APPLICATION, $step;

        if (PHP_VERSION < 8.1) {
            $APPLICATION->ThrowException(
                Loc::getMessage('INY_TRAINING_MODULE_INSTALL_ERROR_MINIMUM_VERSION_PHP', [
                    '#VERSION#' => PHP_VERSION,
                ])
            );
        }

        $this->checkPermission();
        $this->showError();

        switch ((int) $step) {
            case 0:
            case 1:
                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('INY_TRAINING_INSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/step1.php'
                );
                break;
            case 2:
                if ($this->InstallDB()) {
                    $this->InstallFiles();
                }

                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('INY_TRAINING_INSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/step2.php'
                );
                break;
        }
    }

    /**
     * @return void
     * @throws ArgumentNullException
     */
    public function DoUninstall(): void
    {
        global $APPLICATION, $step;

        $this->checkPermission();
        $this->showError();

        switch ((int) $step) {
            case 0:
            case 1:
                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('INY_TRAINING_UNINSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/unstep1.php'
                );
                break;
            case 2:
                $this->UnInstallFiles();
                $this->UnInstallDB();

                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage('INY_TRAINING_UNINSTALL_TITLE'),
                    $this->MODULE_FOLDER . '/install/unstep2.php'
                );
                break;
        }
    }

    /**
     * @return void
     */
    public function InstallFiles(): void
    {
    }

    /**
     * @return void
     */
    public function UnInstallFiles(): void
    {
    }

    /**
     * @return bool
     */
    public function InstallDB(): bool
    {
        ModuleManager::registerModule($this->MODULE_ID);

        $eventManager = EventManager::getInstance();
        foreach ($this->getListEventHandler() as $event) {
            $eventManager->registerEventHandler(...$event);
        }

        return true;
    }

    /**
     * @return void
     * @throws ArgumentNullException
     */
    public function UnInstallDB(): void
    {
        $postList = Application::getInstance()->getContext()->getRequest()->getPostList();

        if ($postList->get('save_data') !== 'Y') {
            Option::delete($this->MODULE_ID);
        }

        $eventManager = EventManager::getInstance();
        foreach ($this->getListEventHandler() as $event) {
            $eventManager->unRegisterEventHandler(...$event);
        }

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    /**
     * @return array[]
     */
    public function getListEventHandler(): array
    {
        return [
            [
                'main',
                'OnPageStart',
                $this->MODULE_ID,
                Events\Provider::class,
                'onPageStart',
            ],
            [
                'main',
                'OnProlog',
                $this->MODULE_ID,
                Events\Provider::class,
                'onProlog',
            ],
            [
                'main',
                'OnBeforeUserUpdate',
                $this->MODULE_ID,
                Events\UserHandler::class,
                'onBeforeUserUpdate',
            ],
            [
                'main',
                'OnBeforeUserUpdate',
                $this->MODULE_ID,
                Event\User\UserHandler::class,
                'onBeforeUserUpdate',
            ],
        ];
    }

    /**
     * @return void
     */
    protected function checkPermission(): void
    {
        global $APPLICATION;

        if (!check_bitrix_sessid() || !CurrentUser::get()->isAdmin()) {
            $APPLICATION->ThrowException(Loc::getMessage('INY_TRAINING_MODULE_INSTALL_ERROR_PERMISSION'));
        }
    }

    /**
     * @return void
     */
    protected function showError(): void
    {
        global $APPLICATION;

        if ($APPLICATION->GetException()) {
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('INY_TRAINING_MODULE_INSTALL_ERROR'),
                $this->MODULE_FOLDER . "/install/error.php"
            );
        }
    }
}
