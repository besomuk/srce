<?php
class Tools extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('messages_model');
        //$this->load->model('comments_model');
        //$this->load->model('admin_model');
        //$this->load->model('autologin_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function smail ( $from, $to, $subject, $msg )
    {
        $this->load->library('email');

        $this->email->from($from)
                    ->reply_to("office@iqpixel.com")
                    ->to($to)
                    ->subject($subject)
                    ->message( $this->load->view('templates/mail_template_01', null, true) )
                    ->set_mailtype('html');
        //$this->email->print_debugger();
        $this->email->send();
    }    
}
