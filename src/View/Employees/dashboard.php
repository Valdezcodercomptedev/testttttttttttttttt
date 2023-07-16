<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\ServiceController;
use App\Controller\TransactionController;
use App\Controller\SupplierController;
use App\Controller\UserController;
use App\Controller\CommandController;
use Core\Auth\Auth;

(new ServiceController())->dashboard();
(new TransactionController())->dashboard();
(new CommandController())->dashboard();
(new CommandController())->dashboardApproved();
(new UserController())->dashboard();
(new SupplierController())->dashboard();

require_once dirname(__DIR__) . DS . 'Elements' . DS . 'header.php';

?>

<!-- ========== section start ========== -->
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- ========== title-wrapper end ========== -->
        
        <div class="row">
            <?php $auth_user = (new Auth())->getAuthUser();
            if (empty($auth_user) || $auth_user->getRole() == 'DIR' || $auth_user->getRole() == 'EMP') {
            ?>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon purple">
                            <i class="lni lni-package"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">Articles</h6>
                            <h3 class="text-bold mb-10"><?= $stics['nb_commands'] ?></h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
            <?php
            }
            ?>
            

            
            <!-- End Col -->
            <?php $auth_user = (new Auth())->getAuthUser();
            if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
            ?>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon orange">
                            <i class="lni lni-apartment"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">Services</h6>
                            <h3 class="text-bold mb-10"><?= $stats['nb_services'] ?></h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
            <?php
            }
            ?>
            <!-- End Col -->
            <?php $auth_user = (new Auth())->getAuthUser();
            if (empty($auth_user) || $auth_user->getRole() == 'FSR' || $auth_user->getRole() == 'DIR') {
            ?>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon primary">
                            <i class="lni lni-cart-full"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">Commandes</h6>
                            <h3 class="text-bold mb-10"><?= $statics['nb_commands'] ?></h3>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <!-- End Icon Cart -->
            <!-- End Col -->
            <?php $auth_user = (new Auth())->getAuthUser();
            if (empty($auth_user) || $auth_user->getRole() == 'EMP' || $auth_user->getRole() == 'DIR') {
            ?>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon success">
                            <i class="lni lni-users"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">Employés</h6>
                            <h3 class="text-bold mb-10"><?= $sts['nb_users'] ?></h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
            <?php
            }
            ?>
            <!-- End Col -->
            <?php $auth_user = (new Auth())->getAuthUser();
            if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
            ?>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon success">
                            <i class="lni lni-users"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">Fournisseurs</h6>
                            <h3 class="text-bold mb-10"><?= $stat['nb_suppliers'] ?></h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
            <?php
            }
            ?>
            <!-- End Col -->
            <?php $auth_user = (new Auth())->getAuthUser();
            if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
            ?>
            
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon orange">
                            <i class="lni lni-dollar"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">Ventes (Fcfa)</h6>
                            <h3 class="text-bold mb-10"><?= number_format($strats['nb_transactions']) ?></h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
            <?php
            }
            ?>
            
            <!-- End Col -->
        </div>
        <!-- End Row -->
        <?php $auth_user = (new Auth())->getAuthUser();
        if (empty($auth_user) || $auth_user->getRole() == 'DIR') {
        ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="title d-flex flex-wrap justify-content-between">
                            <div class="left">
                                <h6 class="text-medium mb-10">Ventes aucours de l'année
                                    <strong>
                                        <script>
                                            document.write(new Date().getFullYear());
                                        </script>
                                    </strong>
                                </h6>
                            </div>
                        </div><br>
                        <!-- End Title -->
                        <div class="chart">
                            <canvas id="Chart1" style="width: 100%; height: 400px"></canvas>
                        </div>
                        <!-- End Chart -->
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
    </div>
<?php
        }
?>
<!-- end container -->
</section>
<!-- ========== section end ========== -->

<?php require_once dirname(__DIR__) . DS . 'Elements' . DS . 'footer.php'; ?>