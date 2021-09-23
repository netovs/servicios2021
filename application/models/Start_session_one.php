<?php 
class Start_session_one extends CI_Model  {

    public function updateUser($idUsuario = null, $data ) {
    /*
    $data = array(
            'title' => $title,
            'name' => $name,
            'date' => $date
    );

    $this->db->where('id', $id);
    $this->db->update('mytable', $data);
    */
    
    $this->db->where('id', $idUsuario);
    $this->db->update('usuarios', $data);


    }

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