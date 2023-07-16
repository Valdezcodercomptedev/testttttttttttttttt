<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\SupplierController;
use App\Controller\CommandController;

(new CommandController())->add();

(new SupplierController())->view();

require_once dirname(__DIR__) . DS . 'Elements' . DS . 'header.php';

?>

<!-- ========== tab components start ========== -->
<section class="tab-components">
  <div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Commandes</h2>
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
                  <a href="<?= VIEWS . 'Suppliers' ?>"> Fournisseurs </a>
                </li>
                <li class="breadcrumb-item">Commandes </li>
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
        <div class="col-lg-10">
          <!-- input style start -->
          <div class="card-style mb-30">
            <h6 class="mb-25">Remplissez les champs ci-après pour commander un article</h6>

            <form method="post" action="" id="quickForm">
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-12 mb-3">
                    <label>Nom du fournisseur</label>
                    <input type="text" name="name" value="<?= $supplier->getName() ?>" class="form-control" autocomplete="off" readonly>
                  </div>

                  <div class="col-12 col-sm-12 mb-3">
                    <div class="card card-primary card-outline card-outline-tabs">
                      <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Boisson</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Lingerie</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Produits frais</a>
                          </li>
                        </ul>
                      </div>
                      <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                          <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                            <div class="col-md">
                              <div class="card mb-3">
                                <div class="row g-0">
                                  <div class="col-md-4">
                                    <img class="card-img card-img-left" src="<?= IMAGES_TEMP ?>whisky.jfif" alt="Company Image" class="w-100">
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body">
                                      <p class="card-text">
                                      <div class="row">
                                        <div class="form-group col-md-12 mb-2">
                                          <label>Nom de l'article</label>
                                          <input type="text" name="libelle" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                          <label>Contenance (en Centilitre)</label>
                                          <input type="text" name="volume" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                          <label>Quantité</label>
                                          <input type="text" name="quantity" class="form-control" autocomplete="off">
                                        </div>
                                      </div>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                            <div class="col-md">
                              <div class="card mb-3">
                                <div class="row g-0">
                                  <div class="col-md-8">
                                    <div class="card-body">
                                      <p class="card-text">
                                      <div class="row">
                                        <div class="form-group col-md-12 mb-2">
                                          <label>Nom de l'article</label>
                                          <input type="text" name="libelleLog"  class="form-control" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                          <label>Quantité</label>
                                          <input type="text" name="qteLog" class="form-control" autocomplete="off">
                                        </div>
                                      </div>
                                      </p>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <img class="card-img card-img-left" src="<?= IMAGES_TEMP ?>laundry.jfif" alt="Company Image" class="w-100">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                            <div class="col-md">
                              <div class="card mb-3">
                                <div class="row g-0">
                                  <div class="col-md-4">
                                    <img class="card-img card-img-left" src="<?= IMAGES_TEMP ?>foods.jfif" alt="Company Image" class="w-100">
                                  </div>
                                  <div class="col-md-8">
                                    <div class="card-body">
                                      <p class="card-text">
                                      <div class="row">
                                        <div class="form-group col-md-12 mb-2">
                                          <label>Nom de l'article</label>
                                          <input type="text" name="libelleAli" name="libelle" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                          <label>Quantité</label>
                                          <input type="text" name="qteAli" class="form-control" autocomplete="off">
                                        </div>
                                      </div>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- /.card-body -->
                  <div class="col-6 mb-3">
                    <a href="<?= VIEWS . 'Suppliers' ?>" class="btn btn-outline-secondary col-md-4">Retour</a>

                    <input type="submit" class="btn btn-primary" value="Enregistrer" name="add_command">
                  </div>
                </div>
            </form>
            <!-- ========== form-elements-wrapper end ========== -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.card -->
  </div>


  <!-- end row -->
  </div>
  <!-- end container -->
  </div>
</section>
<!-- ========== tab components end ========== -->
<?php require_once dirname(__DIR__) . DS . 'Elements' . DS . 'footer-val.php'; ?>

<!-- Page specific script -->
<script>
  $(function() {

    $('#quickForm').validate({
      rules: {
        name: {
          required: !0,
        },
        libelle: {
          required: !0,
          maxlength: 50,
          minlength: 2
        },
        libelleLog: {
          required: !0,
          maxlength: 50,
          minlength: 2
        },
        libelleAli: {
          required: !0,
          maxlength: 50,
          minlength: 2
        },
        volume: {
          required: !0,
          number: !0
        },
        quantity: {
          required: !0,
          number: !0
        },
        qteLog: {
          required: !0,
          number: !0
        },
        qteAli: {
          required: !0,
          number: !0
        },
      },
      messages: {
        name: {
          required: "Veuillez spécifier le nom du fournisseur.",
        },
        libelle: {
          required: "Veuillez entrer le nom de l'article à commander.",
          maxlength: "Le nom de l'article à commander ne doit pas dépasser 50 caractères.",
          minlength: "Le nom de l'article à commander doit avoir aumoinse 02 caractères."
        },
        libelleLog: {
          required: "Veuillez entrer le nom de l'article à commander.",
          maxlength: "Le nom de l'article à commander ne doit pas dépasser 50 caractères.",
          minlength: "Le nom de l'article à commander doit avoir aumoinse 02 caractères."
        },
        libelleAli: {
          required: "Veuillez entrer le nom de l'article à commander.",
          maxlength: "Le nom de l'article à commander ne doit pas dépasser 50 caractères.",
          minlength: "Le nom de l'article à commander doit avoir aumoinse 02 caractères."
        },
        volume: {
          required: "Veuillez entrer la contenance de l'article à commander",
          number: "Veuillez entrer un nombre.",
        },
        quantity: {
          required: "Veuillez entrer la quantité d'article à commander",
          number: "Veuillez entrer un nombre.",
        },
        qteLog: {
          required: "Veuillez entrer la quantité d'article à commander",
          number: "Veuillez entrer un nombre.",
        },
        qteAli: {
          required: "Veuillez entrer la quantité d'article à commander",
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

<script type="text/javascript">
  function deleteCommand(id) {
    if (confirm("Voulez-vous vraiment supprimer cette commande ?")) {
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
</script>


<script type="text/javascript">
  function sendCommand(id) {
    if (confirm("Voulez-vous vraiment commander cet article ?")) {
      var xmlhttp = new XMLHttpRequest();
      var url = "<?= VIEWS . 'Suppliers/sendCommand.php?ajax=1&id=' ?>" + id;

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