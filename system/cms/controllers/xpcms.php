<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
            $this->my_renderAll('admin/login_view', $data);
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
        //                              input框name, 报错文字，必填项|去首位空格|清除代码|md5加密
        $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clear|md5');
//        is_unique[user.name] 是否与数据表user中的name重复
//        $this->form_validation->set_message('is_unique','%s is invalid');

        if ($this->form_validation->run()) {
            $this->load->model('inhalt_model');
            // 检测用户名和密码是否正确
            $arr = array(
                'username' => $this->input->post('name'),
                // 密码经过md5加密处理
                // 可以在这里加密 也可以在上面加密
                'password' => $this->input->post('password'),
            );
            if ($this->inhalt_model->can_log_in('be_users', $arr)) {
                // set session;
                $row = $this->inhalt_model->getValue('be_users', 'username', $arr['username']);
                $admin = $row[0]->admin;
                $newdata = array(
                    'username' => $this->input->post('name'),
                    'login_ip' => $_SERVER['REMOTE_ADDR'],
                    'logged_in' => TRUE,
                    'admin' => $admin
                );
                $this->session->set_userdata($newdata);

                if ($row[0]->admin === 1) {
                    redirect('xpcms/home');
                }
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
     */
    public function admin() {
        $this->reallyLogin();
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

        $this->my_renderAll('admin/admin_view', $data);
    }

    /**
     * action pages create website tree
     */
    public function pages() {
        $this->reallyLogin();
        // get page type, let user make page menu
        $standarts = $this->getPageType('STANDART');
        $lists = $this->getPageType('LISTS');
        $forms = $this->getPageType('FORMS');
        $specials = $this->getPageType('SPECIALS');
        $menuarray = array(
            'standarts' => $standarts,
            'lists' => $lists,
            'forms' => $forms,
            'specials' => $specials
        );
        // get the fe menus
        $menu = $this->inhalt_model->getMenu();
        // $menuarray = array_push();
        $menuarray['feMenu'] = $menu;
        $this->my_renderAll('admin/pages_view', $menuarray);
    }

    public function home() {
        
         // get page type, let user make page menu
        $standarts = $this->getPageType('STANDART');
        $lists = $this->getPageType('LISTS');
        $forms = $this->getPageType('FORMS');
        $specials = $this->getPageType('SPECIALS');
        $data = array(
            'standarts' => $standarts,
            'lists' => $lists,
            'forms' => $forms,
            'specials' => $specials
        );
        $data['feMenu'] = $this->inhalt_model->getMenu();
        
        $this->my_renderAll('admin/home_view', $data);
    }

    public function files() {
        $this->reallyLogin();
        $data = array(
            'test' => 'abc',
            'test2' => '1234'
        );
        $this->my_renderAll('admin/files_view', $data);
    }

    public function template() {
        $this->reallyLogin();
        $data = array(
            'test' => 'abc',
            'test2' => '1234'
        );
        $this->my_renderAll('admin/template_view', $data);
    }

    public function configuration() {
        $this->reallyLogin();
        $data = array(
            'test' => 'abc',
            'test2' => '1234'
        );
        $this->my_renderAll('admin/configuration_view', $data);
    }

    public function useradmin() {
        $this->reallyLogin();
        $data = array(
            'test' => 'abc',
            'test2' => '1234'
        );
        $this->my_renderAll('admin/useradmin_view', $data);
    }

    /**
     * action savemenu get data from ajax
     *
     * @return void
     */
    public function setMenu() {
        $this->reallyLogin();
        $url = preg_match('/\s/', trim($_REQUEST['title'])) ? preg_replace('/\s+/', '-', $_REQUEST['title']) : $_REQUEST['title'];
        $now = time();
        $fe_pages = array(
            'uid' => NULL,
            'title' => $_REQUEST['title'],
            'keyword' => $_REQUEST['title'],
            'description' => $_REQUEST['title'],
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
            'url' => $url
        );
        $this->inhalt_model->insertValue('fe_pages', $fe_pages);
        $this->getMenu();
        $content = array(
            'uid' => NULL,
            'body_text' => '',
            'col_pos' => 0,
            'header' => '',
            'pages' => $url,
            'tstamp' => $now,
            'starttime' => $now,
            'endtime' => 0,
            'lastupdated' => 0,
            'display' => 1,
            'deleted' => 0,
            'content_type' => $_REQUEST['content_type'],
            'image' => '',
            'image_width' => 0,
            'image_height' => 0,
            'image_link' => ''
        );
        $this->inhalt_model->insertValue('content', $content);
    }

    public function getMenu() {
        $menu = $this->inhalt_model->getMenu();
        $num = count($menu);
        for ($i = 0; $i < $num; $i++) {
            $titles[] = $menu[$i]['title'];
            $descriptions[] = $menu[$i]['description'];
            $urls[] = $menu[$i]['url'];
            echo '<li class="list" rel="' . $urls[$i] . '" title="' . $descriptions[$i] . '">' . $titles[$i] .
            '<span class="delete">X</span></li>' . PHP_EOL;
        }
    }

    /**
     * action reallyLogin
     */
    private function reallyLogin() {
        if (!$this->session->userdata('logged_in')) {
            redirect('xpcms/login', 'refresh');
        }
    }

    /**
     * action getPageType
     * @param string $label
     * @return array
     */
    private function getPageType($label) {
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
     * 
     */
    public function fileUpload() {
        $status = '';
        $msg = '';
        $file_element_name = 'userfile';
        if (empty($_POST['title'])) {
            $status = "error";
            $msg = "Please enter a title";
        }

        if ($status != "error") {
            $config['upload_path'] = './public_html/xp/xp_cms/images';
            $config['allowed_types'] = 'gif|jpg|png|doc|txt|pdf';
            $config['max_size'] = 1024 * 8;
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

}

/* End of file xpcms.php */
/* Location: ./application/controllers/xpcms.php */