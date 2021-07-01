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
$IBLOCK_ID = 4; //ИД инфоблока с которым работаем
?>
<form name="add" action="/add_form_result.php?task=add_el" method="POST" enctype="multipart/form-data">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="crud">
                    <p>Фамилия</p>
                    <input type="text" name="lastname" maxlength="255" required value="">
                    <p>Имя</p>
                    <input type="text" name="firstname" maxlength="255" required value="">
                    <p>Отчество</p>
                    <input type="text" name="midname" maxlength="255" required value="">
                    <p>Пол</p>
                    <select required name='gender'>
                        <option>Мужской</option>
                        <option>Женский</option>
                    </select>
                    <p>Адрес</p>
                    <input type="text" name="address" maxlength="255" required value="">
                    <p>Дата рождения</p>
                    <input type="date" name="birthday">
                    <p>Телефон</p>
                    <input type="number" name="telephone" maxlength="255" required value="">
                    <p>Класс</p>
                    <select required name='class'>
                        <?
                        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
                        $arFilter = Array(
                            "IBLOCK_ID" => $IBLOCK_ID
                        );
                        $res = CIBlockElement::GetList(Array("SORT" => "ASC", "property_number_class" => "ASC"), $arFilter);
                        while($row = $res->GetNextElement()){
                            $arFields = $row->GetFields();
                            $arProp = $row->GetProperties();
                            ?>
                            <option value="<?=$arFields['ID']?>"><?="".$arProp['number_class']['VALUE']."".$arProp['letter_class']['VALUE'].""?></option>
                            <?
                        }
                        ?>
                    </select>
                    <p></p>
                    <input type="submit" value="Добавить">
                </div>
            </div>
        </div>
    </div>
</form>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>