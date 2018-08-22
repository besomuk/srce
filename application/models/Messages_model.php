<?php
class Messages_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->model('autologin_model');
    }
    
    /* uzimanje poruka iz baza      */
    /* $t = 0 - neodobrene poruke   */
    /* $t = 1 - odobrene poruke     */
    /* $t = 99 - sve poruke         */
    public function get_messages ( $t )
    {
        if ( $t == 99 )            
            $query = $this->db->order_by("datecreated","desc")->get('messages');      // uzmi tabelu svih poruka        
        else
            $query = $this->db->order_by("datecreated","desc")->get_where('messages', array ( 'active' => $t ) ); // uzmi tabelu poruka               */
                                                                                                                 // kojima je status $t              */ 
                                                                                                                 // su odobrene od strane moderatora */
        return $query->result_array();   // pljuni je napolje        
    }    
    
    /* uzmi JEDNU poruku iz baze na osnovu njenog ID */
    public function get_message ( $id )
    {
        $query = $this->db->get_where('messages', array ( 'id' => $id ) );
        return array ( "id"          => $query->row()->id,
                       "author"      => $query->row()->author,
                       "title"       => $query->row()->title,
                       "message"     => $query->row()->message,
                       "likes"       => $query->row()->likes,
                       "dislikes"    => $query->row()->dislikes,
                       "datecreated" => $query->row()->datecreated,
                       "views"       => $query->row()->views
                     );  
    }     
    
    /* upisivanje nove poruke u bazu */
    public function set_message ( )
    {
        $this->load->helper('url');
        
        // vreme
        date_default_timezone_set('Europe/Belgrade');
        $new_date = date('Y-m-d H:i:s');
        
        // pospremi poruku, dodaj nove redove
        $message = str_replace ("\r\n", "<br>", $this->input->post('text') );
        if ( $this->input->post('author') == "" )
           $author  = "Anonimus";
        else 
            $author = $this->input->post('author');
            
        $data = array(
            'author'     => $author,
            'title'      => $this->input->post('title'),
            'message'    => $message,
            'datecreated'=> $new_date,
            'user_ip'    => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent()
            );
        return $this->db->insert('messages', $data);        
    }
    
    /* metoda za menjanje statusa poruke od strane admina i upis u tabelu poruka i tabelu protokola */
    /* $id - ID poruke o kojoj se radi                                                              */
    /* $val - vrednost novog statusa                                                                */
    /* $user - ko je menjao poruku                                                                  */
    public function set_message_status($id, $val, $user)
    {
        $user = strip_tags($user);
        
        date_default_timezone_set('Europe/Belgrade');
        $new_date = date('Y-d-m H:i:s');
        
        /* update tabele messages */
        $data = array ( 'active' => $val );
        $this->db->where('id', $id);        
        $this->db->update('messages', $data);         
        
        /* podesi tip promene */
        if ( $val == 0 )
            $type = "BRISANJE";
        if ( $val == 1 )
            $type = "ODOBRENO";        
        
        /* dodavanje u tabelu protokola */            
        $data = array(
            'message_id'   => $id,
            'user_name'    => $user,
            'change_type'  => $type,
            'change_date'  => $new_date,
            'change_ip'    => $this->input->ip_address(),
            'change_agent' => $this->input->user_agent(),
            'type'         => 1
            );
        return $this->db->insert('admin_protokol', $data);           
    }
    
    /* ocenjivanje poruke od strane korisnika */
    /* $type - dali je 'like' ili 'dislike'   */
    public function assess_message($id, $type)
    {
        if ( $type == 'like' )
        {
            $result = $this->get_message ( $id );   // uzmi broj lajkova
            $likes = $result['likes'];              // za datu poruku iz baze
            $likes ++;                              // povecaj ga za 1
            $data = array ( 'likes' => $likes );    
            $this->db->where('id', $id);        
            $this->db->update('messages', $data);   // vrati ga u bazu                  
        }
        if ( $type == 'dislike' )
        {
            $result = $this->get_message ( $id );
            $dislikes = $result['dislikes'];
            $dislikes ++;
            $data = array ( 'dislikes' => $dislikes );
            $this->db->where('id', $id);        
            $this->db->update('messages', $data);                     
        }        
    }        
    
    /* inkrementiranje broja pregleda */
    public function add_one_view ( $id , $views )
    {
        //$result = $this->get_message ( $id );  // uzmi broj pregleda
        //$query = $this->db->get_where('messages', array ( 'id' => $id ) );
        
        //$views = $query->row()->views;
        
        //$views  = $result['views'];            // za datu poruku iz baze
        //echo "Ucitan: " . $views . "<br>";
        //$views = 1;
        //$views++;                   // povecaj ga za 1        
        //$data = array ( 'views' => 'views + 1');    
        //$this->db->where('id', $id);        
        //$this->db->update('messages', $data);  // vrati ga u bazu                  
        
        $this->db->where('id', $id);
        $this->db->set('views', $views, FALSE);
        $this->db->update('messages');
        
        // da vucem rezultat iz kontrolera?
        
        // proveri koliko puta se ucitava sama stranice
        
        //echo $this->db->last_query() . "<br>";
    }
    
    /* uzimanje prvih 5 poruka po nekom kriterijumu */
    /* 1 - 5 najnovijih                             */
    /* 2 - 5 najcitanijih                           */
    /* 3 - 5 najvise komentara                      */    
    function get_top_5 ( $selector )
    {
        if ( $selector == 1 )
        {
                $query = $this->db->order_by("datecreated","desc")->get_where('messages', array ( 'active' => 1 ) );
        }
        if ( $selector == 2 )
        {
                $query = $this->db->order_by("datecreated","desc")->get_where('messages', array ( 'active' => 1 ) );
        }
        if ( $selector == 3 )
        {
                $query = $this->db->order_by("datecreated","desc")->get_where('messages', array ( 'active' => 1 ) );
        }        
        return $query->result_array();
    }
    
    /* uzimanje broja poruka na osnovu parametra $t koji predstavlja */
    /* status poruke                                                 */
    /* $t = 99 - prikazi sve poruke                                  */
    /* $t = 0  - neodobrene poruke                                   */
    /* $t = 1  - odobrene poruke                                     */
    /* $t = 2  - arhivirane poruke                                   */
    function count_messages ( $t )
    {
        if ( $t == 99 )
            $query = $this->db->get('messages');
        else                
            $query = $this->db->get_where('messages', array ( 'active' => $t ) );
        
        $rowcount = $query->num_rows();        
        return $rowcount;
    }
    
    
    /* preuzimanje istorije svih izmena koje su napravili administratori i moderatori */
    public function get_status_history ( $id, $type )
    {
        $query = $this->db->order_by("change_date","asc")->get_where('admin_protokol', array ( 'message_id' => $id,
                                                                                               'type' => $type  ) );
        return $query->result_array();
    }
    
    /* metoda za ispisivanje slike u JPEG koji moze da se sacuva na hardu ili da se posalje na FB, Twiter... */
    /* --------> zasto je ovo u modelu ?????????                                                             */
    public function make_jpg ( $id, $width, $height, $title, $message )
    {
        // opsti parametri
        $w = $width;
        $h = $height;
        $font_loc = "../srce/assets/fonts/minya-nouvelle-rg.ttf";
        
        // velicina fonta id, naslova i poruke
        $size_id    = 14;
        $size_title = 20;
        $size_text  = 14;
        
        //pripremi poruku
        $message = str_replace( "<br>", "\\r\\n", $message );
        //$message = stripcslashes($message);
        
        //$message = "prvi red ". PHP_EOL ."drugi red \ntreci red \ndalje";
        
        $my_img = imagecreate( $w, $h );
        $my_img = imagecreatefromjpeg( "../srce/assets/img/mb.jpg" );
        $background = imagecolorallocate( $my_img, 0, 0, 255 );
        $text_color = imagecolorallocate( $my_img, 50, 50, 50 );
        $line_color = imagecolorallocate( $my_img, 128, 255, 0 );        

        
        imagettftext( $my_img, $size_title, 0, $this->align_text($size_title, $font_loc, "#".$id, $w, 'right'), 40, $text_color, $font_loc, "#".$id);        
        imagettftext( $my_img, $size_title, 0, $this->align_text($size_title, $font_loc, $title, $w, 'center'), 70, $text_color, $font_loc, $title);                
        //$this->imagettftextjustified($my_img, $size_text, 0, 30, 80, $text_color, $font_loc, $message, 740, 3, 1 );
        $xxx = $this->align_text($size_title, $font_loc, $message, $w, 'center');
        $this->write_multiline_text($my_img, $size_text, $text_color, $font_loc, $message, 90, 120, 700 );
        
        // pljuni sliku
        header( "Content-type: image/png" );
        imagepng( $my_img );
        imagecolordeallocate( $my_img, $line_color );
        imagecolordeallocate( $my_img, $text_color );
        imagecolordeallocate( $my_img, $background );
        imagedestroy( $my_img );
    }
    
    /* pomocna metoda za postavljanje teksta levo/centar/desno */
    /* $font_size - velicina fonta                             */
    /* $font      - lokacija fonta                             */
    /* $str       - string                                     */
    /* $width     - ukupna sirina slike                        */
    /* $type      - vrsta poravnanja                           */ 
    /*              - left   - levo                            */
    /*              - center - centriranje                     */
    /*              - right  - desno                           */
    private function align_text ( $font_size, $font, $str, $width, $type )
    {
        $margin = 30;
        if ( $type == 'left' )
        {
            $newX = $margin; // ako si levi, treba poceti od margine, sto zavisi od ulazne slike
        }                
        if ( $type == 'center' )
        {
            $box = imagettfbbox( $font_size, 0, $font, $str);
            $newX = $width/2 - ($box[2]-$box[0])/2;
        }
        if ( $type == 'right' )
        {
            $box = imagettfbbox( $font_size, 0, $font, $str);
            $newX = $width - ($box[2]-$box[0]) - $margin;
        }        
        return $newX;
    }    
    
    
    private function write_multiline_text($image, $font_size, $color, $font, $text, $start_x, $start_y, $max_width) 
    { 
        //split the string 
        //build new string word for word 
        //check everytime you add a word if string still fits 
        //otherwise, remove last word, post current string and start fresh on a new line 
        $words = explode(" ", $text); 
        $string = ""; 
        $tmp_string = ""; 

        for($i = 0; $i < count($words); $i++) { 
            $tmp_string .= $words[$i]." "; 

            //check size of string 
            $dim = imagettfbbox($font_size, 0, $font, $tmp_string); 

            if($dim[4] < ($max_width - $start_x)) { 
                $string = $tmp_string; 
                $curr_width = $dim[4];
            } else { 
                $i--; 
                $tmp_string = ""; 
                //$start_xx = $start_x + round(($max_width - $curr_width - $start_x) / 2);        
                $start_xx = $max_width/2 - ($dim[2]-$dim[0])/2;
                imagettftext($image, $font_size, 0, $start_xx, $start_y, $color, $font, $string); 

                $string = ""; 
                $start_y += abs($dim[5]) * 2; 
                $curr_width = 0;
            } 
        } 

        //$start_xx = $start_x + round(($max_width - $dim[4] - $start_x) / 2);        
        $start_xx = $max_width/2 - ($dim[2]-$dim[0])/2;
        imagettftext($image, $font_size, 0, $start_xx, $start_y, $color, $font, $string);
    }    
    
    /* podesavanje teksta da bude JUSTIFIED ( sa php.net ) */
    private function imagettftextjustified(&$image, $size, $angle, $left, $top, $color, $font, $text, $max_width, $minspacing=3,$linespacing=1)
    {
        $wordwidth = array();
        $linewidth = array();
        $linewordcount = array();
        $largest_line_height = 0;
        $lineno=0;
        $words=explode(" ",$text);
        $wln=0;
        $linewidth[$lineno]=0;
        $linewordcount[$lineno]=0;
        foreach ($words as $word)
        {
            $dimensions = imagettfbbox($size, $angle, $font, $word);
            $line_width = $dimensions[2] - $dimensions[0];
            $line_height = $dimensions[1] - $dimensions[7];
            if ($line_height>$largest_line_height) $largest_line_height=$line_height;
            if (($linewidth[$lineno]+$line_width+$minspacing)>$max_width)
            {
                $lineno++;
                $linewidth[$lineno]=0;
                $linewordcount[$lineno]=0;
                $wln=0;
            }
            $linewidth[$lineno]+=$line_width+$minspacing;
            $wordwidth[$lineno][$wln]=$line_width;
            $wordtext[$lineno][$wln]=$word;
            $linewordcount[$lineno]++;
            $wln++;
        }
        for ($ln=0;$ln<=$lineno;$ln++)
        {
            $slack=$max_width-$linewidth[$ln];
            if (($linewordcount[$ln]>1)&&($ln!=$lineno)) $spacing=($slack/($linewordcount[$ln]-1));
            else $spacing=$minspacing;
            $x=0;
            for ($w=0;$w<$linewordcount[$ln];$w++)
            {
                imagettftext($image, $size, $angle, $left + intval($x), $top + $largest_line_height + ($largest_line_height * $ln * $linespacing), $color, $font, $wordtext[$ln][$w]);
                $x+=$wordwidth[$ln][$w]+$spacing+$minspacing;
            }
        }
        return true;
    }        
}