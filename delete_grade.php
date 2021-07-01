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
$ELEMENT_ID = $_GET['id_el'];
if (CIBlock::GetPermission($IBLOCK_ID) >= 'W') {
    $DB->StartTransaction();
    if (!CIBlockElement::Delete($ELEMENT_ID)) {
        $strWarning .= 'Error!';
        echo $strWarning;
        $DB->Rollback();
    } else{
        echo 'Удалено';
        $DB->Commit();
    }
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
