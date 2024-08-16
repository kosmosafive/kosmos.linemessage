<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class kosmos_linemessage extends CModule
{
    public $MODULE_ID = 'kosmos.linemessage';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;
    public $PARTNER_URI;

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('KOSMOS_LINE_MESSAGE_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('KOSMOS_LINE_MESSAGE_MODULE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('KOSMOS_LINE_MESSAGE_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('KOSMOS_LINE_MESSAGE_PARTNER_URI');
    }

    public function DoInstall(): void
    {
        global $APPLICATION;

        ModuleManager::registerModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('KOSMOS_LINE_MESSAGE_INSTALL_TITLE'),
            dirname(__DIR__) . '/install/step.php'
        );
    }

    public function DoUninstall(): void
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}
