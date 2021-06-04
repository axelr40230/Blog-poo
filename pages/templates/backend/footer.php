<?php
use App\App;
?>
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Alexandra Rochette 2021</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vous partez déjà ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Appuyer sur "se déconnecter" pour sortir de l'administration</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                <a class="btn btn-primary" href="<?= App::url('logout') ?>">Se déconnecter</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= App::url('') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= App::url('') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= App::url('') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= App::url('') ?>public/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= App::url('') ?>vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= App::url('') ?>public/js/demo/chart-area-demo.js"></script>
<script src="<?= App::url('') ?>public/js/demo/chart-pie-demo.js"></script>

<!-- Pages with tables -->
<script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="<?= App::url('') ?>public/js/demo/datatables-demo.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"></script>

<!-- TinyMCE -->
<script>
    tinymce.init({
        selector: 'textarea#form-content',
        width:'100%',
        height:500,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'wrap',
    });
</script>