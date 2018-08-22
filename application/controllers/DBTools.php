<?php
class DBTools extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('messages_model');
        $this->load->model('comments_model');
        $this->load->model('admin_model');
        $this->load->model('autologin_model');
        $this->load->model('dbtools_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');     
        $this->load->dbutil();
        
        // da li smo ulogovani?
        $this->is_logged_in(); 
    }    
    
    public function backup_db ()
    {
        $this->dbtools_model->backup_db ();
    }
    
    public function backup_table ()
    {
        $this->dbtools_model->backup_table ();
    }    
    
    private function is_logged_in ()
    {
        if ( $this->auth->loggedin() != 1 )
        {
            redirect ('/admin');
        }                
    }    
}