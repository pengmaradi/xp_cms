<?php
$num = count($userarr);
for ($i = 0; $i < $num; $i++):
    ?>
    <div class="userlist">
        <div class="realname">
            <?php
            echo '<span class="realneme_'.$userarr[$i]->uid.'">'.$userarr[$i]->realname.'</span>';
            printf(' Last login: %s' , !$userarr[$i]->lastlogin? '-':date('d.m.Y H:i', $userarr[$i]->lastlogin));
            echo ' Login IP: ' . $userarr[$i]->login_ip;
            ?>
        </div>
        <div class="list_form" style="display:none">
            <div class="changeuser">
                <?php
                echo form_open('', 'method="post" id="change_form_' . $userarr[$i]->uid . '"') . PHP_EOL;
                echo form_input(array('type'=>'hidden','name'=>'change_uid'), $userarr[$i]->uid, 'id="change_uid_' . $userarr[$i]->uid . '"');
                ?>
                
                <div class="formlist">
                    <?php
                    echo form_label('Username: ', 'change_username') . PHP_EOL;
                    echo form_input('change_username', $userarr[$i]->username, 'id="change_username_' . $userarr[$i]->uid . '"');
                    ?>
                </div>
                <div class="formlist">
                    <?php
                    echo form_label('Password: ', 'change_pass') . PHP_EOL;
                    echo form_input('change_pass', '', 'id="change_pass_' . $userarr[$i]->uid . '"');
                    echo form_input(array('type' =>'hidden','name'=>'old_password'), $userarr[$i]->password, 'id="old_pass_' . $userarr[$i]->uid . '"');
                    ?>
                </div>
                <div class="formlist">            
                    <?php
                    echo form_label('Identity: ', 'change_admin') . PHP_EOL;
                   // echo form_input('change_admin', $userarr[$i]->admin, 'id="change_admin_' . $userarr[$i]->uid . '"');
                    echo form_dropdown('change_admin', $options, $userarr[$i]->admin, 'id="change_admin_' . $userarr[$i]->uid . '"');
                    ?>
                </div>
                <div class="formlist">
                    <?php
                    echo form_label('Starttime: ', 'change_start') . PHP_EOL;
                    echo form_input('change_start', date('d-m-Y H:i', $userarr[$i]->starttime), 'id="change_start_' . $userarr[$i]->uid . '"');
                    ?>
                </div>
                <div class="formlist">
                    <?php
                    echo form_label('Endtime: ', 'change_end') . PHP_EOL;
                    echo form_input('change_end', date('d-m-Y H:i', $userarr[$i]->endtime), 'id="change_end_' . $userarr[$i]->uid . '"');
                    ?>
                </div>
                <div class="formlist">
                    <?php
                    echo form_label('Realname: ', 'change_realname') . PHP_EOL;
                    echo form_input('change_realname', $userarr[$i]->realname, 'id="change_realname_' . $userarr[$i]->uid . '"');
                    ?>
                </div>
                <div class="formlist">
                    <?php
                    echo form_label('Email: ', 'change_eamil') . PHP_EOL;
                    echo form_input('change_eamil', $userarr[$i]->email, 'id="change_email_' . $userarr[$i]->uid . '"');
                    ?>
                </div>
                <div class="formlist">
                    <?php
                    echo form_label('Deleted: ', 'change_deleted') . PHP_EOL;
                    //echo form_input('change_deleted', $userarr[$i]->deleted, 'id="change_deleted_' . $userarr[$i]->uid . '"');
                    $checked = $userarr[$i]->deleted;
                    echo form_checkbox('change_deleted', 1, $checked, 'id="change_deleted_' . $userarr[$i]->uid . '"')
                    ?>
                </div>
                <div class="formlist">
<?php
    echo form_label('&nbsp; ', 'save') . PHP_EOL;
    echo form_submit('submit', 'Save', 'id="change_save_' . $userarr[$i]->uid . '"') . PHP_EOL;
?>
        </div>
                <?php
                echo form_close();
                ?>
            </div>
            <div class="error_<?php echo $userarr[$i]->uid;?>"></div>
        </div>        
    </div>

<script>
(function($){
    // add date time picker
    $('#change_start_<?php echo $userarr[$i]->uid;?>').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#change_end_<?php echo $userarr[$i]->uid;?>').datetimepicker({dateFormat: 'dd-mm-yy'});
    $('#change_realname_<?php echo $userarr[$i]->uid;?>').keyup(function(){
        var realname = $(this).val();
        $('span.realneme_<?php echo $userarr[$i]->uid;?>').text(realname);
    });
    // send ajax
    $('#change_save_<?php echo $userarr[$i]->uid;?>').click(function(){
        var contents = $('#change_form_<?php echo $userarr[$i]->uid;?>').serialize();
        $.post('admin/resetUser',contents,function(data){
                if(data.success){
                    $('.error_<?php echo $userarr[$i]->uid;?>').text('changed');
                    $('#change_save_<?php echo $userarr[$i]->uid;?>').closest('.list_form').hide();
                }else{
                    $('.error_<?php echo $userarr[$i]->uid;?>').text('not changed');
                }
            },'json');
        return false;
    });
})(jQuery);
</script>
    <?php
endfor;
?>
<script>
(function($){
    $('.realname').click(function(){
        $(this).next().toggle();
        $(this).closest('.userlist').siblings().find('.list_form').hide();
    });
})(jQuery);
</script>