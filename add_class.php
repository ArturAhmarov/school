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
$IBLOCK_ID = 4;
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="crud">
                <?php
                CModule::IncludeModule('iblock');
                if ($_POST['add']) {
                    $el = new CIBlockElement;
                    $PROP = array();
                    $PROP['letter_class'] = $_POST['letter'];
                    $PROP['number_class'] = $_POST['number'];

                    $name ="".$_POST['number']."".$_POST['letter']."";
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
                    <p>Номер класса</p>
                    <select name="number">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                    </select>
                    <p>Буква</p>
                    <input type="text" name="letter" maxlength="1" required value="">
                    <input name="add" type="submit" value="Добавить">
                </form>
                <?php
                require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");

                ?>
            </div>
        </div>
    </div>
</div>