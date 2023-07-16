<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use Core\Database\ConnectionManager;

use App\Controller\CommandController;

(new CommandController())->addPrice();

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
            <h2>Plan tarifaire</h2>
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
                <li class="breadcrumb-item">Plan tarifaire </li>
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

      <section class="section profile">
        <div class="row">

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
                    <h5 class="card-title">Informations détaillées sur les prix des boissons</h5>

                    <div class="table-responsive">
                      <table class="table table-striped table-hover">
                        <tbody>
                          <?php

                          $connectionManager = new ConnectionManager();

                          $id = $_GET['id'];

                          $sql = "SELECT * FROM articles e WHERE e.id = ? AND e.deleted = ? ";

                          $query = $connectionManager->getConnection()->prepare($sql);

                          $query->execute([$id, 0]);

                          foreach ($query as $sq) {
                          ?>

                            <tr>
                              <th>Prix d'un verre (en Fcfa)</th>
                              <td><?= $sq["puv"] ?: 'Non défini' ?></td>
                            </tr>
                            <tr>
                              <th>Prix d'une bouteille (en Fcfa)</th>
                              <td><?= $sq["pu"] ?: 'Non défini' ?></td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="tab-pane fade pt-3" id="profile-edit">
                    <h5 class="card-title">Editer les prix</h5>

                    <form method="post" action="" id="quickForm">
                      <div class="card-body">
                        <div class="row">
                          <div class="form-group col-md-6 mb-2">
                            <label>Prix d'un verre (en Fcfa)</label>
                            <input type="number" name="prixv" class="form-control" autocomplete="off">
                          </div>
                          <div class="form-group col-md-6 mb-2">
                            <label>Prix d'une bouteille (en Fcfa)</label>
                            <input type="number" name="prixb" class="form-control" autocomplete="off">
                          </div>

                        </div>
                      </div>
                    <?php
                          }
                    ?>
                    <!-- /.card-body -->
                    <div class="col-6 mb-3">
                      <a href="<?= VIEWS . 'Services' ?>" class="btn btn-outline-secondary col-md-4">Retour</a>

                      <input type="submit" class="btn btn-primary" value="Enregistrer" name="add_price">
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
              prixv: {
                required: !0,
                number: !0
              },
              prixb: {
                required: !0,
                number: !0
              },
            },
            messages: {
              prixv: {
                required: "Veuillez entrer le prix d'un verre.",
                number: "Veuillez entrer un nombre.",
              },
              prixb: {
                required: "Veuillez entrer le prix d'une bouteille.",
                number: "Veuillez entrer un nombre.",
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