<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* debug helper
*/

function debug($cand,$exit=false) {
    //echo '<pre style="font-size:1.6em;">';
    print_r($cand);
    if($exit) exit;
    //echo '</pre>';
}