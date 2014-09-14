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
    echo form_open($action);
    echo form_fieldset($fieldset);
    // add a hide input
    echo form_input(array('name' => 'pageid', 'type'=>'hidden', 'id' =>'pageid'));
    echo form_input(array('name' => 'content_type', 'type'=>'hidden', 'id' =>'content_type', 'value' => 1));
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Begin: ', 'begin') . PHP_EOL;
    echo form_input('begin', $this->input->post('begin'), 'id="setbegintime"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('End: ', 'end') . PHP_EOL;
    echo form_input('end', $this->input->post('end'), 'id="setendtime"') . PHP_EOL;
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
    echo '<textarea name="content" id="content" >' . $this->input->post('content') . '</textarea>' . PHP_EOL;
    echo display_ckeditor($ckeditor);
    echo '</div>' . PHP_EOL;
    echo '<div class="formlist">' . PHP_EOL;
    echo form_submit('submit', 'Save','id="savecontent" class="submit_save"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo form_fieldset_close();
    echo form_close();
    ?>
    <div class="closeit">X</div>
</div>

<script>
(function($){
    $('#setbegintime').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#setendtime').datetimepicker({dateFormat: 'dd-mm-yy'});
})(jQuery);
</script>