<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }
    }

    public function index() {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('warning', 'Você não tem permissão para acessar esse menu');
            redirect('/');
        }

        $data = array(
            'titulo'        => 'Usuários',
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

        $this->load->view('layout/header', $data);
        $this->load->view('usuarios/index');
        $this->load->view('layout/footer');
    }

    public function core($usuario_id = null) {

        if (!$usuario_id) {

            if (!$this->ion_auth->is_admin()) {
                $this->session->set_flashdata('warning', 'Você não tem permissão para acessar esse menu');
                redirect('/');
            }

            $this->form_validation->set_rules('first_name', 'Nome', 'required|alpha|min_length[3]|max_length[50]');
            $this->form_validation->set_rules('last_name', 'Sobrenome', 'required|alpha|min_length[3]|max_length[50]');
            $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|min_length[4]|max_length[50]|is_unique[users.email]');
            $this->form_validation->set_rules('username', 'Nome do usuário', 'required|min_length[5]|max_length[100]|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Senha', 'required|min_length[5]|max_length[255]');
            $this->form_validation->set_rules('confirma_senha', 'Confirmação de senha', 'required|matches[password]');


            if ($this->form_validation->run()) {


                $username = html_escape($this->input->post('username'));
                $password = html_escape($this->input->post('password'));
                $email = html_escape($this->input->post('email'));


                $dados_adicionais = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'active' => $this->input->post('active'), // Não esquecer de comentar a linha 853 do ion_auth_model
                );

                $group = array($this->input->post('perfil')); //Tem que ser array

                $dados_adicionais = html_escape($dados_adicionais);

                if ($this->ion_auth->register($username, $password, $email, $dados_adicionais, $group)) {

                    $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');
                } else {
                    $this->session->set_flashdata('error', 'Erro ao salvar os dados');
                }
                redirect('usuarios');
            } else {

                $data = array(
                    'titulo' => 'Cadastrar usuário',
                    'sub_titulo' => 'Cadastrando um novo usuário',
                    'icone' => 'ik ik-user-plus bg-blue',
                    'valor_btn' => 'Cadastrar',
                );

                $this->load->view('layout/header', $data);
                $this->load->view('usuarios/core');
                $this->load->view('layout/footer');
            }
        } else {
            //editar
            $usuario = $this->ion_auth->user($usuario_id)->row();

            if (!$this->ion_auth->user($usuario_id)->row()) {
                $this->session->set_flashdata('error', 'Usuário não encontrado');
                redirect('usuarios');
            } else {

                if ($this->session->userdata('user_id') != $usuario_id && !$this->ion_auth->is_admin()) {
                    $this->session->set_flashdata('error', 'Você não pode editar um usuário diferente do seu!');
                    redirect('/');
                }

                $perfil_atual = $this->ion_auth->get_users_groups($usuario_id)->row();

                $this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[3]|max_length[20]');
                $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[3]|max_length[50]');
                $this->form_validation->set_rules('username', 'Nome do usuário', 'trim|required|min_length[5]|max_length[100]|callback_check_username');
                $this->form_validation->set_rules('email', 'e-mail', 'trim|required|valid_email|min_length[4]|max_length[50]|callback_check_email');
                $this->form_validation->set_rules('password', 'Senha', 'min_length[4]|max_length[254]');
                $this->form_validation->set_rules('confirma_senha', 'Confirmação de senha', 'matches[password]');

                if ($this->form_validation->run()) {

                    $data = elements(array('first_name', 'last_name', 'email', 'username', 'password', 'active'), $this->input->post());

                    $data = html_escape($data);

                    if (!$this->ion_auth->is_admin()) {
                        unset($data['active']);
                    }

                    $password = $this->input->post('password'); ///VER ATUALIZAÇÃO DE SENHA

                    /* Remove do array o campo senha, caso a mesma não tenha sido passada */
                    if (!$password) {
                        unset($data['password']);
                    }

                    if ($this->ion_auth->update($usuario_id, $data)) {

                        $perfil_post = $this->input->post('perfil');

                        /* Se for passado o perfil no post, passa para a regra seguinte */
                        if ($perfil_post) {

                            /* Se for diferente, atualiza */
                            if ($perfil_atual->id != $perfil_post) {

                                $this->ion_auth->remove_from_group($perfil_atual->id, $usuario_id);
                                $this->ion_auth->add_to_group($perfil_post, $usuario_id);
                            }
                        }

                        $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso!');
                    } else {

                        $this->session->set_flashdata('error', 'Erro ao salvar os dados');
                    }

                    if ($this->ion_auth->is_admin($usuario_id)) {
                        redirect('usuarios');
                    } else {
                        redirect('/');
                    }
                } else {
                    //erro de validação
                    $data = array(
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
            $this->session->set_flashdata('warning', 'Você não tem permissão para acessar esse menu');
            redirect('/');
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

        if ($this->Core_model->get_by_id('users', array('email' => $email, 'id !=' => $usuario_id))) {

            $this->form_validation->set_message('check_email', 'Esse e-mail já existe. Ele deve ser único');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_username($username) {

        $usuario_id = $this->input->post('user_id');

        if ($this->Core_model->get_by_id('users', array('username' => $username, 'id !=' => $usuario_id))) {

            $this->form_validation->set_message('check_username', 'Esse usuário já existe. Ele deve ser único');

            return FALSE;
        } else {

            return TRUE;
        }
    }
}
