<?php

require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\AuthController;

AuthController::require_auth();

use Core\Auth\Auth;

use App\Controller\CompanyController;

(new CompanyController())->index();
(new CompanyController())->verified();


use Core\Database\ConnectionManager;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?= TEMPLATE_PATH ?>assets/images/favicons/favicon.ico" type="image/x-icon" />
    <?php
    if (@$_SESSION['title']) {
    ?>
        <title><?= @$_SESSION['title'] ?></title>
    <?php
    }
    ?>
    <title>Tableau de bord</title>

    <!-- Vendor CSS Files -->
    <link href="<?= TEMPLATE_PATH ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= TEMPLATE_PATH ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= TEMPLATE_PATH ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>assets/css/lineicons.css" />
    <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="<?= TEMPLATE_PATH ?>assets/css/main.css" />
</head>

<body>
    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
        <div class="navbar-logo">
            <a href="<?= BASE_URL ?>">
                <h3 style="text-transform: capitalize;"> <strong> <?= $company->getName() ?: 'Hotel'  ?></strong></h3>
            </a>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>">
                        <span class="icon">
                            <i class="lni lni-grid-alt"></i>
                        </span>
                        <span class="text">Tableau de bord</span>
                    </a>
                </li>
                <span class="divider">
                    <hr />
                </span>

                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
                    ?>
                        <a href="<?= VIEW_PATH ?>Services/">
                            <span class="icon">
                                <i class="lni lni-apartment"></i>
                            </span>
                            <span class="text">Les Services</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>

                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
                    ?>
                        <a href="<?= VIEW_PATH ?>Commands/">
                            <span class="icon">
                                <i class="lni lni-cart-full"></i>
                            </span>
                            <span class="text"> Les Commandes</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>
                

                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
                    ?>
                        <a href="<?= VIEW_PATH ?>Suppliers/">
                            <span class="icon">
                                <i class="lni lni-users"></i>
                            </span>
                            <span class="text">Les Fournisseurs</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>

                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'FSR') {
                    ?>

                        <a href="<?= VIEW_PATH ?>Suppliers/view.php">
                            <span class="icon">
                                <i class="lni lni-users"></i>
                            </span>
                            <span class="text">Fournisseurs</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
                    ?>
                        <a href="<?= VIEW_PATH ?>Commands/">
                            <span class="icon">
                                <i class="lni lni-cart-full"></i>
                            </span>
                            <span class="text">Gestion de chambres</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>

                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
                    ?>
                        <a href="<?= VIEW_PATH ?>Commands/">
                            <span class="icon">
                                <i class="lni lni-cart-full"></i>
                            </span>
                            <span class="text">Gestion reservations</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
                    ?>
                        <a href="<?= VIEW_PATH ?>Suppliers/">
                            <span class="icon">
                                <i class="lni lni-users"></i>
                            </span>
                            <span class="text">Espace Clients</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>
                
                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
                    ?>
                        <a href="<?= VIEW_PATH ?>Commands/">
                            <span class="icon">
                                <i class="lni lni-cart-full"></i>
                            </span>
                            <span class="text">Facturation</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>
                

                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'EMP') {
                    ?>

                        <a href="<?= VIEW_PATH ?>Employees/products.php">
                            <span class="icon">
                                <i class="lni lni-users"></i>
                            </span>
                            <span class="text">Voir son stock</span>
                        </a>
                    <?php
                    }
                    ?>
                </li>

                <li class="nav-item">
                    <?php $auth_user = (new Auth())->getAuthUser();
                    if (empty($auth_user) || $auth_user->getRole() == 'EMP') {
                    ?>

                        <a href="<?= VIEW_PATH ?>Employees/products.php">
                            <span class="icon">
                                <i class="lni lni-users"></i>
                            </span>
                            <span class="text"></span>
                        </a>
                    <?php
                    }
                    ?>
                </li>


                



                <li class="nav-item">

                    <span class="divider">
                        <hr />
                    </span>

                    <?php if ((new CompanyController())->verified() == true) {
                    ?>
                        <a href="<?= VIEW_PATH ?>Company/view.php">
                            <span class="icon">
                                <i class="lni lni-question-circle"></i>
                            </span>
                            <span class="text">Configuration</span>
                        </a>
                    <?php
                    } else {
                    ?>
                        <a href="<?= VIEW_PATH ?>Company/">
                            <span class="icon">
                                <i class="lni lni-question-circle"></i>
                            </span>
                            <span class="text">Configuration</span>
                        </a>
                    <?php
                    }
                    ?>

                </li>
            </ul>
        </nav>
    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== header start ========== -->
        <header class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-6">
                        <div class="header-left d-flex align-items-center">
                            <div class="menu-toggle-btn mr-20">
                                <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                                    <i class="lni lni-chevron-left me-2"></i>
                                </button>
                            </div>
                            <div class="header-search d-none d-md-flex">
                                <form action="#">
                                    <input type="text" placeholder="Rechercher" />
                                    <button><i class="lni lni-search-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-7 col-6">
                        <div class="header-right">

                            <?php $auth_user = (new Auth())->getAuthUser();
                            if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
                            ?>

                                <!-- notification start -->
                                <div class="notification-box ml-15 d-none d-md-flex">
                                    <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="lni lni-alarm"></i>
                                        <span>

                                            <?php

                                            $connectionManager = new ConnectionManager();

                                            $sql = "SELECT COUNT(*) AS count FROM articles e WHERE e.quantity < ? AND e.status = ? AND e.reading = ? AND e.deleted = ?";

                                            $query = $connectionManager->getConnection()->prepare($sql);

                                            $query->execute([10, "Enregistrée", "unread", 0]);

                                            $result = $query->fetch(\PDO::FETCH_ASSOC);

                                            $count = $result['count'];

                                            echo $count;
                                            ?>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">

                                        <?php

                                        $sql = "SELECT *  FROM articles e WHERE e.quantity < ? AND e.status = ? AND e.reading = ? AND e.deleted = ?";

                                        $query = $connectionManager->getConnection()->prepare($sql);

                                        $query->execute([5, "Enregistrée", "unread", 0]);

                                        if ($count > 0) {

                                            foreach ($query as $sq) {
                                        ?>
                                                <li>
                                                    <a onclick="UpdateView(<?= $sq['id'] ?>)">
                                                        <div class="content">
                                                            <h6>
                                                                Urgent
                                                            </h6>
                                                            <p>
                                                                L'article <span style="font-weight: bold; text-transform: capitalize;" class="text-dark"><?= $sq["libelle"] ?></span> du service
                                                                <?php

                                                                $connectionManager = new ConnectionManager();

                                                                $sql = "SELECT libelle FROM services e WHERE e.id  = ? AND e.deleted = ?";

                                                                $query = $connectionManager->getConnection()->prepare($sql);

                                                                $query->execute([$sq["service_id"], 0]);

                                                                foreach ($query as $rq) {
                                                                ?>
                                                                    <?= $rq["libelle"] ?>
                                                                    <?php
                                                                }
                                                                    ?>nécéssite un approvisionnement.
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                        <?php
                                            }
                                        } else {
                                            echo "Aucune notification.";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <!-- notification end -->

                            <?php
                            }
                            ?>
                            <!-- profile start -->
                            <div class="profile-box ml-15">
                                <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="profile-info">
                                        <div class="info">
                                            <div class="image">
                                                <img src="<?= ASSETS_PATH ?>/company/user_icon.png" alt="#MyPicture" />
                                            </div>
                                            <h6 style="text-transform: capitalize;"><?= $auth_user->getname() ?></h6>
                                        </div>
                                    </div>
                                    <i class="lni lni-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                    <li>
                                        <a href="<?= VIEW_PATH ?>Employees/profile.php">
                                            <i class="lni lni-user"></i> Mon profile
                                        </a>
                                    </li>
                                    <li>
                                        <a id="logoutBtn" href="#0"> <i class="lni lni-enter"></i> Se déconnecter </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- profile end -->
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?php
        if (@$_SESSION['succes']) {
        ?>
            <div class="" id="flash">
                <div class="alert alert-success alert-dismissible col-md-12 mt-3 mb-0 m-auto" style="width: 93%;" role="alert">
                    <span style="color: #37860c;"> <?= @$_SESSION['succes'] ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php
        }
        ?>

        <?php
        if (@$_SESSION['error']) {
        ?>
            <div class="" id="flasher">
                <div class="alert alert-danger alert-dismissible col-md-12 mt-3 mb-0 m-auto" style="width: 93%;" role="alert">
                    <span> <?= @$_SESSION['error'] ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php
        }
        ?>

        <script>
            function flash() {
                document.getElementById('flash').innerHTML = "";
                <?php
                unset($_SESSION['succes']);
                ?>
            }
            window.setTimeout(flash, 5000);
        </script>

        <script>
            function flash() {
                document.getElementById('flasher').innerHTML = "";
                <?php
                unset($_SESSION['error']);
                ?>
            }
            window.setTimeout(flash, 5000);
        </script>

        <script type="text/javascript">
            function UpdateView(id) {
                var xmlhttp = new XMLHttpRequest();
                var url = "<?= VIEWS . 'Commands/UpdateView.php?ajax=1&id=' ?>" + id;

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
        </script>
        <!-- ========== header end ========== -->