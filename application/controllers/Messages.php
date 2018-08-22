<?php
class Messages extends CI_Controller
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

    /* prikaz svih poruka na naslovnoj strani */
    public function index()
    {
        $data['messages'] = $this->messages_model->get_messages(1);
        $data['title'] = "Lista poruka";

        /* obradi svaku pojedinacnu poruku */
        for ( $i = 0; $i<count($data['messages']); $i++)
        {
            // skrati poruku na MAX_CHARS karaktera
            $data['messages'][$i]['message'] = substr ( $data['messages'][$i]['message'], 0, MAX_CHARS) . "...";            
            // izbaci generisanu grafiku za prikaz odnosa lajkova i dislajkova
            $width = $data['messages'][$i]['likes'] * 10;
            $data['messages'][$i]['img'] = "<img src='http://127.0.0.1/srce/im.php?w=".$width."&h=50&txt=zum'>";
            
            // uzmi komentare
            $data['messages'][$i]['comments'] = $this->comments_model->get_comments( $data['messages'][$i]['id'], 1 );
            
            // izbroj komentare, moram iz 2 puta, da bih izbrojio i odgovore
            $data['messages'][$i]['comments_no'] = $this->comments_model->count_comments( $data['messages'][$i]['id'], 1 );
            
            // ako ima komentara, prodji kroz njih
            /*
            if ( $data['messages'][$i]['comments_no'] > 0 )
            {            
                for ( $k = 0; $k<$data['messages'][$i]['comments_no']; $k++)
                {
                    // proveri ima li dece
                    if ( $data['messages'][$i]['comments'][$k]['has_child'] == 1 )
                    {
                        $data['messages'][$i]['comments'][$k]['comment_rep'] = $this->comments_model->get_replies( $data['messages'][$i]['id'], $data['messages'][$i]['comments'][$k]['id'] );
                        //echo count( $this->comments_model->get_replies( $data['messages'][$i]['id'], $data['messages'][$i]['comments'][$k]['id'] ) );
                    }
                }   
            }*/
        }
        
        // uzmi top poruke za razlicite kategorije 
        $tops['top_newest']        = $this->tools_model->get_top_5(1);
        $tops['top_most_read']     = $this->tools_model->get_top_5(1);
        $tops['top_most_comments'] = $this->tools_model->get_top_5(1);
            
        $this->load->view('templates/header', $data);
        $this->load->view('pages/messages', $data);
        $this->load->view('templates/sidebar', $tops);
        $this->load->view('templates/footer');
    }

    /* pregled jedne poruke */
    public function view_message ( $id )
    {
        $messages = $this->messages_model->get_message( $id );
        
        //echo $messages['views'];
        
        $data['comments'] = $this->comments_model->get_comments( $id, 1 );
        $data['title'] = $messages['title'];
        $data['comments_count'] = $this->comments_model->count_comments( $id );

        /* na ovoj stranici je i forma za komentare - obradi je */
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {            
            // dodaj +1 na broj pregleda
            $v = $messages['views'] + 1;
            $this->messages_model->add_one_view ( $id , $v );
            $this->load->view('templates/header', $data);
            $this->load->view('pages/view_message', $messages);
            $this->load->view('pages/comments', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            //$messages = $this->comments_model->set_comment( $id );
            //$messages = $this->messages_model->get_message( $id );
            //$data['comments'] = $this->comments_model->get_comments( $id, 1 );

            //$this->load->view('templates/header', $data);
            //$this->load->view('templates/menu');
            //$this->load->view('pages/view_message', $messages);
            //$this->load->view('pages/comments', $data);
            //$this->load->view('templates/success_comment');
            //$this->load->view('templates/footer');
        }

        //echo $this->db->last_query() . "<br>";
        $this->output->enable_profiler(TRUE);
    }

    /* pisanje poruke */
    public function write_message ()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        // nekakav komentar, da vidim da li mi se snima fajl

        /* VALIDIRAJ FORMU */
        $this->form_validation->set_rules('author', 'author', 'trim');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('text', 'Text', 'trim|required');
        $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required');
        
        /* premosti default poruku o gresci */
        $this->form_validation->set_message('required', 'Ovo polje je obavezno');
        
        /* promeni default selektor */
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        /* POSTAVI NASLOV STRANICE */
        $data['title'] = "Pisanje poruke";

        /* VARIJANT 1, UZMI SLUCAJNU REC ZA CAPTCHA IZ MODELA */
        $captcha_word = $this->tools_model->get_random_word();

        /* VARIJANTA 2, NAPRAVI SLUCAJNI NIZ SLOVA I BROJEVA */
        //$captcha_word =  substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0, 10);
        $captcha_word =  substr(str_shuffle("0123456789"),0, 5);

        if ($this->form_validation->run() === FALSE)
        {
            /* POSTAVI VREDNOSTI ZA CAPTCHA KOD */
            $vals = array(
                'word'	=> $captcha_word,
                'img_path'	 => './captcha/',
                'img_url'	 => base_url() . 'captcha/',
                'font_path'	 => './path/to/fonts/texb.ttf',
                'img_width'	 => 110,
                'img_height' => 28,
                'expiration' => 1800,
			    'colors'	=> array(
				                        'background' => array(255,255,255),
				                        'border'	 => array(0,0,0),
				                        'text'		 => array(255,103,153),
				                        'grid'		 => array(255,192,122))
            );
            $cap = create_captcha($vals);

            /* PRIPREMI PODATKE ZA TEMP TABELU */
            $captcha_time = $cap['time'];
            $ip_address   = $this->input->ip_address();
            $c_word       = $cap['word'];
            $this->tools_model->set_captcha( $captcha_time, $ip_address, $c_word );

            /* PRIKAZI FORMU ZA UNOS */
            $this->load->view('templates/header', $data);
            $this->load->view('pages/write_message', $cap);
            $this->load->view('templates/footer');
        }
        else
        {
            if ( $this->tools_model->check_captcha( $this->input->post('captcha') ) == 1 )
            {
                // upisi poruku u bazu
                $this->messages_model->set_message();

                // prikazi stranicu o uspesnom upisu poruke
                $this->load->view('templates/header', $data);
                //$this->load->view('templates/menu', $data);
                $this->load->view('templates/success');
                $this->load->view('templates/footer');
            }
            else
            {
                // captcha ne valja
                $this->load->view('templates/header', $data);
                //$this->load->view('templates/menu', $data);
                $this->load->view('templates/bad_captcha');
                $this->load->view('templates/footer');
            }
        }
    }

    public function like_message ( $id )
    {
        $this->messages_model->assess_message($id, 'like');
        $this->load->view('pages/alert');
        redirect ("view_message/".$id);
    }

    public function dislike_message ( $id )
    {
        $this->messages_model->assess_message($id, 'dislike');
        redirect ("view_message/".$id);
    }

    /* eksportovanje date poruke u JPEG */
    public function export_message ( $id )
    {
        $messages = $this->messages_model->get_message( $id );
        //$this->make_jpg ( $id, 800, 600, $messages['title'], $messages['message'] );
        $this->messages_model->make_jpg ( $id, 800, 600, $messages['title'], $messages['message'] );
    }        
}
