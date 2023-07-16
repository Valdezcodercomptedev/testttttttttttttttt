<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\ServiceController;

(new ServiceController())->select();
(new ServiceController())->save();

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
            <h2>Enregistrement</h2>
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
                  <a href="<?= VIEWS . 'Commands' ?>"> Commandes </a>
                </li>
                <li class="breadcrumb-item">Enregistrement </li>
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
            <h6 class="mb-25">Remplissez les champs ci-après pour enregistrer cet article</h6>

            <form method="POST" action="" id="quickForm">
              <div class="card-body">
                <div class="row">

                  <div class="form-group col-md-6 mb-2">
                    <label for="service"><strong>Selectionner le service </strong></label>
                    <select class="form-select form-control" name="service" readonly>
                      <?php if (!empty($services)) : ?>
                        <?php foreach ($services as $service) : ?>
                          <option value="<?= $service->getId() ?>"><?= $service->getLibelle() ?></option>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                          <span class="bi bi-info-circle flex-shrink-0 me-2" role="img" aria-label="Info:"></span>
                          <div>
                            Aucun service enregistré. Veuillez ajouter un service.
                          </div>
                        </div>

                      <?php endif ?>
                    </select>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="col-6 mb-3">
                <a href="<?= VIEWS . 'Commands' ?>" class="btn btn-outline-secondary col-md-4">Retour</a>

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
        service: {
          required: !0,
        },
      },
      messages: {
        service: {
          required: "Veuillez selectionner un service.",
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