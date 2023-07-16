<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\AuthController;

use App\Controller\CompanyController;

(new CompanyController())->index();

(new AuthController())->login();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?= TEMPLATE_PATH ?>assets/images/favicons/favicon.ico" type="image/x-icon" />
    <title>Se connecter</title>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= TEMPLATE_PATH ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= TEMPLATE_PATH ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= TEMPLATE_PATH ?>assets/css/style.css" rel="stylesheet">

</head>

<body>

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="logo d-flex align-items-center w-auto">
                                    <img src="<?= TEMPLATE_PATH ?>assets/images/favicons/favicon.ico" alt="">
                                    <span class="d-none d-lg-block" style="text-transform: capitalize;"> <?= $company->getName() ?: 'Hotel'  ?></span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

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

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Connectez-vous à votre compte</h5>
                                        <p class="text-center small">Entrez votre nom d'utilisateur et votre mot de passe</p>
                                    </div>

                                    <form method="post" action="" class="row g-3 needs-validation" novalidate>

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Nom d'utilisateur</label>
                                            <input type="text" name="username" class="form-control" id="yourUsername" required>
                                            <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Mot de passe</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                                            <div class="invalid-feedback">Veuillez entrer votre mot de passe!</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-success w-100" type="submit" name="login">Se connecter</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits">
                                &copy; Copyright <strong><span><a href="https://github.com/franklinCoder02" target="_blank">Valdezprince dev</a></span></strong>, <script>
                                    document.write(new Date().getFullYear());
                                </script>. Tout droits reservés
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <!-- Vendor JS Files -->
    <script src="<?= TEMPLATE_PATH ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Template Main JS File -->
    <script src="<?= TEMPLATE_PATH ?>assets/js/main-1.js"></script>

    <script>
        function flash() {
            document.getElementById('flasher').innerHTML = "";
            <?php
            unset($_SESSION['error']);
            ?>
        }
        window.setTimeout(flash, 5000);
    </script>

</body>

</html>