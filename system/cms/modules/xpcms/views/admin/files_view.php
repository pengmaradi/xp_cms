<?php
//echo str_replace('index.php','',$_SERVER['PHP_SELF']);
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
<div id="maincontent" class="files">
    <div id="gallery" calss="documents">
        <h3>Images: jpg, jpeg, gif, png</h3>
    <?php if (isset($images) && count($images)):
            foreach($images as $image):	?>
        <div class="thumb">
            <a href="<?php echo $image['url']; ?>" title="<?php echo $image['file']; ?>">
                <img class="smallimg" src="<?php echo $image['thumb_url']; ?>" />
                <?php //$info = getimagesize($image['url']); echo $info['bits'];?>
            </a>
            <div class="delete_image delete" title="delete this">X</div>
        </div>
    <?php endforeach; else: ?>
        <div id="blank_gallery">Please upload an image</div>
    <?php endif; ?>
    </div>
    <div class="show">
        <div class="my_slider"></div>        
        <div class="deco"></div>
    </div>
    
    <script>
    (function($){
        // delete file
        $('.delete_image').click(function(){
            var title = $(this).prev().attr('title');
            $.post('xpcms/removeFile', {title:title}, function(data){
                if(data.success){
                    alert('the '+ data.title + ' is deleted');
                    // page refresh
                    location.reload();
                }else {
                    alert('the '+ data.title + ' is not deleted');
                }
            },'json');
        });
        // simple slider
        $('.thumb a').each(function(){
            $(this).click(function(){
                var href = $(this).attr('href'),
                title = $(this).attr('title'),
                $myimg = $('<img />', {
                    class: 'newimg',
                    src  : href,
                    title: title,
                    width: '700'
                });
                $(this).toggleClass('act');
                $('.my_slider').html($myimg);
                $('.newimg').after('<div class="prev">prev</div><div class="next">next</div>');
                $('.show').show();
                $('.deco').click(function(){
                    $('.show').hide();
                });
                
                $('.next').click(function(){                    
                    var nxhref = $('a.act')
                            .removeClass('act')
                            .closest('.thumb')
                            .next()
                            .children('a')
                            .addClass('act')
                            .attr('href');
                    
                    if( typeof nxhref == 'undefined'){
                        nxhref = $('.thumb:first').find('a').addClass('act').attr('href');
                        $('.thumb:last').find('a').removeClass('act')
                    }
                    $('.newimg').attr('src', nxhref);
                    
                });
                
                $('.prev').click(function(){                    
                    var prhref = $('a.act')
                            .removeClass('act')
                            .closest('.thumb')
                            .prev()
                            .children('a')
                            .addClass('act')
                            .attr('href');
                    if( typeof prhref == 'undefined'){
                        prhref = $('.thumb:last').find('a').addClass('act').attr('href');
                        $('.thumb:first').find('a').removeClass('act')
                    }
                    $('.newimg').attr('src', prhref);
                });
                return false;
            });            
        });

    })(jQuery);
    </script>
    <div class="upload">
        <?php
        echo form_open_multipart('xpcms/files');
        echo form_upload('userfile','','size="40"');
        echo form_submit('upload', 'Upload');
        echo form_close();
        ?>	
    </div>
    <div class="documents">
        <h3>Documents: txt, pdf, xml, doc, docx </h3>
        <?php if (isset($documents) && count($documents)):
            foreach($documents as $document):	?>
        <div class="thumb document">
            <?php
            //print_r($document);
            printf('<a href="%s" target="_blank" title="%s">%s</a>%s', $document['url'], $document['file'], $document['file'] ,PHP_EOL);
            echo $document['file_size'];
            ?>
            <div class="delete_ducu delete" title="delete this">X</div>
        </div>
    <?php endforeach; else: ?>
        <div id="blank_gallery">Please upload a document</div>
    <?php endif; ?>
    </div>
    <div class="upload">
        <?php
        echo form_open_multipart('xpcms/files');
        echo form_upload('dument','','size="40"');
        echo form_submit('upload_docu', 'Upload');
        echo form_close();
        ?>
    </div>
</div>
<script>
(function($){
// delete file
    $('.delete_ducu').click(function(){
        var title = $(this).prev().attr('title');
        $.post('xpcms/removeDocument', {title:title},function(data){
            if(data.success){
                alert('the '+ data.title + ' is deleted');
                // page refresh
                location.reload();
            }else {
                alert('the '+ data.title + ' is not deleted');
            }
//            alert(data.success);
        },'json');
    });
})(jQuery);
</script>
