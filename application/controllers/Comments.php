<?php
class Comments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('messages_model');
        $this->load->model('tools_model');
        $this->load->model('comments_model');
        $this->load->helper('url');
        $this->load->helper('captcha');
        $this->load->helper('html');
    }
    
    public function write_comment()
    {
        $this->comments_model->set_comment( $this->input->post('id') );
        
        $data['title'] = 'asd';
        // prikazi stranicu o uspesnom upisu komentara
        $this->load->view('templates/header', $data);
        //$this->load->view('templates/menu', $data);
        $this->load->view('templates/success_comment');
        $this->load->view('templates/footer');        
    }
}