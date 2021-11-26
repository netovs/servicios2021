<?php
class Start_session_one extends CI_Model
{
    public function serachSession($idUsuario=null, $ci_ss=null){
        $array = array('id'=>$idUsuario, '__ci_last_regenerate'=> $ci_ss);
        $this->db->where($array);
        $query = $this->db->get('usuarios');

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }        
    }

    public function updateUser($idUsuario = null, $data = null) {
        $this->db->where('id', $idUsuario);
        $query = $this->db->update('usuarios', $data);
        
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

    public function closeSession($idUsuario = null, $data = null) {
        $field = array('__ci_last_regenerate' => '');
        $this->db->where('id', $idUsuario);
        $this->db->update('usuarios', $field);
    }

    public function findUser($username = null, $pwclaveacceso_6 = null) {
        $array = array('username' => $username, 'pwclaveacceso_6' => $pwclaveacceso_6);
        $this->db->where($array);
        $query = $this->db->get('usuarios');

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

    public function updateSession($idUsuario = null, $ci_last = null) {
        
        $field = array('__ci_last_regenerate' => $ci_last);
        $this->db->where('id', $idUsuario);
        $this->db->update('usuarios', $field);

    }
}
