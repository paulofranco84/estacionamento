<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">

    <?php $this->load->view('layout/sidebar'); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="<?php echo $icone ?>"></i>
                            <div class="d-inline">
                                <h5><?php echo $titulo ?></h5>
                                <span><?php echo $sub_titulo ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a data-toggle="tooltip" data-placement="bottom" title="Home" href="<?php echo base_url('/') ?>"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-block">
                            <a data-toggle="tooltip" data-placement="left" title="Cadastrar mensalidade" class="btn btn-primary float-right" href="<?php echo base_url($this->router->fetch_class() . '/core'); ?>">+&nbsp;Novo</a>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="table-responsive-sm">
                                    <table class="data-table table dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th class="all">#</th>
                                                <th class="all">Nome</th>
                                                <th class="all">CPF</th>
                                                <th class="all">Categoria</th>
                                                <th class="all">Valor</th>
                                                <th class="all">Data vencimento</th>
                                                <th class="all">Data pagamento</th>
                                                <th class="all text-center">Status</th>
                                                <th class="all nosort text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($mensalidades as $mensalidade) : ?>
                                                <tr>
                                                    <td><?php echo $mensalidade->mensalidade_id ?></td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="Visualizar mensalista" class="btn btn-sm btn-link" href="<?php echo base_url('mensalistas/core/' . $mensalidade->mensalista_id); ?>"><i class="ik ik-eye"></i><?php echo $mensalidade->mensalista_nome ?></a></td>
                                                    <td><?php echo $mensalidade->mensalista_cpf ?></td>
                                                    <td><?php echo $mensalidade->mensalista_categoria ?></td>
                                                    <td><?php echo 'R$&nbsp;' . $mensalidade->mensalista_valor_mensalidade ?></td>
                                                    <td><?php echo formata_data_banco_sem_hora($mensalidade->mensalidade_data_vencimento) ?></td>
                                                    <td><?php echo ($mensalidade->mensalidade_status == 1 ? formata_data_banco_com_hora($mensalidade->mensalidade_data_pagamento) : 'Em Aberto'); ?></td>

                                                    <td class="text-center">
                                                        <?php
                                                        if ($mensalidade->mensalidade_status == 1) {
                                                            echo '<span class="badge badge-pill badge-success small">Paga</span>';
                                                        } else if (strtotime($mensalidade->mensalidade_data_vencimento) > strtotime(date('Y-m-d'))) {
                                                            echo '<span class="badge badge-pill badge-primary small">A receber</span>';
                                                        } else if (strtotime($mensalidade->mensalidade_data_vencimento) == strtotime(date('Y-m-d'))) {
                                                            echo '<span class="badge badge-pill badge-navy text-white">Vence hoje</span>';
                                                        } else {
                                                            echo '<span class="badge badge-pill badge-danger">Vencida</span>';
                                                        }
                                                        ?>
                                                    </td>

                                                    <td class="table-actions text-center">
                                                        <?php if ($mensalidade->mensalidade_status == 0) : ?>

                                                            <a data-toggle="tooltip" data-placement="bottom" title="Editar" href="<?php echo base_url('mensalidades/core/' . $mensalidade->mensalidade_id); ?>" class="btn btn-icon btn-primary mr-2"><i class="ik ik-edit-2"></i></a>

                                                        <?php else : ?>

                                                            <a data-toggle="tooltip" data-placement="bottom" title="Visualizar" href="<?php echo base_url('mensalidades/core/' . $mensalidade->mensalidade_id); ?>" class="btn btn-icon btn-success mr-2"><i class="ik ik-eye text-white"></i></a>

                                                        <?php endif; ?>
                                                        <span data-toggle="tooltip" data-placement="bottom" title="Excluir"><a href="javascript:void(0)" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#mensalidade-<?php echo $mensalidade->mensalidade_id; ?>"><i class="ik ik-trash-2"></i></a></span>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" id="mensalidade-<?php echo $mensalidade->mensalidade_id; ?>" tabindex="-1" role="dialog" aria-labelledby="mensalidade-<?php echo $mensalidade->mensalidade_id; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="demoModalLabel"><i class="fas fa-exclamation-triangle text-danger"></i>&nbsp;&nbsp;Exclusão de registro!</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Se deseja excluir o registro, clique em <strong>Sim, excluir!</strong></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button data-toggle="tooltip" data-placement="bottom" title="Cancelar exclusão" type="button" class="btn btn-secondary" data-dismiss="modal">Não, voltar.</button>
                                                                <a data-toggle="tooltip" data-placement="bottom" title="Excluir" class="btn btn-danger text-white" href="<?php echo base_url($this->router->fetch_class() . '/del/' . $mensalidade->mensalidade_id); ?>">Sim, excluir!</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>