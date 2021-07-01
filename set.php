<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
CModule::IncludeModule('iblock');
$ELEMENT_ID = 9;  // код элемента
$PROPERTY_CODE = "Theme";  // код свойства
$PROPERTY_VALUE = "1234";  // значение свойства

// Установим новое значение для данного свойства данного элемента
CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");