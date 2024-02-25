<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function index(){

        $data = array (
            'titulo'        => 'Usuários cadastrados',
            'sub_titulo'    => 'Listando os usuários cadastrados',
            'icone'         =>  'ik ik-users bg-blue',
            'usuarios'      => $this->ion_auth->users()->result(),
            'styles'        => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            ),
            'scripts'       => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
        );

        // echo '<pre>';
        // echo print_r($data['usuarios']);
        // exit();

        $this->load->view('layout/header', $data);
        $this->load->view('usuarios/index');
        $this->load->view('layout/footer');
        
    }

    public function core($usuario_id = null){

        if(!$usuario_id){
            //cadastro
            exit('Usuário será cadastrado');
        }else{
            //editar
            $usuario = $this->ion_auth->user($usuario_id)->row();

            if(!$usuario){
                exit('Usuário não existe');
            }else{

                $this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[3]|max_length[20]');
                $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[3]|max_length[50]');
                $this->form_validation->set_rules('username', 'Nome do usuário', 'required|min_length[5]|max_length[100]');
                $this->form_validation->set_rules('email', 'e-mail', 'required|valid_email|min_length[4]|max_length[50]');
                $this->form_validation->set_rules('password', 'Senha', 'min_length[4]|max_length[254]');
                $this->form_validation->set_rules('confirma_senha', 'Confirmação de senha', 'matches[password]');

                if ($this->form_validation->run()) {
        
                    echo '<pre>';
                    echo print_r($this->input->post());
                    exit();

                }else{
                    //erro de validação
                    $data = array (
                        'titulo'        => 'Editar Usuário',
                        'sub_titulo'    => 'Editando o usuário ' . $usuario->first_name,
                        'icone'         =>  'ik ik-user bg-blue',
                        'usuario'       => $usuario,
                        'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row(),
                        'valor_btn' => 'Atualizar',
                    );

                    $this->load->view('layout/header', $data);
                    $this->load->view('usuarios/core');
                    $this->load->view('layout/footer');
                }
    
            }
        }
        
    }

    public function del($usuario_id = NULL) {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Usuário não encontrado');
            redirect('usuarios');
        }


        if (!$usuario_id || !$this->ion_auth->user($usuario_id)->row()) {
            $this->session->set_flashdata('error', 'Usuário não encontrado');
            redirect('usuarios');
        }

        if ($this->ion_auth->is_admin($usuario_id)) {
            $this->session->set_flashdata('error', 'Você não pode excluir o administrador');
            redirect('usuarios');
        }

        if ($this->ion_auth->delete_user($usuario_id)) {
            $this->session->set_flashdata('sucesso', 'Usuário excluído com sucesso!');
        } else {

            $this->session->set_flashdata('error', 'Erro ao excluir o usuário');
        }

        redirect('usuarios');
    }

    public function check_email($email) {

        $usuario_id = $this->input->post('user_id');

        if ($this->core_model->get_by_id('users', array('email' => $email, 'id !=' => $usuario_id))) {

            $this->form_validation->set_message('check_email', 'Esse e-mail já existe. Ele deve ser único');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_username($username) {

        $usuario_id = $this->input->post('user_id');

        if ($this->core_model->get_by_id('users', array('username' => $username, 'id !=' => $usuario_id))) {

            $this->form_validation->set_message('check_username', 'Esse usuário já existe. Ele deve ser único');

            return FALSE;
        } else {

            return TRUE;
        }
    }

}