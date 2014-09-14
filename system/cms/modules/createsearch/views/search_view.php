<div class="ckeditorform">
    <?php
    echo form_open($action);
    echo form_fieldset($fieldset);
    // add a hide input
    echo form_input(array('name' => 'pageid', 'type'=>'hidden', 'id' =>'pageid'));
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Begin: ', 'begin') . PHP_EOL;
    echo form_input('begin', $this->input->post('begin'), 'id="searchbegintime"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('End: ', 'end') . PHP_EOL;
    echo form_input('end', $this->input->post('end'), 'id="searchendtime"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('Title: ', 'title') . PHP_EOL;
    echo form_input('title', $this->input->post('title'), 'class="createtitle"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo '<div class="formlist">' . PHP_EOL;
    echo '<textarea name="content" id="mysearch" >' . $this->input->post('content') . '</textarea>' . PHP_EOL;
    echo display_ckeditor($ckeditor);
    echo '</div>' . PHP_EOL;
    echo '<div class="formlist">' . PHP_EOL;
    echo form_submit('submit', 'Save','id="savecontent"') . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo form_fieldset_close();
    echo form_close();
    ?>
    <div class="closeit">X</div>
</div>

<script>
(function($){
    $('#searchbegintime').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#searchendtime').datetimepicker({dateFormat: 'dd-mm-yy'});
})(jQuery);
</script>