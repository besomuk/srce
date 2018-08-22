<?php
class Pages extends CI_Controller 
{
    private $tops;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->model('tools_model');
                
        // pokupi najporuke
        $this->tops['top_newest']        = $this->tools_model->get_top_5(1);
        $this->tops['top_most_read']     = $this->tools_model->get_top_5(2);
        $this->tops['top_most_comments'] = $this->tools_model->get_top_5(3);
    }
    
    public function view ( $page = 'home' )
    {
        $this->load->helper('url');
        
        if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
        {
                show_404();
        }
        
        $data['title'] = "Naslov";
        
        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);        
    }
    
    public function sta_je_to()                
    {
        // uzmi top poruke za razlicite kategorije         
        $data['title'] = "Šta je to Reci Srce?";
        $this->load->view('templates/header', $data);
        $this->load->view('pages/sta_je', $data);
        $this->load->view('templates/sidebar', $this->tops);     
        $this->load->view('templates/footer', $data);     
    }
    
    public function pravila()
    {
        $data['title'] = "Pravila korišćenja";
        $this->load->view('templates/header', $data);
        $this->load->view('pages/pravila', $data);
        $this->load->view('templates/sidebar', $this->tops);     
        $this->load->view('templates/footer', $data);     
    }    
    
    public function o_nama()
    {
        $data['title'] = "O nama";
        $this->load->view('templates/header', $data);
        $this->load->view('pages/o_nama', $data);
        $this->load->view('templates/sidebar', $this->tops);     
        $this->load->view('templates/footer', $data);     
    }
    
    public function uslovi()
    {
        $data['title'] = "Uslovi korišćenja";
        $this->load->view('templates/header', $data);
        $this->load->view('pages/uslovi', $data);
        $this->load->view('templates/sidebar', $this->tops);     
        $this->load->view('templates/footer', $data);     
    }
    
    public function faq()
    {
        $data['title'] = "FAQ";
        $this->load->view('templates/header', $data);
        $this->load->view('pages/faq', $data);
        $this->load->view('templates/sidebar', $this->tops);     
        $this->load->view('templates/footer', $data);     
    }
    
    public function kontakt()
    {
        $data['title'] = "Kontakt";
        $this->load->view('templates/header', $data);
        $this->load->view('pages/kontakt', $data);
        $this->load->view('templates/sidebar', $this->tops);     
        $this->load->view('templates/footer', $data);     
    }
}