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
    echo form_open('xpcms/check_login', 'method="post" id="loginform"').PHP_EOL;
    echo '<p>';
    echo form_label('Username: ', 'name' ).PHP_EOL;
    echo form_input('name',$this->input->post('name'),'id="name"').PHP_EOL;
    echo '<p>';
    echo form_label('Password: ', 'password' ).PHP_EOL;
    echo form_password('password','','id="pass"').PHP_EOL;
    echo '<p>';
    echo form_submit('submit','Login','id="login"').PHP_EOL;
    echo form_close().PHP_EOL;
    ?>
        <div class="error"></div>
    </div>
    
</div>
<script>
(function($){
    $('#login').click(function(){
        var name = $.trim($('#name').val()), pass = $.trim($('#pass').val()), 
        alphanumeric = /^[a-zA-Z0-9-_@]+/;
        if(name == '' || pass == '' || !alphanumeric.test(name) ){
            $('.error').text('please check your username is empty or username is wrong');
            return false;
        }
    });

})(jQuery);
</script>
