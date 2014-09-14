<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    private $adminarr = array();
    private $userarr = array();
    private static $be_users = 'be_users';
    /**
     * action __construct 
     * @return void Description
     */
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('xpcms/index');
        $this->load->model('xpcms/inhalt_model');
        $this->load->model('admin_model');
        //$this->adminarr = $this->inhalt_model->getValue(self::$be_users ,'username', $this->session->userdata('username'));
        $this->adminarr = $this->admin_model->get_value('username', $this->session->userdata('username'));
        //$this->userarr = $this->inhalt_model->getValue(self::$be_users , 'username !=', $this->session->userdata('username')); //'deleted', 0
        $this->userarr = $this->admin_model->get_value('username !=', $this->session->userdata('username'));
    }
    /**
     * action index view change password 
     * @return void
     */
    public function index() {
        $data = array();
        $data['adminarr'] = $this->adminarr[0];
        $this->load->view('changepass_view',$data);
    }
    /**
     * action add user
     * @return void
     */
    public function add() {
        $data = array();
        $data['options'] = array(
            '0' => 'select one',
            '1' => 'administrator',
            '2' => 'normal user'
        );
        $this->load->view('adduser_view', $data);
    }
    /**
     * action contact
     * @return void
     */
    public function contact() {
        $data = array();
        $data['userarr'] = $this->userarr;        
        $this->load->view('contact_view',$data);
    }
    /**
     * action administration
     * @return void Description
     */
    public function administration() {
        $data = array();
        $data['options'] = array(
            '0' => 'select one',
            '1' => 'administrator',
            '2' => 'normal user'
        );
        $data['userarr'] = $this->userarr;
        $this->load->view('administration_view',$data);
    }
    /**
     * action checkUserName
     * @return array json
     */
    public function checkUserName() {
        $this->load->model('admin_model');
        if(isset($_POST['user'])) {
            $user = $_POST['user'];
        }
        $foo = $this->admin_model->can_create_user($user);
        $json = array();
        $json['success'] = FALSE;
        if($foo) {
            $json['success'] = TRUE;
        }
        echo json_encode($json);
    }
    /**
     * action setUser
     * @return array Description
     */
    public function setUser(){
        $this->load->model('admin_model');
        $now = time();
        if( $_POST['identity'] != 0 && trim($_POST['add_user']) != '' && trim($_POST['add_email']) != '') {
            $getBegin = new dateTime($_POST['add_begin']);
            $begin = empty($_POST['add_begin']) ? $now : $getBegin->getTimestamp();
            $getEnd = new dateTime($_POST['add_end']);
            $end = empty($_POST['add_end']) ? 0 : $getEnd->getTimestamp();
            $data = array(
                'uid'       =>  NULL,
                'username'  =>  $_POST['add_user'],
                'password'  =>  md5($_POST['add_password']),
                'tstamp'    =>  $now,
                'admin'     =>  $_POST['identity'],
                'starttime' =>  $begin,
                'endtime'   =>  $end,
                'language'  =>  '',
                'deleted'   =>  0,
                'lastlogin' =>  0,
                'usergroup' =>  '',
                'realname'  =>  $_POST['add_name'],
                'email'     =>  $_POST['add_email'],
                'login_ip'  =>  ''
            );           
        }
        $foo = $this->admin_model->set_user($data);
        $json = array();
        $json['success'] = FALSE;
        if($foo) {
            $json['success'] = TRUE;
        }
        echo json_encode($json);
    }
    /**
     * action resetUser
     * @return array json
     */
    public function resetUser() {
        $this->load->model('admin_model');     
        
        $json = array(
            'success' => FALSE
        );
        // reset other user
        if(isset($_POST['change_uid'])){
            $uid = $_POST['change_uid'];
            if(isset($_POST['change_password'])) {
                $pass = md5(trim($_POST['change_password']));
            }else {
                $pass = $_POST['old_password'];
            }
            if(isset($_POST['change_deleted'])) {
                $deleted = $_POST['change_deleted'];
            }else{
                $deleted = 0;
            }
            $getBegin = new dateTime($_POST['change_start']);
            $begin = $getBegin->getTimestamp();
            $getEnd = new dateTime($_POST['change_end']);
            $end = $getEnd->getTimestamp();
            $data = array(
                'username'  =>  $_POST['change_username'],
                'password'  =>  $pass,
                'admin'     =>  $_POST['change_admin'],
                'starttime' =>  $begin,
                'endtime'   =>  $end,
                'deleted'   =>  $deleted,
                'realname'  =>  $_POST['change_realname'],
                'email'     =>  $_POST['change_eamil']        
            );
        }
        // reset admin
        if(isset($_POST['ch_uid'])) {
            $uid = $_POST['ch_uid'];
            $data = array(
                'username'  =>  $_POST['ch_user'],
                'password'  =>  md5($_POST['ch_password']),
                'realname'  =>  $_POST['ch_realname'],
                'email'     =>  $_POST['ch_email']        
            );            
        }
       $foo =  $this->admin_model->reset_user($uid,$data);
       
       if($foo){
           $json['success'] = TRUE;
       }
       echo json_encode($json);
    }
    /**
     * action sendMail
     * @return array json
     */
    public function sendMail() {
        /* local send mail with gmail test ok!
        $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'yourname@gmail.com',
                'smtp_pass' => 'password',
            );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
       */ 
        
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $userarr = array();
        $userarr = $this->userarr;
        $num = count($userarr);
        $options = array(0 => 'Select a contact');
        $emailarr = array();
        $emailstr = '';
        for ($i = 0; $i < $num; $i++) {
            array_push($options, $userarr[$i]->email);
        }
        $json = array(
            'usersel' => 0
        );
        $json['msg'] = '';
        if(isset($_POST['usersel'])){
            $mailfrom = $this->adminarr[0]->email;
            $mailto = $options[$_POST['usersel']];
            $sender = $this->adminarr[0]->realname;
            
            $this->email->from($mailfrom, $sender);
            $this->email->to($mailto);
            $this->email->subject($_POST['subject']);
            $this->email->message($_POST['message']);
            $this->email->send();

            $json['msg'] .= $this->email->print_debugger();
        }
        echo json_encode($json);
        // usersel=1&subject=a&message=b
    }
    /**
     * action sorting
     * @return void Description
     */
    public function sorting() {
        // sortable menu testing        
        $this->load->model('xpcms/inhalt_model');
        $data['menus'] = $this->inhalt_model->getMenu();
        $data['num'] = count($data['menus']);
        $this->load->view('admin_view_test',$data);
    }

}

/* End of file admin.php */
/* Location: ./cms/modules/admin/admin.php */