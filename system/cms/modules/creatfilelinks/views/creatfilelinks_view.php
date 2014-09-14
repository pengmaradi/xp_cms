<div class="documentlink">
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
    echo form_open($action, 'method="post" id="creatfilelinks"');
    echo form_fieldset($fieldset);
    // add a hide input
    echo form_input(array('name' => 'pageid', 'type'=>'hidden', 'id' =>'file-pid'));
    echo form_input(array('name' => 'content_type', 'type'=>'hidden', 'id' =>'content_type', 'value' => 3));
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Begin: ', 'begin') . PHP_EOL;
    echo form_input('begin', $this->input->post('begin'), 'id="begin-file"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('End: ', 'end') . PHP_EOL;
    echo form_input('end', $this->input->post('end'), 'id="end-file"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
// select position
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Position: ', 'pos') . PHP_EOL;
    echo form_dropdown('pos', $options, array($this->input->post('pos')), 'id="pos"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
        
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Title: ', 'title') . PHP_EOL;
    echo form_input('title', $this->input->post('title'), 'class="createtitle"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Documents: ', 'docu') . PHP_EOL;
    echo form_textarea('docu_title', $this->input->post('docu_title'), 'class="docu_title"') . PHP_EOL;
    echo form_input(array('name' => 'docu_link', 'type'=>'hidden', 'class' =>'docu_link'));
    ?>
    <div id="document_browser" style="height:200px;width:100%;margin-top:20px;">
    <?php if (isset($documents) && count($documents)):
            foreach($documents as $document):	?>
            <div class="thumb" style="margin-right:5px;">
                <a href="<?php echo $document['url']; ?>" title="<?php echo $document['file'].'<span>(size:'.$document['file_size'].')</span>'; ?>">
                    <?php echo $document['file'].' size:'.$document['file_size']; ?>
                </a>
            </div>
    <?php endforeach; else: ?>
            <div id="blank_gallery">Please upload document first</div>
    <?php endif; ?>
        </div>
    </div>

    <?php 
    echo '<div class="formlist">' . PHP_EOL;
    echo form_submit('submit', 'Save','id="save-file-contnet" class="submit_save"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo form_fieldset_close();
    echo form_close();

    ?>
    <div class="closeit">X</div>
</div>

<script>
(function($){
    $('#begin-file').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#end-file').datetimepicker({dateFormat: 'dd-mm-yy'});

    $('#document_browser').find('a').click(function(){
        var title = $(this).attr('title'),
        href = $(this).attr('href'),
        docu_title = $('.docu_title').val(),
        docu_link = $('.docu_link').val();
        docu_title += title+',\n';
        $(this).hide();
        docu_link += href + ',\n';
        $('.docu_link').val(docu_link);
        $('.docu_title').val(docu_title);
        return false;
    });
    $('#save-file-contnet').click(function(){
        var contents = $('#creatfilelinks').serialize();
//        alert(contents);
        $.post('xpcms/setContent',contents,function(data){
            if(data.success){
                $('.makeFileLinks, .backDeco').hide();
                location.reload();
            }
        },'json');
        return false;
    });
})(jQuery);
</script>