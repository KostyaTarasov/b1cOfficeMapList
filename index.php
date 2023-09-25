<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Контакты офисов");

$APPLICATION->IncludeComponent(
	"new:contactsOffice",
	"",
	array(
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "N"
	),
	false
);