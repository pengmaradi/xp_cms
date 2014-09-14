<?php

/**
 * @filename = configuration_view
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
?>
<script src="public_html/xp/xp_cms/js/colorpicker.js"></script>
<div id="maincontent" class="configuration">
<!-- web info --> 
    <div class="tabs">
        <h3>Website</h3>
        <div class="tab">
            <div class="tab_inner website">
                <?php echo form_open('', 'method="post" id="web_info_form"') . PHP_EOL;?>
                <div class="formlist text">
                    <?php echo form_label('Web title: ', 'web_title') . PHP_EOL; ?>
                    <?php echo form_input('web_title', @$web_info[0]->web_title, 'id="web_title"'). PHP_EOL; ?>                    
                </div>
                <div class="formlist text">
                    <?php echo form_label('Web description: ', 'web_description') . PHP_EOL; ?>
                    <?php echo form_textarea('web_description', @$web_info[0]->web_description, 'id="web_description"').PHP_EOL;?>
                </div>
                <div class="formlist text"> 
                    <?php echo form_label('Web copyright: ', 'web_copyright') . PHP_EOL; ?>
                    <?php echo form_textarea('web_copyright', @$web_info[0]->web_copyright, 'id="web_copyright"').PHP_EOL;?>
                </div>
                <div class="formlist text">
                    <?php echo form_label('Web address: ', 'web_address') . PHP_EOL; ?>
                    <?php echo form_textarea('web_address', @$web_info[0]->web_address, 'id="web_address"').PHP_EOL;?>
                </div> 
                <div class="formlist">
                    <?php echo form_label('&nbsp;', 'info_submit') . PHP_EOL; ?>
                    <?php echo form_submit('submit', 'Save', 'id="info_submit"') . PHP_EOL; ?>
                </div>
               <?php echo form_close();?> 
                <div class="web_info_error"></div>
            </div>            
        </div>
    </div>
<script>
(function(){
    $('#info_submit').click(function(){
        var contents = $('#web_info_form').serialize();        
        $.post('xpcms/resetWebinfo',contents,function(data){
            if(data.success){
              $('.web_info_error').text('saved');
            }else{
               $('.web_info_error').text(''); 
            }            
        },'json');
        return false;
    });
})(jQuery);
</script>
<!-- web theme -->   
    <div class="tabs">
        <h3>Theme</h3>
        <div class="tab">
            <div class="tab_inner">
<!-- icon and logo upload begin --> 
                <div class="upload_files">
                <?php echo form_open_multipart('xpcms/upload_icon_logo');?>
                    <div class="formlist file icon">
                    <?php echo form_label('web icon: ', 'icon') . PHP_EOL; ?>
                    <?php echo form_upload('icon'). PHP_EOL;?>
                    </div>  
                    <div class="formlist file icon">
                     <?php echo form_label('&nbsp;', 'sub_icon') . PHP_EOL; ?>
                    <?php echo form_submit('sub_icon', 'Icon upload'). PHP_EOL; ?> 
                    </div>
                <?php echo form_close();?>
                </div>
                <div class="prview_files">
                    <img class="icon" src="public_html/ui/<?php echo @$web_info[0]->icon;?>" title="<?php echo @$web_info[0]->icon;?>"/>
                </div>

                <div class="clear"></div>
                
                <div class="upload_files">
                <?php echo form_open_multipart('xpcms/upload_icon_logo');?>
                <div class="formlist file logo">
                    <?php echo form_label('Web logo: ', 'logo') . PHP_EOL; ?>
                    <?php echo form_upload('logo'). PHP_EOL; ?>
                </div>
                <div class="formlist file logo">
                    <?php echo form_label('&nbsp;', 'sub_logo') . PHP_EOL; ?>
                    <?php echo form_submit('sub_logo', 'Logo upload'); ?>                     
                </div>
                <?php echo form_close();?>
                </div>
                <div class="prview_files">
                    <img class="logo" src="public_html/ui/<?php echo @$web_info[0]->logo;?>" title="<?php echo @$web_info[0]->logo;?>"/>
                </div>
<!-- icon and logo upload end -->

                <?php echo form_open('', 'method="post" id="theme_form"') . PHP_EOL;?>
                <div class="formlist color">
                    <?php echo form_label('body color: ', 'body_color') . PHP_EOL; ?>
                    <?php echo form_input('body_color', @$web_info[0]->body_color, 'id="body_color"'). PHP_EOL; ?>
                    <button class="set body_color">preview</button>
                </div>
                <div class="formlist color">
                    <?php echo form_label('Header color: ', 'header_color') . PHP_EOL; ?>
                    <?php echo form_input('header_color', @$web_info[0]->header_color, 'id="header_color"'). PHP_EOL; ?>
                    <button class="set header_color">preview</button>
                </div>
                <div class="formlist color">
                    <?php echo form_label('Content color: ', 'content_color') . PHP_EOL; ?>
                    <?php echo form_input('content_color', @$web_info[0]->content_color, 'id="content_color"'). PHP_EOL; ?>
                    <button class="set content_color">preview</button>
                </div>                
                <div class="formlist color">
                    <?php echo form_label('Footer color: ', 'footer_color') . PHP_EOL; ?>
                    <?php echo form_input('footer_color', @$web_info[0]->footer_color, 'id="footer_color"'). PHP_EOL; ?>
                    <button class="set footer_color">preview</button>
                </div>
                <div class="formlist">
                    <?php echo form_label('&nbsp;', 'theme_submit') . PHP_EOL; ?>
                    <?php echo form_submit('submit', 'Save', 'id="theme_submit"') . PHP_EOL; ?>
                </div>
            <?php echo form_close();?>    
            </div>
            <div class="theme_error"></div>
        </div>
    </div>
<script>
(function($){
$('#body_color, #header_color, #content_color, #footer_color').ColorPicker({
    onSubmit: function(hsb, hex, rgb, el) {
        $(el).val(hex);
        $(el).ColorPickerHide();
    },
    onBeforeShow: function() {
        $(this).ColorPickerSetColor(this.value);
    }
    });
    $('.set').each(function() {
        $(this).click(function(){
            var previd = $(this).prev().attr('id');
            //alert(previd);
            $('#'+previd).css('background-color', '#' + $('#'+previd).val());
            //$('#body_color').css('background-color', '#' + $('#body_color').val());
            return false;
        });        
    });
})(jQuery);
</script>
<script>
(function(){
    $('#theme_submit').click(function(){
        var contents = $('#theme_form').serialize();
//        alert(contents);
        $.post('xpcms/resetTheme',contents,function(data){
            if(data.success){
              $('.theme_error').text('saved');
            }else{
               $('.theme_error').text(''); 
            }
        },'json');
        return false;
    });
})(jQuery);
</script>
<!-- google -->   
    <div class="tabs">
        <h3>google analytics</h3>
        <div class="tab">
            <div class="tab_inner">
                <?php echo form_open('', 'method="post" id="google_form"') . PHP_EOL;?>
                <p>Tracking-Code. Copy to hier</p>
                <div class="formlist text">
                    <?php echo form_label('Tracking Code: ', 'google_analitytis') . PHP_EOL; ?>
                    <?php echo form_textarea('google_analitytis', @$web_info[0]->google_analitytis, 'id="google_analitytis"').PHP_EOL;?>                   
                </div>
                <div class="formlist text">
                    <?php echo form_label('Key words: ', 'key_words') . PHP_EOL; ?>
                    <?php echo form_textarea('key_words', @$web_info[0]->key_words, 'id="key_words"').PHP_EOL;?>                  
                </div>
                <div class="formlist">
                    <?php echo form_label('&nbsp;', 'google_submit') . PHP_EOL; ?>
                    <?php echo form_submit('submit', 'Save', 'id="google_submit"') . PHP_EOL; ?>
                </div>
            <?php echo form_close();?>
                <?php echo form_close();?>
            </div>
            <div class="google_error"></div>
        </div>
    </div>
<script>
(function(){
    $('#google_submit').click(function(){
        var contents = $('#google_form').serialize();
//        alert(contents);
        $.post('xpcms/resetGoogle',contents,function(data){
            if(data.success){
              $('.google_error').text('saved');
            }else{
               $('.google_error').text(''); 
            }
        },'json');
        return false;
    });
})(jQuery);
</script>
<!-- social netz -->   
    <div class="tabs">
        <h3>Social Network</h3>
        <div class="tab">
            <div class="tab_inner">
                <?php echo form_open('', 'method="post" id="sozial_form"') . PHP_EOL;?>
                <div class="formlist text">
                    <?php echo form_label('social netzwork: ', 'social_netzwork') . PHP_EOL; ?>
                    <?php echo form_textarea('social_netzwork', @$web_info[0]->social_netzwork, 'id="social_netzwork"').PHP_EOL;?>                   
                </div>
                <div class="formlist">
                    <?php echo form_label('&nbsp;', 'social_submit') . PHP_EOL; ?>
                    <?php echo form_submit('submit', 'Save', 'id="social_submit"') . PHP_EOL; ?>
                </div>
                <?php echo form_close();?>
            </div>
            <div class="social_error"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<script>
(function(){
    $('#social_submit').click(function(){
        var contents = $('#sozial_form').serialize();
//        alert(contents);
        $.post('xpcms/resetSozial',contents,function(data){
            if(data.success){
              $('.social_error').text('saved');
            }else{
               $('.social_error').text(''); 
            }
        },'json');
        return false;
    });
})(jQuery);
</script>
<script>
(function($){
   $('.tab:eq(0)').show();
   $('.tabs:eq(0) h3').addClass('act');
   $('.tabs h3').each(function(){
       $(this).click(function(){
           $(this).addClass('act');
           $(this).closest('.tabs').siblings().find('h3').removeClass('act');
           $(this).closest('.tabs').siblings().find('.tab').hide();
           $(this).next().show();
       });
   });
})(jQuery);    
</script>