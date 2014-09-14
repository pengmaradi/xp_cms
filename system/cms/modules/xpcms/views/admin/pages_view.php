<?php
echo $menu;
?>
<div id="maincontent" class="pages">
    <div class="fe_pages">
        <!-- tree of the menu -->
        <div class="pageTree">
            <?php
            echo MPTtreeToUl($feMenu,'');
            ?>
        </div>

    </div>
    <div class="fe_content">

        <?php
//        $num = count($feMenu);
//        for ($i = 0; $i < $num; $i++) {
//        $titles[] = $feMenu[$i]['title'];
//        $descriptions[] = $feMenu[$i]['description'];
//        $urls[] = $feMenu[$i]['url'];
//        $uids[] = $feMenu[$i]['uid'];
//        echo '<li class="list" rel="' . $urls[$i] . 
//                '" id="pid_' . $uids[$i] . '" title="' . $descriptions[$i] . 
//                '"><span class="addPageContent">' . 
//                $titles[$i] .
//        '</span></li>' . PHP_EOL;
//        }
        ?>

        <iframe src="sorting"></iframe>
    </div>
    <div class="clear"></div>
</div>
<script>
(function($){
    $('#root .delete').hide();
    $('#root li').each(function(){
        var $th = $(this), rel = $th.attr('rel');
        $th.click(function(){
            $('.fe_content iframe').attr('src','xpcms/pages_edtor?url='+rel);
        });
    });
})(jQuery);
</script>

