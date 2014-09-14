<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
/* Location: ./system/cms/modules/xpcms/controllers/xpcms.php */
class Xpcms extends MY_Controller {

    /**
     *
     * @var string $sControllerName
     */
    protected $sControllerName = 'login';

    /**
     * action __construct
     * @return void
     */
    public function __construct() {
        $this->sControllerName = strtolower(__CLASS__);
        parent::__construct($this->sControllerName, TRUE);
        //parent::__construct();
        $this->load->model('inhalt_model');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/xpcms
     * 	- or -
     * 		http://example.com/index.php/xpcms/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/xpcms/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->login();
    }

    /**
     * action calendar
     *
     * @param int $year
     * @param int $month
     * @return string Description
     */
    public function calendar($year = null, $month = null) {
        $pref = array(
            'show_next_prev' => TRUE,
            'next_prev_url' => base_url() . 'xpcms/calendar'
        );
        $this->load->library('calendar', $pref);
        echo $this->calendar->generate($year, $month);
    }

    /**
     * login action
     */
    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('xpcms/home');
        } else {
            $data = array(
                'title' => 'Admin login',
            );   
         $this->my_renderAll('./admin/login_view', $data);
        }
    }

    /**
     * action check_login set sessions
     *
     * @return void
     */
    public function check_login() {
               
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Username', 'required|trim|xss_clear');
        //                              input框name, 报错文字，      必填项|去首位空格|清除代码|md5加密
        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clear|md5');
//        is_unique[user.name] 是否与数据表user中的name重复
//        $this->form_validation->set_message('is_unique','%s is invalid');
        ///////
        $username = $this->_sqlFilter($this->input->post('name'));
        $password = $this->_sqlFilter($this->input->post('password'));

        // user or pass is empty back to login
        if($username == '' or $password == ''){           
            redirect('xpcms/login');
        }
        
        ///////
        if ($this->form_validation->run()) {
            $this->load->model('inhalt_model');
            
            $arr = array(
                'username' => $this->input->post('name'),
                // 密码经过md5加密处理
                // 可以在这里加密 也可以在上面加密
                'password' => $this->input->post('password'),
            );
            
            // 检测用户名和密码是否正确
            if ($this->inhalt_model->can_log_in('be_users', $arr)) {
                 //
                //$row = $this->inhalt_model->getValue('be_users', 'username', $arr['username']);
                $row = $this->inhalt_model->getAdmin('be_users', 'username', $arr['username']);
                $admin = $row[0]->admin;
                $newdata = array(
                    'username' => $this->input->post('name'),
                    'login_ip' => $_SERVER['REMOTE_ADDR'],
                    'logged_in' => TRUE,
                    'admin' => $admin
                );          
                // set session;
                $this->session->set_userdata($newdata);
                // write update last login user ip
                $data = array(
                    'lastlogin' => time(),
                    'login_ip' => $_SERVER['REMOTE_ADDR']
                );
                $this->inhalt_model->updateInhalt('be_users', 'uid' , $row[0]->uid , $data);
                redirect('xpcms/home');
                if ($row[0]->admin !== 1) {
                    // Destroy the current session
                    session_start();
                    $this->session->sess_destroy();
                    //session_destroy();
                    redirect('xpcms/login');
                }
                
            }else {
                redirect('xpcms/login');
            }
        }
    }

    /**
     * action logout
     * @return void
     */
    public function logout() {
        session_start();
        $this->session->sess_destroy();
        session_destroy();
        redirect('home', 'refresh');
    }

    /**
     * action add inhalt
     * @return void Description
     */
    public function admin() {
        $this->_reallyLogin();
        // make ckeditor
        $this->load->helper('ckeditor');
        //Ckeditor's configuration
        $data['ckeditor'] = array(
            //ID of the textarea that will be replaced
            'id' => 'content',
            'path' => 'js/ckeditor',
            //Optionnal values
            'config' => array(
                'toolbar' => "Full", //Using the Full toolbar
                'width' => "80%", //550pxSetting a custom width
                'height' => '100px', //Setting a custom height
            ),
            //Replacing styles from the "Styles tool"
            'styles' => array(
                //Creating a new style named "style 1"
                'style 1' => array(
                    'name' => 'Blue Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Blue',
                        'font-weight' => 'bold'
                    )
                ),
                //Creating a new style named "style 2"
                'style 2' => array(
                    'name' => 'Red Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Red',
                        'font-weight' => 'bold',
                        'text-decoration' => 'underline'
                    )
                )
            )
        );

        $data['ckeditor_1'] = array(
            //ID of the textarea that will be replaced
            'id' => 'content_1',
            'path' => 'js/ckeditor',
            //Optionnal values
            'config' => array(
                'width' => "80%", // 550pxSetting a custom width
                'height' => '50px', //Setting a custom height
                'toolbar' => array(//Setting a custom toolbar
                    array('Bold', 'Italic'),
                    array('Underline', 'Strike', 'FontSize'),
                    array('Smiley'),
                    '/'
                )
            ),
            //Replacing styles from the "Styles tool"
            'styles' => array(
                //Creating a new style named "style 1"
                'style 3' => array(
                    'name' => 'Green Title',
                    'element' => 'h3',
                    'styles' => array(
                        'color' => 'Green',
                        'font-weight' => 'bold'
                    )
                )
            )
        );

        $this->my_renderAll('./admin/admin_view', $data);
    }

    /**
     * action pages change the contents and change the tree
     * @return void Description
     */
    public function pages() {
        $this->_reallyLogin();
        // get page type, let user make page menu
        $standarts = $this->_getPageType('STANDART');
        $lists = $this->_getPageType('LISTS');
        $forms = $this->_getPageType('FORMS');
        $specials = $this->_getPageType('SPECIALS');
        $data['pagetype'] = array(
            'standarts' => $standarts,
            'lists' => $lists,
            'forms' => $forms,
            'specials' => $specials
        );
        // get the fe menus
        $data['feMenu'] = $this->inhalt_model->getMenu();        
        $treeData = reset($data['feMenu']);        
        $data['feMenu'] = @$treeData['children'];
        if($data['feMenu'] == '') {
           $data['feMenu'] = array();
        } 
        $this->load->helper('tree');
        $this->my_renderAll('./admin/pages_view', $data);
    }
    /**
     * action home add page, create page content
     * @return void Description
     */
    public function home() {
        $this->_reallyLogin();
         // get page type, let user make page menu
        $standarts = $this->_getPageType('STANDART');
        $lists = $this->_getPageType('LISTS');
        $forms = $this->_getPageType('FORMS');
        $specials = $this->_getPageType('SPECIALS');
        $data = array(
            'standarts' => $standarts,
            'lists' => $lists,
            'forms' => $forms,
            'specials' => $specials
        );
        $data['feMenu'] = $this->inhalt_model->getMenu();
        $treeData = reset($data['feMenu']);
        $data['feMenu'] = @$treeData['children'];
        if($data['feMenu'] == '') {
           $data['feMenu'] = array();
        } 
        $this->load->helper('tree');        
        $this->my_renderAll('./admin/home_view', $data);
    }
    /**
     * action files add image and show image
     * @return void Description
     */
    public function files() {
        $this->_reallyLogin();
        $this->load->model('file_model');
        $this->load->model('document_model');
        $data = array();
        if ($this->input->post('upload')) {
            $this->file_model->do_upload();
        }
        if ($this->input->post('upload_docu')) {
            $this->document_model->do_upload();
        }
	$data['documents'] = $this->document_model->get_documents();
	$data['images'] = $this->file_model->get_images();
        $this->my_renderAll('./admin/files_view', $data);
    }

    /**
     * action upload_icon_logo
     * @return void reurl to configuration
     */
    public function upload_icon_logo() {
        $this->_reallyLogin();
        $this->load->model('icon_logo_model');
        $data = array();
        if ($this->input->post('sub_icon')) {
            $file = 'icon';
            $this->icon_logo_model->set_icon($file);            
        }
        if ($this->input->post('sub_logo')) {
            $file = 'logo';
            $this->icon_logo_model->set_logo($file);            
        } 
       redirect('xpcms/configuration');
    }
    /**
     * action removeFile delete image
     * @return array Description
     */
    public function removeFile() {
        header('Content-type: text/javascript');
        $this->_reallyLogin();
        $this->load->model('file_model');
        $json = array(            
        );
        if(isset($_POST['title'])){
            $json['success'] = $this->file_model->do_delete($_POST['title']);
            $json['title'] = $_POST['title'];
            echo json_encode($json);
        }
    }
    public function removeDocument() {
        header('Content-type: text/javascript');
        $this->_reallyLogin();
        $this->load->model('document_model');
        $json = array(            
        );
        if(isset($_POST['title'])){
            $json['success'] = $this->document_model->do_delete($_POST['title']);
            $json['title'] = $_POST['title'];
            echo json_encode($json);
        }
    }

    /**
     * action template select template
     * @return void Description
     */
    public function template() {
        //header('Content-Type: application/json');
        $this->_reallyLogin();       
        $temparr = $this->inhalt_model->getValue('template','uid',1);

        $template = $temparr[0]->template;
        $header = $temparr[0]->header;        
        $content = $temparr[0]->content;
        $footer = $temparr[0]->footer;
        $sidebar = $temparr[0]->sidebar;
        $data = array(
            'template' => json_decode($template),
            'header' => json_decode($header),
            'content' => json_decode($content),
            'footer' => json_decode($footer),
            'sidebar' => json_decode($sidebar)
        );
        
        $this->my_renderAll('./admin/template_view', $data);
    }
    /**
     * action setTemplate
     * @return arry json Description
     */
    public function setTemplate() {
        header('Content-type: text/javascript');
        $this->_reallyLogin();        
        // get the default template
        $json = array();
        if(isset($_POST['template'])) {            
            $template = $_POST['template'];
        }
        if(isset($_POST['logo'])) {            
            $logo = $_POST['logo'];
        }else{
            $logo = 0;
        }
        if(isset($_POST['title'])) {            
            $title = $_POST['title'];
        }else{
            $title = 0;
        }       
        if(isset($_POST['hmenu'])) {            
            $hmenu = $_POST['hmenu'];
        }else{
            $hmenu = 0;
        }
        if(isset($_POST['hsearch'])) {            
            $hsearch = $_POST['hsearch'];
        }else{
            $hsearch = 0;
        }
        // header login
        if(isset($_POST['hlogin'])) {            
            $hlogin = $_POST['hlogin'];
        }else{
            $hlogin = 0;
        }
        // footer login
        if(isset($_POST['flogin'])) {            
            $flogin = $_POST['flogin'];
        }else{
            $flogin = 0;
        }
        
        if(isset($_POST['cmenu'])) {            
            $cmenu = $_POST['cmenu'];
        }else{
            $cmenu = 0;
        }
        if(isset($_POST['rootline'])) {            
            $rootline = $_POST['rootline'];
        }else{
            $rootline = 0;
        }
        if(isset($_POST['fmenu'])) {            
            $fmenu = $_POST['fmenu'];
        }else{
            $fmenu = 0;
        }
        if(isset($_POST['sbar'])) {            
            $sbar = $_POST['sbar'];
        }else{
            $sbar = 0;
        }
        if(isset($_POST['plugin'])) {            
            $plugin = $_POST['plugin'];
        }else{
            $plugin = 0;
        }
//update `template`       
        $data = array(
            'template' => '{"template" : '.$template.'}',
            'header'=> '{"logo" : '.$logo.',"title" : '.$title.',"hmenu" : '.$hmenu.',"search" : '.$hsearch.',"hlogin" : '.$hlogin.'}',
            'content'=> '{"cmenu" : '.$cmenu.',"rootline" : '.$rootline.'}',
            'footer'=>  '{"fmenu" : '.$fmenu.',"flogin" : '.$flogin.'}',
            'sidebar'=> '{"sidebar" : '.$sbar.',"plugin" : '.json_encode($plugin).'}',
            'last_update' =>time()
        );     
        //$fo = $this->inhalt_model->insertValue('template',$data);
        $fo = $this->inhalt_model->updateInhalt('template', 'uid', 1, $data);
        if($fo){
            $json['temp'] = $template;
            $json['success'] = TRUE;
            echo json_encode($json);
        }
    }
    /**
     * 
     * action configuration
     * @return void Description
     */
    public function configuration() {
        $this->_reallyLogin();
        $web_info_arr = $this->inhalt_model->getValue('web_info','uid',1);

        $data = array(
            'web_info' => $web_info_arr
        );
        $this->my_renderAll('./admin/configuration_view', $data);
    }
    /**
     * resetWebinfo
     */
    public function resetWebinfo() {
        $this->_reallyLogin();
        $web_title = $_POST['web_title'];
        $web_description = $_POST['web_description'];
        $web_copyright = $_POST['web_copyright'];
        $web_address = $_POST['web_address'];
        $json = array();
        $data = array(
            'web_title' => $web_title,
            'web_description' => $web_description,
            'web_copyright' => $web_copyright,
            'web_address' => $web_address,
            'last_update' => time()
        ); 
        $fo = $this->inhalt_model->updateInhalt('web_info', 'uid', 1, $data);
        if($fo){
            $json['success'] = TRUE;
        }
        echo json_encode($json);
    }
    /**
     * resetTheme
     */
    public function resetTheme() {
        $this->_reallyLogin();
        $json = array();
        $data = array(
            'body_color' => $_POST['body_color'],
            'header_color' => $_POST['header_color'],
            'content_color'=> $_POST['content_color'],
            'footer_color' => $_POST['footer_color'],
            'last_update' => time()
        );
        $fo = $this->inhalt_model->updateInhalt('web_info', 'uid', 1, $data);
        if($fo){
            $json['success'] = TRUE;
        }
        echo json_encode($json);
    }
    /**
     * resetGoogle
     */
    public function resetGoogle() {
        $this->_reallyLogin();
        $json = array();
        $data = array(
            'google_analitytis' => $_POST['google_analitytis'],
            'key_words' => $_POST['key_words'],
            'last_update' => time()
        );
        $fo = $this->inhalt_model->updateInhalt('web_info', 'uid', 1, $data);
        if($fo){
            $json['success'] = TRUE;
        }
        echo json_encode($json);
    }
    /**
     * resetSozial
     */
    public function resetSozial() {
        $this->_reallyLogin();
        $json = array();
        $data = array(
            'social_netzwork' => $_POST['social_netzwork'],
            'last_update' => time()
        );
        $fo = $this->inhalt_model->updateInhalt('web_info', 'uid', 1, $data);
        if($fo){
            $json['success'] = TRUE;
        }
        echo json_encode($json);
    }
    /**
     * action useradmin admin change password, add new user, send amil to another user
     * @return void Description
     */
    public function useradmin() {
        $this->_reallyLogin();
        $data = array(
            
        );
        //$this->load->controller('admin/admin/index',$data);
        $this->my_renderAll('./admin/useradmin_view', $data);
    }

    /**
     * action savemenu save data as new page
     *
     * @return string json
     */
    public function setMenu() {
        header('Content-type: text/javascript');
        $this->_reallyLogin();
        $json = array(
            'success' => FALSE,
            'msg' => 'can not save the page.'
        );
        $title = trim($_REQUEST['title']);
        $url = preg_match('/\s/', $title) ? preg_replace('/\s+/', '-', $title) : $title;        
        $url = preg_replace('/(ä)|(Ä)/', 'ae', $url);
        $url = preg_replace('/(ö)|(Ö)/', 'oe', $url);
        $url = preg_replace('/(ü)|(Ü)/', 'ue', $url);
        
        $now = time();
        // rgt where uid = 1
        $rgtrows = $this->inhalt_model->getValue('fe_pages', 'uid', 1);
        $n = intval($rgtrows[0]->rgt);
        $fe_pages = array(
            'uid' => NULL,
            'title' => $title,
            'keyword' => $title,
            'description' => $title,
            'author' => $this->session->userdata('username'),
            'author_email' => '',
            'subtitle' => '',
            'crdate' => $now,
            'starttime' => $now,
            'endtime' => 0,
            'hidden' => 0,
            'deleted' => 0,
            'last_updated' => 0,
            'nav_title' => '',
            'nav_hidden' => 0,
            'layout' => '',
            'sys_language' => '',
            'url' => $url ,
            'lft' => $n,
            'rgt' => $n +1
        );
        $uid = $this->inhalt_model->insertValue('fe_pages', $fe_pages);
        // update for uid = 1
        if($uid > 0) {
            $this->inhalt_model->updateInhalt('fe_pages','uid', 1, array('last_updated' => $now,'rgt' => $n +2));
            $json['success'] = TRUE;
            $json['msg'] = 'the page is saved.';
        }
        echo json_encode($json);
    }
    public function resetMenu() {
        header('Content-type: text/javascript');
        $this->_reallyLogin();
        $json = array(
            'success' => FALSE,
            'msg' => 'can not save the page.'
        );
        $title = trim($_REQUEST['pagetitle']);
        $url = preg_match('/\s/', $title) ? preg_replace('/\s+/', '-', $title) : $title;        
        $url = preg_replace('/(ä)|(Ä)/', 'ae', $url);
        $url = preg_replace('/(ö)|(Ö)/', 'oe', $url);
        $url = preg_replace('/(ü)|(Ü)/', 'ue', $url);
        
        $now = time();
        $uid = $_REQUEST['uid'];
        $data = array(
            'title' => $title,
            'keyword' => $title,
            'description' => $title,
            'last_updated' => $now,
            'url' => $url
        );
        //print_r($data);
        $this->inhalt_model->updateInhalt('fe_pages','uid', $uid, $data);
        $json['success'] = TRUE;
        $json['msg'] = 'the page is saved.';
        
        echo json_encode($json);
    }
    
        /**
     * action getMenu get frontend menu
     * @return string Description
     */
    public function getMenu() {
        $this->_reallyLogin();
        $menu = $this->inhalt_model->getMenu();
        $num = count($menu);
        
        for ($i = 0; $i < $num; $i++) {
            $titles[] = $menu[$i]['title'];
            $descriptions[] = $menu[$i]['description'];
            $urls[] = $menu[$i]['url'];
            echo '<li class="list" rel="' . $urls[$i] . '" title="' . $descriptions[$i] . '">' . $titles[$i] .
            '<span class="delete">X</span></li>' . PHP_EOL;
        }
// TEST script        
        echo '<script>
(function($){
$(".list").click(function(){
    var rel = $(this).attr("rel");
    alert(rel);
});
})(jQuery);            
</script>';
    }
    /**
     * action hiddenMenu deleted the select menu
     * @return string info for admin
     */
    public function hiddenMenu() {
        header('Content-type: text/javascript');
        $this->_reallyLogin();

        $uid = $_POST['uid'];
        $json = array();

        // get fe_pages.rgt and fe_pages.lft
        $delrows = $this->inhalt_model->getValue('fe_pages', 'uid', $uid);
        $rgt = intval($delrows[0]->rgt);
        $lft = intval($delrows[0]->lft);        
        // if rgt - lft = 1 delete || delete where rgt - lft = 1 and uid = $uid 
        if(($rgt - $lft) == 1) {            
            $now = time();
            
            $this->inhalt_model->updateColumn('fe_pages', ' lft < '.$rgt.' AND rgt > '.$rgt ,' rgt = rgt - 2, last_updated = '.$now.' ');
            $this->inhalt_model->updateColumn('fe_pages', ' lft > '.$rgt.' AND rgt > '.$rgt ,' rgt = rgt - 2, lft = lft - 2, last_updated = '.$now.' ');
            //$this->inhalt_model->updateColumn('fe_pages', 'uid = '.$uid ,' deleted = 1, lft = 0, rgt = 0 , last_updated = '.$now .' ');
            // delete
            $this->inhalt_model->deleteValue('fe_pages', 'uid', $uid );
            
            $json['success'] = TRUE;
            $json['msg'] = 'the page is deleted.';
        } else {
            $json['success'] = FALSE;
            $json['msg'] = 'the page can not delete.';
        }
        
        echo json_encode($json);
    }

    /**
     * action setContent
     * @return srting
     */
    public function setContent() {
        $this->_reallyLogin();
        
        $now = time();
        $getBegin = new dateTime($_REQUEST['begin']);
        $begin = empty($_REQUEST['begin']) ? $now : $getBegin->getTimestamp();        
        $getEnd = new dateTime($_REQUEST['end']);        
        $end = empty($_REQUEST['end']) ? 0 : $getEnd->getTimestamp();
        
        if(isset($_REQUEST['pos'])) {
            $pos = $_REQUEST['pos'];
        } else {
            $pos = 0;
        }
        $content_type = $_REQUEST['content_type'];
        
        $image = '';
        $imageWidth =  0;
        $imageHeight = 0;
        $fileLink = '';
        $content = '';

        // make slider
        if($content_type == '7') {
            //$pics = $_REQUEST['pics'];
            $width = $_REQUEST['width'];
            $height = $_REQUEST['height'];
            $sliders = $_REQUEST['content'];
            $imageWidth =  $width;
            $imageHeight = $height;
            $content = '<div class="flexslider" style="width:'.$width.'px; height:'.$height.'px;"><ul class="slides lightbox_content">';
            $images = array();
            $images = explode(',', $sliders);
            $num = count($images);
            unset($images[$num-1]);
            for($i = 0; $i < $num-1; $i ++) {
                $content .= '<li class="lightbox item">
                    <img src="'.$images[$i].'" title="'.$images[$i].'" alt="'.$images[$i].'" />
                        </li>';
            }
            $content .= '</ul></div>';
            $fileLink = $sliders;
        }
        // make search
        if($content_type == '6') {
$searchForm = <<<SEARCHFORM
<div class="page-search-form">
    <form method="get" id="search-page" role="form">
        <div class="form-group">
            <input type="text" name="s" value="" id="s-val" class="form-control" />
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="search" id="s-page-sub" class="btn btn-default" />
        </div>
    </form> 
</div>
<div id="p-s-rst"></div>
<script>
(function($){    
    // search
    $('#s-page-sub').click(function(){
        var contents = $('#search-page').serialize();
        $.post('search/get_result', contents, function(data){
            if(data.success) {
                if(data.result != '') {
                    $('#p-s-rst').html(data.result);
                }              
            }
        },'json');
        return false;
    });
})(jQuery);
</script>
SEARCHFORM;
            $content = $searchForm;
        }
        // create login
        if($content_type == '5') {
$loginform = <<<LOGINFORM
<div class="login-form">
    <form action="login/check_login" method="post" id="login" role="form">
        <div class="formlist form-group">
            <label for="user">user: </label>
            <input type="text" name="user" value="" id="user" class="form-control"/>
        </div>
        <div class="formlist form-group">
            <label for="password">password: </label>
            <input type="password" name="password" value="" id="user_pass" class="form-control"/>
        </div>
        <div class="formlist form-group">
            <label for="submit">&nbsp;</label>
            <input type="submit" name="submit" value="login" id="user_login" class="btn btn-default"/>
        </div>
    </form>
</div>
<div class="login/registry"><a href="registry">registry</a></div>
<script>
(function($){
    $('#user_login').click(function(){
        var contents = $('#login').serialize();
        $.post('login/get_login', contents, function(data){
            if(data.success) {
                $('.situation').html(data.result);                              
            }
        },'json');    
        return false;
    });
})(jQuery);
</script>
<div class="login-situation">    
    <div class="situation">       
    </div>
</div>
LOGINFORM;
    $content = $loginform;
        }
        // create form
        if($content_type == '4') {
            $forms = <<<CONTACT
<div class="contact">
    <form action="contact" method="post" role="form">
        <fieldset>           
            <legend>Contact Form</legend>
            <div class="formlist form-group">
                <label for="name">Name: </label>
                <input type="text" name="name" class="c_name form-control" placeholder="name"/>
            </div>
            <div class="formlist form-group">
               <label for="email">Email: </label>
               <input type="email" name="email" class="c_email form-control" placeholder="email"/>     
           </div>
            <div class="formlist form-group">
                <label for="subject">Subject: </label>
                <input type="text" name="subject" class="c_subject form-control" placeholder="subject"/>         
            </div>
            <div class="formlist form-group">
                <label for="message">Subject: </label>
                <textarea class="c_message form-control" rows="10" cols="40" name="message"></textarea>
            </div>
            <div class="formlist form-group">
                <label for="send">&nbsp; </label>
               <input type="submit" name="send" value="send" class="c_send btn btn-default"/>
            </div>  
        </fieldset>
    </form>   
</div>
<script>
    (function($){
        $('.c_send').click(function(){
            var contents = $()..serialize();
            $.post('contact',contents,function(data){
                if(data.success){
                    //alert(data.thanks);
                }
            },'json');
            return false;
        });
    })(jQuery);
</script>
CONTACT;
            $content = $forms;
        }
        // create file links
        if($content_type == '3') {
            $docu_title = $_REQUEST['docu_title'];
            $docu_link = $_REQUEST['docu_link'];
            $titles = array();
            $titles = explode(',', $docu_title);
            $num = count($titles);
            $links = array();
            $links = explode(',', $docu_link);
            unset($titles[$num-1]);
            unset($links[$num-1]);
            $content = '<ul class="file_link">';
            for($i = 0; $i < $num-1; $i ++) {
                $content .= '<li><a class="file_contnet item" href="'.$links[$i].'" target="_blank">'.$titles[$i].'</a></li>';
            }
            $content .= '</ul>';
            $fileLink = $docu_link;            
        }
        // create image
        if($content_type == '2') {
            $image = $_REQUEST['pic'];
            $imageWidth = $_REQUEST['width'];
            $imageHeight = $_REQUEST['height'];
            $fileLink = $image;
        }
        // text content
        if($content_type == '1') {
            $content = $_REQUEST['content'];
        }
        
        $contents = array(
            'uid' => NULL,
            'body_text' => $content,
            'col_pos' => $pos,
            'header' => $_REQUEST['title'],
            'tstamp' => $now,
            'starttime' => $begin,
            'endtime'  => $end,
            'lastupdated' => 0,
            'display' => 1,
            'deleted' => 0,
            'content_type' => $content_type, 
            'image' => $image,
            'image_width' => $imageWidth,
            'image_height' => $imageHeight,
            'file_link' => $fileLink,
            'pid' => $_REQUEST['pageid']
        );
         
        $id = $this->inhalt_model->insertValue('content', $contents);
        //echo 'insert page is ok';
        $json = array(
            'success' => FALSE
        );
        if($id){
            $json['success'] = TRUE;
            $json['image'] = $image;
        }
        echo json_encode($json);
    }
    /**
     * action resetContent
     */
    public function resetContent() {
        $this->_reallyLogin();
        
        $json = array(
            'success' => FALSE
        );
        $now            = time();
        $uid            = $_REQUEST['uid'];
        
        if(isset($_REQUEST['starttime'])) {
            $getBegin = new dateTime($_REQUEST['starttime']);
            $begin    = $getBegin->getTimestamp();
        } else {
            $begin = $now ;
        }
        
        if(isset($_REQUEST['endtime']) && $_REQUEST['endtime'] != 0) {
            $getEnd = new dateTime($_REQUEST['endtime']);
            $end    = $getEnd->getTimestamp();
        } else {
            $end = 0;
        }
        
        if(isset($_REQUEST['pos'])) {
            $pos = $_REQUEST['pos'];
        } else {
            $pos = 0;
        }
        
        $lastupdate     = $now;
        if(isset($_REQUEST['deleted'])) {
            $deleted        = $_REQUEST['deleted'];
        } else {
            $deleted        = 0;
        }
            
        if(isset($_REQUEST['display'])) {
            $display        = $_REQUEST['display'];
        } else {
            $display        = 1;
        }
            
        $title = $_REQUEST['title'];
        
        // delete the content
        if($deleted) {
            $this->inhalt_model->deleteValue('content', 'uid', $uid);
        }
        
        if(isset($_REQUEST['ck_content'])) {
            $ck_content = $_REQUEST['ck_content'];
            $content = $ck_content;
        } else {
            $content = $_REQUEST['content'];
        } 
        
        if(isset($_REQUEST['pic'])){
            $image = $_REQUEST['pic'];
        }else {
            $image = '';
        }
        if(isset($_REQUEST['width'])){
            $width = $_REQUEST['width'];
        }else {
            $width = 0;
        }
        if(isset($_REQUEST['height'])){
            $height= $_REQUEST['height'];
        }else {
            $height= 0;
        }
        if(isset($_REQUEST['link'])){
            $link = $_REQUEST['link'];
        }else {
            $link = '';
        }
        
        if(isset($_REQUEST['content_type'])){
            $content_type = $_REQUEST['content_type'];
        }else {
            $content_type = '1';
        }
        // slider
        if($content_type == '7') {
            $sliders = trim($_REQUEST['content']);
            $content = '<div class="flexslider" style="width:'.$width.'px; height:'.$height.'px;"><ul class="slides lightbox_content">';
            $images = array();
            $images = explode(',', $sliders);
            $num = count($images);
            unset($images[$num-1]);
            for($i = 0; $i < $num-1; $i ++) {
                $content .= '<li class="lightbox item">
                    <img src="'.$images[$i].'" title="'.$images[$i].'" alt="'.$images[$i].'" />
                        </li>';
            }
            $content .= '</ul></div>';
            $link = $sliders;
        }
        // file links
        if($content_type == '3') {            
            $link = trim($_REQUEST['content']);
            $links = explode(',',$link);
            $num = count($links);
            unset($links[$num-1]);
            $titles = array();
            
            $content = '<ul class="file_link">';            
            for($i = 0; $i < $num -1 ; $i ++) {
                // get file info
                //$fileinfos = $this->$this->inhalt_model->getValue('files','file_name',str_replace(base_url().'public_html/files/','',$links[$i]));
                $file_name = str_replace(base_url().'public_html/files/','',$links[$i]);
                $content .= '<li><a class="file_contnet item" href="'.$links[$i].'" target="_blank">'.$file_name.'</span></a></li>';
            }
            $content .= '</ul>';
        }
        $data = array(
            'body_text' => $content,
            'col_pos' => $pos,
            'header' => $title,
            'starttime' => $begin,
            'endtime'  => $end,
            'lastupdated' => $lastupdate,
            'display' => $display,
            'deleted' => $deleted,
            'content_type' => $content_type,
            'image' => $image,
            'image_width' => $width,
            'image_height' => $height,
            'file_link' => $link
        );
        $fo = $this->inhalt_model->updateInhalt('content', 'uid', $uid, $data);
        if($fo) {
            $json = array(
                'success' => TRUE
            );
        }
        echo json_encode($json);
    }

    /**
     * action _reallyLogin
     */
    private function _reallyLogin() {
        if (!$this->session->userdata('logged_in')) {
            redirect('xpcms/login', 'refresh');
        }
    }

    /**
     * action _getPageType
     * @param string $label
     * @return array
     */
    private function _getPageType($label) {
        $standart = $this->inhalt_model->getValue('page_type', 'label', $label);
//        die(print_r($standart));
        $page_type = array();
        $num = count($standart);
        for ($i = 0; $i < $num; $i++) {
            $standarts['name'][] = $standart[$i]->name;
            $standarts['type'][] = $standart[$i]->type;
            $standarts['description'][] = $standart[$i]->description;
            $standarts['sys_lanage'][] = $standart[$i]->sys_lanage;
        }
        return $standarts;
    }

    /**
     * testing fileUpload
     */
    public function fileUpload() {
        header('Content-type: text/javascript');
        $status = '';
        $msg = '';
        $file_element_name = 'userfile';

        if ($status != "error") {
            $config['upload_path'] = './public_html/xp/xp_cms/images';
            $config['allowed_types'] = 'gif|jpg|png|doc|txt|pdf';
            $config['max_size'] = 1024 * 20;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
                $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
                if ($file_id) {
                    $status = "success";
                    $msg = "File successfully uploaded";
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }
            }
            @unlink($_FILES[$file_element_name]);
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    /**
     *
     * @param string $str sql injection
     * @return string 
     */
    private function _sqlFilter($str) {
        $sql = '/(select)|(insert)|(update)|(delete)|(\')|(\/\*)|(\*)|(\.\.\/)|(\.\/)|(union)|(into)|(load_file)|(outfile)/i';
        $check = preg_match($sql, $str);
        return $check ? preg_replace($sql, "-$1$2$3$4$5$6$7$8$9$10$11$12$13~", $str) : $str;
    }
    /**
     * reset_home
     */
    public function reset_home () {
        $this->_reallyLogin();
        // editor
        $this->load->helper('ckeditor');
        $rows = $this->inhalt_model->getValue('content','uid' ,1);
        $temparr = $this->inhalt_model->getValue('template','uid',1);
        $template = $temparr[0]->template;
        $data = array(
            'header' => $rows[0]->header,
            'body_text' => $rows[0]->body_text,
            'col_pos' => $rows[0]->col_pos,
            'template' => json_decode($template)
            
        );
        $this->load->view('reset_home_view',$data);
    }

}

/* End of file xpcms.php */
