<div class="donor_view">
  <p class="name">
    <a href="<?php echo $config['site_home']?>/add_donor.php?network_id=<?php echo $value['id'];?>"><?php echo $value['name'] ?></a>
    <br/>
    <a href="tel:<?php echo $value['phone']?>">
      <?php echo $value['phone']?>
    </a>
  </p>
  <?php
    setlocale(LC_MONETARY,"en_IN");
    if(isset($value['pledged_amount']) && ($value['donor_status']!='lead' && $value['donor_status']!='disagreed')){
  ?>
    <p class="name">Amount Pledged: <?php echo money_format("%i",$value['pledged_amount'])?> (<?php echo strtoupper($value['pledge_type']) ?>)</p>
  <?php
    }
  ?>
  <div class="btn-group btn-group-justified" role="group" aria-label="...">
    <div class="btn-group" role="group">
      <?php
        if($value['donor_status']=='lead'){
      ?>
        <a href="tel:<?php echo $value['phone']?>">
          <button type="button" class="btn btn-default">
            <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp; Call
          </button>
        </a>
      <?php
        }else {
      ?>
        <a href="tel:<?php echo $value['phone']?>">
          <button type="button" class="btn btn-default">
            <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp; Call
          </button>
        </a>
      <?php
        }
      ?>
    </div>
    <div class="btn-group" role="group">
      <?php
        if($value['donor_status']=='lead'){
      ?>
        <a href="<?php echo $config['site_home']?>pledge.php?network_id=<?php echo $value['id'] ?>">
          <button type="button" class="btn btn-default">
            Pledge
          </button>
        </a>
      <?php
        }
        else if($value['donor_status']=='donated'){
      ?>
        <a href="">
          <button type="button" disabled id="" class="btn btn-default">
            Add to Donut
          </button>
        </a>
      <?php
        }
        else if($value['donor_status']=='pledged'){
      ?>
        <a href="">
          <button type="button" disabled id="" class="btn btn-default">
            Add to Donut
          </button>
        </a>
      <?php
        }else {
      ?>
        <a href="<?php echo $config['site_home']?>pledge.php?network_id=<?php echo $value['id'] ?>">
          <button type="button" class="btn btn-default">
            Pledge
          </button>
        </a>
      <?php
        }
      ?>
    </div>
    <div class="btn-group" role="group">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <?php
         if($value['donor_status']=='pledged' && $value['collection_by']=='self'){
        ?>
          <li>
            <a title="Donation Collected" href="<?php $config['site_home']?>update_status.php?action=donated&network_id=<?php echo $value['id'] ?>">
              <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> &nbsp; Donated
            </a>
          </li>
          <!-- <li>
            <a href="<?php //$config['site_home']?>update_status.php?action=handover_to_mad&network_id=<?php //echo $value['id'] ?>">
              Handover to MAD
            </a>
          </li> -->
        <?php
          }
        ?>
        <?php
         if($value['donor_status']=='pledged' && $value['collection_by']=='handover_to_mad'){
        ?>
          <li>
            <a href="<?php $config['site_home']?>update_status.php?action=collect_by_self&network_id=<?php echo $value['id'] ?>">
              Collect by Self
            </a>
          </li>
        <?php
          }
        ?>
        <li>
          <a title="Delete Donor" href="<?php $config['site_home']?>update_status.php?action=delete&network_id=<?php echo $value['id'] ?>">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> &nbsp; Delete
          </a>
        </li>
        <?php
         if($value['donor_status']!='donated'){
        ?>
          <li>
            <a title="Donor Disagreed" href="<?php $config['site_home']?>update_status.php?action=disagreed&network_id=<?php echo $value['id'] ?>">
              <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> &nbsp;
              <?php
               if($value['donor_status']=='lead'){
              ?>
                Didn't Agree
              <?php
                }else if($value['donor_status']=='pledged'){
              ?>
                Changed Mind
              <?php
                }
              ?>
            </a>
          </li>
        <?php
          }
        ?>

      </ul>
    </div>
  </div>
</div>
