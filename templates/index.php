
<!-- MultiStep Form -->

<?php

?>


<div class="row">
    <div class="form-class col-md-6 col-md-offset-3">
        <form id="msform" action="preview.php" method="POST" onsubmit="submit_form()">
          <fieldset>
              <br>

              <?php
                if(isset($added_donor)){
              ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><?php echo $added_donor['name'] ?></strong> was successfully added to your network.
                </div>
              <?php
                }
              ?>

              <h2 class="fs-title">Hi, <?php echo $user['name'];?></h2>
	            <!-- <h3 class="fs-subtitle">Please verify your personal details.</h3> -->
              <hr>
              <p class="form-label">

              </p>
              <p class="form-label">

              </p>
              <!-- <p class="form-label">What do you want to do?</p> -->

              <div class="row">
                <div class="add_donor col-md-6 col-md-offset-3">
                  <a href="./add_donor.php">
                    <button type="button" class="add-button btn btn-default btn-lg">
                      <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> <br>Add Donor
                    </button>
                  </a>
                </div>
              </div>
              <?php
                if(!empty($network_data)){
              ?>
              <hr>
              <div class="row">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a href="#my_network" data-toggle="tab">Donors to Call</a></li>
                  <li role="presentation"><a data-toggle="tab" href="#pledged">Pledges to be Collected</a></li>
                  <li role="presentation"><a data-toggle="tab" href="#donated">Pledges Collected</a></li>
                  <li role="presentation"><a data-toggle="tab" href="#handover">Handed Over to MAD</a></li>
                </ul>

                <div class="tab-content">
                    <!-- My Network -->
                    <div class="tab-pane fade in active" id="my_network">
                        <?php
                          if(empty($leads)){
                            echo $nodata;
                          }
                          foreach ($leads as $key => $value) {
                            include './templates/modules/donor_info.php';
                          }
                        ?>
                    </div>
                    <!-- Pending Collection -->
                    <div class="tab-pane fade in" id="pledged">
                      <?php
                        if(empty($pledged)){
                          echo $nodata;
                        }
                        foreach ($pledged as $key => $value) {
                          include './templates/modules/donor_info.php';
                        }
                      ?>
                    </div>
                    <!-- Collected -->
                    <div class="tab-pane fade in" id="donated">
                      <?php
                        if(empty($donated)){
                          echo $nodata;
                        }
                        foreach ($donated as $key => $value) {
                          include './templates/modules/donor_info.php';
                        }
                      ?>
                    </div>
                    <div class="tab-pane fade in" id="handover">
                      <?php
                        if(empty($handover)){
                          echo $nodata;
                        }
                        foreach ($handover as $key => $value) {
                          include './templates/modules/donor_info.php';
                        }
                      ?>
                    </div>
                </div>
              </div>
              <?php
                }
              ?>


          </fieldset>
        </form>
    </div>
</div>


<script src="https://www.gstatic.com/firebasejs/5.4.0/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyBVlOLflYMAYMMXTXwLIBrX6CaJe_39IPI",
    authDomain: "fraise-ef296.firebaseapp.com",
    databaseURL: "https://fraise-ef296.firebaseio.com",
    projectId: "fraise-ef296",
    storageBucket: "fraise-ef296.appspot.com",
    messagingSenderId: "451577737862"
  };
  firebase.initializeApp(config);
</script>
