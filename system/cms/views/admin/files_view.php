<?php

/**
 * @filename = files_view
 * @deprecated =
 *
 * @author = xiaoling
 * @copyright = pengmaradi
 * @email = pengmaradi@gmail.com
 * @link = http://pengmaradi.szmay.com
 * @license = ...
 * @version = 1.0
 */
echo $menu;
?>
<div id="maincontent">
    <div class="create">File upload</div>
    <div class="uploadFile" style="display:none">
        <form method="post" action="" id="upload_file">
            <div class="formlist">
                <label for="title">title</label>
                <input type="text" name="title" id="title"/>
                <span id="warnung" style="display: none">!!!!</span>            
            </div>
            <div class="formlist">
                <label for="filename">upload a file</label>
                <input type="file" name="file" id="filename"/>
                <span id="warnung" style="display: none">!!!!</span>            
            </div>
            <div class="formlist">
                <input type="submit" value="save" id="save" />
            </div>
        </form>
        <div id="closeit">X</div>
    </div>
    <div id="files"></div>
</div>
<script>
//$(document).ready(function(){
//    alert(0);
//});

function refresh_files()
{
   $.get('./public_html/xp/xp_cms/images/')
   .success(function (data){
      $('#files').html(data);
   });
}
(function($){
    $('#closeit').click(function(){
        $(this).closest('.uploadFile').slideToggle();
    });
    $('.create').click(function(){
        $(this).next().slideToggle();
        
    });
    $('#save').click(function(){
        var file = $('#filename').val();
        //alert(file);
        if( file == '' ){
            $('#filename')
            .addClass('hightlight')
            .focus();
            return false;
        } else {
            $('#filename')
            .removeClass('hightlight')
        }

        //$(this).closest('.makeTree').css('display','none');
    });
    
    $('#upload_file').submit(function(e){
        e.preventDefault();
        $.ajaxFileUpload({
            url:        'xpcms/fileUpload',
            secureuri:  false,
            fileElementId: 'filename',
            dataType:   'json',
            data:       {
                'title':    $('#title').val()
            },
            success:    function(data, status){
                if(data.status != 'error' ) {
                    $('#files').html('<p>Reloading files...</p>');
                    refresh_files();
                    $('#title').val('');
                }
                alert(data.msg);
            }
        });
        return false;
    });
})(jQuery);
//jQuery(function($){
//    alert(0);
//});
</script>