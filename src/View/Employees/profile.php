<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\AuthController;

AuthController::require_auth();
AuthController::profile();
// (new AuthController())->profile();

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
            <h2>Mon profile</h2>
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
                <li class="breadcrumb-item"><?= $auth_user->getname() ?></li>
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
              <img src="<?= ASSETS_PATH ?>/company/user_icon.png" alt="Company Image" class="w-100">
              <h2 class="mt-2" style="text-transform: capitalize;"><?= $auth_user->getname() ?></h2>
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
                  <h5 class="card-title">Informations détaillées sur l'utilisateur</h5>

                  <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <tbody>
                        <tr>
                          <th>Nom complet</th>
                          <td><?= $auth_user->getname() ?></td>
                        </tr>
                        <tr>
                          <th>Rôle</th>
                          <?php if ($auth_user->getRole() == 'DIR') : ?>

                            <td>Directeur</td>

                          <?php elseif ($auth_user->getRole() == 'EMP') : ?>

                            <td>Employé</td>

                          <?php elseif ($auth_user->getRole() == 'FSR') : ?>

                            <td>Fournisseur</td>

                          <?php else : ?>

                            <td>Role non défini</td>

                          <?php endif; ?>
                        </tr>
                        <tr>
                          <th>Numéro de téléphone</th>
                          <td><?= $auth_user->getPhone() ?></td>
                        </tr>
                        <tr>
                          <th>Adresse e-mail</th>
                          <td><?= $auth_user->getemail() ?></td>
                        </tr>
                        <tr>
                          <th>Nom d'utilisateur</th>
                          <td><?= $auth_user->getusername() ?></td>
                        </tr>
                        <tr>
                          <th>Date d'ajout</th>
                          <td><?= $auth_user->getcreated() ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade pt-3" id="profile-edit">
                  <h5 class="card-title">Editer le profil</h5>

                  <form method="post" action="" id="quickForm">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6 mb-2">
                          <label>Nom</label>
                          <input type="text" name="name" value="<?= $auth_user->getname() ?>" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label>Numéro de téléphone</label>
                          <input type="text" name="phone" value="<?= $auth_user->getPhone() ?>"  class="form-control" data-inputmask='"mask": "+(237) 699-999-999"' data-mask>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label>Adresse e-mail</label>
                          <input type="text" name="email" value="<?= $auth_user->getemail() ?>" class="form-control" autocomplete="off" readonly>
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label>Nom d'utilisateur</label>
                          <input type="text" name="username" value="<?= $auth_user->getusername() ?>" class="form-control" autocomplete="off">
                        </div>
                        <hr>
                        <h5 class="card-title">Changer le mot de passe</h5>

                        <div class="form-group col-md-6 mb-2">
                          <label>Nouveau mot de passe</label>
                          <input type="password" name="newpass" id="newpass" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                          <label>Confirmer le mot de passe</label>
                          <input type="password" name="cnfpass" id="cnfpass" class="form-control" autocomplete="off">
                        </div>
                        <hr>
                        <h5 class="card-title">Entrez votre mot de passe actuel pour confirmer les modifications</h5>

                        <div class="form-group col-md-6 mb-2">
                          <label>Mot de passe</label>
                          <input type="password" name="oldpass" class="form-control" autocomplete="off">
                        </div>

                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="col-6 mb-3">
                      <a href="<?= BASE_URL ?>" class="btn btn-outline-secondary col-md-5">Retour</a>

                      <input type="submit" class="btn btn-primary" value="Enregistrer" name="edit_profile">
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

        $('#quickForm').validate({
          rules: {
            name: {
              required: !0,
              maxlength: 50,
              minlength: 2
            },
            email: {
              required: !0,
              email: !0
            },
            username: {
              required: !0,
              maxlength: 50,
              minlength: 2
            },
            newpass: {
              required: !0,
              minlength: 3
            },
            cnfpass: {
              required: !0,
              equalTo: "#newpass"
            },
            oldpass: {
              required: !0,
            },
          },
          messages: {
            name: {
              required: "Veuillez entrer votre nom.",
              maxlength: "Votre nom ne doit pas dépasser 50 caractères.",
              minlength: "Votre nom doit avoir aumoinse 02 caractères."
            },
            email: {
              required: "Veuillez entrer votre adresse mail",
              email: "Veuiller entrer une adresse mail valide.",
            },
            username: {
              required: "Veuillez entrer votre nom d'utilisateur.",
              maxlength: "Votre nom d'utilisateur ne doit pas dépasser 50 caractères.",
              minlength: "Votre nom d'utilisateur doit avoir aumoinse 02 caractères."
            },
            newpass: {
              required: "Veuillez entrer votre nouveau mot de passe.",
              minlength: "Votre nouveau mot de passe doit avoir aumoinse 05 caractères."
            },
            cnfpass: {
              required: "Veuillez entrer la confirmation du mot de passe.",
              equalTo: "Vos mots de passes ne correspondent pas"
            },
            oldpass: {
              required: "Veuillez entrer votre ancien mot de passe",
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