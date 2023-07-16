<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\SupplierController;

(new SupplierController())->index();

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
            <h2>Les fournisseurs</h2>
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
    <a href="add.php" class="main-btn primary-btn btn-hover">
      <i class="lni lni-plus"></i> Nouveau fournisseur</a>
    <hr>
    <!-- ========== tables-wrapper start ========== -->
    <div class="tables-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card-style mb-30">
            <div class="left">
              <h6 class="text-medium text-gray mb-30"> <strong> Liste des fournisseurs</strong></h6>
            </div>
            <?php if (!empty($suppliers)) : ?>
              <div class="table-wrapper table-responsive">
                <table class="table datatable">
                  <thead>
                    <tr>
                      <th>
                        <h6>Id</h6>
                      </th>
                      <th>
                        <h6>Fournisseurs</h6>
                      </th>
                      <th>
                        <h6>Phone</h6>
                      </th>
                      <th>
                        <h6>Email</h6>
                      </th>
                      <th>
                        <h6>Ville / Localité</h6>
                      </th>
                      <th>
                        <h6>Actions</h6>
                      </th>
                    </tr>
                    <!-- end table row-->
                  </thead>
                  <tbody>
                    <?php foreach ($suppliers as $supplier) : ?>
                      <tr>
                        <td class="min-width">
                          <p><?= $supplier->getId() ?></p>
                        </td>
                        <td class="min-width">
                          <p><?= $supplier->getName() ?></p>
                        </td>
                        <td class="min-width">
                          <p><?= $supplier->getPhone() ?></p>
                        </td>
                        <td class="min-width">
                          <p><?= $supplier->getEmail() ?></p>
                        </td>
                        <td class="min-width">
                          <p><?= $supplier->getVille() ?></p>
                        </td>
                        <td class="min-width" width="150">
                          <a href="<?= VIEWS . 'Suppliers/update.php?id=' . $supplier->getId() ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<span>Modifier le fournisseur</span>">
                            <i class="lni lni-pencil-alt"></i>
                          </a>

                          <a onclick="deleteSupplier(<?= $supplier->getId() ?>)" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<span>Supprimer le fournisseur</span>">
                            <i class="lni lni-trash-can"></i>
                          </a>

                          <a href="<?= VIEWS . 'Suppliers/commands.php?id=' . $supplier->getId() ?>" class="btn btn-success" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<span>Commander un article</span>">
                            <i class="lni lni-cart-full"></i>
                          </a>
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
                    Aucun fournisseur enregistré
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
  function deleteSupplier(id) {
    if (confirm("Voulez-vous vraiment supprimer ce fournisseur ?")) {
      var xmlhttp = new XMLHttpRequest();
      var url = "<?= VIEWS . 'Suppliers/delete.php?ajax=1&id=' ?>" + id;

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