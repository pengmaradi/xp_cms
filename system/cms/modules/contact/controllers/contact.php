<?php


/**
 * Description of contact
 *
 * @author Xiaoling
 */
class Contact extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->model('contact_model');
        $json = array(
            'success' => FALSE
        );
        
        if(isset($_REQUEST['email'])) {
            $email = $_REQUEST['email'];
            $name = $_REQUEST['name'];
            $subject = $_REQUEST['subject'];
            $message = $_REQUEST['message'];
            
            /* local send mail with gmail test ok! */
            /***
            $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'pengmaradi@gmail.com',
                    'smtp_pass' => 'password=your pass',
                );
            $this->load->library('email', $config);
           //*/ 
            
            $this->load->library('email');
            $this->email->set_newline("\r\n");
            
            $adminmail = $this->contact_model->getAdminmail();
            $json['thanks'] = 'send mail to: '.$adminmail[0]->email.' ';
            $mailto = $adminmail[0]->email;

            $this->email->from($email, $name);
            $this->email->to($mailto);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();
            
            $json['success'] = TRUE;
            $json['thanks'] .= 'Thank you! the email is sended.';
            //$this->email->print_debugger();
        } 
        echo json_encode($json);
        if($json['success']) {
            redirect('home');
        }
    }
}

?>
