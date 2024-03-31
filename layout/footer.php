<script>
    let site_url = "<?= SITE_URL ?>";
</script>

<script type="text/javascript" src="<?= RESOURCE_URL ?>/js/jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="<?= RESOURCE_URL ?>/js/vendors.bundle.js"></script>
<script type="text/javascript" src="<?= RESOURCE_URL ?>/js/app.bundle.js"></script>
<script type="text/javascript" src="<?= RESOURCE_URL ?>js/formplugins/summernote/summernote.js"></script>
<script type="text/javascript" src="<?= RESOURCE_URL ?>/js/datagrid/datatables/datatables.bundle.js"></script>
<script type="text/javascript" src="<?= RESOURCE_URL ?>/js/datagrid/datatables/datatables.export.js"></script>
<!-- <script type="text/javascript" src="<?= RESOURCE_URL ?>/js/sweet-alert/sweetalert2.bundle.js"></script> -->
<script type="text/javascript" src="<?= RESOURCE_URL ?>/js/notifications/toastr/toastr.js"></script>

<!-- <script type="text/javascript" src="<?= RESOURCE_URL ?>/js/light-gallery/lightgallery.bundle.js"></script> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->

<script type="text/javascript" src="<?= asset('js/main.js') ?>"></script>
<script type="text/javascript" src="<?= asset('js/dataTable.js') ?>"></script>
<script>

// $('#summernote').summernote(); 


</script>

<?php
if (isset($_SESSION['login']) && $_SESSION['login'] == 'y') { ?>
    <footer class="page-footer" role="contentinfo">
        <div class="d-flex align-items-center flex-1 text-muted">
            <span class="hidden-md-down fw-700"><?= date('Y').' '. admin::copyright?><a href='#' class='text-primary fw-500' title='' target='_blank'></a></span>
        </div>
    </footer>

    </div><!-- div start on sidebar -->
<?php } ?>

 <!--Both  div start on header -->
    </div></div>
    
<?php
if (isset($_SESSION['login']) && $_SESSION['login'] == 'y') { ?>
    <nav class="shortcut-menu d-none d-sm-block">
        <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
        <label for="menu_open" class="menu-open-button ">
            <span class="app-shortcut-icon d-block"></span>
        </label>
        <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Scroll Top">
            <i class="fal fa-arrow-up"></i>
        </a>
        <a href="<?=urlController('auth_controller&submit_action=log_out')?>" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Logout">
            <i class="fal fa-sign-out"></i>
        </a>
        <a href="#" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left" title="Full Screen">
            <i class="fal fa-expand"></i>
        </a>
        <a href="#" class="menu-item btn" data-action="app-print" data-toggle="tooltip" data-placement="left" title="Print page">
            <i class="fal fa-print"></i>
        </a>
    </nav>
<?php } ?>
<!-- END Quick Menu -->
</body>
<?php
//if no any use of session flash then its clear automatically
sessionFlashClear();
?>


<script>



    
</script>

</html>