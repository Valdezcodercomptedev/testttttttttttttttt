<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

require_once dirname(__DIR__) . DS . 'Elements' . DS . 'header.php';

use App\Controller\AuthController;

AuthController::require_auth();

use Core\Database\ConnectionManager;

?>

<!-- ========== table components start ========== -->
<div class="notification-wrapper">

    <section class="card-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <?php

                            $connectionManager = new ConnectionManager();

                            $sql = "SELECT e.libelle FROM services e WHERE e.id = ? AND e.deleted = ? ";

                            $query = $connectionManager->getConnection()->prepare($sql);

                            $query->execute([$auth_user->getServiceId(), 0]);

                            foreach ($query as $sq) {
                            ?>
                                <h2 style="text-transform: capitalize;">Stock <?= $sq["libelle"] ?></h2>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper mb-30">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="<?= BASE_URL ?>">Accueil </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Stock
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

            <!-- ========== cards-styles start ========== -->
            <div class="cards-styles">
                <!-- ========= card-style-3 start ========= -->
                <div class="row">
                    <!-- end col -->
                    <?php

                    $connectionManager = new ConnectionManager();

                    $sql = "SELECT * FROM articles e WHERE e.service_id = ? AND e.deleted = ? AND e.status = ? ORDER BY e.libelle";

                    $query = $connectionManager->getConnection()->prepare($sql);

                    $query->execute([$auth_user->getServiceId(), 0, "Enregistrée"]);

                    foreach ($query as $rq) {
                    ?>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                            <div class="icon-card card-style-3 mb-30">
                                <div class="icon primary">
                                    <i class="lni lni-package"></i>
                                </div>
                                <div class="card-content">
                                    <h4 style="text-transform: capitalize;"><a href="<?= VIEWS . 'Employees/remove.php?id=' . $rq["id"] ?>"><?= $rq["libelle"] ?> </a></h4>
                                    <p><?= $rq["quantity"] ?> </p>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    if ($sq["libelle"] == "logement") {
                    ?>
                        <!-- ========== tables-wrapper start ========== -->
                        <div class="tables-wrapper">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="card-style mb-30">
                                        <div class="left">
                                            <h6 class="text-medium text-gray mb-30"> <strong> Etat des articles </strong></h6>
                                        </div>
                                        <div class="table-wrapper table-responsive ">
                                            <table class="table table-border datatable">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <h6>Date</h6>
                                                        </th>
                                                        <th>
                                                            <h6>Libelle</h6>
                                                        </th>
                                                        <th>
                                                            <h6>Quantité</h6>
                                                        </th>
                                                        <th>
                                                            <h6>Status</h6>
                                                        </th>
                                                    </tr>
                                                    <!-- end table row-->
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $connectionManager = new ConnectionManager();

                                                    $sql = "SELECT * FROM articles e WHERE e.status = ? AND e.deleted = ? ";

                                                    $query = $connectionManager->getConnection()->prepare($sql);

                                                    $query->execute(["Encours d'utilisation", 0]);

                                                    foreach ($query as $sq) {
                                                    ?>
                                                        <tr>
                                                            <td class="min-width">
                                                                <p><?= $sq["date"] ?></p>
                                                            </td>
                                                            <td class="min-width">
                                                                <p><?= $sq["libelle"] ?></p>
                                                            </td>
                                                            <td class="min-width">
                                                                <p><?= $sq["quantity"] ?></p>
                                                            </td>
                                                            <td class="min-width">
                                                                <span class="status-btn active-btn"><?= $sq["status"] ?></span>
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
                    <?php
                    }
                    ?>
                </div>
                <!-- ========= card-style-3 end ========= -->
            </div>

            <!-- ========== cards-styles end ========== -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== card components end ========== -->


    <!-- ======== main-wrapper end =========== -->

    <!-- ========== table components end ========== -->

    <?php require_once dirname(__DIR__) . DS . 'Elements' . DS . 'footer.php'; ?>