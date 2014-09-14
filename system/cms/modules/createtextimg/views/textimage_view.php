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
    echo form_open($action,'method="post" id="createImage"');
    echo form_fieldset($fieldset);
    // add a hide input
    echo form_input(array('name' => 'pageid', 'type'=>'hidden', 'id' =>'page_image_id'));
    echo form_input(array('name' => 'content_type', 'type'=>'hidden', 'id' =>'content_type', 'value' => 2));
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Begin: ', 'begin') . PHP_EOL;
    echo form_input('begin', $this->input->post('begin'), 'id="image_begin"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('End: ', 'end') . PHP_EOL;
    echo form_input('end', $this->input->post('end'), 'id="image_end"') . PHP_EOL;
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
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Picture: ', 'pic') . PHP_EOL;
    echo form_input('pic', $this->input->post('pic'), 'class="pic"') . PHP_EOL;
    ?>
    <div id="img_browser_gallery" style="display:none;height:200px;width:100%;margin-top:20px;">
    <?php if (isset($images) && count($images)):
            foreach($images as $image):	?>
        <div class="thumb" style="float: left;margin-right:5px;">
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
    ///////////////////////////////////////////////////
   echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Width: ', 'width') . PHP_EOL;
    echo form_input('width', $this->input->post('width'), 'class="width"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Height: ', 'height') . PHP_EOL;
    echo form_input('height', $this->input->post('height'), 'class="height"') . PHP_EOL;
    echo '</div>' . PHP_EOL; 
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_submit('submit', 'Save','id="saveImgContent" class="submit_save"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo form_fieldset_close();
    echo form_close();
    ?>
    <div class="closeit">X</div>  
</div>

<script>
(function($){
    $('#image_begin').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#image_end').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('.pic').click(function(){
        $('#img_browser_gallery').show();
    });
    
})(jQuery);
</script>
<script>
(function($){
    $('#img_browser_gallery a').click(function(){
        //alert(0);
        var href = $(this).attr('href'),
        title = $(this).attr('title');
        $('.pic').val(href);
        $.post('createtextimg/imageInfo',{title:title},function(data){
            //alert(data.title);
            $('.width').val(data.image_width);
            $('.height').val(data.image_height);
        },'json');
        $(this).closest('#img_browser_gallery').hide();
        return false;
    });
    $('#saveImgContent').click(function(){
        var contents = $('#createImage').serialize();
        alert(contents);
        $.post('xpcms/setContent',contents,function(data){
            if(data.success){
                $('.makeTextImg, .backDeco').hide();
                location.reload();
            }
        },'json');
        return false;
    });
})(jQuery);
</script>