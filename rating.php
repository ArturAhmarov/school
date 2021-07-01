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
$id_cl = $_GET['id_cl'];
$results = $DB->Query("SELECT  `PROPERTY_21` AS `id_student`, AVG(`PROPERTY_23`) AS `AVG` FROM `b_iblock_element_prop_s5`
                                WHERE `PROPERTY_25`='$id_cl' GROUP BY `PROPERTY_21` ORDER BY AVG(`PROPERTY_23`) DESC");
$i = 1;
?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <H3> Рейтинг </H3>
                <p></p>
                <table class="table table-bordered table-hover table-striped artur-table">
                    <tr>
                        <th>Рейтинг</th>
                        <th>Средний балл</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th></th>
                    </tr>
                    <?php
                    while($row = $results->Fetch()) {
                        $res = CIBlockElement::GetByID($row['id_student']);
                        if($ar_res = $res->GetNextElement()){
                            $arProp = $ar_res->GetProperties();
                            $arFields = $ar_res->GetFields();
                            ?>
                            <tr>
                                <td>
                                    <?=$i;?>
                                </td>
                                <td>
                                    <?=$row['AVG'];?>
                                </td>
                                <td>
                                    <?=$arProp['firstname']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$arProp['lastname']['VALUE'];?>
                                </td>
                                <td>
                                    <?=$arProp['midname']['VALUE'];?>
                                </td>
                            </tr>
                            <?
                            $i++;
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