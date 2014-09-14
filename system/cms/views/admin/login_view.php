<?php
//echo $menu;
?>
<div class="adminlogin">
    <h1 id="logo">xp_cms</h1>
</div>
<div id="maincontent">
    <div class="loginform">
    <?php
    echo validation_errors();
    echo form_open('xpcms/check_login').PHP_EOL;
    echo '<p>';
    echo form_label('Username: ', 'name' ).PHP_EOL;
    echo form_input('name',$this->input->post('name')).PHP_EOL;
    echo '<p>';
    echo form_label('Password: ', 'password' ).PHP_EOL;
    echo form_password('password').PHP_EOL;
    echo '<p>';
    echo form_submit('submit','Submit').PHP_EOL;
    echo form_close().PHP_EOL;
    ?>
    </div>
</div>
