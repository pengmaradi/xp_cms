<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8>
        <base href="<?php echo base_url(); ?>" />
        <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" media="all" rel="stylesheet">
        <script src="public_html/xp/xp_cms/js/jquery.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery.ui.js"></script>
        <script src="public_html/xp/xp_cms/js/ckeditor/ckeditor.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery-timepicker.js"></script>
        <style type="text/css">
            .content .header {width:90%;padding:2px;}
            label {float: left;width: 100px;}
            .slider_textarea, .files_textarea{height: 150px;width: 560px;}
            .formlist {margin-bottom: 10px;clear: both;}
            .delimg, .delete, .delfile {cursor: pointer; padding:2px 4px; background: #1392e9;color: red; margin-left: 5px;}
            .showimg {margin: 2px;}
            .showimg img {border:1px solid #eee;padding: 5px;}
            .resetimg {width:400px; padding: 2px;}
            .item {float: left;list-style: none; margin-right: 10px;margin-bottom: 20px;}
            .clearfix {clear: both;}
        </style>
    </head>
    <body>
        <div id="maincontent" class="edtor">
            <?php
            $tmp = $template->template;
            switch ($tmp) {
                default :
                case 1:
                    $options = array();
                    break;
                case 2:
                case 3:
                case 4:
                    $options = array(
                        0 => 'Left',
                        1 => 'Right'
                    );
                    break;
                case 5:
                    $options = array(
                        0 => 'Left',
                        1 => 'Mittel',
                        2 => 'Right'
                    );
                    break;
            }
            $num = count($content);
            for ($i = 0; $i < $num; $i++) {
                // editor
                $images = 'xpcms/files';
                $ckeditor = array(
                    'id' => 'content_' . $content[$i]->uid,
                    'path' => 'js/ckeditor',
                    'config' => array(
                        'filebrowserUploadUrl' => $images,
                        'filebrowserImageBrowseUrl' => $images,
                        'filebrowserImageWindowWidth' => '50%',
                        'filebrowserImageWindowHeight' => '20%',
                        'toolbar' => "Full", //Using the Full toolbar
                        'width' => "100%", //550pxSetting a custom width
                        'height' => '100px', //Setting a custom height
                    ),
                    'styles' => array(
                        'style 1' => array(
                            'name' => 'Red Title',
                            'element' => 'h2',
                            'styles' => array(
                                'color' => 'Red',
                                'font-weight' => 'bold',
                                'text-decoration' => 'underline'
                            )
                        ),
                        'style 2' => array(
                            'name' => 'Blue Title',
                            'element' => 'h2',
                            'styles' => array(
                                'color' => 'Blue',
                                'font-weight' => 'bold'
                            )
                        ),
                        'style 3' => array(
                            'name' => 'Yellow Title',
                            'element' => 'h2',
                            'styles' => array(
                                'color' => 'Yellow',
                                'font-weight' => 'bold'
                            )
                        ),
                        'style 4' => array(
                            'name' => 'Green Title',
                            'element' => 'h3',
                            'styles' => array(
                                'color' => 'Green',
                                'font-weight' => 'bold'
                            )
                        )
                    )
                );

printf('<div class="content" id="uid_%s">', $content[$i]->uid);
                echo form_open('','method="post" id="content_form_'.$content[$i]->uid.'"').PHP_EOL;
                echo form_fieldset($content[$i]->header).PHP_EOL;
                printf('<p class="lastupdated">Last edit: %s</p>', empty($content[$i]->lastupdated) ? '-' : date('d-m-Y H:i', $content[$i]->lastupdated));
                // form begin
                printf('<h3 class="h_%s">header: 
                    <input type="text" class="header" name="title" value="%s" />
                    </h3>',
                        $content[$i]->uid,
                        $content[$i]->header
                );

        echo '<div class="element">'. PHP_EOL;
            echo '<div class="formlist">' . PHP_EOL;
                echo form_label('display: ', 'display') . PHP_EOL;
                printf('<input type="radio" name="display" value="1" %s>On
                <input type="radio" name="display" value="0" %s>Off',
                        $content[$i]->display ? 'checked' : '', 
                        $content[$i]->display ? '' : 'checked');
            echo '</div>' . PHP_EOL;
                
            echo '<div class="formlist">' . PHP_EOL;
                echo form_label('deletde: ', 'deletde') . PHP_EOL;
                printf('<input type="radio" name="deleted" value="1" %s>yes
                <input type="radio" name="deleted" value="0" %s>no',
                        $content[$i]->deleted ? 'checked' : '', 
                        $content[$i]->deleted ? '' : 'checked');
            echo '</div>' . PHP_EOL;
            echo '<div class="formlist">' . PHP_EOL;
                echo form_label('starttime: ', 'starttime') . PHP_EOL;
                printf('<input id="begin_%s" type="text" name="starttime" class="starttime" value="%s" /><span class="delete">x</span>', $content[$i]->uid, date('d-m-Y H:i', $content[$i]->starttime));
            echo '</div>' . PHP_EOL;
                
            echo '<div class="formlist">' . PHP_EOL;
                echo form_label('endtime: ', 'endtime') . PHP_EOL;
                printf('<input id="end_%s" type="text" name="endtime" class="endtime" value="%s" /><span class="delete">x</span>', $content[$i]->uid, empty($content[$i]->endtime) ? '' : date('d-m-Y H:i', $content[$i]->endtime));
            echo '</div>' . PHP_EOL;
                
            echo '<div class="formlist">' . PHP_EOL;
                echo form_label('Position: ', 'pos') . PHP_EOL;
                echo form_dropdown('pos', $options,array($content[$i]->col_pos), 'id="pos"') . PHP_EOL;
            echo '</div>' . PHP_EOL;
                
            echo '<div class="formlist">' . PHP_EOL;
                echo form_label('Content: ', 'content') . PHP_EOL;
                echo '<br/>';
                $type = $content[$i]->content_type;
                printf('<input type="hidden" name="content_type" value="%s"/>',$type);
                printf('<input type="hidden" name="uid" value="%s"/>',$content[$i]->uid);
                switch ($type) {
                    // 1-7
                    case 1:
                        echo '<textarea class="has_editor" name="content" id="content_' . $content[$i]->uid . '" >' . $content[$i]->body_text . '</textarea>' . PHP_EOL;
                        echo display_ckeditor($ckeditor);
                        break;
                    case 2:
                        printf('<div class="showimg"><img src="%s" width="%s" /></div>',$content[$i]->image,$content[$i]->image_width,$content[$i]->image_height);                        
                        printf('<div class="formlist"><label for="width">width: </label><input type="text" name="width" value="%s" /></div>',$content[$i]->image_width);
                        printf('<div class="formlist"><label for="height">height: </label><input type="text" name="height" value="%s" /></div>',$content[$i]->image_height);
                        printf('<div class="formlist"><label for="pic">picture: </label><input class="resetimg" name="pic" value="%s"/></div>',$content[$i]->image,$content[$i]->image_width,$content[$i]->image_height);                        
                        echo '<div class="formlist" id="img_browser_gallery_all" style="display:none;width:100%;margin-top:20px;">';
                        if (isset($gallery) && count($gallery)){
                            foreach($gallery as $image) {
                                echo '<div class="thumb" style="float: left; margin-right:5px;">';
                                    echo '<a href="'.$image['url'].'" title="'.$image['file'].'">';
                                        echo '<img class="smallimg" src="'. $image['thumb_url'].'" />';
                                    echo '</a>';
                                echo '</div>';
                            }
                            
                        }else {
                                echo '<div id="blank_gallery">Please Upload Image First</div>';
                        }
                        echo '</div>';
                        
                        break;
                    case 3:
                        //echo '<h5>Preview</h5>';
                        $files = array();
                        $files = explode(',', $content[$i]->file_link);
                        $num_files = count($files);
                        unset($files[$num_files-1]);
                        $slider = '<ul class="files_edit">'.PHP_EOL;
                        for($j = 0; $j < $num_files-1; $j ++) {
                            $slider .= '<li class="lightbox item" data-file="'.$files[$j].'">
                                '.$files[$j].'
                                <span class="delfile">X</span></li>'.PHP_EOL;
                        }
                        echo $slider.'</ul>'.PHP_EOL;
                        echo '<div class="clearfix"></div>';
                        echo '<textarea name="content" class="files_textarea" id="content_' . $content[$i]->uid . '" >' . $content[$i]->file_link . '</textarea>' . PHP_EOL;

                        echo '<div id="document_browser_edit" style="width:100%;margin-top:20px;display:none;">'.PHP_EOL;                        
                        foreach($documents as $document){
                            echo '<div class="thumb" style="margin-right:5px;">'.PHP_EOL;
                                echo '<a href="'.$document['url'].'" title="'.$document['file'].'<span>(size:'.$document['file_size'].')</span>">'.$document['file'];
                                    echo $document['file'].' size:'.$document['file_size'];
                                echo '</a>'.PHP_EOL;
                            echo '</div>'.PHP_EOL;
                        }
                        echo '</div>'.PHP_EOL;
                        break;
                    case 4:
                        echo '-';
                        break;
                    case 5:
                        echo '-';
                        break;
                    case 6:
                        echo '-';
                        break;
                    case 7:
                        echo '<h5>Preview</h5>';
                        $images = array();
                        $images = explode(',', $content[$i]->file_link);
                        $num_imgs = count($images);
                        unset($images[$num_imgs-1]);
                        $slider = '<ul class="slider_edit">'.PHP_EOL;
                        for($j = 0; $j < $num_imgs-1; $j ++) {
                            $slider .= '<li class="lightbox item">
                                <img src="'.$images[$j].'" width="100" height="70" />
                                <span class="delimg">X</span></li>'.PHP_EOL;
                        }
                        echo $slider.'</ul>'.PHP_EOL;
                        echo '<div class="clearfix"></div>';
                        echo '<textarea name="content" class="slider_textarea" id="content_' . $content[$i]->uid . '" >' . $content[$i]->file_link . '</textarea>' . PHP_EOL;
                        
                        echo '<div class="formlist" id="slider_browser_gallery_all" style="display:none;width:100%;margin-top:20px;">';
                        if (isset($gallery) && count($gallery)){
                            foreach($gallery as $image) {
                                echo '<div class="thumb" style="float: left; margin-right:5px;">';
                                    echo '<a href="'.$image['url'].'" title="'.$image['file'].'">';
                                        echo '<img class="smallimg" src="'. $image['thumb_url'].'" />';
                                    echo '</a>';
                                echo '</div>';
                            }
                            
                        }else {
                                echo '<div id="blank_gallery">Please Upload Image First</div>';
                        }
                        echo '</div>';
                        
                        printf('<div class="formlist"><label for="width">width: </label><input type="num" name="width" value="%s"/></div>'.PHP_EOL, $content[$i]->image_width);
                        printf('<div class="formlist"><label for="height">height: </label><input type="num" name="height" value="%s"/></div>'.PHP_EOL,$content[$i]->image_height);
                        
                        break;
                }
            echo '</div>' . PHP_EOL;
            
            echo '<div class="formlist">' . PHP_EOL;
            echo form_label('&nbsp;', 'save_content_'.$content[$i]->uid ) . PHP_EOL;
            echo form_submit('submit', 'Save', 'id="save_content_'.$content[$i]->uid.'"') . PHP_EOL;
            echo '</div>' . PHP_EOL;
                // create time picker
printf('<script>
    jQuery(function($){
        $("#begin_%s").datetimepicker({dateFormat: "dd-mm-yy"});
        $("#end_%s").datetimepicker({dateFormat: "dd-mm-yy"});
        $("#save_content_%s" ).click(function(){
            var contents = $("#content_form_%s").serialize();
            if($("textarea#content_%s").hasClass("has_editor")) {
                var ck_content = CKEDITOR.instances.content_%s.getData();
                contents += "&ck_content=" + ck_content;
            }
            //alert(contents);
            $.post("xpcms/resetContent",contents,function(data){
                if(data.success){
                    location.reload();
                }
            },"json");
            return false;
        });
    });
    </script>', 
        $content[$i]->uid,
        $content[$i]->uid,
        $content[$i]->uid,
        $content[$i]->uid,
        $content[$i]->uid,
        $content[$i]->uid
);
        echo '</div>'.PHP_EOL;
                
                echo form_fieldset_close();
                echo form_close();
                
        echo '</div>'.PHP_EOL;
            }
            ?>

        <script>
            jQuery(function($) {
                $('.element').hide();
                $('.content h3').click(function() {
                    $(this).next().show(1000);
                    $(this).closest('.content').siblings().find('.element').hide(1000);
                });
                $('legend').click(function(){
                    $(this).nextAll().toggle(100);
                });
                $('.delete').click(function(){
                    $(this).prev('input').val('');
                });
                // show image gallery
                $('.resetimg').click(function(){
                    $(this).closest('.formlist').nextAll('#img_browser_gallery_all').show(1000);
                });
                $('#img_browser_gallery_all a').click(function(){
                    var href = $(this).attr('href');
                    $('.resetimg').val(href);
                    $('.showimg img').attr('src',href);
                    $(this).closest('#img_browser_gallery_all').hide(1000);
                    return false;
                });
                // slider browser
                $('.slider_textarea').click(function(){
                    $('#slider_browser_gallery_all').toggle(100);
                });
                // add img
                $('#slider_browser_gallery_all a').click(function(){
                    var href = $(this).attr('href'),
                    newlist = '<li class="lightbox item"><img height="70" width="100" src="'+href+'"><span class="delimg">X</span></li>';
                    sliderval = $('.slider_textarea').val();
                    sliderval += href+',\n';
                    $('.slider_textarea').val(sliderval);
                    $('.slider_edit').append(newlist);
                    // remove img
                    $('.delimg').click(function(){
                        var imgsrc = $(this).prev().attr('src'),
                        slider = $('.slider_textarea').val();
                        slider = slider.replace(imgsrc+',','');
                        $('.slider_textarea').val(slider);
                        $(this).closest('.item').hide(1000);
                    });
                    $(this).hide(1000);
                    return false;
                });
                // remove img
                $('.delimg').click(function(){
                    var imgsrc = $(this).prev().attr('src'),
                    slider = $('.slider_textarea').val();
                    slider = slider.replace(imgsrc+',','');
                    $('.slider_textarea').val(slider);
                    $(this).closest('.item').hide(1000);
                });
                // files browser
                $('.files_textarea').click(function(){
                    $('#document_browser_edit').toggle(1000);
                });
                // document browser
                $('#document_browser_edit a').click(function(){
                    var title = $(this).attr('href'),
                    files_content = $('.files_textarea').val();
                    files_content += title+',\n';
                    $('.files_textarea').val(files_content);
                    $(this).hide(1000);
                    $('.files_textarea').val();
                    $('.files_edit').append('<li class="lightbox item" data-file="'+title+'">'+title+'<span class="delfile">X</span></li>');
                    
                    $('.delfile').click(function(){
                        var delfile = $(this).closest('.item').attr('data-file'),
                        document = $('.files_textarea').val();
                        document = document.replace(delfile+',','');
                        $('.files_textarea').val(document);
                        $(this).closest('.item').hide(1000);

                    });
                    return false;
                });
                $('.delfile').click(function(){
                    var delfile = $(this).closest('.item').attr('data-file'),
                    document = $('.files_textarea').val();
                    document = document.replace(delfile+',','');
                    $('.files_textarea').val(document);
                    $(this).closest('.item').hide(1000);
                    
                });
                // 
            });
        </script>
    </body>
</html>