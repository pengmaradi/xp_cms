<div id="img_browser_gallery">
    <?php if (isset($images) && count($images)):
            foreach($images as $image):	?>
        <div class="thumb">
            <a href="<?php echo $image['url']; ?>" title="<?php echo $image['file']; ?>">
                <img class="smallimg" src="<?php echo $image['thumb_url']; ?>" />
            </a>
        </div>
    <?php endforeach; else: ?>
        <div id="blank_gallery">Please Upload Image First</div>
    <?php endif; ?>
    </div>
<script>
(function($){
    $('#img_browser_gallery a').click(function(){
        //alert(0);
        var href = $(this).attr('href');
        $('.pic').val(href);
        return false;
    });
})(jQuery);
</script>
