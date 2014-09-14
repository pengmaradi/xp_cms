<div class="ckeditorform">
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
    echo form_open($action, 'method="post" id="createmedia"');
    echo form_fieldset($fieldset);
    // add a hide input 
    echo form_input(array('name' => 'pageid', 'type'=>'hidden', 'id' =>'lightbox-pid'));
    echo form_input(array('name' => 'content_type', 'type'=>'hidden', 'id' =>'content_type', 'value' => 7));
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Begin: ', 'begin') . PHP_EOL;
    echo form_input('begin', $this->input->post('begin'), 'id="begin-media"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('End: ', 'end') . PHP_EOL;
    echo form_input('end', $this->input->post('end'), 'id="end-media"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
// select position
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Position: ', 'pos') . PHP_EOL;
    echo form_dropdown('pos', $options,array($this->input->post('pos')), 'id="pos"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
        
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Title: ', 'title') . PHP_EOL;
    echo form_input('title', $this->input->post('title'), 'class="createtitle"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    // width and height
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Width: ', 'light-width') . PHP_EOL;
    echo form_input('width', $this->input->post('light-width'), 'class="light-width"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Height: ', 'light-height') . PHP_EOL;
    echo form_input('height', $this->input->post('light-height'), 'class="light-height"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
// image feld
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Pictures: ', 'pics') . PHP_EOL;
    echo form_textarea('pics', $this->input->post('pics'), 'class="pics"') . PHP_EOL;
    echo form_input(array('name' => 'content', 'type'=>'hidden', 'id' =>'lightbox-content'));
    ?>
    <div id="img_browser_gallery_all" style="height:200px;width:100%;margin-top:20px;">
    <?php if (isset($images) && count($images)):
            foreach($images as $image):	?>
        <div class="thumb" style="float: left; margin-right:5px;">
            <a href="<?php echo $image['url']; ?>" title="<?php echo $image['file']; ?>">
                <img class="smallimg" src="<?php echo $image['thumb_url']; ?>" />
            </a>
        </div>
    <?php endforeach; else: ?>
        <div id="blank_gallery">Please Upload Image First</div>
    <?php endif; ?>
    </div>
    <?php    
    echo '</div>' . PHP_EOL;
//    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_submit('submit', 'Save','id="save-lightbox" class="submit_save"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo form_fieldset_close();
    echo form_close();
    ?>
    <div class="closeit">X</div>
</div>

<script>
(function($){
    $('#begin-media').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#end-media').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#img_browser_gallery_all').find('a').click(function(){
        var title = $(this).attr('title'),
        href = $(this).attr('href'),
        lightbox_content = $('#lightbox-content').val(),
        pics = $('.pics').val();
        pics += title+',\n';
        $(this).hide();
        lightbox_content += href + ',\n';
        $('.pics').val(pics);
        $('#lightbox-content').val(lightbox_content)
        return false;
    });
    $('#save-lightbox').click(function(){
        var contents = $('#createmedia').serialize();
        $.post('xpcms/setContent',contents,function(data){
            if(data.success){
                $('.makeMedia, .backDeco').hide();
                location.reload();
            }
        },'json');
        return false;
    });
})(jQuery);
</script>