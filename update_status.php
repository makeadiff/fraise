<?php

  require 'common.php';

  if(isset($_GET['network_id'])&&isset($_GET['action'])){
    if($_GET['action']=='delete'){
      $fraise->deleteAll($_GET['network_id']);
      header('location: '.$config['site_home'].'index.php');
    }
    if($_GET['action']=='disagreed'){
      $fraise->update_status($_GET['network_id'],$_GET['action']);
      header('location: '.$config['site_home'].'index.php');
    }
  }
  else{
    header('location: '.$config['site_home'].'index.php');
  }
