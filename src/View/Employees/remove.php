<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

require_once dirname(__DIR__) . DS . 'Elements' . DS . 'header.php';

use App\Controller\ServiceController;

use App\Controller\AuthController;

AuthController::require_auth();

use Core\Database\ConnectionManager;

(new ServiceController())->updateArticle();

?>

<!-- ========== tab components start ========== -->
<section class="tab-components">

  <!-- ========== title-wrapper start ========== -->
  <div class="title-wrapper pt-30">
    <?php

    $_SESSION['title'] = 'Déstockage';

    $connectionManager = new ConnectionManager();

    $sql = "SELECT e.libelle FROM services e WHERE e.id = ? AND e.deleted = ? ";

    $query = $connectionManager->getConnection()->prepare($sql);

    $query->execute([$auth_user->getServiceId(), 0]);

    foreach ($query as $sq) {
    ?>
      <div class="container-fluid">

        <?php

        $connectionManager = new ConnectionManager();

        if (isset($_GET['id'])) {

          $id = $_GET['id'];

          $sql = "SELECT * FROM articles e WHERE e.id = ? AND e.deleted = ? ";

          $query = $connectionManager->getConnection()->prepare($sql);

          $query->execute([$id, 0]);

          foreach ($query as $sr) {
        ?>
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title mb-30">
                  <h2 style="text-transform: capitalize;">Déstocker : <?= $sr["libelle"] ?> </h2>
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
                        <a href="<?= VIEWS . 'Employees/products.php' ?>"> Stock </a>
                      </li>
                      <li class="breadcrumb-item">Déstocker </li>
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
              <h6 class="mb-25">Remplissez les champs ci-après pour rétirer la quantité d'article désirée</h6>

              <form method="post" action="" id="quickForm">
                <?php

                if ($sq["libelle"] == "bar") {

                  $connectionManager = new ConnectionManager();

                  if (isset($_POST['remove_article_bar'])) {

                    $qtev = ($_POST['qtev']);
                    $qteb = ($_POST['qteb']);

                    $valueBouteille = $qteb * $sr["volume"];

                    $valueVerre = $qtev * 25;

                    $qtityTotal = $sr["volume"] * $sr["quantity"];

                    $qtitySortie = $valueBouteille + $valueVerre;

                    $qteArticle = $qtityTotal - $qtitySortie;

                    $qtity = $qteArticle / $sr["volume"];

                    $quantity = number_format($qtity, 1, '.', '');

                    $month = date('m');

                    $year = date('Y');

                    $amounts = $qtev * $sr["puv"] + $qteb * $sr["pu"];

                    if ($qtitySortie > $qtityTotal) {
                      $_SESSION['error'] = "La quantité d'article que vous souhaitez déstocker est supérieur à notre quantité en stock !";

                      // header('Location: ' . VIEWS . 'Employees/remove.php?id=' . $id);
                    } else {

                      $sq = "UPDATE articles SET quantity = ? WHERE id = ?";

                      $query = $connectionManager->getConnection()->prepare($sq);

                      $query->execute([$quantity, $id]);


                      $transactions = $connectionManager->getConnection()->prepare('INSERT INTO transactions(month, year, amounts) VALUES (?,?,?)');
                      $transactions->execute(array($month, $year, $amounts));

                      $_SESSION['succes'] = "Article déstocker avec succèss !";

                      // header('Location: ' . VIEWS . 'Employees/products.php');
                    }
                  }
                ?>
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-6 mb-2">
                        <label>1 verre ( <?= $sr["puv"] ?: 'Non défini' ?> Fcfa )</label>
                        <input type="number" name="qtev" class="form-control" autocomplete="off">

                      </div>
                      <div class="form-group col-md-6 mb-2">
                        <label>1 Bouteille ( <?= $sr["pu"] ?: 'Non défini' ?> Fcfa )</label>
                        <input type="number" name="qteb" class="form-control" autocomplete="off">
                      </div>
                    </div>
                  </div>

                  <!-- /.card-body -->
                  <div class="col-6 mb-3">
                    <a href="<?= VIEWS . 'Employees/products.php' ?>" class="btn btn-outline-secondary col-md-4">Retour</a>

                    <input type="submit" class="btn btn-primary" value="Rétirer" name="remove_article_bar">
                  </div>

                <?php
                } elseif ($sq["libelle"] == "logement") {

                  $connectionManager = new ConnectionManager();

                  if (isset($_POST['remove_article_logement'])) {

                    $qtel = ($_POST['qtel']);

                    $qteTotal = $sr["quantity"];

                    $qteUtil = $qteTotal - $qtel;

                    if ($qtel > $qteTotal) {
                      $_SESSION['error'] = "La quantité d'article que vous souhaitez déstocker est supérieur à notre quantité en stock !";

                      // header('Location: ' . VIEWS . 'Employees/remove.php?id=' . $id);
                    } else {

                      $sq = "UPDATE articles SET quantity = ? WHERE id = ?";

                      $query = $connectionManager->getConnection()->prepare($sq);

                      $query->execute([$qteUtil, $id]);


                      $qql = $connectionManager->getConnection()->prepare('INSERT INTO articles(supplier_id , service_id , libelle , quantity, status) VALUES (?,?,?,?,?)');
                      $qql->execute(array($sr["supplier_id"], $sr["service_id"], $sr["libelle"], $qtel, "Encours d'utilisation"));

                      $_SESSION['succes'] = "Article déstocker avec succèss !";

                      // header('Location: ' . VIEWS . 'Employees/products.php');
                    }
                  } ?>
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-6 mb-2">
                        <label>Quantité</label>
                        <input type="number" name="qtel" class="form-control" autocomplete="off">
                      </div>
                    </div>
                  </div>

                  <!-- /.card-body -->
                  <div class="col-6 mb-3">
                    <a href="<?= VIEWS . 'Employees/products.php' ?>" class="btn btn-outline-secondary col-md-4">Retour</a>

                    <input type="submit" class="btn btn-primary" value="Rétirer" name="remove_article_logement">
                  </div>
                <?php
                } else {
                ?>
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-6 mb-2">
                        <label>Quantité</label>
                        <input type="number" name="qte" class="form-control" autocomplete="off">
                      </div>
                    </div>
                  </div>

                  <!-- /.card-body -->
                  <div class="col-6 mb-3">
                    <a href="<?= VIEWS . 'Employees/products.php' ?>" class="btn btn-outline-secondary col-md-4">Retour</a>

                    <input type="submit" class="btn btn-primary" value="Rétirer" name="remove_article">
                  </div>
            <?php
                }
              }
            }
            ?>
              </form>
              <!-- ========== form-elements-wrapper end ========== -->
            </div>
          </div>
          <!-- end row -->
        </div>
      <?php
    }
      ?>
      <!-- end container -->
</section>
<!-- ========== tab components end ========== -->
<?php require_once dirname(__DIR__) . DS . 'Elements' . DS . 'footer-val.php'; ?>

<!-- Page specific script -->
<script>
  $(function() {
    $('#quickForm').validate({
      rules: {
        qtev: {
          required: !0,
          number: !0,
        },
        qteb: {
          required: !0,
          number: !0,
        },
        qte: {
          required: !0,
          number: !0,
        },
      },
      messages: {
        qtev: {
          required: "Veuillez entrer la quantité de verre à rétirer( Si vouz ne souhaitez paz rétirer de verre(s), entrer 0.",
          number: "Veuillez entrer un nombre.",
        },
        qteb: {
          required: "Veuillez entrer la quantité de bouteille à rétirer( Si vouz ne souhaitez paz rétirer de bouteille(s), entrer 0.",
          number: "Veuillez entrer un nombre.",
        },
        qte: {
          required: "Veuillez entrer la quantité d'article à rétirer.",
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