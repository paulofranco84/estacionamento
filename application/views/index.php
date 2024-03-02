<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">

    <?php $this->load->view('layout/sidebar'); ?>

    <div class="main-content">
        <div class="container-fluid">
        <?php
        if ($message = $this->session->flashdata('error')):
            ?>

            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "<?php echo $message; ?>",
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>   

        <?php endif; ?>

        <?php
        if ($message = $this->session->flashdata('sucesso')):
            ?>

            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "<?php echo $message; ?>",
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>

        <?php endif; ?>

        </div>