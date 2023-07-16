      <!-- ========== footer start =========== -->
      <footer class="footer">
          <div class="container-fluid">
              <hr>
              <div class="row" style="justify-content: center;">
                  <div class="col-md-6 order-last order-md-first">
                      <div class="copyright text-center text-md-start">
                          <p class="text-sm">
                              © Copyrights
                              <a href="#" class="footer-link fw-bolder">FranklinCoder02 </a>,
                              <script>
                                  document.write(new Date().getFullYear());
                              </script>.
                              Tout droits reservés
                          </p>
                      </div>
                  </div>
              </div>
              <!-- end row -->
          </div>
          <!-- end container -->
      </footer>


      <!-- ========= All Javascript files linkup ======== -->
      <script src="<?= TEMPLATE_PATH ?>assets/js/bootstrap.bundle.min.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/js/Chart.min.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/js/dynamic-pie-chart.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/js/moment.min.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/js/fullcalendar.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/js/jvectormap.min.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/js/world-merc.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/js/polyfill.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/js/main.js"></script>

      <!-- jQuery -->
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
      <!-- jquery-validation -->
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>

      <script src="<?= TEMPLATE_PATH ?>assets/plugins/moment/moment.min.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/inputmask/inputmask.es6.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/inputmask/inputmask.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/inputmask/jquery.inputmask.js"></script>
      <script src="<?= TEMPLATE_PATH ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>

      <script type="text/javascript">
          var logoutbtn = document.getElementById('logoutBtn');

          if (logoutbtn !== null) {
              logoutbtn.addEventListener('click', function() {
                  if (confirm("Voulez-vous fermer votre session ?")) {
                      location.href = "<?= VIEWS . 'Auth/logout.php' ?>";
                  }
              });
          }
      </script>

      <script>
          $(function() {

              $('[data-mask]').inputmask()
          });
      </script>