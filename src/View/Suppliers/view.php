<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\AuthController;

AuthController::require_auth();;

require_once dirname(__DIR__) . DS . 'Elements' . DS . 'header.php';

use Core\Database\ConnectionManager;
?>

<!-- ========== table components start ========== -->
<section class="table-components">
  <div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>ESPACE FOURNISSEURS</h2>
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
                  Fournisseurs
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

    <hr>
    <!-- ========== tables-wrapper start ========== -->
    <div class="tables-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card-style mb-30">

            <div class="invoice-for">
              <h6 class="mb-25">Toutes les commandes d'articles</h6>
            </div>
              <div class="table-wrapper table-responsive">
                <table class="table datatable">
                  <thead>
                    <tr>
                      <th>
                        <h6>Id</h6>
                      </th>
                      <th>
                        <h6>Libellé</h6>
                      </th>
                      <th>
                        <h6>Volume (en centilitre)</h6>
                      </th>
                      <th>
                        <h6>Quantité</h6>
                      </th>
                      <th>
                        <h6>Actions</h6>
                      </th>
                    </tr>
                    <!-- end table row-->
                  </thead>
                  <tbody>
                    <?php

                    $connectionManager = new ConnectionManager();

                    $sql = "SELECT * FROM articles e WHERE e.supplier_id = ? AND e.status = ? AND e.deleted = ? ";

                    $query = $connectionManager->getConnection()->prepare($sql);

                    $query->execute([$auth_user->getId() , 'En attente' , 0]);

                    foreach ($query as $sq) {
                    ?>

                      <tr>
                        <td class="min-width">
                          <p><?= $sq["id"] ?></p>
                        </td>
                        <td class="min-width">
                          <p><?= $sq["libelle"] ?></p>
                        </td>
                        <td class="min-width">
                          <p><?= $sq["volume"] ?: '/' ?></p>
                        </td>
                        <td class="min-width">
                          <p><?= $sq["quantity"] ?></p>
                        </td>
                        <td class="min-width" width="100">
                          <a onclick="approvCmd(<?= $sq['id'] ?>)" class="btn btn-success">
                            <i class="lni lni-checkmark"></i>
                          </a>

                          <a onclick="deleteCmd(<?= $sq['id'] ?>)" class="btn btn-danger">
                            <i class="lni lni-trash-can"></i>
                          </a>
                        </td>
                      </tr>
                      <?php
                    }
                    ?>
                    <!-- end table row -->
                  </tbody>
                </table>
              <!-- end table -->
              </div>
          </div>
          <!-- end card -->
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- ========== tables-wrapper end ========== -->
  </div>
  <!-- end container -->
</section>
<!-- ========== table components end ========== -->

<?php require_once dirname(__DIR__) . DS . 'Elements' . DS . 'footer.php'; ?>

<script type="text/javascript">
  function deleteCmd(id) {
    if (confirm("Voulez-vous vraiment rejetter cette commande ?")) {
      var xmlhttp = new XMLHttpRequest();
      var url = "<?= VIEWS . 'Suppliers/deleteCommand.php?ajax=1&id=' ?>" + id;

      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            location.reload();
          } else {
            alert("Erreur: " + (JSON.parse(xmlhttp.response)).message);
          }
        }
      };

      xmlhttp.open("GET", url, true);
      xmlhttp.send();
    }
  }

  function approvCmd(id) {
    if (confirm("Voulez-vous vraiment approuver cette commande ?")) {
      var xmlhttp = new XMLHttpRequest();
      var url = "<?= VIEWS . 'Suppliers/approvedCommand.php?ajax=1&id=' ?>" + id;

      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            location.reload();
          } else {
            alert("Erreur: " + (JSON.parse(xmlhttp.response)).message);
          }
        }
      };

      xmlhttp.open("GET", url, true);
      xmlhttp.send();
    }
  }
</script>