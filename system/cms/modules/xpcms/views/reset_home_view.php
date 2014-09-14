<?php
$tmp = $template->template;
switch($tmp) {
    default :
    case 1:
        $options = array();
        break;
    case 2: 
    case 3:
    case 4:
        $options = array(
            0 => 'Left',
            1 => 'Right'
        );
        break;
    case 5: 
        $options = array(
            0 => 'Left',
            1 => 'Mittel',
            2 => 'Right'
        );
        break;
}

// editor
    $images = 'xpcms/files';
    $ckeditor = array(
        'id' => 'content_0',
        'path' => 'js/ckeditor',
        'config' => array(
            'filebrowserUploadUrl' => $images,
            'filebrowserImageBrowseUrl' => $images,
            'filebrowserImageWindowWidth' => '50%',
            'filebrowserImageWindowHeight' => '20%',
            'toolbar' => "Full", //Using the Full toolbar
            'width' => "100%", //550pxSetting a custom width
            'height' => '100px', //Setting a custom height
        ),
        'styles' => array(
            'style 1' => array(
                'name' => 'Red Title',
                'element' => 'h2',
                'styles' => array(
                    'color' => 'Red',
                    'font-weight' => 'bold',
                    'text-decoration' => 'underline'
                )
            ),
            'style 2' => array(
                'name' => 'Blue Title',
                'element' => 'h2',
                'styles' => array(
                    'color' => 'Blue',
                    'font-weight' => 'bold'
                )
            ),
            'style 3' => array(
                'name' => 'Yellow Title',
                'element' => 'h2',
                'styles' => array(
                    'color' => 'Yellow',
                    'font-weight' => 'bold'
                )
            ),
            'style 4' => array(
                'name' => 'Green Title',
                'element' => 'h3',
                'styles' => array(
                    'color' => 'Green',
                    'font-weight' => 'bold'
                )
            )
        )
    );

echo '<h3>Default page inhalt</h3>';
echo form_open('','id="reset_home"');
echo '<div class="formlist">';
echo form_label('header');
echo form_input('title', $header, 'class="header"');
echo '</div>';
echo '<div class="formlist">';
echo form_label('position');
echo form_dropdown('pos', $options, array($col_pos), 'class="body_text"');
echo '</div>';
echo '<div class="formlist">';
//echo form_label('body_text');
echo form_textarea('content', $body_text, 'class="body_text" id="content_0"');
echo display_ckeditor($ckeditor);
echo '</div>';
echo '<div class="formlist">';
echo form_label('&nbsp;');
echo form_submit('save', 'change it', 'class="set_home"');
echo '</div>';
echo form_close();
?>
<a href="<?php echo base_url();?>" target="_blank">View</a>
<script>
(function($){
    $('.set_home').click(function(){
        var contents = $('#reset_home').serialize(), uid = 1, ck_content = CKEDITOR.instances.content_0.getData();
        contents += '&uid='+ uid;
        contents += '&ck_content='+ ck_content;
        //alert(contents);
        $.post('xpcms/resetContent',contents,function(data){
            if(data.success) {
                location.reload();
            }
        },'json');
        return false;        
    })
})(jQuery);
</script>
