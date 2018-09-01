<?php
  require 'common.php';
  $network_data = $fraise->get_network_info($user_id);
  $leads = $fraise->get_network_info($user_id,'lead');
  $pledged = $fraise->get_network_info($user_id,'pledged','self');
  $donated = $fraise->get_network_info($user_id,'donated');
  $disagreed = $fraise->get_network_info($user_id,'disagreed');
  $handover = $fraise->get_network_info($user_id,'pledged','handover_to_mad');
  // dump($handover);
  $total_pledge = $fraise->get_total_pledge($user_id);


  if(isset($_GET['success'])){
    $added_id = $_GET['success'];
    $added_donor = $fraise->get_network($added_id);
  }

  // $total_pledge = $fraise->get_total_collected($user_id);

  render();
?>
