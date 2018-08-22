<?php
class Tools_model extends CI_Model
{
    private $number_of_words = 102; // broj zapisa u bazi za recnik
    
    public function __construct()
    {
        $this->load->database();
        $this->load->model('messages_model');
    }    
    
    /* VRACA SLUCAJNU REC IZ BAZE */
    public function get_random_word ()
    {
        $random_id = rand( 1, $this->number_of_words );
        $query = $this->db->get_where('captcha_dic', array ( 'id' => $random_id ) );
        return $query->row()->word;  
    }
    
    /* PISE INFO O CAPTCHA U PRIVREMENU TABELU */
    public function set_captcha( $captcha_time, $ip_address, $c_word )
    {    
        $data = array(
                    'captcha_time'	=> $captcha_time,
                    'ip_address'	=> $ip_address,
                    'word'	=> $c_word
                    );                        
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);        
    }
    
    /* PROVERA CAPTCHA IZ TABELE         */
    /* $c_word - rec koju unosi korisnik */
    /* izlaz                             */
    /* 0 - ne valja, rec nije dobra      */  
    /* 1 - sve je ok                     */
    public function check_captcha( $c_word )
    {
        // prvo obrisi stare
        /* PAZNJA !!! PAZNJA !!!                     */
        /* SLEDECE DVE LINIJE SU SPORNI MOMENAT !!!! */ 
        $expiration = time()-1000; // 30 minuta
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	        
        
        // uporedi ulaz sa stanjem u bazi
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array( $c_word, $this->input->ip_address(), $expiration);
         
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
        
        // ako je rezultat nula, captcha je losa
        if ($row->count == 0)
            return 0;
        else
            return 1;
    }
    
    // vrati set od 5 poruke za naj poruke po nekom kriterijumu
    // Ovo nisam hteo da radim u kontroleru ( pojavljuje se vise puta na vise mesta ) , a ni u modelu ( preglednost ), pa sam ga ostavio
    // u alatima u kojima se ionako nalazi razni krs
    public function get_top_5( $s )
    {
        $temp['messages'] = $this->messages_model->get_top_5( $s );        
        $tops['top'] =  '';            
        for ( $i = 0; $i<5; $i++)
        {
            $tops['top'] .= ($i + 1) . '. <a href="#">' . $temp['messages'][$i]['title'] . ' od <i>' . $temp['messages'][$i]['author'] . "</i></a><br>";
        }        
        return $tops['top'];
    }
}
