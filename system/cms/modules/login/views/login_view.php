<div class="search-form">
    <?php
    echo form_open($action, 'method="post" id="login"'). PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('user: ', 'user') . PHP_EOL;
    echo form_input('user', '', 'id="user"'). PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label('password: ', 'password') . PHP_EOL;
    echo form_password('password', $this->input->post('password'), 'id="user_pass"'). PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo '<div class="formlist">' . PHP_EOL;
    echo form_label(' ', 'submit') . PHP_EOL;
    echo form_submit('submit', 'login', 'id="user_login"'). PHP_EOL;
    echo '</div>' . PHP_EOL;
    
    echo form_close(). PHP_EOL;
    ?> 
</div>
<script>
(function($){
    $('#user_login').click(function(){
        var contents = $('#login').serialize();
//        alert(contents);
        $.post('login/login', contents, function(data){
            if(data.success) {
                $('.situation').html(data.result);                              
            }
        },'json');    
        return false;
    });
})(jQuery);
</script>
<div class="login-situation">    
    <div class="situation">       
    </div>
</div>

