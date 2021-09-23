<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Services extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('start_session_one');
    }

    public function user_session(){
        echo $this->session->id;
    }

    public function cerrar_sesion(){
        $this->session->unset_userdata('id', 'session_id', 'imagenPrincipal', 'nombre', 'logged_in');
    }

    public function actualiza_usuario() {
        $data = $_REQUEST;
        // updateUser 
        $result     = $this->start_session_one->updateUser($data['id'], $data);
        // $updateUser = $result->result_id->num_rows;
        if($updateUser >= 1) {
            $arraResponse['status']     = 'SUCCESS';
            $arraResponse['msg']        = 'Los datos fueron actualizados exitosamente,';
        } else {
            $arraResponse['status']     = 'ERROR';
            $arraResponse['msg']        = 'Los datos NO fueron actualizados, favor de verificar.';
        }
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($arraResponse));  
    }
    
    public function iniciar_sesion(){
        //  $data = json_decode(file_get_contents('php://input'), true);
        $data = $_REQUEST;
        $result = $this->start_session_one->findUser($data['username'], $data['pwclaveacceso_6']);
        $findUser = $result->result_id->num_rows;
        if($findUser == 1){
            $arraResponse['status'] = 'SUCCESS';
            $arraResponse['nombre'] = $result->row(0)->nombre;
            $arraResponse['nombreRepresentante'] = $result->row(0)->nombreRepresentante;
            $arraResponse['id'] = $result->row(0)->id;
            $arraResponse['imagenPrincipal'] = $result->row(0)->imagenPrincipal;
            $arraResponse['logged_in'] = 'true';
            $this->session->set_userdata($arraResponse);
            $session_id = $this->session->id;
            $arraResponse['session_id'] = $session_id;
            $arraResponse['msg'] = 'Inicio de sesión correcto.';
        } else {
            $arraResponse['status'] = 'ERROR';
            $arraResponse['msg'] = 'Nombre de usuario o cotraseña incorrecto.';
            $arraResponse['logged_in'] = false;
            $this->session->unset_userdata('id', 'session_id', 'imagenPrincipal', 'nombre');
        }

        /*
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
        */
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($arraResponse));    
    }
}