<div class="admincontact">
    <div class="con_error">
        <?php
        echo validation_errors();
        ?>        
    </div>
    <?php
    echo form_open('', 'method="post" id="contact"') . PHP_EOL;
    ?>
    <div class="formlist">     
        <?php
        echo form_label('User: ', 'user') . PHP_EOL;
        $num = count($userarr);
        $options = array(0 => 'Select a contact');
        $emailarr = array();
        $emailstr = '';
        for ($i = 0; $i < $num; $i++) {
            array_push($options, $userarr[$i]->realname);
        }

        echo form_dropdown('usersel', $options, $this->input->post('usersel'), 'id="usersel"') . PHP_EOL;

//echo form_hidden('keyemail',$this->input->post('user'),'id="email"');
        ?>
    </div>

    <div class="formlist">  
        <?php
        echo form_label('Subject: ', 'subject') . PHP_EOL;
        echo form_input('subject', $this->input->post('subject'), 'id="subject"') . PHP_EOL;
        ?>
    </div>
    <div class="formlist">    
        <?php
        echo form_label('Message: ', 'message') . PHP_EOL;
        echo form_textarea('message', $this->input->post('message'), $extra = 'id="message"') . PHP_EOL;
        ?>
    </div>



    <div class="formlist">
        <?php
        echo form_label('&nbsp; ', 'send') . PHP_EOL;
        echo form_submit('submit', 'Send', 'id="send"') . PHP_EOL;
        ?>
    </div>       
    <?php
    echo form_close() . PHP_EOL;
    ?>       

</div>
<script>
    (function($) {
        $('#send').click(function() {
            var contents = $('#contact').serialize(),
            usersel = $('#usersel').val(),
            subject = $('#subject').val(), 
            message = $('#message').val();
            if(usersel == 0) {
                $('.con_error').text('please select a user to contact.');
                return false;
            }else {
                $('.con_error').text('');
            }
            if(subject == '') {
                $('.con_error').text('please write a subject.');
                return false;
            }else {
                $('.con_error').text('');
            }
            if(message == '') {
                $('.con_error').text('please write the message.');
                return false;
            }else {
                $('.con_error').text('');
            }
            //alert(contents);
            //var usersel = $('#usersel').val(), 
            $.post('admin/sendMail', contents, function(data) {
                $('.con_error').html(data.msg);
            }, 'json');
            return false;
        });
    })(jQuery);
</script>
