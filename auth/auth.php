<?php
session_start();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
CModule::IncludeModule('iblock');
function auth(){
    global $conf;


    $error = array();
    $flag = false;
    if(!isset($_POST['mail'])){

        $error[] = 'Электронная почта не введена';
    }

    if( ! count($error) ) {
        $_POST['mail']      = trim($_POST['mail']);
        $_POST['password']  = trim($_POST['password']);

        $IBLOCK_ID = 6;
        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
        $arFilter = Array(
            "IBLOCK_ID" => $IBLOCK_ID
        );
        $res = CIBlockElement::GetList(Array(), $arFilter);
        while ($row = $res->GetNextElement()) {
            $arFields = $row->GetFields();
            $arProp = $row->GetProperties();
            if($arProp['login']['VALUE'] == $_POST['mail'] && $arProp['password']['VALUE'] ==  $_POST['password']){
                $flag = true;
                $_SESSION['login'] = $_POST['mail'];
                $_SESSION['AId'] = $arFields['ID'];
                return $flag;
            }
        }
    }
    else {
        echo 'Электронная почта не введена';
        return false;
    }
    if(!$flag){
        echo 'Электронная почта и пароль не верны';
        return $flag;
    }

}
function auth_session(){

    if(!empty($_SESSION['login']) AND !empty( $_SESSION['AId'])) {

        $AId = intval($_SESSION['AId']);
        $login= $_SESSION['login'];

        $IBLOCK_ID = 6;
        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
        $arFilter = Array(
            "IBLOCK_ID" => $IBLOCK_ID
        );
        $res = CIBlockElement::GetList(Array(), $arFilter);
        while ($row = $res->GetNextElement()) {
            $arFields = $row->GetFields();
            $arProp = $row->GetProperties();
            if($arFields['ID'] == $AId && $arProp['login']['VALUE'] ==  $login){
                return true;
            }
        }
    }

    return false;
}
if(!auth_session()){
    require_once 'auth.html';
    if($_POST['log_in']) {
        if (auth()) {
            ?>
            <p>Вы авторизованы! Перейдите по ссылке.</p>
            <a href="../index.php">Ссылка</a>
            <?php
        }
        else{
            ?>
            <p>Ошибка авторизации!</p>
            <?php
        }
    }
}