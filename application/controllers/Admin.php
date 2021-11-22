<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }

    public function _exit_view($data = null)
    {
        $this->load->view('admin/mainAdmin.php', (array)$data);
    }

    public function catservicios_management()
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('datatables');
            $crud->set_table('catservicios');
            $crud->set_subject('Categoria');
            $crud->required_fields('nombreCat');
            $crud->columns('nombreCat', 'descripCat', 'logoURLCat');
            $crud->set_field_upload('logoURLCat', 'assets/uploads/files/logoServicios');

            $crud->display_as('nombreCat', 'Nombre de categoría')
                ->display_as('descripCat', 'Descripción de la categoría')
                ->display_as('logoURLCat', 'Logotipo de la categoría');


            $data = $crud->render();

            $this->_exit_view($data);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function servicios_management()
    {
        try {
            $crud = new grocery_CRUD();

            $crud->set_theme('datatables');
            $crud->set_table('prestadoresservicios');
            $crud->set_relation('catServicios_id', 'catservicios', 'nombrecat');
            $crud->set_relation('idUsuarioAdministrador', 'usuarios', 'nombreRepresentante');
            $crud->display_as('catServicios_id', 'Categoría de servicios');
            $crud->display_as('idUsuarioAdministrador', 'Usuario responsable');
            $crud->set_subject('Servicios');
            $crud->required_fields('nombre');
            $crud->columns('nombre', 'logoPrestadoresServicios', 'descripPrestadoresServicios');
            $crud->set_field_upload('logoPrestadoresServicios', 'assets/uploads/files/logoServicios');
            $crud->display_as('nombre', 'Nombre de servicio')
                ->display_as('descripPrestadoresServicios', 'Descripción de prestador de servicios')
                ->display_as('logoPrestadoresServicios', 'Logotipo de prestador de servicios');

            $data = $crud->render();

            $this->_exit_view($data);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function snservicios_management()
    {
        try {
            $crud = new grocery_CRUD();

            $crud->set_theme('datatables');
            $crud->set_table('snprestadoresservicios');
            $crud->set_relation('prestadoresServicios_id', 'prestadoresservicios', 'nombre');
            $crud->set_subject('Redes sociales de servicios');
            $crud->required_fields('nombre');
            $crud->columns('redsocial', 'urlRedSocial');
            $crud->callback_add_field('redsocial', array($this, 'add_redesSOciales'));
            $crud->display_as('redsocial', 'Nombre de redsocial')
                ->display_as('prestadoresServicios_id', 'Prestadores de servicios')
                ->display_as('urlRedSocial', '<b>Sólo el nombre de tu página o perfil</b>');

            $data = $crud->render();

            $this->_exit_view($data);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    function add_redesSOciales()
    {
        return ' <input type="radio" name="redsocial" value="Facebook" /> Facebook<br/>
        <input type="radio" name="redsocial" value="Instagram" /> Instagram<br/>
        <input type="radio" name="redsocial" value="YouTube" /> YouTube<br/>
        <input type="radio" name="redsocial" value="Twitter" /> Twitter<br/>
        <input type="radio" name="redsocial" value="Otro" /> Otro';
    }

    public function ubicaciones_management()
    {
        try {
            $crud = new grocery_CRUD();

            $crud->set_theme('datatables');
            $crud->set_table('ubicacionservicios');
            $crud->set_relation('prestadoresServicios_id', 'prestadoresservicios', 'nombre');
            $crud->display_as('prestadoresServicios_id', 'Sucursales de servicios');
            $crud->set_subject('Sucursales de servicios');
            $crud->required_fields('nombre');
            $crud->columns('nombreUbicacion', 'direccionServicio', 'tel1', 'tel2');
            $crud->display_as('nombreUbicacion', 'Nombre de sucurssal')
                ->display_as('direccionServicio', 'Dirección de sucursal')
                ->display_as('tel1', 'Número de teléfono 1')
                ->display_as('tel2', 'Número de teléfono 2');
            $crud->unset_read_fields('lat', 'lon');


            $data = $crud->render();

            $this->_exit_view($data);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function catusuarios_management()
    {
        try {
            $crud = new grocery_CRUD();

            $crud->set_theme('datatables');
            $crud->set_table('catusuarios');
            $crud->set_subject('Categoría de usuarios');
            $crud->required_fields('nombre');
            $crud->columns('nombre', 'descripcion', 'iconoURL');
            $crud->set_field_upload('iconoURL', 'assets/uploads/files/logoServicios');
            $crud->display_as('nombreUbicacion', 'Nombre de categoria de usuario')
                ->display_as('descripcion', 'Descripcion de categoria de usuario')
                ->display_as('iconoURL', 'Icono de categoría');


            $data = $crud->render();

            $this->_exit_view($data);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function usuarios_management()
    {
        try {
            $crud = new grocery_CRUD();
            $state = $crud->getState();
            $crud->set_theme('datatables');
            $crud->set_table('usuarios');
            $crud->set_subject('Usuarios');
            $crud->required_fields('username', 'nombre');
            $crud->set_relation('catUsuarios_id', 'catusuarios', 'nombre');
            if ($state == "edit") {
                $crud->field_type('username', 'readonly');
            }
            $crud->display_as('catServicios_id', 'Categoría de usuarios');
            $crud->columns('nombre', 'username', 'pwclaveacceso_6', 'imagenPrincipal');
            $crud->set_field_upload('imagenPrincipal', 'assets/uploads/files/logoServicios');
            $crud->display_as('username', 'Nombre de usuario email')
                ->display_as('pwclaveacceso_6', 'Password')
                ->display_as('imagenPrincipal', 'Imagen principal del usuario');
            $crud->field_type('pwclaveacceso_6', 'password');
            $crud->unset_read_fields('pwclaveacceso_6');

            $crud->set_rules('username', 'Nombre de usuario (Email)', 'trim|valid_email|max_length[255]|is_unique[usuarios.username]');

            /*
            $crud->callback_before_insert(array($this,'encrypt_password_callback'));
            $crud->callback_before_update(array($this,'encrypt_password_callback'));
            $crud->callback_edit_field('pwclaveacceso_6',array($this,'decrypt_password_callback'));
            */

            $data = $crud->render();

            $this->_exit_view($data);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function index()
    {
        $this->_exit_view((object)array('output' => '', 'data' => '', 'js_files' => array(), 'css_files' => array()));
    }
}
