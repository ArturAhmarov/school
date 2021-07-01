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
                    $PROP['firstname'] = $_POST['firstname'];
                    $PROP['lastname'] = $_POST['lastname'];
                    $PROP['midname'] = $_POST['midname'];
                    $PROP['gender'] = $_POST['gender'];
                    $PROP['address'] = $_POST['address'];
                    $date = new DateTime($_POST['birthday']);
                    $PROP['birthday'] = $date->format('d.m.Y');
                    $PROP['telephone'] = $_POST['telephone'];
                    $PROP['class'] = $_POST['class'];
                    $fields = array(
                        "IBLOCK_ID" => 2,
                        "PROPERTY_VALUES" => $PROP,
                        "NAME" => strip_tags($_REQUEST['lastname']),
                        "ACTIVE" => "Y"
                    );
                    if($ID = $el->Update($id_el, $fields)){
                        print '<h1>Изменено</h1>';
                    }else{
                        print( $el->LAST_ERROR);
                    }
                }
                $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
                $arFilter = Array(
                    "IBLOCK_ID" => 2,
                    "ID" => $id_el
                );
                $res = CIBlockElement::GetList(Array(), $arFilter);
                while ($row = $res->GetNextElement()) {
                    $arFields = $row->GetFields();
                    $arProp = $row->GetProperties();
                    $firstname = $arProp['firstname']['VALUE'];
                    $lastname=$arProp['lastname']['VALUE'];
                    $midname=$arProp['midname']['VALUE'];
                    $gender=$arProp['gender']['VALUE'];
                    $address=$arProp['address']['VALUE'];
                    $date = new DateTime($arProp['birthday']['VALUE']);
                    $birthday= $date->format('Y-m-d');
                    $telephone=$arProp['telephone']['VALUE'];
                    $class=$arProp['class']['VALUE'];
                }
                ?>
                <form name="update"  method="POST">
                    <p>Имя</p>
                    <input type="text" name="firstname" maxlength="255" required value="<?=$firstname?>">
                    <p>Фамилия</p>
                    <input type="text" name="lastname" maxlength="255" required value="<?=$lastname?>">
                    <p>Отчество</p>
                    <input type="text" name="midname" maxlength="255" required value="<?=$midname?>">
                    <p>Пол</p>
                    <select required name='gender'>
                        <?
                        if($gender == "Мужской"){
                            ?>
                            <option selected>Мужской</option>
                            <option>Женский</option>
                            <?
                        }
                        ?>
                        <?
                        if($gender == "Женский"){
                            ?>
                            <option >Мужской</option>
                            <option selected>Женский</option>
                            <?
                        }
                        ?>
                    </select>
                    <p>Адрес</p>
                    <input type="text" name="address" maxlength="255" required value="<?=$address?>">
                    <p>Дата рождения</p>
                    <input type="date" name="birthday" required value="<?=$birthday?>">
                    <p>Телефон</p>
                    <input type="number" name="telephone" required maxlength="255" value="<?=$telephone?>">
                    <p>Класс</p>
                    <select required name='class'>
                        <?
                        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_*');
                        $arFilter = Array(
                            "IBLOCK_ID" => 4
                        );
                        $res = CIBlockElement::GetList(Array("SORT" => "ASC", "property_number_class" => "ASC"), $arFilter);
                        while($row = $res->GetNextElement()){
                            $arFields = $row->GetFields();
                            $arProp= $row->GetProperties();
                            if($arFields['ID'] == $class){
                                ?>
                                <option selected value="<?=$arFields['ID']?>" ><?="".$arProp['number_class']['VALUE']."".$arProp['letter_class']['VALUE'].""?></option>
                                <?
                                continue;
                            }
                            ?>
                            <option value="<?=$arFields['ID']?>"><?="".$arProp['number_class']['VALUE']."".$arProp['letter_class']['VALUE'].""?></option>
                            <?
                        }
                        ?>
                    </select>
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


