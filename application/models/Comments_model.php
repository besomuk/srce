<?php
class Comments_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->model('autologin_model');
    }

    /* UZIMANJE KOMENTARA NA DATU PORUKU IZ BAZE            */
    public function get_comments ( $id, $status )
    {
       $query = $this->db->get_where('comments', array ( 'message_id' => $id,
                                                             'status' => $status,
                                                      'parrent_id >=' => 0          ) );
       return $query->result_array();
    }
    
    /* UZIMANJE SVIH KOMENTARA IZ BAZE            */
    public function get_all_comments ( $status )
    {
        if ( $status == 99 )
            $query = $this->db->order_by("comment_time","desc")->get('comments');
        else
            $query = $this->db->order_by("comment_time","desc")->get_where('comments', array ( 'status'     => $status ) );        
        return $query->result_array();
    }    
    
    /* UZIMANJE ODGOVORA NA KOMENTARE IZ BAZE  */
    /* $id  - id poruke na koju je komentar    */
    /* $cid - id komentara na koji je odgovor  */
    public function get_replies ( $id, $cid )
    {
       $status = 1;
       $query = $this->db->get_where('comments', array ( 'message_id' => $id, 'parrent_id' => $cid, 'status' => $status ) );
       return $query->result_array();        
    }
    
    /* UPISIVANJE NOVOG KOMENTARA NA DATU PORUKU U BAZU */
    public function set_comment ( $id )
    {
        $this->load->helper('url');
        
        date_default_timezone_set('Europe/Belgrade');
        $new_date = date('Y-m-d H:i:s');
        
        /* pospremi komentar, zelim i nove redove */
        $message = str_replace ("\r\n", "<br>", $this->input->post('text') );
        
        $data = array(
            'message_id'     => $id,
            'comment_author' => $this->input->post('author'),
            'comment_txt'    => $message,
            'user_ip'        => $this->input->ip_address(),
            'comment_time'   => $new_date
            );
        return $this->db->insert('comments', $data);        
    }    
    
    /* PODESI STATUS KOMENTARA NA UKLJUCEN ILI ISKLJUCEN */
    public function set_comment_status($id, $val, $user)
    {
        $user = strip_tags($user);
        
        date_default_timezone_set('Europe/Belgrade');
        $new_date = date('Y-d-m H:i:s');
        
        /* update tabele COMMENTS */
        $data = array ( 'status' => $val );
        $this->db->where('id', $id);        
        $this->db->update('comments', $data);         
        
        /* sta smo uradili */
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
            'type'         => 2
            );
        return $this->db->insert('admin_protokol', $data);          
        
    }

	/* BROJANJE KOMENTARA NA DATU PORUKU                           */
    /* BROJIM SAMO ODOBRENE KOMENTARE, TJ. ONE KOJI IMAJU STATUS 1 */
    function count_comments ( $id, $status = 1)
    {        
        $query = $this->db->get_where('comments', array ( 'message_id' => $id, 'status' => $status ) );
        return $query->num_rows();
    }
}
    
?>
