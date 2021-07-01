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
include 'menu.php';
CModule::IncludeModule('iblock');

$IBLOCK_ID = 3;
$id_student = $_GET['id_el'];
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
$arFilter = Array(
    "IBLOCK_ID" => $IBLOCK_ID
);
$res = CIBlockElement::GetList(Array(), $arFilter);
$ar_id_student = CIBlockElement::GetByID($id_student);
if($ar_res = $ar_id_student->GetNextElement()){
    $arFields = $ar_res->GetFields();
    $id_s = $arFields['ID'];
}
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <H3> Родители </H3>
            <?
            if($_SESSION['login'] == 'qwerty'){
                ?>
                <a href="\p_add_form.php?id_student=<?=$id_s?>"> Добавить родителя</a>
                <?
            }
            ?>
            <p></p>
            <table class="table table-bordered table-hover table-striped artur-table">
                <tr>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Отчество</th>
                    <th>Адрес</th>
                    <th>Дата рождения</th>
                    <th>Телефон</th>
                    <th>Место работы</th>
                    <?
                    if($_SESSION['login'] == 'qwerty'){
                        ?>
                    <th colspan="3"></th>
                            <?
                    }
                    ?>
                </tr>
                <?php
                while ($row = $res->GetNextElement()) {
                    $arFields = $row->GetFields();
                    $arProp = $row->GetProperties();
                    if( $id_student == $arProp['id_student']['VALUE']){
                        ?>
                        <tr>
                            <td>
                                <?=$arProp['p_firstname']['VALUE'];?>
                            </td>
                            <td>
                                <?=$arProp['p_lastname']['VALUE'];?>
                            </td>
                            <td>
                                <?=$arProp['p_midname']['VALUE'];?>
                            </td>
                            <td>
                                <?=$arProp['p_address']['VALUE'];?>
                            </td>
                            <td>
                                <?=$arProp['p_birthday']['VALUE'];?>
                            </td>
                            <td>
                                <?=$arProp['p_telephone']['VALUE'];?>
                            </td>
                            <td>
                                <?=$arProp['p_workplace']['VALUE'];?>
                            </td>
                            <?
                            if($_SESSION['login'] == 'qwerty'){
                                ?>
                                <td><a href="p_update.php?id_el=<?=$arFields['ID']?>">Изменить</a></td>
                                <td><a href="p_delete.php?id_el=<?=$arFields['ID']?>">Удалить</a></td>
                                <?
                            }
                            ?>
                        </tr>
                        <?
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>
