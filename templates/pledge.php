<?php
// include_once('includes/application.php'); //Find the configuratio files in db/config.php


$time =  date('Y-m-d H:i:s');

// if($time > '2018-03-26 00:00:00')
//   $form_status = false;
// else
//   $form_status = true;

// dump($network_info);
$form_status = true;

?>


<!-- TODO : Add number of months field for NACH
    Description under Donor Email, reciepts will be sent to this email.
-->

<div class="row">
    <div class="form-class col-md-6 col-md-offset-3">
        <form id="msform" action="add_donor_pledge.php" method="POST" onsubmit="submit_form()">
          <!-- progressbar -->
          <?php if($form_status){ ?>


          <!-- Verify your details -->
            <fieldset>

                <!-- Hidden Fields -->
                <input type="hidden" name="network_id" value="<?php echo $network_info['id'] ?>">
                <input type="hidden" name="pledge_type" id="pledge_type" value="<?php echo $network_info['pledge_type'] ?>">

                <?php

                  $nach_display='';
                  $online_display='';
                  $cash_display='';

                  switch ($network_info['pledge_type']) {
                    case 'nach':
                      $nach_display = 'style="display:block"';
                      break;
                    case 'online':
                      $online_display = 'style="display:block"';
                      break;
                    case 'cash-cheque':
                      $cash_display = 'style="display:block"';
                      break;
                    default:
                      break;
                  }

                ?>

                <h2 class="fs-title">Pledge from: <?php echo $network_info['name']; ?></h2>
                <hr>
                <p class="form-label">Select the type of Pledge <span class="required">*</span></p>
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                  <div class="btn-group" role="group">
                    <button type="button" id="nach" class="btn pledge btn-default <?php if($network_info['pledge_type']=='nach') echo 'active'; ?>" >NACH</button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" id="online" class="btn pledge btn-default <?php if($network_info['pledge_type']=='online') echo 'active'; ?>" >Online</button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" id="cash-cheque" class="btn pledge btn-default <?php if($network_info['pledge_type']=='cash-cheque') echo 'active'; ?>" >Cash/Cheque</button>
                  </div>
                </div>
                <hr>

                <p class="required-text">*Required</p>

                <input type='text' name="user_id" class="hidden" value= "<?php echo $user['id'] ?>"/>

                <p class="form-label">Pledged Amount <span class="required">*</span></p>

                <div class="hidden_div nach" <?php echo $nach_display;?> >
                    <p class="note">Enter Monthly Pledged Amount for NACH Donations</p>
                </div>
                <input type="text" name="pledged_amount" onchange="{req(this);}" placeholder="" required value="<?php echo $network_info['pledged_amount']; ?>"/>

                <hr>

                <div class="hidden_div nach" <?php echo $nach_display;?> >

                  <p class="form-label">NACH Duration <span class="required">*</span> </p>
                  <?php echo create_select($nach_duration, 'nach_duration',$network_info['nach_duration']) ?>

                  <p class="form-label">Form Collection <span class="required">*</span> </p>

                </div>

                <div class="hidden_div cash-cheque" <?php echo $cash_display?> >
                  <p class="form-label">Cash/Cheque Collection <span class="required">*</span> </p>

                </div>

                <div class="hidden_div nach cash-cheque" <?php echo $cash_display; echo $nach_display?> >

                  <?php echo create_select($collection, 'collection_by',$network_info['collection_by']) ?>

                  <p class="form-label">Donor Email <span class="required">*</span></p>
                  <input type="email" name="donor_email" onchange="req(this);" placeholder="roxxxx@xxxx.com" value="<?php echo $network_info['email']; ?>"/>
                  <p class="note">Receipts will be sent to the Email ID mentioned above</p>

                  <?php
                    $address = '';
                    $pin     = '';
                    if($network_info['address']!=""){
                      $value = explode(' PIN: ',$network_info['address']);
                      $address = $value[0];
                      $pin     = $value[1];
                    }
                  ?>

                  <p class="form-label">Donor Address <span class="required">*</span></p>
                  <input type="text" name="donor_address" placeholder="Enter Donor Address"  value="<?php echo $address; ?>"/><br>

                  <p class="form-label">Donor Pin Code <span class="required">*</span></p>
                  <input type="text" name="donor_pincode" placeholder="Enter Donor Pin Code"  value="<?php echo $pin; ?>" /><br>

                  <p class="form-label">Collection Date <span class="required">*</span></p>
                  <input type="date" name="collect_on" min="<?php echo date('Y-m-d');?>" value="<?php
                      if($network_info['collect_on']!=NULL)
                      echo date('Y-m-d',strtotime($network_info['collect_on']));
                  ?>"/><br>

                </div>

                <div class="hidden_div online" <?php echo $online_display;?>>

                  <p class="form-label">Follow Up Date <span class="required">*</span></p>
                  <input type="date" name="follow_up_on" min="<?php echo date('Y-m-d');?>" value="<?php
                      if($network_info['follow_up_on']!=NULL)
                      echo date('Y-m-d',strtotime($network_info['follow_up_on']));
                  ?>"/><br>

                </div>


                <div class="center">
                  <input type="submit" name="submit" class="action-button" value="Save Pledge"/>
                </div>
            </fieldset>





          <?php } else{  ?>
          <fieldset>
              <!-- <h2 class="fs-title">Form is Closed</h2> -->
              <h3 class="fs-subtitle">The deadline to fill the form is now over.</h3><hr>
              <h2 class="fs-title">Applied already?</h2>
              <h3 class="fs-subtitle"> Completed your Tasks?</h3>
              <a href="./task-upload/" target="_self"><div class="action-button" style="width:200px; margin:auto;">Upload Tasks</div></a>
          </fieldset>
          <?php }   ?>
        </form>
    </div>
</div>

        <!-- /.MultiStep Form -->
