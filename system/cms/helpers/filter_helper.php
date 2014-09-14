<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @param type $str
 * @return type 
 */
function sqlFilter($str) {
    $sql = '/(select)|(insert)|(update)|(delete)|(\')|(\/\*)|(\*)|(\.\.\/)|(\.\/)|(union)|(into)|(load_file)|(outfile)/i';
    $check = preg_match($sql, $str);
    return $check ? preg_replace($sql, "-$1$2$3$4$5$6$7$8$9$10$11$12$13~", $str) : $str;
}

// email
/**
 *
 * @param type $email
 * @return type 
 */
function emialCK($email) {
    $regex = "/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/";
    $ckmail = preg_match($regex, $email);

//        return $ckmail ? $email : $this->jsAlert("php: mail ist ungültig");
    return $ckmail ? $email : (print '<p style="color:red">php: mail ist ungültig</p>');
}

// telefon
/**
 *
 * @param type $telefon
 * @return type 
 */
function telefonCK($telefon) {
    $regtel = "/^0{1,2}|^\+{1}\d{2,4}-?\d{7,9}/";
    $cktel = preg_match($regtel, $telefon);
    return $cktel ? $telefon : $this->jsAlert("telefon ist ungültig");
}

// url
/**
 * 
 * @param type $url
 * @return type 
 */
function urlCK($url) {
    //                       http://pengmaradi.szmay.com/about/xiaoling
    $regurl = "/^(ftp|http|https):\/\/([\w-]+(\.|\/))+\w{2,3}(\/([\w]+\/?)+)?$|([\w]+(\.)\w{3,4}\?([\w]+\=[\w]+\&?)+)$/";
    $ckurl = preg_match($regurl, $url);
    return $ckurl ? $url : $this->jsAlert("url ist ungültig");
}

// javascript alert
/**
 *
 * @param type $fehler 
 */
function jsAlert($fehler) {
    echo '<script>alert("' . $fehler . '");</script>';
}

// js jump to url
/**
 *
 * @param type $url 
 */
function jsGoto($url) {
    echo '<script>document.location.href="' . $url . '";</script>';
}


