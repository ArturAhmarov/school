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
include 'class/parents.php';

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

                    $id_student = $_GET['id_student'];
                    $p_firstname = $_POST['firstname'];
                    $p_lastname = $_POST['lastname'];
                    $p_midname = $_POST['midname'];
                    $p_address = $_POST['address'];
                    $date = new DateTime($_POST['birthday']);
                    $p_birthday = $date->format('d.m.Y');
                    $p_telephone = $_POST['telephone'];
                    $p_workplace = $_POST['workplace'];
                    $parents = new parents();
                    $parents->add($id_student,$p_firstname,$p_lastname,$p_midname,$p_birthday,$p_address,$p_workplace,$p_telephone);
                }
                $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
                $arFilter = Array(
                    "IBLOCK_ID" => 4
                );
                $res = CIBlockElement::GetList(Array(), $arFilter);
                ?>
                <form name="update"  method="POST">
                    <p>Фамилия</p>
                    <input type="text" name="lastname" maxlength="255" required value="">
                    <p>Имя</p>
                    <input type="text" name="firstname" maxlength="255" required value="">
                    <p>Отчество</p>
                    <input type="text" name="midname" maxlength="255" required value="">
                    <p>Адрес</p>
                    <input type="text" name="address" maxlength="255" required value="">
                    <p>Дата рождения</p>
                    <input type="date" name="birthday" required value="">
                    <p>Телефон</p>
                    <input type="number" name="telephone" maxlength="255" required value="">
                    <p>Место работы</p>
                    <input type="text" name="workplace" maxlength="255" required value="">
                    <p></p>
                    <input name="add" type="submit" value="Добавить">
                </form>
                <?php
                require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");

                ?>
            </div>
        </div>
    </div>
</div>

