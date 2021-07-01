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
CModule::IncludeModule('iblock');
$IBLOCK_ID = 5;
$id_el = $_GET['id_el'];
$ar_id_student = CIBlockElement::GetByID($id_el);
if($ar_res = $ar_id_student->GetNextElement()){
    $arFields = $ar_res->GetFields();
    $arProp = $ar_res->GetProperties();
    $id_s = $arFields['ID'];
    $id_class = $arProp['class']['VALUE'];
}
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="crud">
                <?php
                if ($_POST['add']) {
                    $el = new CIBlockElement;
                    $PROP = array();
                    $PROP['subject'] = $_POST['subject'];
                    $PROP['grade'] = $_POST['grade'];
                    $PROP['id_student'] = $id_s;
                    $PROP['id_class'] = $id_class;
                    $name ="Оценка'$id_s'";
                    $fields = array(
                        "IBLOCK_ID" => $IBLOCK_ID, //ID информационного блока он 1-ый
                        "PROPERTY_VALUES" => $PROP, // Передаем массив значении для свойств
                        "NAME" =>  $name,
                        "ACTIVE" => "Y" //поумолчанию делаем активным или ставим N для отключении поумолчанию
                    );


                    //Результат в конце отработки
                    if ($ID = $el->Add($fields)) {
                        echo "Сохранено";
                    } else {
                        print(  $el->LAST_ERROR);
                    }
                }
                ?>
                <form name="add"  method="POST">
                    <p>Предмет</p>
                    <input type="text" name="subject" maxlength="255" required value="">
                    <p>Оценка</p>
                    <input type="number" name="grade" maxlength="1" required value="">
                    <input name="add" type="submit" value="Добавить">
                </form>
                <?php
                require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
                ?>
            </div>
        </div>
    </div>
</div>