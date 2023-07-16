<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\ServiceController;

(new ServiceController())->add();

require_once dirname(__DIR__) . DS . 'Elements' . DS . 'header.php';

?>

<!-- ========== tab components start ========== -->
<section class="tab-components">
  <div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Nouveau</h2>
          </div>
        </div>
        <!-- end col -->
        <div class="col-md-6">
          <div class="breadcrumb-wrapper mb-30">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="<?= BASE_URL ?>"> Accueil </a>
                </li>
                <li class="breadcrumb-item">
                  <a href="<?= VIEWS . 'Services' ?>"> Services </a>
                </li>
                <li class="breadcrumb-item">Nouveau </li>
              </ol>
            </nav>
          </div>
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->

    <!-- ========== form-elements-wrapper start ========== -->
    <div class="form-elements-wrapper">
      <div class="row">
        <div class="col-lg-9">
          <!-- input style start -->
          <div class="card-style mb-30">
            <h6 class="mb-25">Remplissez les champs ci-après pour ajouter un service</h6>

            <form method="post" action="" id="quickForm">
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6 mb-2">
                    <label>Libellé</label>
                    <input type="text" name="libelle" class="form-control" autocomplete="off">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="col-6 mb-3">
                <a href="<?= VIEWS . 'Services' ?>" class="btn btn-outline-secondary col-md-4">Retour</a>

                <input type="submit" class="btn btn-primary" value="Enregistrer" name="add_service">
              </div>
            </form>
            <!-- ========== form-elements-wrapper end ========== -->
          </div>
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
</section>
<!-- ========== tab components end ========== -->
<?php require_once dirname(__DIR__) . DS . 'Elements' . DS . 'footer-val.php'; ?>

<!-- Page specific script -->
<script>
  $(function() {
    $('#quickForm').validate({
      rules: {
        libelle: {
          required: !0,
          maxlength: 50,
          minlength: 2
        },
      },
      messages: {
        libelle: {
          required: "Veuillez entrer le libéllé du service.",
          maxlength: "Le libéllé du service ne doit pas dépasser 50 caractères.",
          minlength: "Le libéllé du service doit avoir aumoinse 02 caractères."
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
</script>