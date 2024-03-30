<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Park Now&nbsp;-&nbsp;<?php echo (isset($titulo) ? $titulo : 'Um novo conceito em estacionamento') ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?php echo base_url('public/favicon.ico') ?>" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url('public/plugins/bootstrap/dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/plugins/sweetalert2/dist/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/plugins/icon-kit/dist/css/iconkit.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/plugins/ionicons/dist/css/ionicons.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/plugins/perfect-scrollbar/css/perfect-scrollbar.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/dist/css/theme.min.css') ?>">
    <?php if (isset($styles)) : ?>
        <?php foreach ($styles as $style) : ?>
            <link rel="stylesheet" href="<?php echo base_url('public/' . $style) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <script src="<?php echo base_url('public/src/js/vendor/modernizr-2.8.3.min.js') ?>"></script>
</head>

<body>

    <div class="wrapper">

        <?php
        if ($message = $this->session->flashdata('error')) :
        ?>

            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "<?php echo $message; ?>",
                        showConfirmButton: true,
                        confirmButtonColor: '#0275d8',
                        //timer: 2000
                    });
                });
            </script>

        <?php endif; ?>

        <?php
        if ($message = $this->session->flashdata('warning')) :
        ?>

            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title: "<?php echo $message; ?>",
                        showConfirmButton: true,
                        confirmButtonColor: '#0275d8',
                        //timer: 2000
                    });
                });
            </script>

        <?php endif; ?>

        <?php
        if ($message = $this->session->flashdata('sucesso')) :
        ?>

            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "<?php echo $message; ?>",
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            </script>

        <?php endif; ?>