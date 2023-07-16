<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\CommandController;

(new CommandController())->index();

use Core\Database\ConnectionManager;

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
            <h2>Les commandes</h2>
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
                  Commandes
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

    <!-- ========== tables-wrapper start ========== -->
    <div class="tables-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card-style mb-30">
            <div class="left">
              <h6 class="text-medium mb-30">Récentes commandes passées</h6>
            </div>
            <?php if (!empty($commands)) : ?>
              <div class="table-wrapper table-responsive">
                <table class="table datatable">
                  <thead>
                    <tr>
                      <th>
                        <h6>#</h6>
                      </th>
                      <th>
                        <h6>Date</h6>
                      </th>
                      <th>
                        <h6>Fournisseurs</h6>
                      </th>
                      <th>
                        <h6>Description</h6>
                      </th>
                      <th>
                        <h6>Status</h6>
                      </th>
                      <th>
                        <h6>Actions</h6>
                      </th>
                    </tr>
                    <!-- end table row-->
                  </thead>
                  <tbody>
                    <?php foreach ($commands as $command) : ?>
                      <tr>
                        <td class="min-width">
                          <p><?= $command->getId() ?></p>
                        </td>
                        <td class="min-width">
                          <p><?= $command->getDate() ?></p>
                        </td>
                        <td class="min-width">

                          <?php

                          $connectionManager = new ConnectionManager();

                          $sql = "SELECT e.name FROM employees e WHERE e.id = ? AND e.role = ? AND e.deleted = ?";

                          $query = $connectionManager->getConnection()->prepare($sql);

                          $query->execute([$command->getSupplierId(), "FSR", 0]);

                          foreach ($query as $sq) {
                          ?>
                            <p><?= $sq["name"] ?></p>
                          <?php
                          }
                          ?>
                        </td>
                        <td class="min-width">
                          <p><?= 'Libellé : ' .  $command->getLibelle() . ' , Volume : ' . $command->getVolume()  . 'cl , Quantité : ' . $command->getQuantity() ?></p>
                        </td>
                        <td>
                          <?php if ($command->getStatus() == 'En attente') : ?>
                            <span class="status-btn active-btn">En attente</span>
                          <?php elseif ($command->getStatus() == 'Approuvée') : ?>
                            <span class="status-btn success-btn">Approuvée</span>
                          <?php elseif ($command->getStatus() == 'Rejetée') : ?>
                            <span class="status-btn close-btn">Rejetée</span>
                          <?php elseif ($command->getStatus() == 'Annulée') : ?>
                            <span class="status-btn light-btn">Annulée</span>
                          <?php elseif ($command->getStatus() == 'Enregistrée') : ?>
                            <span class="status-btn info-btn">Enregistrée</span>
                          <?php else : ?>
                            <span class="badge text-bg-info"> <?= $command->getStatus() ?></span>
                          <?php endif; ?>
                        </td>
                        <td class="min-width" width="100">
                          <div class="action">
                            <?php if ($command->getStatus() == 'En attente') : ?>

                              <a onclick="deleteCmd(<?= $command->getId() ?>)" class="btn btn-danger">
                                <i class="lni lni-trash-can"></i>
                              </a>

                            <?php elseif ($command->getStatus() == 'Approuvée') : ?>

                              <a href="<?= VIEWS . 'Commands/save.php?id=' . $command->getId() ?>" class="btn btn-success">
                                <i class="lni lni-inbox"></i>
                              </a>

                            <?php elseif ($command->getStatus() == 'Annulée') : ?>

                            <?php elseif ($command->getStatus() == 'Enregistrée') : ?>

                            <?php elseif ($command->getStatus() == 'Rejetée') : ?>

                            <?php else : ?>

                            <?php endif; ?>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <!-- end table row -->
                  </tbody>
                </table>
              <?php else : ?>
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                  <span class="bi bi-info-circle flex-shrink-0 me-2" role="img" aria-label="Info:"></span>
                  <div>
                    Aucune commande enregistrée
                  </div>
                </div>

              <?php endif ?>
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
    if (confirm("Voulez-vous vraiment annuler cette commande ?")) {
      var xmlhttp = new XMLHttpRequest();
      var url = "<?= VIEWS . 'Suppliers/dropCommand.php?ajax=1&id=' ?>" + id;

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