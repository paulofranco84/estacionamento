<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mensalistas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        $this->load->model('core_model');
    }

    public function index() {

        $data = array(
            'titulo' => 'Mensalistas',
            'sub_titulo' => 'Listando todos os mensalistas cadastrados',
            'icone' => 'fas fa-users bg-blue',
            'styles' => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
            'mensalistas' => $this->core_model->get_all('mensalistas'),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('mensalistas/index');
        $this->load->view('layout/footer');
    }

    public function core($mensalista_id = NULL) {

        if (!$mensalista_id) {

            //Cadastra

            $this->form_validation->set_rules('mensalista_nome', 'Nome', 'required|min_length[4]|max_length[45]');
            $this->form_validation->set_rules('mensalista_sobrenome', 'Sobrenome', 'required|min_length[4]|max_length[145]');
            $this->form_validation->set_rules('mensalista_data_nascimento', 'Data Nascimento', 'required');
            $this->form_validation->set_rules('mensalista_cpf', 'CPF', 'required|callback_check_documento_valido');
            $this->form_validation->set_rules('mensalista_rg', 'RG', 'trim|required|is_unique[mensalistas.mensalista_rg]');
            $this->form_validation->set_rules('mensalista_email', 'E-mail', 'required|valid_email|is_unique[mensalistas.mensalista_email]');
            $this->form_validation->set_rules('mensalista_telefone_fixo', 'Telefone fixo', 'is_unique[mensalistas.mensalista_telefone_fixo]');
            $this->form_validation->set_rules('mensalista_telefone_movel', 'Celular', 'is_unique[mensalistas.mensalista_telefone_movel]');
            $this->form_validation->set_rules('mensalista_cep', 'CEP', 'required');
            $this->form_validation->set_rules('mensalista_endereco', 'Endereço', 'required|min_length[5]|max_length[155]');
            $this->form_validation->set_rules('mensalista_numero_endereco', 'Número', 'required|max_length[20]');
            $this->form_validation->set_rules('mensalista_bairro', 'Bairro', 'required|min_length[5]|max_length[45]');
            $this->form_validation->set_rules('mensalista_cidade', 'Cidade', 'required|min_length[5]|max_length[45]');
            $this->form_validation->set_rules('mensalista_estado', 'Estado', 'required|max_length[2]');
            $this->form_validation->set_rules('mensalista_dia_vencimento', 'Dia vencimento', 'required|exact_length[2]|greater_than[0]|less_than[32]|integer');

            if ($this->form_validation->run()) {

                $data = elements(
                    array(
                        'mensalista_nome',
                        'mensalista_sobrenome',
                        'mensalista_data_nascimento',
                        'mensalista_cpf',
                        'mensalista_rg',
                        'mensalista_email',
                        'mensalista_telefone_fixo',
                        'mensalista_telefone_movel',
                        'mensalista_cep',
                        'mensalista_endereco',
                        'mensalista_numero_endereco',
                        'mensalista_bairro',
                        'mensalista_cidade',
                        'mensalista_estado',
                        'mensalista_complemento',
                        'mensalista_ativo',
                        'mensalista_dia_vencimento',
                        'mensalista_obs',
                    ),
                    $this->input->post()
                );

                $data = html_escape($data);

                $this->core_model->insert('mensalistas', $data);

                redirect($this->router->fetch_class());
            } else {

                /* Erro de validação */

                $data = array(
                    'titulo' => 'Cadastrar mensalista',
                    'sub_titulo' => 'Cadastrando um novo mensalista',
                    'icone' => 'fas fa-user-plus bg-blue',
                    'valor_btn' => 'Cadastrar',
                    'scripts' => array(
                        'plugins/Mask/jquery.mask.min.js',
                        'plugins/Mask/custom.js',
                        'plugins/Mask/mensalista.js'
                    ),
                );

                $this->load->view('layout/header', $data);
                $this->load->view('mensalistas/core');
                $this->load->view('layout/footer');
            }
        } else {

            //Atualiza

            if (!$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))) {

                $this->session->set_flashdata('error', 'Mensalista não encontrado');
                redirect($this->router->fetch_class());
            } else {

                $this->form_validation->set_rules('mensalista_nome', 'Nome', 'required|min_length[4]|max_length[45]');
                $this->form_validation->set_rules('mensalista_sobrenome', 'Sobrenome', 'required|min_length[4]|max_length[145]');
                $this->form_validation->set_rules('mensalista_data_nascimento', 'Data Nascimento', 'required');
                $this->form_validation->set_rules('mensalista_cpf', 'CPF', 'required|callback_check_documento_valido');
                $this->form_validation->set_rules('mensalista_rg', 'RG', 'required|callback_check_rg');
                $this->form_validation->set_rules('mensalista_email', 'E-Mail', 'required|valid_email|callback_check_email');
                /* Trecho que verifica no banco apenas se foi inputado alguma coisa nos campos correspondentes */
                /* Tem que ser assim, pois o campo não é obrigatório. */
                /* Na opção de 'Cadastrar' caso não seja inputado algo, será salvo o campo em branco e o callback retorna FALSE */
                $mensalista_telefone_fixo = $this->input->post('mensalista_telefone_fixo');
                $mensalista_telefone_movel = $this->input->post('mensalista_telefone_movel');

                if (!empty($mensalista_telefone_fixo)) {
                    $this->form_validation->set_rules('mensalista_telefone_fixo', 'Telefone fixo', 'callback_check_telefone_fixo');
                }

                if (!empty($mensalista_telefone_movel)) {
                    $this->form_validation->set_rules('mensalista_telefone_movel', 'Celular', 'callback_check_telefone_movel');
                }
                /* Fim */

                $this->form_validation->set_rules('mensalista_cep', 'CEP', 'required');
                $this->form_validation->set_rules('mensalista_endereco', 'Endereço', 'required|min_length[5]|max_length[155]');
                $this->form_validation->set_rules('mensalista_numero_endereco', 'Número', 'required|max_length[20]');
                $this->form_validation->set_rules('mensalista_bairro', 'Bairro', 'required|min_length[5]|max_length[45]');
                $this->form_validation->set_rules('mensalista_cidade', 'Cidade', 'required|min_length[5]|max_length[45]');
                $this->form_validation->set_rules('mensalista_estado', 'Estado', 'required|max_length[2]');
                $this->form_validation->set_rules('mensalista_dia_vencimento', 'Dia vencimento', 'required|exact_length[2]|greater_than[0]|less_than[32]|integer');

                if ($this->form_validation->run()) {

                    if ($mensalista_ativo == 0) {
                        if ($this->db->table_exists('mensalidades')) {
                            if ($this->core_model->get_by_id('mensalidades', array('mensalidade_mensalista_id' => $mensalista_id))) {
                                $this->session->set_flashdata('error', 'Existem mensalidades cadastradas para este mensalista');
                                redirect($this->router->fetch_class());
                            }
                        }
                    }

                    $data = elements(
                        array(
                            'mensalista_nome',
                            'mensalista_sobrenome',
                            'mensalista_data_nascimento',
                            'mensalista_cpf',
                            'mensalista_rg',
                            'mensalista_email',
                            'mensalista_telefone_fixo',
                            'mensalista_telefone_movel',
                            'mensalista_cep',
                            'mensalista_endereco',
                            'mensalista_numero_endereco',
                            'mensalista_bairro',
                            'mensalista_cidade',
                            'mensalista_estado',
                            'mensalista_complemento',
                            'mensalista_ativo',
                            'mensalista_dia_vencimento',
                            'mensalista_obs',
                        ),
                        $this->input->post()
                    );

                    $data = html_escape($data);

                    $this->core_model->update('mensalistas', $data, array('mensalista_id' => $mensalista_id));

                    redirect($this->router->fetch_class());
                } else {

                    /* Erro de validação */

                    $data = array(
                        'titulo' => 'Editar mensalista',
                        'sub_titulo' => 'Editando o mensalista',
                        'icone' => 'fas fa-user-edit bg-blue',
                        'valor_btn' => 'Atualizar',
                        'scripts' => array(
                            'plugins/Mask/jquery.mask.min.js',
                            'plugins/Mask/custom.js',
                            'plugins/Mask/mensalista.js'
                        ),
                        'mensalista' => $this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id)),
                    );

                    $this->load->view('layout/header', $data);
                    $this->load->view('mensalistas/core');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function del($mensalista_id = NULL) {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('warning', 'Você não pode excluir mensalistas');
            redirect($this->router->fetch_class());
        }

        if (!$mensalista_id || !$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))) {

            $this->session->set_flashdata('error', 'Mensalista não encontrado');
            redirect($this->router->fetch_class());
        }

        if ($this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id, 'mensalista_ativo' => 1))) {

            $this->session->set_flashdata('error', 'Não é possível excluir um mensalista ativo');
            redirect($this->router->fetch_class());
        }

        if ($this->core_model->get_by_id('mensalidades', array('mensalidades_mensalista_id' => $mensalista_id))) {

            $this->session->set_flashdata('error', 'Não é possível excluir esse mensalista pois existem mensalidades cadastradas');
            redirect($this->router->fetch_class());
        }

        $this->core_model->delete('mensalistas', array('mensalista_id' => $mensalista_id));
        redirect($this->router->fetch_class());
    }

    public function check_documento_valido($mensalista_cpf) {

        $mensalista_id = $this->input->post('mensalista_id');

        if (!$mensalista_id) {

            if ($this->core_model->get_by_id('mensalistas', array('mensalista_cpf' => $mensalista_cpf))) {

                $this->form_validation->set_message('check_documento_valido', 'Esse CPF já exite');
                return FALSE;
            }
        }

        $mensalista_cpf = str_pad(preg_replace('/[^0-9]/', '', $mensalista_cpf), 11, '0', STR_PAD_LEFT);
        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($mensalista_cpf) != 11 || $mensalista_cpf == '00000000000' || $mensalista_cpf == '11111111111' || $mensalista_cpf == '22222222222' || $mensalista_cpf == '33333333333' || $mensalista_cpf == '44444444444' || $mensalista_cpf == '55555555555' || $mensalista_cpf == '66666666666' || $mensalista_cpf == '77777777777' || $mensalista_cpf == '88888888888' || $mensalista_cpf == '99999999999') {

            $this->form_validation->set_message('check_documento_valido', 'Digite um CPF válido');
            return FALSE;
        } else {
            // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $mensalista_cpf{
                    $c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($mensalista_cpf{
                $c} != $d) {
                    $this->form_validation->set_message('check_documento_valido', 'Digite um CPF válido');
                    return FALSE;
                }
            }
            return TRUE;
        }
    }

    public function check_email($mensalista_email) {

        $mensalista_id = $this->input->post('mensalista_id');

        if ($this->core_model->get_by_id('mensalistas', array('mensalista_email' => $mensalista_email, 'mensalista_id !=' => $mensalista_id))) {

            $this->form_validation->set_message('check_email', 'Esse e-mail já existe');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_telefone_fixo($mensalista_telefone_fixo) {

        $mensalista_id = $this->input->post('mensalista_id');

        if ($this->core_model->get_by_id('mensalistas', array('mensalista_telefone_fixo' => $mensalista_telefone_fixo, 'mensalista_id !=' => $mensalista_id))) {

            $this->form_validation->set_message('check_telefone_fixo', 'Esse telefone já existe');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_telefone_movel($mensalista_telefone_movel) {

        $mensalista_id = $this->input->post('mensalista_id');

        if ($this->core_model->get_by_id('mensalistas', array('mensalista_telefone_movel' => $mensalista_telefone_movel, 'mensalista_id !=' => $mensalista_id))) {

            $this->form_validation->set_message('check_telefone_movel', 'Esse telefone já existe');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_rg($mensalista_rg) {

        $mensalista_id = $this->input->post('mensalista_id');

        if ($this->core_model->get_by_id('mensalistas', array('mensalista_rg' => $mensalista_rg, 'mensalista_id !=' => $mensalista_id))) {

            $this->form_validation->set_message('check_rg', 'Essa informação já existe');

            return FALSE;
        } else {

            return TRUE;
        }
    }
}
