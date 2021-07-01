<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
include 'menu.php';
require_once 'include.php';
if( auth_session() == false ){
    ?>
    <p>Вы не авторизованы!</p>
    <a href="auth/auth.php">Авторизуйтесь</a>
    <?php
    exit;
}
CModule::IncludeModule('iblock');

$IBLOCK_ID = 2;
$class_id = $_GET['class_id'];
$class_letter= CIBlockElement:: GetByID($class_id);
if($ar_res = $class_letter->GetNextElement()){
    $arFields = $ar_res->GetFields();
    $arProp = $ar_res->GetProperties();
    $class= "".$arProp['number_class']['VALUE']."".$arProp['letter_class']['VALUE']."";
    $id_cl= $arFields["ID"];
}
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
$arFilter = Array(
    "IBLOCK_ID" => $IBLOCK_ID
    );
$res = CIBlockElement::GetList(Array("SORT" => "ASC", "property_lastname" => "ASC"), $arFilter);
?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <H3> Ученики </H3>
                <?
                if($_SESSION['login'] == 'qwerty'){
                    ?>
                    <a href="\add_form.php">Добавить ученика |</a>
                    <?
                }
                ?>
                <a href="\rating.php?id_cl=<?=$id_cl;?>">Рейтинг класса</a>
                <p></p>
                <table class="table table-bordered table-hover table-striped artur-table">
                    <tr>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th>Пол</th>
                        <th>Адрес</th>
                        <th>Дата рождения</th>
                        <th>Телефон</th>
                        <th>Класс</th>
                        <th colspan="4"></th>
                    </tr>
                    <?php
                    while ($row = $res->GetNextElement()) {
                        $arFields = $row->GetFields();
                        $arProp = $row->GetProperties();
                        if( $class_id ==$arProp['class']['VALUE']){
                            ?>
                            <tr>
                                <td>
                                    <?=$arProp['firstname']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$arProp['lastname']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$arProp['midname']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$arProp['gender']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$arProp['address']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$arProp['birthday']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$arProp['telephone']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$class;?>
                                </td>
                                <?
                                if($_SESSION['login'] == 'qwerty'){
                                    ?>
                                    <td><a href="update.php?id_el=<?=$arFields['ID']?>">Изменить</a></td>
                                    <td><a href="delete.php?id_el=<?=$arFields['ID']?>">Удалить</a></td>
                                    <?
                                }
                                ?>
                                <td><a href="parents.php?id_el=<?=$arFields['ID']?>">Родители</a></td>
                                <td><a href="grades_list.php?id_el=<?=$arFields['ID']?>">Оценки</a></td>
                            </tr>
                            <?
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>