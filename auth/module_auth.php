<?php

function auth(){
    global $conf;


    $error = array();

    if(!isset($_POST['mail'])){

        $error[] = 'Электронная почта не введена';
    }

    if( ! count($error) ) {
        $_POST['mail']      = trim($_POST['mail']);
        $_POST['password']  = trim($_POST['password']);
        $sql = "SELECT `IBLOCK_ELEMENT_ID` FROM `b_iblock_element_prop_s6` WHERE `PROPERTY_26` = '". $_POST['mail'] ."' AND `PROPERTY_27` = '".$_POST['password']."' LIMIT 1";
        $res = $DB->Query($sql);

        if( $res->getNumRows()) {
            $row = $res->Fetch();
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['AId'] = $row['IBLOCK_ELEMENT_ID'];
            return true;
        }
        else {
            $error[] = 'Электронная почта или пароль введены не верно';
            return false;
        }
    }
    else {
        echo $error;
        return false;
    }

}
function auth_session(){

    if(!empty($_SESSION['password']) AND !empty( $_SESSION['AId'])) {

        $AId = intval($_SESSION['AId']);
        $password = $DB->escape($_SESSION['password']);

        $DB->query("SELECT `IBLOCK_ELEMENT_ID` FROM `b_iblock_element_prop_s6` WHERE `IBLOCK_ELEMENT_ID` = '". $AId ."' AND `APassword` = '". $password ."' LIMIT 1");

        if( $DB->getNumRows() ) {
            return true;
        }
    }

    return false;
}