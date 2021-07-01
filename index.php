<?
require_once 'include.php';
if (auth_session() == false) {
    ?>
    <p>Вы не авторизованы!</p>
    <a href="auth/auth.php">Авторизуйтесь</a>
    <?php
    exit;
}
CModule::IncludeModule('iblock');
$IBLOCK_ID = 4;
$arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
$arFilter = array("IBLOCK_ID" => $IBLOCK_ID);
$res = CIBlockElement::GetList(array("SORT" => "ASC", "property_number_class" => "ASC"), $arFilter);
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="menu">
                <?
                if ($_SESSION['login'] == 'qwerty') {
                    ?>
                    <a href="\add_class.php">Добавить класс </a> |
                    <a href="\transfer.php"> Перевод </a> |
                    <?
                }
                ?>
                <a href="\rating_parallel.php"> Рейтинг параллели </a> |
                <a href="auth/out_auth.php">Выход</a>
                <br>
                <?php
                while ($row = $res->GetNextElement()) {
                    $arFields = $row->GetFields();
                    $arProp = $row->GetProperties();
                    ?>
                    <a href="\show.php?class_id=<?= $arFields['ID'] ?>"><?= "" . $arProp['number_class']['VALUE'] . "" . $arProp['letter_class']['VALUE'] . ""; ?></a>
                    <br>
                    <?php
                }
                require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
                ?>
            </div>
        </div>
    </div>
</div>
