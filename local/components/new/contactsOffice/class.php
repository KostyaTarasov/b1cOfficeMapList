<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

class СontactsOffice extends CBitrixComponent
{
    /**
     * Метод для выполнения компонента
     */
    public function executeComponent(): void
    {
        $arResult = $this->getCachedData();
        if (!$arResult) {
            $arResult = $this->getOfficeData();
            $this->setCache($arResult);
        }

        $this->arResult = $arResult;
        $this->includeComponentTemplate();
    }

    /**
     * Метод для получения данных из инфоблока
     *
     * @return array
     */
    private function getOfficeData(): array
    {
        $arResult = [];

        if (Loader::includeModule("iblock")) {
            $arSelect = ["ID", "NAME", "PROPERTY_OFFICE_NAME", "PROPERTY_OFFICE_PHONE", "PROPERTY_OFFICE_EMAIL", "PROPERTY_OFFICE_COORDINATES", "PROPERTY_OFFICE_CITY"];
            $arFilter = ["IBLOCK_CODE" => 'offices', "ACTIVE" => "Y"];

            $res = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                $arResult[] = [
                    "ID" => $arFields["ID"],
                    "NAME" => $arFields["NAME"],
                    "OFFICE_NAME" => $arFields["PROPERTY_OFFICE_NAME_VALUE"],
                    "OFFICE_PHONE" => $arFields["PROPERTY_OFFICE_PHONE_VALUE"],
                    "OFFICE_EMAIL" => $arFields["PROPERTY_OFFICE_EMAIL_VALUE"],
                    "OFFICE_COORDINATES" => $arFields["PROPERTY_OFFICE_COORDINATES_VALUE"],
                    "OFFICE_CITY" => $arFields["PROPERTY_OFFICE_CITY_VALUE"],
                ];
            }
        }

        return $arResult;
    }

    /**
     * Метод для получения кешированных данных
     *
     * @return array|null
     */
    private function getCachedData(): ?array
    {
        if ($this->startResultCache()) {
            return null;
        }

        return $this->arResult;
    }

    /**
     * Метод для установки кеша
     *
     * @param array $data
     */
    private function setCache(array $data): void
    {
        if (!empty($data)) {
            $this->arResult = $data;
            $this->setResultCacheKeys(["arResult"]);
        }
    }
}
