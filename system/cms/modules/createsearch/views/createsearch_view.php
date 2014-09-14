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
    echo form_open($action, 'method="post" id="creatsearch"');
    echo form_fieldset($fieldset);
    // add a hide input
    echo form_input(array('name' => 'pageid', 'type'=>'hidden', 'id' =>'search-pid'));
    echo form_input(array('name' => 'content_type', 'type'=>'hidden', 'id' =>'content_type', 'value' => 6));
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Begin: ', 'begin') . PHP_EOL;
    echo form_input('begin', $this->input->post('begin'), 'id="begin-search"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('End: ', 'end') . PHP_EOL;
    echo form_input('end', $this->input->post('end'), 'id="end-search"') . PHP_EOL;
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
//// select result page
//    $resoptions = array(
//        0 => 'asd',
//        1 => 'qwe',
//        2 => 'asdf',
//        3 => 'yxcv'
//    );
//    echo '<div class="formlist">' . PHP_EOL;
//    echo form_label('Reult page: ', 'respage') . PHP_EOL;
//    echo form_dropdown('respage', $resoptions,array($this->input->post('respage')), 'id="respage"') . PHP_EOL;
//    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_submit('submit', 'Save','id="save-search" class="submit_save"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo form_fieldset_close();
    echo form_close();
    ?>
    <div class="closeit">X</div>
</div>

<script>
(function($){
    $('#begin-search').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#end-search').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#save-search').click(function(){
        var contents = $('#creatsearch').serialize();
        //alert(contents);
        $.post('xpcms/setContent',contents,function(data){
            if(data.success){
                $('.makeFormSearch, .backDeco').hide();
            }
        },'json');
        return false;
    });
})(jQuery);
</script>