<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        $data = array(
            'titulo' => 'Login',
        );

        $this->load->view('layout/header', $data);
        $this->load->view('login/index');
        $this->load->view('layout/footer');
    }

    public function auth() {

        $email = $this->security->xss_clean($this->input->post('email'));
        $senha = $this->security->xss_clean($this->input->post('senha'));
        $remember = FALSE;

        if ($this->ion_auth->login($email, $senha, $remember)) {
            redirect('/');
        } else {
            $this->session->set_flashdata('error', 'E-mail e/ou senha incorretos');
            redirect($this->router->fetch_class());
        }
    }

    public function logout() {
        $this->ion_auth->logout();
        redirect($this->router->fetch_class());
    }
}
