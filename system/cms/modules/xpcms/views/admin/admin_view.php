<?php
echo $menu;
?>

<!--<textarea name="content_1" id="content_1" >
<p>Example data</p>
</textarea>
-->
<div id="maincontent">
    <div class="ckeditorform">
    <?php
    // echo display_ckeditor($ckeditor_1);

    echo form_open('xpcms/admin');
    echo form_fieldset('Inhalt verwalten');
    echo '<div class="formlist">'.PHP_EOL;
    echo form_label('Title: ', 'title' ).PHP_EOL;
    echo form_input('title',$this->input->post('title')).PHP_EOL;
    echo '</div>'.PHP_EOL;
    echo '<div class="formlist">'.PHP_EOL;
    echo '<textarea name="content" id="content" >'.$this->input->post('content').'</textarea>'.PHP_EOL;
    echo display_ckeditor($ckeditor);
    echo '</div>'.PHP_EOL;
    echo '<div class="formlist">'.PHP_EOL;
    echo form_submit('submit','Save').PHP_EOL;
    echo '</div>'.PHP_EOL;
    echo form_fieldset_close();
    echo form_close();
    ?>
    </div>
</div>