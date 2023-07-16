<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\ServiceController;

(new ServiceController())->index();

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
            <h2>Les services</h2>
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
                  Services
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
    <a href="add.php" class="main-btn primary-btn btn-hover">
      <i class="lni lni-plus"></i> Nouveau service</a>
    <hr>
    <!-- ========== tables-wrapper start ========== -->

    <?php if (empty($services)) : ?>

      <div class="alert alert-primary d-flex align-items-center" role="alert">
        <span class="bi bi-info-circle flex-shrink-0 me-2" role="img" aria-label="Info:"></span>
        <div>
          Aucun service trouvé.
        </div>
      </div>

    <?php else : ?>
      <div class="row">
        <?php foreach ($services as $service) : ?>

          <div class="col-lg-3 col-md-12 col-12 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                  <span style="text-transform: capitalize;"><?= $service->getLibelle() ?></span>
                  <div class="dropdown">
                    <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="lni lni-more"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                      <a class="dropdown-item" href="<?= VIEWS . 'Services/view.php?id=' . $service->getId() ?>"><i class="lni lni-eye"></i> Voir</a>
                      <a class="dropdown-item" href="<?= VIEWS . 'Services/update.php?id=' . $service->getId() ?>"><i class="lni lni-pencil-alt"></i> Modifier</a>
                      <a class="dropdown-item text-danger" href="#" onclick="deleteService(<?= $service->getId() ?>)"><i class="lni lni-trash-can"></i> Supprimer</a>
                    </div>
                  </div>
                </div>
                <div class="ps-3">
                  <?php

                  $connectionManager = new ConnectionManager();

                  $sql = "SELECT * FROM services e WHERE e.id = ? AND e.deleted = ? ";

                  $query = $connectionManager->getConnection()->prepare($sql);

                  $query->execute([$service->getId(), 0]);

                  foreach ($query as $sq) {
                  ?>

                    <span class="text-success small pt-1 fw-bold">

                      <?php

                      $connectionManager = new ConnectionManager();

                      $sql = "SELECT * FROM employees e WHERE e.service_id = ? AND e.deleted = ? ";

                      $quer = $connectionManager->getConnection()->prepare($sql);

                      $quer->execute([$sq["id"], 0]);

                      $nb = $quer->fetchall(PDO::FETCH_OBJ);
                      $n_user = count($nb);
                      echo $n_user;
                      ?>
                      employés</span> |


                    <span class="text-primary small pt-1 fw-bold">

                      <?php

                      $connectionManager = new ConnectionManager();

                      $sql = "SELECT * FROM articles e WHERE e.service_id = ? AND e.status = ? AND e.deleted = ? ";

                      $query = $connectionManager->getConnection()->prepare($sql);

                      $query->execute([$sq["id"], "Enregistrée", 0]);

                      $nbr = $query->fetchall(PDO::FETCH_OBJ);
                      $nb_user = count($nbr);
                      echo $nb_user;
                      ?>
                      articles</span>

                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <!-- ========== tables-wrapper end ========== -->
  </div>
  <!-- end container -->
</section>
<!-- ========== table components end ========== -->

<?php require_once dirname(__DIR__) . DS . 'Elements' . DS . 'footer.php'; ?>


<script type="text/javascript">
  function deleteService(id) {
    if (confirm("Voulez-vous vraiment supprimer ce service ?")) {
      var xmlhttp = new XMLHttpRequest();
      var url = "<?= VIEWS . 'Services/delete.php?ajax=1&id=' ?>" + id;

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