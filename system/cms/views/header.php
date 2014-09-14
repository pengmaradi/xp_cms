<?php
/**
 * @filename = header
 * @deprecated =
 *
 * @author = xiaoling
 * @copyright = pengmaradi
 * @email = pengmaradi@gmail.com
 * @link = http://pengmaradi.szmay.com
 * @license = ...
 * @version = 1.0
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title><?php echo $cmstitle; ?></title>
        <base href="<?php echo base_url();?>" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>        
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
        <script src="public_html/xp/xp_cms/js/ckeditor/jquery.js"></script>
        <script src="public_html/xp/xp_cms/js/ckeditor/jquery.ui.js"></script>
        <script src="public_html/xp/xp_cms/js/ckeditor/ckeditor.js"></script>
        <?php
        foreach($css_files as $key => $value) {
            echo '<link rel="stylesheet" type="text/css" href="public_html/xp/xp_cms/css/'.$key.'.css" media="'.$value.'" />'.PHP_EOL;
        }
        if(is_array($js_files)) {
            include_once './system/cms/libraries/'.$js_files[0];
            echo '<script src="public_html/xp/xp_cms/js/'.$js_files[1].'"></script>';
        }
        ?>

    </head>
    <body>
        <div class="main">


