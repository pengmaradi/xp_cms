<div class="createform">
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
    echo form_open($action, 'method="post" id="creatcontact"');
    echo form_fieldset($fieldset);
    // add a hide input 
    echo form_input(array('name' => 'pageid', 'type'=>'hidden', 'id' =>'form-pid'));
    
    echo form_input(array('name' => 'content_type', 'type'=>'hidden', 'id' =>'content_type', 'value' => 4));
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Begin: ', 'begin') . PHP_EOL;
    echo form_input('begin', $this->input->post('begin'), 'id="form_begin"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('End: ', 'end') . PHP_EOL;
    echo form_input('end', $this->input->post('end'), 'id="form_end"') . PHP_EOL;
    echo '</div>' . PHP_EOL;    
    
    // select position
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Position: ', 'pos') . PHP_EOL;
    echo form_dropdown('pos', $options,array($this->input->post('pos')), 'id="pos"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Title: ', 'title') . PHP_EOL;
    echo form_input('title', $this->input->post('title'), 'id="title"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_submit('submit', 'Save','id="savecontakt" class="submit_save"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo form_fieldset_close();
    echo form_close();
    ?>
    <div class="closeit">X</div>
    
    <div class="ausgabe"></div>
</div>
<script>
(function($){
    $('#form_begin').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#form_end').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#savecontakt').click(function(){
        var contents = $('#creatcontact').serialize();
        //alert(contents);
        $.post('xpcms/setContent',contents,function(data){
            if(data.success) {
                $('.makeForm , .backDeco').hide();
                location.reload();
            }
        },'json');
        return false;
    });
})(jQuery);
</script>
