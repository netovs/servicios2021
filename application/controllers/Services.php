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
        $this->load->model('datos_servicios');
    }

    public function locationList() // Lista de sucursales 
    {
        $sessionData['idSession'] = $this->session;
        $data = $_REQUEST;
        $userLogged = $sessionData['idSession']->id;
        $idUsuario = $data['id'];
        $ci_last    = $data['__ci_last_regenerate'];
        $result = $this->start_session_one->serachSession($idUsuario, $ci_last);
        // print_r($result->result_id->num_rows);

        
        if ($result == 1) {
            $arraResponse['status']     = 'SUCCESS';
            $arraResponse['msg']        = 'Listado de sucursales.';
            $arraResponse['sucursales'] = $this->datos_servicios->getSucursales($data['id']);
        } else {
            $arraResponse['status']     = 'ERROR';
            $arraResponse['msg']        = 'Usuario no inició sesión.';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($arraResponse));
    }

    public function user_session()
    {
        $sessionData['idSession'] = $this->session;
        $data = $_REQUEST;
        $userLogged = $sessionData['idSession']->id;

        if ($userLogged == $data['id']) {
            $arraResponse['status']     = 'SUCCESS';
            $arraResponse['msg']        = 'Los datos fueron actualizados exitosamente.';
            $this->output->set_content_type('application/json')->set_output(json_encode($sessionData));
        } else {
            $arraResponse['status']     = 'ERROR';
            $arraResponse['msg']        = 'Usuario no inició sesión.';
            $this->output->set_content_type('application/json')->set_output(json_encode($arraResponse));
        }
    }

    public function cerrar_sesion()
    {
        $this->session->sess_destroy();
        // ('id', 'session_id', 'imagenPrincipal', 'nombre', 'logged_in');
    }

    public function actualiza_usuario()
    {
        $data = $_REQUEST;
        // unset($data['ci_session']);
        // print_r($data);
        // updateUser 
        $userLogged = $this->session->id;
   //  $this->session->__ci_last_regenerate;
        $arraResponse['ci_last'] = $ci_last;
        $arraResponse['session_id']        = $userLogged;
        $idUsuario = $data['id'];
        $ci_last    = $data['__ci_last_regenerate'];
        $result = $this->start_session_one->serachSession($idUsuario, $ci_last);
        // print_r($result->result_id->num_rows);

        
        if ($result == 1) {
            $result     = $this->start_session_one->updateUser($data['id'], $data);
            $arraResponse['result']     = $result;
            $arraResponse['status']     = 'SUCCESS';
            $arraResponse['msg']        = 'Los datos fueron actualizados exitosamente.';
            $arraResponse['session_id']        = $userLogged;
        } else {
            $arraResponse['status']     = 'ERROR';
            $arraResponse['msg']        = 'Usuario incorrecto, favor de verificar.';
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($arraResponse));
    }

    public function iniciar_sesion()
    {
        //  $data = json_decode(file_get_contents('php://input'), true);
        $data = $_REQUEST;
        $result = $this->start_session_one->findUser($data['username'], $data['pwclaveacceso_6']);
        $findUser = $result->result_id->num_rows;
        if ($findUser == 1) {
            $arraResponse['status'] = 'SUCCESS';
            $arraResponse['nombre'] = $result->row(0)->nombre;
            $arraResponse['nombreRepresentante'] = $result->row(0)->nombreRepresentante;
            $arraResponse['id'] = $result->row(0)->id;
            $arraResponse['imagenPrincipal'] = $result->row(0)->imagenPrincipal;
            $arraResponse['logged_in'] = 'true';
            $arraResponse['catUsuarios_id'] = $result->row(0)->catUsuarios_id;
            $arraResponse['msg'] = 'Inicio de sesión correcto.';
            $this->session->set_userdata($arraResponse);
            $session_id = $this->session->id;
            $arraResponse['session_id'] = $session_id;
            $arraResponse['__ci_last_regenerate'] = $this->session->__ci_last_regenerate;
            $this->start_session_one->updateSession($session_id, $this->session->__ci_last_regenerate);
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
