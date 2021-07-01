<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
require_once 'include.php';
if( auth_session() == false ){
    ?>
    <p>Вы не авторизованы!</p>
    <a href="auth/auth.php">Авторизуйтесь</a>
    <?php
    exit;
}
CModule::IncludeModule('iblock');
$IBLOCK_ID = 4;
$flag = false;
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
$arFilter = Array("IBLOCK_ID"=> $IBLOCK_ID );
$res = CIBlockElement::GetList(Array(), $arFilter);
if(!empty($res)) {
    while ($row = $res->GetNextElement()) {
        $arFields = $row->GetFields();
        $arProp = $row->GetProperties();
        if ($arProp['number_class']['VALUE'] == 9) {
            CIBlockElement::Delete($arFields['ID']);
        } else {
            $new_number = $arProp['number_class']['VALUE'] + 1;
            $el = new CIBlockElement;
            $PROP = array();
            $PROP['number_class'] = $new_number;
            $PROP['letter_class'] = $arProp['letter_class']['VALUE'];
            $fields = array(
                "IBLOCK_ID" => 5,
                "PROPERTY_VALUES" => $PROP,
                "NAME" => $arFields['NAME'],
                "ACTIVE" => "Y"
            );
            $el->Update($arFields['ID'], $fields);
        }
    }
    echo "<H1>Перевод выполнен успешно!</H1>";
}
?>