<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
CModule::IncludeModule('iblock');
include 'menu.php';
//require_once 'delete.php'; // @todo переписать
$IBLOCK_ID = 2;
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
$arFilter = Array("IBLOCK_ID"=> $IBLOCK_ID );
$res = CIBlockElement::GetList(Array(), $arFilter);
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <H3> Товары </H3>
            <a href="\add_form.php">Добавить товар</a>
            <p></p>
            <table class="table table-bordered table-hover table-striped artur-table">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Тема</th>
                    <th>Автор</th>
                </tr>
                <?php
                while ($row = $res->GetNextElement()) {
                    $arFields = $row->GetFields();
                    $arProp = $row->GetProperties();
                    ?>
                    <tr>
                        <td>
                            <?=$arFields['ID'];?>
                        </td>
                        <td>
                            <?=$arProp['firstname']['VALUE'];?>
                        </td>
                        <td>
                            <?=$arProp['lastname']['VALUE'];?>
                        </td>
                        <td><a href="update.php?id_el=<?=$arFields['ID']?>">Изменить</a></td>
                        <td><a href="delete.php?id_el=<?=$arFields['ID']?>">Удалить</a></td>
                    </tr>
                    <?
                }
                ?>
            </table>
        </div>
    </div>
</div>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>