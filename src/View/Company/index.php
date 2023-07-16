<?php 
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\CompanyController;
use Core\FlashMessages\Flash;
if ((new CompanyController())->verified() == true) {
  header('Location: ' . VIEWS . 'Company/view.php');
}
(new CompanyController())->index();

require_once dirname(__DIR__) . DS . 'Elements' . DS . 'header.php';

?>

<!-- ========== table components start ========== -->
<section class="table-components">
  <div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>L'entreprise</h2>
          </div>
        </div>
        <!-- end col -->
        <div class="col-md-6">
          <div class="breadcrumb-wrapper mb-30">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="<?= BASE_URL ?>">Accueil</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Configuration
                </li>
              </ol>
            </nav>
          </div>
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->
    <!-- Content -->


    <section class="section profile">
      <div class="row">

        <div class="col-xl-4">

          <div class="card">
            <div class="card-body pt-4 d-flex flex-column align-items-center">
              <img src="<?= IMAGES ?>company-illustration.png" alt="Company Image" class="w-100">
              <h2 class="mt-2" style="text-transform: capitalize;"><?= $company->getName() ?></h2>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Détails</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Mettre à jour</button>
                </li>
              </ul>

              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Informations détaillées sur l'entreprise</h5>

                  <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <tbody>
                        <tr>
                          <th>Raison sociale</th>
                          <td><?= $company->getName() ?: 'Non défini' ?></td>
                        </tr>
                        <tr>
                          <th>Nom du responsable</th>
                          <td><?= $company->getDirectorName() ?: 'Non défini'  ?></td>
                        </tr>
                        <tr>
                          <th>Adresse de localisation</th>
                          <td><?= $company->getAddress() ?: 'Non défini'  ?></td>
                        </tr>
                        <tr>
                          <th>Adresse e-mail</th>
                          <td><?= $company->getEmail() ?: 'Non défini'  ?></td>
                        </tr>
                        <tr>
                          <th>Téléphone 1</th>
                          <td><?= $company->getTel1() ?: 'Non défini'  ?></td>
                        </tr>
                        <tr>
                          <th>Téléphone 2</th>
                          <td><?= $company->getTel2() ?: 'Non défini'  ?></td>
                        </tr>
                        <tr>
                          <th>Dernière modification</th>
                          <td><?= $company->getModified() ?: '/' ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade pt-3" id="profile-edit">
                  <h5 class="card-title">Mettre à jour les informations de l'entreprise</h5>

                  <form name="company_edit_form" id="company-edit-form" action="" method="post" novalidate>
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6 mb-2">
                          <label for="cpname">Raison sociale </label>
                          <input type="text" name="name" id="cpname" class="form-control" value="<?= isset($form_data['name']) ? $form_data['name'] : $company->getName() ?>" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label for="drname">Nom du responsable</label>
                          <input type="text" name="director_name" id="drname" class="form-control" value="<?= isset($form_data['director_name']) ? $form_data['director_name'] : $company->getDirectorName() ?>" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label for="address">Adresse de localisation </label>
                          <input type="text" name="address" id="address" class="form-control" value="<?= isset($form_data['address']) ? $form_data['address'] : $company->getAddress() ?>" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label for="cpemail">Adresse e-mail</label>
                          <input type="text" name="email" id="cpemail" class="form-control" value="<?= isset($form_data['email']) ? $form_data['email'] : $company->getEmail() ?>" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label for="cptel1">Telephone 1</label>
                          <input type="text" name="tel1" id="cptel1" class="form-control" value="<?= isset($form_data['tel1']) ? $form_data['tel1'] : $company->getTel1() ?>" data-inputmask='"mask": "+(999) 999-999-999"' data-mask autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label for="cptel2">Telephone 2</label>
                          <input type="text" name="tel2" id="cptel2" class="form-control" value="<?= isset($form_data['tel2']) ? $form_data['tel2'] : $company->getTel2() ?>" data-inputmask='"mask": "+(999) 999-999-999"' data-mask autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="col-6 mb-3">
                      <a href="<?= VIEWS . 'Company' ?>" class="btn btn-outline-secondary col-md-5">Retour</a>

                      <input type="submit" class="btn btn-primary col-sm-12 col-md-6" value="Enregistrer" name="update_company">

                      <!-- <button type="submit" name="update_company" class="btn btn-primary col-md-5">
                        <strong>Enregistrer</strong>
                      </button> -->
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========== tab components end ========== -->
    <?php require_once dirname(__DIR__) . DS . 'Elements' . DS . 'footer-val.php'; ?>

    <!-- Page specific script -->
    <script>
      $(function() {
        // $.validator.setDefaults({
        //   submitHandler: function() {
        //     alert("Form successful submitted!");
        //   }
        // });
        $('#company-edit-form').validate({
          rules: {
            name: {
              required: !0,
              maxlength: 50,
              minlength: 2
            },
            director_name: {
              required: !0,
              maxlength: 50,
              minlength: 2
            },
            address: {
              required: !0,
              maxlength: 50,
              minlength: 2
            },
            email: {
              required: !0,
              email: !0
            },
            tel1: {
              required: !0,
            },
            tel2: {
              required: !0,
            },
          },
          messages: {
            name: {
              required: "Veuillez entrer la raison sociale de l'entreprise.",
              maxlength: "La raison sociale ne doit pas dépasser 50 caractères.",
              minlength: "La raison sociale doit avoir aumoinse 02 caractères."
            },
            director_name: {
              required: "Veuillez entrer le nom du directeur de l'entreprise.",
              maxlength: "Le nom du responsable ne doit pas dépasser 50 caractères.",
              minlength: "Le nom du responsable doit avoir aumoinse 02 caractères."
            },
            address: {
              required: "Veuillez entrer l'adresse de localisation de l'entreprise.",
              maxlength: "L'adresse de localisation ne doit pas dépasser 50 caractères.",
              minlength: "L'adresse de localisation doit avoir aumoinse 02 caractères."
            },
            email: {
              required: "Veuillez entrer l'adresse mail de l'employé",
              email: "Veuiller entrer une adresse mail valide.",
            },
            tel1: "Veuillez entrer le contact de l'entreprise.",
            tel2: "Veuillez entrer le contact de l'entreprise.",
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