<?php
//echo Modules::run('feheader/index',$title);
$title = @$web_info[0]->web_title;
$headerdata = array(
    'title' => $title.': '.$page,
    'keywords' => @$web_info[0]->key_words,
    'description' => @$web_info[0]->web_description,
    'google_verification' => '123',
    'icon' => @$web_info[0]->icon,
    'page' => $title,
    'body_color' => @$web_info[0]->body_color,
    'header_color'  => @$web_info[0]->header_color,
    'logo' => @$web_info[0]->logo
);

$this->load->controller('feheader/index', $headerdata);
?>
    <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
    <?php if ($header->hmenu):?>
       <?php echo MPTtreeToUlFE($feMenu, '');?>    
    <?php endif;?>
    
    <?php
    if ($header->hlogin): ?>
        <div class="login navbar-form navbar-right"><a href="xpcms" target="_blank">login</a></div>
    <?php endif; ?>
    <?php 
    if ($header->search) {
        $this->load->controller('search/search',array('home'));
    } ?>    
    </nav>
 


</div>
</header>
<!--<div id="content" class="bs-header">
    <div class="container">
        <h1>CSS</h1>
        <p>设置全局CSS样式，基本的HTML元素均可以通过class设置样式并得到增强效果，还有先进的栅格系统。</p>
    </div>
</div>-->

<div  class="container bs-docs-container" style="background-color: #<?php echo @$web_info[0]->content_color; ?>">
    <div class="twospalt col-md-12" role="main">
    <?php
    // show content menu
    if ($content->cmenu == 1) {
        echo MPTtreeToUlFE($feMenu, '');
    }
    
    $leftContent = '';
    $mittelContent = '';
    $rightContent = '';
    for ($i = 0; $i < $num; $i++) {
        if ($contents[$i]['col_pos'] == 0) {
            $leftContent  .= '<div class="cElement">'.PHP_EOL;
            $leftContent .= '<h3>' . $contents[$i]['header'] . '</h3>'.PHP_EOL;
            $leftContent .= '<div class="body_text">'.$contents[$i]['body_text'] . '</div>'.PHP_EOL;         

            $leftContent .= '<div class="body_image"><img src="'.
                    $contents[$i]['image'].'" alt="'.$contents[$i]['image'].'" title="'.
                    $contents[$i]['image'].'" width="'.$contents[$i]['image_width'].'" height="'.
                    $contents[$i]['image_height'].'" /></div>'.PHP_EOL;
            $leftContent .= '</div>'.PHP_EOL;
        } else if ($contents[$i]['col_pos'] == 1) {
            $mittelContent .= '<div class="cElement">'.PHP_EOL ;
            $mittelContent .= '<h3>' . $contents[$i]['header'] . '</h3>';
            $mittelContent .= '<div class="body_text">' . $contents[$i]['body_text'] . '</div>'.PHP_EOL;
            
            $mittelContent .= '<div class="body_image"><img src="'.
                    $contents[$i]['image'].'" alt="'.$contents[$i]['image'].'" title="'.
                    $contents[$i]['image'].'" width="'.$contents[$i]['image_width'].'" height="'.
                    $contents[$i]['image_height'].'" /></div>'.PHP_EOL;
            $mittelContent .= '</div>'.PHP_EOL;
            
        } else {
            $rightContent .= '<div class="cElement">'.PHP_EOL;
            $rightContent .= '<h3>' . $contents[$i]['header'] . '</h3>';
            $rightContent .= '<div class="body_text">' . $contents[$i]['body_text'] . '</div>'.PHP_EOL;
            
            $rightContent .= '<div class="body_image"><img src="'.
                    $contents[$i]['image'].'" alt="'.$contents[$i]['image'].'" title="'.
                    $contents[$i]['image'].'" width="'.$contents[$i]['image_width'].'" height="'.
                    $contents[$i]['image_height'].'" /></div>'.PHP_EOL;
            
            $rightContent .= '</div>'.PHP_EOL;
        }
    }
    ?>  
    <div class="thirty_three left col-lg-4 col-md-4">
        <div class="content">
            <?php echo $leftContent; ?>
        </div>
    </div>
    <div class="thirty_three mittel col-lg-4 col-md-4">            
        <div class="content">
            <?php echo $mittelContent; ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="thirty_three right col-lg-4 col-md-4">
        <div class="content">
            <?php echo $rightContent; ?>
        </div>
    </div>
</div>
</div>
<footer class="bs-footer navbar-fixed-bottom" role="contentinfo" style="background-color: #<?php echo @$web_info[0]->footer_color;?>">
    <div class="container">
<?php 
    if ($footer->flogin) {
        echo '<div class="login"><a href="xpcms" target="_blank">login</a></div>';
    }
    ?>
    
<?php
// footer menu
if ($footer->fmenu == 1) {
    echo MPTtreeToUlFE($feMenu, '');
}
$footer_data = array(
    @$web_info[0]->google_analitytis,
    @$web_info[0]->web_copyright,
    @$web_info[0]->social_netzwork,
    @$web_info[0]->web_address,
    @$web_info[0]->footer_color
);
$this->load->controller('fefooter/index', $footer_data);
?>