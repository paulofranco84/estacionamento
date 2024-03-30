</div>

<?php if ($this->router->fetch_class() !== 'login') : ?>
    <footer class="footer text-center" style="padding-top: 19px !important">
        <div class="w-100 clearfix">
            <span class="text-center text-sm-center">Park now - Um novo conceito em estacionamento</span>
        </div>
    </footer>
<?php endif; ?>

</div>

</div>

<script src="<?php echo base_url('public/src/js/vendor/jquery-3.3.1.min.js') ?>"></script>
<script src="<?php echo base_url('public/plugins/popper.js/dist/umd/popper.min.js') ?>"></script>
<script src="<?php echo base_url('public/plugins/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('public/plugins/sweetalert2/dist/sweetalert2.min.js') ?>"></script>
<script src="<?php echo base_url('public/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') ?>"></script>
<script src="<?php echo base_url('public/plugins/screenfull/dist/screenfull.js') ?>"></script>
<script src="<?php echo base_url('public/dist/js/theme.js') ?>"></script>

<?php if (isset($scripts)) : ?>
    <?php foreach ($scripts as $script) : ?>
        <script src="<?php echo base_url('public/' . $script) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

</body>

</html>