<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\UserController;
use App\Controller\ServiceController;

(new UserController())->add();
(new ServiceController())->view();

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
                  <a href="<?= VIEWS . 'Services' . DS. 'view.php?id=' . $service->getId() . '&?=/' . $service->getUniqueId() ?>"> Services </a>
                </li>
                <li class="breadcrumb-item">Nouvel employé </li>
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
            <h6 class="mb-25">Remplissez les champs ci-après pour ajouter un employé</h6>

            <form method="post" action="" id="quickForm">
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6 mb-2">
                    <label>Nom</label>
                    <input type="text" name="name" class="form-control" autocomplete="off">
                  </div>
                  <div class="form-group col-md-6 mb-2">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" data-inputmask='"mask": "+(237) 699-999-999"' data-mask>
                  </div>
                  <div class="form-group col-md-6 mb-2">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="example@gmail.com" class="form-control" autocomplete="off">
                  </div>
                  <div class="form-group col-md-6 mb-2">
                    <label>Nom d'utilisateur</label>
                    <input type="text" name="username" class="form-control" autocomplete="off">
                  </div>
                  <div class="form-group col-md-6 mb-2">
                    <label>Mot de passe</label>
                    <input type="password" name="pass" id="pass" class="form-control" autocomplete="off">
                  </div>
                  <div class="form-group col-md-6 mb-2">
                    <label>Confirmation du mot de passe</label>
                    <input type="password" name="cnfpass" class="form-control" autocomplete="off">
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="col-6 mb-3">
                <a href="<?= VIEWS . 'Services' . DS. 'view.php?id=' . $service->getId() . '&?=/' . $service->getUniqueId() ?>" class="btn btn-outline-secondary col-md-4">Retour</a>

                <input type="submit" class="btn btn-primary" value="Enregistrer" name="add_user">
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
        name: {
          required: !0,
          maxlength: 50,
          minlength: 2
        },
        phone: {
          required: !0,
        },
        email: {
          required: !0,
          email: !0
        },
        username: {
          required: !0,
          minlength: 5
        },
        pass: {
          required: !0,
          minlength: 5
        },
        cnfpass: {
          required: !0,
          equalTo: "#pass"
        },
      },
      messages: {
        name: {
          required: "Veuillez entrer le nom de l'employé.",
          maxlength: "Le nom de l'employé ne doit pas dépasser 50 caractères.",
          minlength: "Le nom de l'employé doit avoir aumoinse 02 caractères."
        },
        phone: "Veuillez entrer le numéro de téléphone de l'employé",
        email: {
          required: "Veuillez entrer l'adresse mail de l'employé",
          email: "Veuiller entrer une adresse mail valide.",
        },
        username: {
          required: "Veuillez entrer le login de l'employé.",
          maxlength: "Le login de l'employé ne doit pas dépasser 50 caractères.",
          minlength: "Le login de l'employé doit avoir aumoinse 05 caractères."
        },
        pass: {
          required: "Veuillez entrer le mot de passe de l'employé.",
          minlength: "Le mot de passe de l'employé doit avoir aumoinse 05 caractères."
        },
        cnfpass: {
          required: "Veuillez entrer la confirmation du mot de passe.",
          equalTo: "Vos mots de passes ne correspondent pas"
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