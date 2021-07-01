<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
require_once 'include.php';
if( auth_session() == false ){
    ?>
    <p>Вы не авторизованы!</p>
    <a href="auth/auth.php">Авторизуйтесь</a>
    <?php
    exit;
}
include 'menu.php';
if ($_GET['task'] == 'add_el') {

    CModule::IncludeModule('iblock');


    //Погнали
    $el = new CIBlockElement;
    $IBLOCK_ID = 2;
    //Свойства
    $PROP = array();

    $PROP['firstname'] = $_POST['firstname'];
    $PROP['lastname'] = $_POST['lastname'];
    $PROP['midname'] = $_POST['midname'];
    $PROP['gender'] = $_POST['gender'];
    $PROP['address'] = $_POST['address'];
    $date = new DateTime($_POST['birthday']);
    $PROP['birthday'] = $date->format('d.m.Y');
    $PROP['telephone'] = $_POST['telephone'];
    $PROP['class'] = $_POST['class'];

    //Основные поля элемента
    $fields = array(
        "IBLOCK_ID" => $IBLOCK_ID, //ID информационного блока он 1-ый
        "PROPERTY_VALUES" => $PROP, // Передаем массив значении для свойств
        "NAME" => $_REQUEST['lastname'],
        "ACTIVE" => "Y" //поумолчанию делаем активным или ставим N для отключении поумолчанию
    );


    //Результат в конце отработки
    if ($ID = $el->Add($fields)) {
        echo "Сохранено";
    } else {
        print(  $el->LAST_ERROR);
    }
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>