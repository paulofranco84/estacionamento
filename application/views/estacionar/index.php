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
                            <a data-toggle="tooltip" data-placement="left" title="Cadastrar ticket" class="btn btn-primary float-right" href="<?php echo base_url($this->router->fetch_class() . '/core'); ?>">+&nbsp;Novo</a>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="table-responsive-sm">
                                    <table class="data-table table dataTabe no-footer" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Categoria</th>
                                                <th>Valor hora</th>
                                                <th class="text-center">Placa</th>
                                                <th class="text-center">Status</th>
                                                <th>Forma de pagamento</th>
                                                <th class="nosort text-center">Ações</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach ($veiculos_estacionados as $veiculo) : ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $veiculo->estacionar_id ?></td>
                                                    <td><?php echo $veiculo->veiculo_categoria; ?></td>
                                                    <td><?php echo 'R$&nbsp;' . $veiculo->valor_hora; ?></td>
                                                    <td class="text-center"><?php echo $veiculo->estacionar_placa_veiculo ?></td>
                                                    <td class="text-center pr-15"><?php echo ($veiculo->estacionar_status == 1 ? '<span class="badge badge-pill badge-success"><i class="fas fa-lock"></i>&nbsp;Paga</span>' : '<span class="badge badge-pill badge-warning"><i class="fas fa-lock-open"></i>&nbsp;Em Aberto</span>') ?></td>
                                                    <td><?php echo (!empty($veiculo->forma_pagamento) ? $veiculo->forma_pagamento : 'Não informada'); ?></td>
                                                    <td class="text-center">
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Imprimir" href="<?php echo base_url('estacionar/imprimir/' . $veiculo->estacionar_id); ?>" class="btn btn-icon bg-blue mr-2"><i class="ik ik-printer text-white"></i></a>

                                                        <?php if ($veiculo->estacionar_status == 0) : ?>

                                                            <a data-toggle="tooltip" data-placement="bottom" title="Editar" href="<?php echo base_url('estacionar/core/' . $veiculo->estacionar_id); ?>" class="btn btn-icon btn-primary mr-2"><i class="ik ik-edit-2"></i></a>

                                                        <?php else : ?>

                                                            <a data-toggle="tooltip" data-placement="bottom" title="Visualizar" href="<?php echo base_url('estacionar/core/' . $veiculo->estacionar_id); ?>" class="btn btn-icon btn-success mr-2"><i class="ik ik-eye"></i></a>

                                                        <?php endif ?>

                                                        <span data-toggle="tooltip" data-placement="bottom" title="Excluir"><a href="javascript:void(0)" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#estacionar-<?php echo $veiculo->estacionar_id; ?>"><i class="ik ik-trash-2"></i></a></span>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" id="estacionar-<?php echo $veiculo->estacionar_id; ?>" tabindex="-1" role="dialog" aria-labelledby="estacionar-<?php echo $veiculo->estacionar_id; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="demoModalLabel"><i class="ik ik-alert-octagon text-danger"></i>&nbsp;&nbsp;Exclusão de registro!</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Se deseja excluir o registro, clique em <strong>Sim, excluir!</strong></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button data-toggle="tooltip" data-placement="bottom" title="Cancelar exclusão" type="button" class="btn btn-secondary" data-dismiss="modal">Não, voltar.</button>
                                                                <a data-toggle="tooltip" data-placement="bottom" title="Excluir" class="btn btn-danger text-white" href="<?php echo base_url($this->router->fetch_class() . '/del/' . $veiculo->estacionar_id); ?>">Sim, excluir!</a>
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

            <div class="row clearfix">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header d-block text-center">
                            <h5 class="text-uppercase h6">Situação das vagas</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">


                                <div class="col-md-3 mb-35 py-1">
                                    <p class="text-center text-uppercase small">Veículo Pequeno<?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? '&nbsp;<b><span class="text-danger"><i class="fas fa-ban"></i>&nbsp;Desativada</span></b>' : ''); ?></p>
                                    <div class="widget-body text-center">
                                        <div class="content">
                                            <i class="fas fa-car-side fa-3x text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="">

                                        <ul class="list-inline mt-15 text-center">

                                            <?php $ocupadas = array(); ?>

                                            <?php foreach ($vagas_ocupadas_pequeno as $vaga) : ?>

                                                <?php $ocupadas[] = $vaga->estacionar_numero_vaga; ?>
                                                <?php $ocupadas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo; ?>

                                            <?php endforeach; ?>


                                            <?php for ($i = 1; $i <= $numero_vagas_pequeno->vagas; $i++) : ?>

                                                <?php if (in_array($i, $ocupadas)) : ?>

                                                    <li class="list-inline-item">
                                                        <div class="widget social-widget bg-warning vaga">
                                                            <div class="widget-body">
                                                                <div class="content" data-toggle="tooltip" data-placement="top" title="" data-original-title="Placa&nbsp;<?php echo $ocupadas[$i] ?>" title="Ocupada">

                                                                    <i class="fas fa-car-side fa-lg"></i>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>


                                                <?php else : ?>

                                                    <li class="list-inline-item">
                                                        <div class="widget social-widget <?php echo ($numero_vagas_pequeno->precificacao_ativa == 1 ? 'bg-success' : 'bg-secondary')  ?> vaga">
                                                            <div class="widget-body">
                                                                <div class="content" title="Vaga livre">

                                                                    <div title="" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo ($numero_vagas_pequeno->precificacao_ativa == 1 ? 'Vaga livre' : 'Desativada')  ?>" class="text">
                                                                        <?php echo ($numero_vagas_pequeno->precificacao_ativa == 1 ? $i : '<i class="fas fa-ban"></i>')  ?>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>


                                                <?php endif ?>

                                            <?php endfor; ?>
                                        </ul>
                                    </div>
                                </div>


                                <div class="col-md-3 mb-35 py-1">
                                    <p class="text-center text-uppercase small">Veículo Médio<?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? '&nbsp;<b><span class="text-danger"><i class="fas fa-ban"></i>&nbsp;Desativada</span></b>' : ''); ?></p>
                                    <div class="widget-body text-center">
                                        <div class="content">
                                            <i class="fas fa-truck-monster fa-3x text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="">

                                        <ul class="list-inline mt-15 text-center">

                                            <?php $ocupadas = array(); ?>

                                            <?php foreach ($vagas_ocupadas_medio as $vaga) : ?>

                                                <?php $ocupadas[] = $vaga->estacionar_numero_vaga; ?>
                                                <?php $ocupadas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo; ?>

                                            <?php endforeach; ?>


                                            <?php for ($i = 1; $i <= $numero_vagas_medio->vagas; $i++) : ?>

                                                <?php if (in_array($i, $ocupadas)) : ?>

                                                    <li class="list-inline-item">

                                                        <div class="widget social-widget bg-warning vaga">
                                                            <div class="widget-body">
                                                                <div class="content" data-toggle="tooltip" data-placement="top" title="" data-original-title="Placa&nbsp;<?php echo $ocupadas[$i] ?>" title="Ocupada">

                                                                    <i class="fas fa-truck-monster fa-lg"></i>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>


                                                <?php else : ?>

                                                    <li class="list-inline-item">
                                                        <div class="widget social-widget <?php echo ($numero_vagas_medio->precificacao_ativa == 1 ? 'bg-success' : 'bg-secondary')  ?> vaga">
                                                            <div class="widget-body">
                                                                <div class="content" title="Vaga livre">

                                                                    <div title="" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo ($numero_vagas_medio->precificacao_ativa == 1 ? 'Vaga livre' : 'Desativada')  ?>" class="text">
                                                                        <?php echo ($numero_vagas_medio->precificacao_ativa == 1 ? $i : '<i class="fas fa-ban"></i>')  ?>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>


                                                <?php endif ?>

                                            <?php endfor; ?>
                                        </ul>
                                    </div>
                                </div>


                                <div class="col-md-3 mb-35 py-1">
                                    <p class="text-center text-uppercase small">Veículo Grande<?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? '&nbsp;<b><span class="text-danger"><i class="fas fa-ban"></i>&nbsp;Desativada</span></b>' : ''); ?></p>
                                    <div class="widget-body text-center">
                                        <div class="content">
                                            <i class="fas fa-truck fa-3x text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="">

                                        <ul class="list-inline mt-15 text-center">

                                            <?php $ocupadas = array(); ?>

                                            <?php foreach ($vagas_ocupadas_grande as $vaga) : ?>

                                                <?php $ocupadas[] = $vaga->estacionar_numero_vaga; ?>
                                                <?php $ocupadas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo; ?>

                                            <?php endforeach; ?>


                                            <?php for ($i = 1; $i <= $numero_vagas_grande->vagas; $i++) : ?>

                                                <?php if (in_array($i, $ocupadas)) : ?>

                                                    <li class="list-inline-item">
                                                        <div class="widget social-widget bg-warning vaga">
                                                            <div class="widget-body">
                                                                <div class="content" data-toggle="tooltip" data-placement="top" title="" data-original-title="Placa&nbsp;<?php echo $ocupadas[$i] ?>" title="Ocupada">

                                                                    <i class="fas fa-truck fa-lg"></i>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>


                                                <?php else : ?>

                                                    <li class="list-inline-item">
                                                        <div class="widget social-widget <?php echo ($numero_vagas_grande->precificacao_ativa == 1 ? 'bg-success' : 'bg-secondary')  ?> vaga">
                                                            <div class="widget-body">
                                                                <div class="content" title="Vaga livre">

                                                                    <div title="" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo ($numero_vagas_grande->precificacao_ativa == 1 ? 'Vaga livre' : 'Desativada')  ?>" class="text">
                                                                        <?php echo ($numero_vagas_grande->precificacao_ativa == 1 ? $i : '<i class="fas fa-ban"></i>')  ?>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>


                                                <?php endif ?>

                                            <?php endfor; ?>
                                        </ul>
                                    </div>
                                </div>


                                <div class="col-md-3 mb-35 py-1">
                                    <p class="text-center text-uppercase small">Veículo Moto<?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? '&nbsp;<b><span class="text-danger"><i class="fas fa-ban"></i>&nbsp;Desativada</span></b>' : ''); ?></p>
                                    <div class="widget-body text-center">
                                        <div class="content">
                                            <i class="fas fa-motorcycle fa-3x text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="">

                                        <ul class="list-inline mt-15 text-center">

                                            <?php $ocupadas = array(); ?>

                                            <?php foreach ($vagas_ocupadas_moto as $vaga) : ?>

                                                <?php $ocupadas[] = $vaga->estacionar_numero_vaga; ?>
                                                <?php $ocupadas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo; ?>


                                            <?php endforeach; ?>

                                            <?php
                                            //echo '<pre>';
                                            //print_r($ocupadas);
                                            ?>


                                            <?php for ($i = 1; $i <= $numero_vagas_moto->vagas; $i++) : ?>

                                                <?php if (in_array($i, $ocupadas)) : ?>

                                                    <li class="list-inline-item">
                                                        <div class="widget social-widget bg-warning vaga">
                                                            <div class="widget-body">
                                                                <div class="content" data-toggle="tooltip" data-placement="top" title="" data-original-title="Placa&nbsp;<?php echo $ocupadas[$i] ?>" title="Ocupada">

                                                                    <i class="fas fa-motorcycle fa-lg"></i>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>


                                                <?php else : ?>

                                                    <li class="list-inline-item">
                                                        <div class="widget social-widget <?php echo ($numero_vagas_moto->precificacao_ativa == 1 ? 'bg-success' : 'bg-secondary')  ?> vaga">
                                                            <div class="widget-body">
                                                                <div class="content" title="Vaga livre">

                                                                    <div title="" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo ($numero_vagas_moto->precificacao_ativa == 1 ? 'Vaga livre' : 'Desativada')  ?>" class="text">
                                                                        <?php echo ($numero_vagas_moto->precificacao_ativa == 1 ? $i : '<i class="fas fa-ban"></i>')  ?>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                <?php endif ?>

                                            <?php endfor; ?>
                                        </ul>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>