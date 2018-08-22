<?php
class DBTools_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function db_size ()
    {
        $CI=&get_instance();
        $CI->load->database();
        
        $dbName = $CI->db->database;
        
        $dbName = $this->db->escape($dbName);
        
        $sql = "SELECT table_schema AS db_name, sum( data_length + index_length ) / 1024 / 1024 AS db_size_mb 
                FROM information_schema.TABLES 
                WHERE table_schema = $dbName
                GROUP BY table_schema ;";
        
        $query = $CI->db->query($sql);
        
        if ($query->num_rows() == 1) {            
           $row = $query->row(); 
           $size = $row->db_size_mb;
           return $size;           
        } else {            
            log_message('ERROR', "*** Unexpected number of rows returned " . ' | line ' . __LINE__ . ' of ' . __FILE__);
            show_error('Sorry, an error has occured.');            
        }        
    }    
    
    public function backup_db ()
    {        
        echo "Back up db";
    }
    
    public function backup_table ()
    {        
        echo "Back up table";
    }
}