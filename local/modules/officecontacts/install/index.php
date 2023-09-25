<?

class OfficeContacts extends CModule
{
    public $MODULE_ID = 'officecontacts';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;

    public function __construct()
    {
        $this->MODULE_NAME = 'Контакты';
        $this->MODULE_DESCRIPTION = 'Модуль для получения контактов офисов';
        $this->MODULE_VERSION = '0.1.0';
        $this->MODULE_VERSION_DATE = '2023-04-04';
    }

    public function DoInstall()
    {
        registerModule($this->MODULE_ID);
        CModule::IncludeModule('officecontacts');
        $contactsOffice = new OfficeContacts1();
        $contactsOffice->getContactsOffice();
    }

    public function DoUninstall()
    {
        UnRegisterModule($this->MODULE_ID);
    }
}
