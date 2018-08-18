<?php
  require 'common.php';

  if(isset($_GET['network_id'])){
    $network_id = $_GET['network_id'];
  }
  else{
    header('location:index.php');
  }


  $network_info = $fraise->get_network($network_id);
  // dump($network_info);

  if($network_info['pledge_type']=='nach'){
    $network_info['pledged_amount'] = $network_info['pledged_amount']/str_replace('+','',$network_info['nach_duration']);
  }
  // $network_data = $fraise->get_network_info($user_id);

  render();
?>
