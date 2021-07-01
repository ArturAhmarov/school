<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
CModule::IncludeModule('iblock');
$res = CIBlockElement::GetByID(2);
if($ar_res = $res->GetNext()){
    print '<pre>';
    print_r( $ar_res);
    print '<pre>';
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>