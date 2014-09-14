<?php
//echo Modules::run('feheader/index',$title);
$title = 'XP_CMS';

$headerdata = array(
    'title' => $title,
    'keywords' => $web_info[0]->key_words,
    'description' => $web_info[0]->web_description,
    'google_verification' => '123',
    'icon' => $web_info[0]->icon,
    'page' => empty($header->title) ? '' : $web_info[0]->web_title,
    'body_color' => $web_info[0]->body_color,
    'logo' => empty($header->logo) ? '' : $web_info[0]->logo
);

$this->load->controller('feheader/index', $headerdata);
?>
<div class="head" style="background-color: #<?php echo $web_info[0]->header_color; ?>">
    <?php
// show header menu
    if ($header->hmenu == 1) {
        echo MPTtreeToUlFE($feMenu, '');
    }
    ?> 
    <div class="clear"></div>
    <?php 
    if ($header->search) {
        $this->load->controller('search/search',array('home'));
    }
    ?>
    <div class="clear"></div>
</div>

<div id="content" class="registry" style="background-color: #<?php echo $web_info[0]->content_color; ?>">
<?php


echo validation_errors();
echo form_open(base_url().'login/checkRegister').PHP_EOL;
echo '<fieldset>';
echo '<legend>registry</legend>';
echo '<div class="formlist">'.PHP_EOL;
echo form_label('Username: ','name');
echo form_input('name', $this->input->post('name'),'placeholder="Name"  pattern="[a-zA-ZäöüÄÖÜ]{3,}"').PHP_EOL; 
echo '</div>'.PHP_EOL;
echo '<div class="formlist">'.PHP_EOL;
echo form_label('password: ','password');
echo form_password('password','','placeholder="password" required').PHP_EOL;
echo '</div>'.PHP_EOL;
echo '<div class="formlist">'.PHP_EOL;
echo form_label('password again: ','cpassword');
echo form_password('cpassword','','placeholder="password  Confirm" required').PHP_EOL;
echo '</div>'.PHP_EOL;
echo '<div class="formlist">'.PHP_EOL;
echo form_label('E-mail: ','email');
echo '<input type="email" name="email" placeholder="name@you.com" required value="'.$this->input->post('email').'">'.PHP_EOL;
echo '</div>'.PHP_EOL;
echo '<div class="formlist">'.PHP_EOL;
echo form_label('&nbsp;','submit');
echo form_submit('submit', 'registry').PHP_EOL;
echo '</div>'.PHP_EOL;
echo '</fieldset>';
echo form_close().PHP_EOL;

echo '</div>';

//echo '<a href="'.base_url().'admin/login">Login</a>';

//echo '<iframe width="420" height="315" src="http://www.youtube.com/embed/TPo06qXHVb8" frameborder="0" allowfullscreen></iframe>';

?>
<div id="sidebar">
    <div class="s_content"></div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<footer style="background-color: #<?php echo $web_info[0]->footer_color;?>" class="clear">
<?php
if ($footer->fmenu == 1) {
    echo MPTtreeToUlFE($feMenu, '');
}

$footer_data = array(
    $web_info[0]->google_analitytis,
    $web_info[0]->web_copyright,
    $web_info[0]->social_netzwork,
    $web_info[0]->web_address,
    $web_info[0]->footer_color
);
$this->load->controller('fefooter/index', $footer_data);
?>