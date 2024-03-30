<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mensalidades_model extends CI_Model {

    public function get_all() {

        $this->db->select('mensalidades.*');
        $this->db->select('precificacoes.precificacao_id');
        $this->db->select('precificacoes.precificacao_categoria as mensalista_categoria');
        $this->db->select('precificacoes.precificacao_valor_mensalidade as mensalista_valor_mensalidade');
        $this->db->select('mensalistas.mensalista_id');
        $this->db->select('mensalistas.mensalista_nome');
        $this->db->select('mensalistas.mensalista_cpf');
        $this->db->select('mensalistas.mensalista_dia_vencimento');

        $this->db->join('precificacoes', 'precificacao_id = mensalidade_precificacao_id', 'LEFT');
        $this->db->join('mensalistas', 'mensalista_id = mensalidade_mensalista_id', 'LEFT');

        return $this->db->get('mensalidades')->result();
    }
}
