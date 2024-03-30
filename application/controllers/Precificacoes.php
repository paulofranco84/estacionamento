<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Precificacoes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('warning', 'Você não tem permissão para acessar esse menu');
            redirect('/');
        }

        $this->load->model('core_model');
    }

    public function index() {

        $data = array(
            'titulo'        => 'Precificações',
            'sub_titulo'    => 'Listando as precificações cadastradas',
            'icone'         =>  'fas fa-dollar-sign bg-blue',
            'usuarios'      => $this->ion_auth->users()->result(),
            'styles'        => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            ),
            'scripts'       => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
            'precificacoes' => $this->core_model->get_all('precificacoes'),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('precificacoes/index');
        $this->load->view('layout/footer');
    }

    public function core($precificacao_id = NULL) {


        if (!$precificacao_id) {

            //Cadastra

            $this->form_validation->set_rules('precificacao_categoria', 'Categoria', 'required|min_length[4]|max_length[50]|is_unique[precificacoes.precificacao_categoria]');
            $this->form_validation->set_rules('precificacao_valor_hora', '', 'required');
            $this->form_validation->set_rules('precificacao_valor_mensalidade', '', 'required');
            $this->form_validation->set_rules('precificacao_numero_vagas', '', 'required|greater_than[0]|integer');

            if ($this->form_validation->run()) {

                $data = elements(
                    array(
                        'precificacao_categoria',
                        'precificacao_valor_hora',
                        'precificacao_valor_mensalidade',
                        'precificacao_numero_vagas',
                        'precificacao_ativa',
                    ),
                    $this->input->post()
                );

                $data = html_escape($data);

                $this->core_model->insert('precificacoes', $data);

                redirect($this->router->fetch_class());
            } else {

                $data = array(
                    'titulo' => 'Cadastrar precificação',
                    'sub_titulo' => 'Cadastrando uma nova precificação',
                    'icone' => 'fas fa-dollar-sign bg-blue',
                    'valor_btn' => 'Cadastrar',
                    'scripts' => array(
                        'js/Mask/jquery.mask.min.js',
                        'js/Mask/custom.js',
                    ),
                );

                /* Erro de validação */
                $this->load->view('layout/header', $data);
                $this->load->view('precificacoes/core');
                $this->load->view('layout/footer');
            }
        } else {

            //Atualiza

            if (!$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))) {

                $this->session->set_flashdata('error', 'Precificação não encontrada');
                redirect('precificacoes');
            } else {

                $this->form_validation->set_rules('precificacao_categoria', 'Categoria', 'required|min_length[4]|max_length[50]|callback_check_precificacao_categoria');
                $this->form_validation->set_rules('precificacao_valor_hora', '', 'required');
                $this->form_validation->set_rules('precificacao_valor_mensalidade', '', 'required');
                $this->form_validation->set_rules('precificacao_numero_vagas', '', 'required|greater_than[0]|integer');

                if ($this->form_validation->run()) {

                    $precificacao_ativa = $this->input->post('precificacao_ativa');

                    if ($precificacao_ativa == 0) {

                        if ($this->db->table_exists('estacionar')) {

                            if ($this->core_model->get_by_id('estacionar', array('estacionar_precificacao_id' => $precificacao_id, 'estacionar_status' => 0))) {

                                $this->session->set_flashdata('error', 'Existem veículos estacionados com esta categoria');
                                redirect($this->router->fetch_class());
                            }
                        }
                    }

                    if ($precificacao_ativa == 0) {

                        if ($this->db->table_exists('mensalidades')) {

                            if ($this->core_model->get_by_id('mensalidades', array('mensalidade_precificacao_id' => $precificacao_id, 'mensalidade_status' => 0))) {

                                $this->session->set_flashdata('error', 'Existem mensalidades em aberto cadastradas com esta categoria');
                                redirect($this->router->fetch_class());
                            }
                        }
                    }

                    $data = elements(
                        array(
                            'precificacao_categoria',
                            'precificacao_valor_hora',
                            'precificacao_valor_mensalidade',
                            'precificacao_numero_vagas',
                            'precificacao_ativa',
                        ),
                        $this->input->post()
                    );

                    $data = html_escape($data);

                    $this->core_model->update('precificacoes', $data, array('precificacao_id' => $precificacao_id));

                    redirect('precificacoes');
                } else {

                    $data = array(
                        'titulo' => 'Editar precificação',
                        'sub_titulo' => 'Editando uma precificação',
                        'icone' => 'fas fa-dollar-sign bg-blue',
                        'scripts' => array(
                            'js/Mask/jquery.mask.min.js',
                            'js/Mask/custom.js',
                        ),
                        'valor_btn' => 'Atualizar',
                        'precificacao' => $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id)),
                    );

                    /* Erro de validação */
                    $this->load->view('layout/header', $data);
                    $this->load->view('precificacoes/core');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function check_precificacao_categoria($precificacao_categoria) {

        $precificacao_id = $this->input->post('precificacao_id');

        if ($this->core_model->get_by_id('precificacoes', array('precificacao_categoria' => $precificacao_categoria, 'precificacao_id !=' => $precificacao_id))) {

            $this->form_validation->set_message('check_precificacao_categoria', 'Essa categoria já existe');

            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function del($precificacao_id = NULL) {

        if (!$precificacao_id || !$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))) {

            $this->session->set_flashdata('error', 'Precificação não encontrada');
            redirect($this->router->fetch_class());
        }

        if ($this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id, 'precificacao_ativa' => 1))) {

            $this->session->set_flashdata('error', 'Precificação ativa não pode ser excluída');
            redirect($this->router->fetch_class());
        }

        $this->core_model->delete('precificacoes', array('precificacao_id' => $precificacao_id));

        redirect($this->router->fetch_class());
    }
}
