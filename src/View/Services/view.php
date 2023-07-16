<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\ServiceController;
use App\Controller\CommandController;
use App\Controller\UserController;

(new ServiceController())->view();
(new UserController())->index();
(new CommandController())->indexByService();
(new UserController())->dashboard();

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
                        <h2>
                            <span style="text-transform: capitalize;">
                                <?= $service->getLibelle() ?>
                            </span>
                        </h2>
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
                                <li class="breadcrumb-item">
                                    <a href="<?= VIEWS . 'Services'  ?>">   Services</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span style="text-transform: capitalize;">
                                        <?= $service->getLibelle() ?>
                                    </span>
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
        <a href="<?= VIEWS . 'Services' ?>" class="main-btn success-btn btn-hover">
            <i class="lni lni-arrow-left"></i> Retour</a>

        <a href="<?= VIEWS . 'Services/addUser.php?id=' . $service->getId() . '&?=/' . $service->getUniqueId() ?>" class="main-btn primary-btn btn-hover">
            <i class="lni lni-plus"></i> Nouvel employé</a>
        <hr>
        <!-- ========== tables-wrapper start ========== -->
        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="left">
                            <h6 class="text-medium text-gray mb-30"> <strong> Liste des employés</strong></h6>
                        </div>
                        <?php if (!empty($users)) : ?>
                            <div class="table-wrapper table-responsive ">
                                <table class="table table-border datatable">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h6>Id</h6>
                                            </th>
                                            <th>
                                                <h6>Employé</h6>
                                            </th>
                                            <th>
                                                <h6>Phone</h6>
                                            </th>
                                            <th>
                                                <h6>Email</h6>
                                            </th>
                                            <th>
                                                <h6>Actions</h6>
                                            </th>
                                        </tr>
                                        <!-- end table row-->
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user) : ?>
                                            <tr>
                                                <td class="min-width">
                                                    <p><?= $user->getId() ?></p>
                                                </td>
                                                <td class="min-width">
                                                    <p><?= $user->getName() ?></p>
                                                </td>
                                                <td class="min-width">
                                                    <p><?= $user->getPhone() ?></a></p>
                                                </td>
                                                <td class="min-width">
                                                    <p><?= $user->getEmail() ?></p>
                                                </td>

                                                <td class="min-width" width="120">

                                                    <a onclick="deleteEmployee(<?= $user->getId() ?>)" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom" data-bs-html="true" title="<span>Supprimer le fournisseur</span>">
                                                        <i class="lni lni-trash-can"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- end table row -->
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <span class="bi bi-info-circle flex-shrink-0 me-2" role="img" aria-label="Info:"></span>
                                    <div>
                                        Aucun employé enregistré
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

        <hr>
        <!-- ========== tables-wrapper start ========== -->
        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="left">
                            <h6 class="text-medium text-gray mb-30"> <strong> Liste des articles</strong></h6>
                        </div>
                        <?php if (!empty($commands)) : ?>
                            <div class="table-wrapper table-responsive ">
                                <table class="table datatable">
                                    <?php
                                    if ($service->getLibelle() == "bar") {
                                    ?>
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h6>#</h6>
                                                </th>
                                                <th>
                                                    <h6>Désignation</h6>
                                                </th>
                                                <th>
                                                    <h6>Volume</h6>
                                                </th>
                                                <th>
                                                    <h6>Quantité</h6>
                                                </th>
                                                <th>
                                                    <h6>Prix d'un verre</h6>
                                                </th>
                                                <th>
                                                    <h6>Prix d'une bouteille</h6>
                                                </th>
                                                <th>
                                                    <h6>Actions</h6>
                                                </th>
                                            </tr>
                                            <!-- end table row-->
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($commands as $command) : ?>

                                                <tr>
                                                    <td class="min-width">
                                                        <p><?= $command->getId() ?></p>
                                                    </td>
                                                    <td class="min-width">
                                                        <p><?= $command->getLibelle() ?></p>
                                                    </td>
                                                    <td class="min-width">
                                                        <p><?= $command->getVolume() ?: '/' ?></p>
                                                    </td>
                                                    <td class="min-width">
                                                        <p><?= $command->getQuantity() ?></p>
                                                    </td>
                                                    <td class="min-width">
                                                        <p><?= $command->getPuv() ?: 'Non défini' ?></p>
                                                    </td>
                                                    <td class="min-width">
                                                        <p><?= $command->getPu() ?: 'Non défini' ?></p>
                                                    </td>

                                                    <td class="min-width" width="150">

                                                        <a href="<?= VIEWS . 'Services/price.php?id=' . $command->getId() ?>" class="btn btn-primary">
                                                            <i class="lni lni-dollar"></i>
                                                        </a>

                                                        <a onclick="deleteCommand(<?= $command->getId() ?>)" class="btn btn-danger">
                                                            <i class="lni lni-trash-can"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <!-- end table row -->
                                        </tbody>
                                    <?php endforeach;
                                        } else {
                                    ?>
                                    <thead>
                                        <tr>
                                            <th>
                                                <h6>#</h6>
                                            </th>
                                            <th>
                                                <h6>Désignation</h6>
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
                                            foreach ($commands as $command) : ?>
                                            <tr>
                                                <td class="min-width">
                                                    <p><?= $command->getId() ?></p>
                                                </td>
                                                <td class="min-width">
                                                    <p><?= $command->getLibelle() ?></p>
                                                </td>
                                                <td class="min-width">
                                                    <p><?= $command->getQuantity() ?></p>
                                                </td>

                                                <td class="min-width" width="150">

                                                    <a onclick="deleteCommand(<?= $command->getId() ?>)" class="btn btn-danger">
                                                        <i class="lni lni-trash-can"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- end table row -->
                                    </tbody>
                            <?php endforeach;
                                        }
                            ?>
                                </table>
                            <?php else : ?>
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <span class="bi bi-info-circle flex-shrink-0 me-2" role="img" aria-label="Info:"></span>
                                    <div>
                                        Aucun article enregistré
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
    function deleteEmployee(id) {
        if (confirm("Voulez-vous vraiment supprimer cet employé ?")) {
            var xmlhttp = new XMLHttpRequest();
            var url = "<?= VIEWS . 'Services/deleteUser.php?ajax=1&id=' ?>" + id;

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

    function deleteCommand(id) {
        if (confirm("Voulez-vous vraiment supprimer cet article ?")) {
            var xmlhttp = new XMLHttpRequest();
            var url = "<?= VIEWS . 'Services/deleteArticle.php?ajax=1&id=' ?>" + id;

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