<?php
class Datos_servicios extends CI_Model {
    public function getSucursales($idUser = null) {
        $this->db->select('*');
        $this->db->from('ubicacionservicios');
        $this->db->where('prestadoresServicios_id', $idUser);
        $query = $this->db->get();
        return $query->result_array();
    }

}