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
        <title>cms image browser</title>
        <base href="<?php echo base_url();?>" />
        <link rel="shortcut icon" href="http://pengmaradi.szmay.com/pengmaradi/fileadmin/templates/img/pmLogo.png" />
        <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" media="all" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="public_html/xp/xp_cms/css/contextMenu.css" />
        <link rel="stylesheet" href="public_html/xp/xp_cms/css/colorpicker.css" />
        <script src="public_html/xp/xp_cms/js/jquery.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery.ui.js"></script>
        <script src="public_html/xp/xp_cms/js/ckeditor/ckeditor.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery-timepicker.js"></script>
<?php
//    foreach($css_files as $key => $value) {
//        echo '<link rel="stylesheet" type="text/css" href="public_html/xp/xp_cms/css/'.$key.'.css" media="'.$value.'" />'.PHP_EOL;
//    }
//    if(is_array($js_files)) {
//        include_once './system/cms/libraries/'.$js_files[0];
//        echo '<script src="public_html/xp/xp_cms/js/'.$js_files[1].'"></script>';
//    }
?>        
    </head>
    <body>
        <div class="main">