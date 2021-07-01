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

$IBLOCK_ID = 5;
$id_el = $_GET['id_el'];
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
$arFilter = Array(
    "IBLOCK_ID" => $IBLOCK_ID
);
$ar_id_student = CIBlockElement::GetByID($id_el);
if($ar_res = $ar_id_student->GetNextElement()){
    $arFields = $ar_res->GetFields();
    $arProp = $ar_res->GetProperties();
    $id_s = $arFields['ID'];
    $id_class = $arProp['class']['VALUE'];
}
$res = CIBlockElement::GetList(Array(), $arFilter);
?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <H3> Оценки </H3>
                <?
                if($_SESSION['login'] == 'qwerty'){
                    ?>
                    <a href="\add_grade.php?id_el=<?=$id_s;?>">Добавить оценку</a>
                    <?
                }
                ?>
                <p></p>
                <table class="table table-bordered table-hover table-striped artur-table">
                    <tr>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th colspan="2"></th>
                    </tr>
                    <?php
                    while ($row = $res->GetNextElement()) {
                        $arFields = $row->GetFields();
                        $arProp = $row->GetProperties();
                        if( $arProp['id_student']['VALUE'] == $id_el){
                            ?>
                            <tr>
                                <td>
                                    <?=$arProp['subject']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$arProp['grade']['VALUE'];?>
                                </td>
                                <?
                                if($_SESSION['login'] == 'qwerty'){
                                    ?>
                                    <td><a href="update_grade.php?id_el=<?=$arFields['ID']?>">Изменить</a></td>
                                    <td><a href="delete_grade.php?id_el=<?=$arFields['ID']?>">Удалить</a></td>
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

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>