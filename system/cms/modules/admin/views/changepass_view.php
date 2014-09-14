<div class="templateform">
    <div class="ch_error">
<?php 
    echo validation_errors();
?>        
    </div>
<?php
    echo form_open('', 'method="post" id="ch_admin"') . PHP_EOL;
?>
        <div class="formlist">     
<?php 
    echo form_label('Username: ', 'ch_user') . PHP_EOL;
    echo form_input('ch_user', $this->input->post('ch_user')?$this->input->post('ch_user'):$adminarr->username, 'id="ch_user"') . PHP_EOL;
?>
        </div>
        <div class="formlist">  
<?php 
    echo form_label('Password: ', 'ch_password') . PHP_EOL;
    echo form_password('ch_password', $this->input->post('ch_password'), 'id="ch_password"') . PHP_EOL; 
?>
        </div>
        <div class="formlist">    
<?php 
    echo form_label('Password 2: ', 'ch_pass2') . PHP_EOL;
    echo form_password('ch_pass2', $this->input->post('ch_pass2'), 'id="ch_pass2"') . PHP_EOL; 
?>
        </div>
        <div class="formlist">
<?php 
    echo form_label('Realname: ', 'ch_realname') . PHP_EOL;
    echo form_input('ch_realname', $this->input->post('ch_realname')?$this->input->post('ch_realname'):$adminarr->realname, 'id="ch_realname"') . PHP_EOL; 
?>
        </div>
        <div class="formlist">    
<?php 
    echo form_label('Email: ', 'ch_email') . PHP_EOL;
    echo form_input('ch_email', $this->input->post('ch_email')?$this->input->post('ch_email'):$adminarr->email, 'id="ch_email"') . PHP_EOL; 
?>
        </div>
        <div class="formlist">
<?php
    echo form_input(array('type'=>'hidden', 'name'=>'ch_uid'), $adminarr->uid, 'id="ch_uid"');
    echo form_label('&nbsp; ', 'ch_save') . PHP_EOL;
    echo form_submit('submit', 'Save', 'id="ch_save"') . PHP_EOL;
?>
        </div>       
<?php
    echo form_close() . PHP_EOL;
?>       
    
</div>
<script>
(function($){
   
    $('#ch_user').focusout(function(){
          var ch_user = $.trim($('#ch_user').val());
          $.post(
           'admin/checkUserName',
           {user:ch_user},
           function(data){
               if(!data.success) {
                   $('.ch_error').text('the user name is already in use.');
                   return false;
               }else{
                   $('.ch_error').text('you can change as this user name.');
               }                
           },
           'json');
   });
      
    $('#ch_save').click(function(){
       var contents = $('#ch_admin').serialize(),
       ch_password = $('#ch_password').val(),
       ch_pass2 = $('#ch_pass2').val();
       //alert(contents);
       if(ch_password != ch_pass2){
           $('.ch_error').text('your passwords are not correct.');
           return false;
       } else {
            $('.ch_error').text('');
            $.post('admin/resetUser',contents,function(data){
                if(data.success){
                    $('.ch_error').text('changed');
                }else{
                    $('.ch_error').text('not changed');
                }
            },'json');
       }   
       
       return false;
   }); 
})(jQuery);
</script>