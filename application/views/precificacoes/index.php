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
                            <a data-toggle="tooltip" data-placement="left" title="Cadastrar precificação" class="btn btn-primary float-right" href="<?php echo base_url($this->router->fetch_class() . '/core'); ?>">+&nbsp;Novo</a>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="table-responsive-sm">
                                    <table class="data-table table dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th class="pl-25">#</th>
                                                <th>Categoria</th>
                                                <th>Valor Hora</th>
                                                <th>Valor Mensalidade</th>
                                                <th class="text-center">Número vagas</th>
                                                <th>Ativa</th>
                                                <th class="nosort text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($precificacoes as $categoria) : ?>
                                                <tr>
                                                    <td class="pl-25"><?php echo $categoria->precificacao_id ?></td>
                                                    <td><?php echo $categoria->precificacao_categoria ?></td>
                                                    <td>R$&nbsp;<?php echo $categoria->precificacao_valor_hora ?></td>
                                                    <td>R$&nbsp;<?php echo $categoria->precificacao_valor_mensalidade ?></td>
                                                    <td class="text-center"><?php echo $categoria->precificacao_numero_vagas ?></td>
                                                    <td><?php echo ($categoria->precificacao_ativa == 1 ? '<span class="badge badge-pill badge-success mb-1"><i class="fas fa-lock-open"></i>&nbsp;Sim</span>' : '<span class="badge badge-pill badge-danger mb-1"><i class="fas fa-lock"></i>&nbsp;Não</span>') ?></td>
                                                    <td>
                                                        <div class="table-actions text-center">
                                                            <a data-toggle="tooltip" data-placement="bottom" title="Editar" class="btn btn-icon btn-primary text-white mr-2" href="<?php echo base_url($this->router->fetch_class() . '/core/' . $categoria->precificacao_id); ?>"><i class="ik ik-edit-2"></i></a>
                                                            <span data-toggle="tooltip" data-placement="bottom" title="Excluir"><button type="button" class="btn btn-icon btn-danger text-white" data-toggle="modal" data-target="#categoria-<?php echo $categoria->precificacao_id; ?>"><i class="ik ik-trash-2"></i></button></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="categoria-<?php echo $categoria->precificacao_id; ?>" tabindex="-1" role="dialog" aria-labelledby="categoria-<?php echo $categoria->precificacao_id; ?>" aria-hidden="true">
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
                                                                <a data-toggle="tooltip" data-placement="bottom" title="Excluir" class="btn btn-danger text-white" href="<?php echo base_url($this->router->fetch_class() . '/del/' . $categoria->precificacao_id); ?>">Sim, excluir!</a>
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