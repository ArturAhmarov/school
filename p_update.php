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
                $id_el = $_REQUEST['id_el'];
                if ($_POST['edit']) {
                    $el = new CIBlockElement;
                    $PROP = array();
                    $id_student = $_POST['id_student'];
                    $p_firstname = $_POST['firstname'];
                    $p_lastname = $_POST['lastname'];
                    $p_midname = $_POST['midname'];
                    $p_address = $_POST['address'];
                    $date = new DateTime($_POST['birthday']);
                    $p_birthday = $date->format('d.m.Y');
                    $p_telephone = $_POST['telephone'];
                    $p_workplace = $_POST['workplace'];
                    $parents = new parents();
                    $parents->update($id_student,$id_el,$p_firstname,$p_lastname,$p_midname,$p_birthday,$p_address,$p_workplace,$p_telephone);
                }
                $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
                $arFilter = Array(
                    "IBLOCK_ID" => 3,
                    "ID" => $id_el
                );
                $res = CIBlockElement::GetList(Array(), $arFilter);
                while ($row = $res->GetNextElement()) {
                    $arFields = $row->GetFields();
                    $arProp = $row->GetProperties();
                    $id_student = $arProp['id_student']['VALUE'];
                    $firstname = $arProp['p_firstname']['VALUE'];
                    $lastname=$arProp['p_lastname']['VALUE'];
                    $midname=$arProp['p_midname']['VALUE'];
                    $address=$arProp['p_address']['VALUE'];
                    $date = new DateTime($arProp['p_birthday']['VALUE']);
                    $birthday= $date->format('Y-m-d');
                    $telephone=$arProp['p_telephone']['VALUE'];
                    $workplace = $arProp['p_workplace']['VALUE'];
                }
                ?>
                <form name="update"  method="POST">
                    <p>Фамилия</p>
                    <input type="text" name="lastname" maxlength="255" required value="<?=$lastname?>">
                    <p>Имя</p>
                    <input type="text" name="firstname" maxlength="255" required value="<?=$firstname?>">
                    <p>Отчество</p>
                    <input type="text" name="midname" maxlength="255" required value="<?=$midname?>">
                    <p>Адрес</p>
                    <input type="text" name="address" maxlength="255" required value="<?=$address?>">
                    <p>Дата рождения</p>
                    <input type="date" name="birthday" required value="<?=$birthday?>">
                    <p>Телефон</p>
                    <input type="number" name="telephone" maxlength="255" required value="<?=$telephone?>">
                    <p>Место работы</p>
                    <input type="text" name="workplace" maxlength="255" required value="<?=$workplace?>">
                    <input type="number" name="id_student" maxlength="255" hidden value="<?=$id_student?>">
                    <p></p>
                    <input name="edit" type="submit" value="Изменить">
                </form>
                <?php
                require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");

                ?>
            </div>
        </div>
    </div>
</div>

