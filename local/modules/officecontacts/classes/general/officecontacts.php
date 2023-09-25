<?php

class OfficeContacts1
{
    public function getContactsOffice(): void
    {
        $iblockType = 'content';
        $iblockCode = 'offices';
        $iblockName = "office_iblock_name";

        $this->createIblockType($iblockType);
        $iblockId = $this->createIblock($iblockCode, $iblockName, $iblockType);
        $this->createIblockProperties($iblockId);
        $this->fillIblockWithData($iblockId);
    }

    private function createIblockType(string $iblockType): void
    {
        \CModule::IncludeModule("iblock");

        $iblockTypeFields = [
            'ID' => $iblockType,
            'SECTIONS' => 'Y',
            'IN_RSS' => 'N',
            'SORT' => 500,
            'LANG' => [
                'en' => [
                    'NAME' => 'Content',
                ],
                'ru' => [
                    'NAME' => 'Контент',
                ],
            ],
        ];

        $iblockTypeObject = new \CIBlockType;
        $iblockTypeObject->Add($iblockTypeFields);
    }

    private function createIblock(string $iblockCode, string $iblockName, string $iblockType): int
    {
        $iblock = new \CIBlock;

        $arFields = [
            "ACTIVE" => "Y",
            "NAME" => $iblockName,
            "CODE" => $iblockCode,
            "IBLOCK_TYPE_ID" => $iblockType,
            "SITE_ID" => ["s1"],
            "SORT" => 100,
            "GROUP_ID" => ["2" => "R"],
        ];

        return $iblock->Add($arFields);
    }

    private function createIblockProperties(int $iblockId): void
    {
        $properties = [
            [
                "NAME" => "office_name",
                "CODE" => "OFFICE_NAME",
                "TYPE" => "S",
                "SORT" => 100,
            ],
            [
                "NAME" => "office_phone",
                "CODE" => "OFFICE_PHONE",
                "TYPE" => "S",
                "SORT" => 200,
            ],
            [
                "NAME" => "office_email",
                "CODE" => "OFFICE_EMAIL",
                "TYPE" => "S",
                "SORT" => 300,
            ],
            [
                "NAME" => "office_coordinates",
                "CODE" => "OFFICE_COORDINATES",
                "TYPE" => "S",
                "SORT" => 400,
            ],
            [
                "NAME" => "office_city",
                "CODE" => "OFFICE_CITY",
                "TYPE" => "S",
                "SORT" => 500,
            ],
        ];

        $propertyObject = new \CIBlockProperty;

        foreach ($properties as $property) {
            $property["IBLOCK_ID"] = $iblockId;
            $propertyObject->Add($property);
        }
    }

    private function fillIblockWithData(int $iblockId): void
    {
        $data = [
            [
                "NAME" => "Офис 1",
                "OFFICE_NAME" => "Офис в Москве",
                "OFFICE_PHONE" => "+7 (123) 356-7894",
                "OFFICE_EMAIL" => "office1@example.com",
                "OFFICE_COORDINATES" => "55.7558, 37.6173",
                "OFFICE_CITY" => "Москва",
            ],
            [
                "NAME" => "Офис 2",
                "OFFICE_NAME" => "Офис в Санкт-Петербурге",
                "OFFICE_PHONE" => "+7 (987) 654-3237",
                "OFFICE_EMAIL" => "office2@example.com",
                "OFFICE_COORDINATES" => "59.9343, 30.3351",
                "OFFICE_CITY" => "Санкт-Петербург",
            ],
        ];

        foreach ($data as $item) {
            $el = new \CIBlockElement;
            $arFields = [
                "IBLOCK_ID" => $iblockId,
                "NAME" => $item["NAME"],
                "ACTIVE" => "Y",
                "PROPERTY_VALUES" => [
                    "OFFICE_NAME" => $item["OFFICE_NAME"],
                    "OFFICE_PHONE" => $item["OFFICE_PHONE"],
                    "OFFICE_EMAIL" => $item["OFFICE_EMAIL"],
                    "OFFICE_COORDINATES" => $item["OFFICE_COORDINATES"],
                    "OFFICE_CITY" => $item["OFFICE_CITY"],
                ],
            ];

            $el->Add($arFields);
        }
    }
}
