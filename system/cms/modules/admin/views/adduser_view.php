
<div class="adduser">
    <div class="add_error">
<?php 
    echo validation_errors();
?>        
    </div>
<?php    
    echo form_open('', 'method="post" id="add_user_form"') . PHP_EOL;
?>
        <div class="formlist">    
<?php 
    echo form_label('Identity: ', 'identity') . PHP_EOL;    
    echo form_dropdown('identity', $options, '', 'id="identity"') . PHP_EOL;
?>
        </div>
    <div class="formlist">    
<?php 
    echo form_label('Begin: ', 'add_begin') . PHP_EOL;
    echo form_input('add_begin', $this->input->post('add_begin'), 'id="add_begin"') . PHP_EOL; 
?>
        </div>
    
    <div class="formlist">    
<?php 
    echo form_label('End: ', 'add_end') . PHP_EOL;
    echo form_input('add_end', $this->input->post('add_end'), 'id="add_end"') . PHP_EOL; 
?>
        </div>
    
        <div class="formlist">    
<?php 
    echo form_label('Real name: ', 'add_name') . PHP_EOL;
    echo form_input('add_name', $this->input->post('add_name'), 'id="add_name"') . PHP_EOL; 
?>
        </div>
        <div class="formlist">        
<?php 
    echo form_label('Username: ', 'add_user') . PHP_EOL;
    echo form_input('add_user', $this->input->post('add_user'), 'id="add_user"') . PHP_EOL;
?>
            <span class="notice"></span>
        </div>
        <div class="formlist">    
<?php 
    echo form_label('Password: ', 'add_password') . PHP_EOL;
    echo form_password('add_password', $this->input->post('add_password'), 'id="add_password"') . PHP_EOL; 
?>
        </div>
        <div class="formlist">    
<?php 
    echo form_label('Email: ', 'add_email') . PHP_EOL;
    echo form_input('add_email', $this->input->post('add_email'), 'id="add_email"') . PHP_EOL; 
?>
        </div>      
        
        <div class="formlist">
<?php
    echo form_label('&nbsp; ', 'add') . PHP_EOL;
    echo form_submit('submit', 'Add', 'id="add"') . PHP_EOL;
?>
        </div>       
<?php
    echo form_close() . PHP_EOL;
?>       
    <div class="toadmin"></div>
</div>
<script>
(function($){
    // add date time picker
    $('#add_begin').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#add_end').datetimepicker({dateFormat: 'dd-mm-yy'});
    // check if the user name is already in db
    $('#add_user').focusout(function(){
        var user = $(this).val();
        if($.trim(user) == '') {
            $('.notice').text('user can not empty');
            $(this).addClass('hightlight');
            return false;            
        } else{
            $('.notice').text('');
            //check user name
            $.post(
            'admin/checkUserName',
            {user:user},
            function(data){
                if(data.success) {
                    $('.notice').text('username is ok.');
                    $('#add_user').removeClass('hightlight');
                }else{
                    $('.notice').text('username is already in use.');
                    $('#add_user').addClass('hightlight');
                }                
            },
            'json');           
           $(this).removeClass('hightlight');
        }        
    });
    // set user
    $('#add').click(function(){
        var contents = $('#add_user_form').serialize(),
        identity = $('#identity').val(),
        add_user = $.trim($('#add_user').val()),
        add_email = $.trim($('#add_email').val());
        if(identity == 0){
            $('.add_error').text('please select the identity.');
            return false;
        } else {
            $('.add_error').text('');
        }
        if(add_user == ''){
            $('.add_error').text('please add a user.');
            return false;
        } else {
            $('.add_error').text('');
        }
        if(add_email == ''){
            $('.add_error').text('please add a email.');
            return false;
        } else {
            $('.add_error').text('');
        }
        
        $.post(
            'admin/setUser',
            contents,
            function(data){
                if(data.success) {
                    $('.toadmin').text('set user is ok.');
                }else{
                    $('.toadmin').text('set user is NOT ok.');
                }
            },'json');
        return false;
    });
})(jQuery);
</script>