<?php
class Admin extends CI_Controller 
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
              
    }
    
    /* glavna strana */
    public function index ()
    {                
        $data['title'] = "Admin Login";   

        /* ako smo ulogovani, prebaci nas na prikaz radne povrsine za administratora */
        
        if ( $this->auth->loggedin() == 1 )
        {
            $this->dashboard ();
            
            return 0;
        }
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');        
        
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('admin/headerOUT', $data);
            $this->load->view('admin/index', $data);
            $this->load->view('admin/footerOUT', $data);
        }
        else
        {
            $result = $this->admin_model->validate_login();
            if ( $result == 0 )
            {
                echo "Ne valja login";
            }
            else
            {
                $username = $this->input->post('username') . "<br>";
                $this->auth->login($username, $remember = TRUE);
                redirect ('/admin');
            }
        }        
    }
    
    public function dashboard ()
    {
        $this->is_logged_in();        
        
        $data['username'] = $this->auth->userid();
        $data['title'] = 'Admin Panel';
        // prikazi ostatak stranice
        //$data['username'] = "ASD";
        
        /* ----- PODACI O BAZI, PORUKAMA ITD ------------------------------------------------------------------------------------------------------- */
        $data['count_sve'] = $this->messages_model->count_messages ( 99 );       // uzmi broj svih poruka iz baze
        $data['count_odo'] = $this->messages_model->count_messages ( 1 );        // uzmi broj odobrenih poruka iz baze
        $data['count_neodo'] = $this->messages_model->count_messages ( 0 );      // uzmi broj neodobrenih poruka iz baze
        $data['count_arh'] = $this->messages_model->count_messages ( 2 );        // uzmi broj arhiviranih poruka
        
        $data['db_platform'] = $this->db->platform();                        // uzmi platformu na kojoj je baza
        $data['db_version'] = $this->db->version();                          // uzmi verziju
        $data['db_size'] = round ( $this->dbtools_model->db_size(), 2 );     // uzmi velicinu baze i zaokruzi na 2 decimale, velicina je u MB
                
        /* ----- PUSTI SVE NA EKRAN ------------- */
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/dash', $data);
        $this->load->view('admin/footer', $data);
    }
    
    /* prikaz poruka, glavna stranica administratorskog panela                                         */
    /* ukoliko je parametar prazan, id-u dajem vrednost 99 koji oznacava da treba prikazati sve poruke */    
    public function show_messages ( $z = 99 )
    {
        $this->is_logged_in();
        
        $data['messages'] = $this->messages_model->get_messages($z); // uzmi poruke iz baze
        $data['count'] = count($data['messages']);                   // izbroj poruke                
        
        // na osnovu parametra, napisi naslov stranice, da se zna sta gledamo
        if ( $z == 0 )
        {
            $data['title'] = 'Admin Panel - NEODOBRENE PORUKE';
            $data['title2'] = 'NEODOBRENE PORUKE';
        }        
        if ( $z == 1 )
        {
            $data['title'] = 'Admin Panel - ODOBRENE PORUKE';
            $data['title2'] = 'ODOBRENE PORUKE';
        }
            
        if ( $z == 99 )
        {
            $data['title'] = 'Admin Panel - SVE PORUKE';        
            $data['title2'] = 'SVE PORUKE';        
        }
        
        $data['username'] = $this->auth->userid();
        
        // prikazi ostatak stranice
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/poruke', $data);
        $this->load->view('admin/footer', $data);
    }
    
    /* prikazi sve komentare datog statusa, na sve poruke */
    public function show_comments ( $z = 99 )
    {
        $this->is_logged_in();      
        $data['username'] = $this->auth->userid();
        
        // na osnovu parametra, napisi naslov stranice, da se zna sta gledamo
        if ( $z == 0 )
        {
            $data['title'] = 'Admin Panel - ODOBRENI KOMENTARI';
            $data['title2'] = 'NEODOBRENI KOMENTARI';
        }        
        if ( $z == 1 )
        {
            $data['title'] = 'Admin Panel - ODOBRENI KOMENTARI';
            $data['title2'] = 'ODOBRENI KOMENTARI';
        }
            
        if ( $z == 99 )
        {
            $data['title'] = 'Admin Panel - SVI KOMENTARI';        
            $data['title2'] = 'SVI KOMENTARI';        
        }
        
        $data['comments'] = $this->comments_model->get_all_comments( $z ); // uzmi poruke iz baze
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/comments', $data);
        $this->load->view('admin/footer', $data);        
    }
    
    /* ********************************************** */
    /* metoda za proveravanje da li je admin ulogovan */
    /* ako nije, baca ga na admin login               */
    /* Poziv ove funkcije ( ili izvorne iz auth )     */
    /* sam mogao da stavim u konstrutkor, kao sto sam */
    /* uradio u DBTools.php, ali me zezao login ekran */
    /* koji je stalno ucitavao sam sebe ( u slucaju   */
    /* da admin nije ulogovan ). Zato ovo ostavljam   */
    /* kasnije.                                       */
    /* ********************************************** */
    private function is_logged_in ()
    {
        if ( $this->auth->loggedin() != 1 )
        {
            redirect ('/admin');
        }                
    }
    
    /* logout metoda */
    public function logout()
    {
        $this->auth->logout(); 
        redirect ('/admin');
    }
    
    /* odobri poruku za prikaz */
    public function approve_message ( $id )
    {
        $this->is_logged_in();
        $result = $this->messages_model->set_message_status($id, 1, $this->auth->userid() );
        redirect($_SERVER['HTTP_REFERER']); // vrati se na stranu sa koje si i dosao
    }
        
    /* skloni poruku sa glavne liste                             */
    /* poruka ostaje upisana u bazi, menja se status u neaktivan */
    public function remove_message ( $id )
    {
        $this->is_logged_in();
        $result = $this->messages_model->set_message_status($id, 0, $this->auth->userid());
        redirect($_SERVER['HTTP_REFERER']); // vrati se na stranu sa koje si i dosao
    }    
    
    /* ODOBRI KOMENTAR ZA PRIKAZ */
    public function approve_comment ( $id )
    {
        $this->is_logged_in();
        $result = $this->comments_model->set_comment_status($id, 1, $this->auth->userid());
        redirect ('/admin/show_comments/0');
    }
    
    /* SKLONI KOMENTAR */
    public function remove_comment ( $id )
    {
        $this->is_logged_in();
        $result = $this->comments_model->set_comment_status($id, 0, $this->auth->userid());
        redirect ('/admin/show_comments/1');
    }     
    
    /* prikazi istoriju izmena status poruke */
    public function status_history ( $id )
    {
        $this->is_logged_in();
        $data['items'] = $this->messages_model->get_status_history( $id, 1 );
        $data['username'] = $this->auth->userid();
        $data['title'] = "Istorija poruke " . $id;
        $data['id_poruke'] = $id;
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/poruka_izmene', $data);
        $this->load->view('admin/footer', $data);        
    }                
    
    /* STRANICA ZA PODESAVANJA */
    public function settings ()
    {
        $this->is_logged_in();
        $data['title'] = 'Podesavanja';
        $data['username'] = $this->auth->userid();
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/settings', $data);
        $this->load->view('admin/footer', $data);
    }
    
    /* STRANICA ZA NEWS LETTER */
    public function letter ()
    {
        $this->is_logged_in();
        $data['username'] = $this->auth->userid();
        $data['title'] = 'News letter';
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/letter', $data);
        $this->load->view('admin/footer', $data);
    }    
    
    /* STRANICA ZA KORISNIKE */
    public function users ()
    {
        $this->is_logged_in();
        $data['username'] = $this->auth->userid();
        $data['title'] = 'Korisnici';
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('admin/footer', $data);
    }      
    
    /* STRANICA ZA HELP */
    public function help ()
    {
        $this->is_logged_in();
        $data['username'] = $this->auth->userid();
        $data['title'] = 'Help';
        
        $this->load->view('admin/header', $data);
        $this->load->view('admin/menu', $data);
        $this->load->view('admin/help', $data);
        $this->load->view('admin/footer', $data);
    }      
}