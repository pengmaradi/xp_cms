<?php
/**
 * @filename = template_view
 * @deprecated =
 *
 * @author = xiaoling
 * @copyright = pengmaradi
 * @email = pengmaradi@gmail.com
 * @link = http://pengmaradi.szmay.com
 * @license = ...
 * @version = 1.0
 */
echo $menu;
//print_r($sidebar->plugin);

?>
<div id="maincontent" class="template">
    <div class="templateform">
        <div class="temp_error">
            <?php
            echo validation_errors();
            ?>
        </div>
        <?php echo form_open('', 'method="post" id="template_form"') . PHP_EOL;?>
        <div class="formlist">        
            <?php
            echo form_label('Select Template: ', 'template') . PHP_EOL;
            $options = array(
                '0' => 'Select a template',
                '1' => '100%',
                '2' => '50% : 50%',
                '3' => '30% : 70%',
                '4' => '70% : 30%',
                '5' => '33% : 33% : 33%'
            );
            echo form_dropdown('template', $options, $template->template, 'id="template"'). PHP_EOL;
            ?>
        </div>        
        <div class="formlist">    
            <?php
            echo form_label('Header: ', 'header') . PHP_EOL;
            echo 'Logo:'.form_checkbox('logo', '1', $header->logo, 'id=logo');
            echo ' Header title:'.form_checkbox('title', '1', $header->title, 'id=title');
            echo ' Menu:'.form_checkbox('hmenu', '1', $header->hmenu, 'id=hmenu');
            echo ' Search:'.form_checkbox('hsearch', '1', $header->search, 'id=hsearch');
            // login
            echo ' Login:'.form_checkbox('hlogin', '1', $header->hlogin, 'id=hlogin');
            ?>
        </div>
        <div class="formlist">    
            <?php
            echo form_label('Content: ', 'content') . PHP_EOL;
            echo 'Menu:'.form_checkbox('cmenu', '1', $content->cmenu, 'id=cmenu');
            //echo ' Rootline:'.form_checkbox('rootline', '1', $content->rootline, 'id=rootline');
            ?>
        </div>
        <div class="formlist">    
            <?php
            echo form_label('Footer: ', 'footer') . PHP_EOL;
            echo ' Menu:'.form_checkbox('fmenu', '1', $footer->fmenu, 'id=fmenu');
            echo ' Login:'.form_checkbox('flogin', '1', $footer->flogin, 'id=flogin');
            ?>
        </div>
<!--        <div class="formlist">    -->
            <?php
//            echo form_label('Sidebar: ', 'siderbar') . PHP_EOL;
//            echo 'Sidebar:'.form_checkbox('sbar', '1', $sidebar->sidebar, 'id=sbar');
//            $options = array(
//                '1' => 'test1',
//                '2' => 'test2',
//                '3' => 'test3',
//                '4' => 'test4',
//            );
//            echo '<div class="plugin">'. PHP_EOL;
//            echo form_label('Plugin: ', 'plugin') . PHP_EOL;
//            $num = count($sidebar->plugin);

//            echo form_multiselect('plugin[]', $options,$sidebar->plugin , 'id="plugin"'). PHP_EOL;
//            echo '</div>'. PHP_EOL;
            ?>
<!--        </div>-->
        <div class="formlist">
            <?php
            echo form_label('&nbsp;', 'savetemp') . PHP_EOL;
            echo form_submit('submit', 'Save', 'id="savetemp"') . PHP_EOL;
            ?>
        </div>
        
        <?php
        echo form_close() . PHP_EOL;
        ?>

    </div>
</div>
<script>
(function($){
    $('#sbar').focusout(function(){
        if($(this).is(':checked')) {
            $('.plugin').show();
        } else {
            $('.plugin').hide();
        }
    });
    $('#savetemp').click(function(){
       var contents = $('#template_form').serialize(),
       template = $('#template').val();
       //alert(contents);
       if(template == 0){
           $('.temp_error').text('please select a template for your website');
           return false;
       }else{
           $('.temp_error').text('');
       }
      // alert(contents);
       $.post(
            'xpcms/setTemplate',
            contents,
            function(data){
                if(data.success) {
                    $('.temp_error').text('template for your website is saved.');
                }else {
                    $('.temp_error').text('');
                }
            },'json');

       return false;
    });
    
})(jQuery)
</script>