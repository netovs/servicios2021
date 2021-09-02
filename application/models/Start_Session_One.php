<?php 
class Start_session_one extends CI_Model  {

    public function findUser($username = null, $pwclaveacceso_6 = null) {

        $array = array('username' => $username, 'pwclaveacceso_6' => $pwclaveacceso_6);
        $this->db->where($array);
        $query = $this->db->get('usuarios');

        if(!empty($query)){
            return $query;
        } else {
            return false;
        }

    }
    
}