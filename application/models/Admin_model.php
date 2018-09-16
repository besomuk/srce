<?php
class Admin_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /* ********************************* */
    /* PROVERA SIFRE I KORISNICKOG IMENA */
    /* 0 - los login                     */
    /* 1 - dobar login                   */
    /* ********************************* */
    public function validate_login ( $username, $password )
    {
        $data = array( 'username' => $username,
                       'password' => $password
                     );

        $query = $this->db->get_where( 'users', $data );

        if ( $query->num_rows() == 0 )
        {
            return 0;
        }

        if ( $query->num_rows() == 1 )
        {
            return 1;
        }
    }
}
