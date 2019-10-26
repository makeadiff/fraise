<?php

  $user_info = check_user(false);
  $user_id = $user_info['user_id'];

  // $user_id = $_SESSION['user_id'];

  $fraise = new FRaise;

  // $fraise->getenumValues('Donut_Network','relationship');

  $query_user= "SELECT * FROM User WHERE id = ".$user_id;

  setlocale(LC_MONETARY,"en_IN");  

  //Array of Drop Downs

  $relationship = [
    'parent' => 'Parent',
    'sibling' => 'Sibling',
    'relative' => 'Relative',
    'friend' => 'Friend',
    'acquaintance' => 'Acquaintance',
    'other' => 'Other'
  ];

  $age_bracket = [
    '0-25' => 'Under 25',
    '25-40' => '25 to 40',
    '40+' => '40 +',
  ];

  $nach_potential = [
    '200-500' => '&#8377;200-500',
    '500-1000' => '&#8377;500-1,000',
    '1000-5000' => '&#8377;1,000-5,000',
    '5000+' => 'More than &#8377;5,000 '
  ];

  $otd_potential = [
    '500-1000' => '&#8377;500-1,000',
    '1000-5000' => '&#8377;1,000-5,000',
    '5000-10000' => '&#8377;5,000-10000',
    '10000-50000' => '&#8377;10,000-50,000 ',
    '50000-100000' => '&#8377;50,000-1 Lakh ',
    '100000+' => 'More than &#8377;1 Lakh '
  ];

  $nach_duration = [
    '12+' => 'Until Cancelled',
    '12' => '12 Months',
    '11' => '11 Months',
    '10' => '10 Months',
    '9' => '9 Months',
    '8' => '8 Months',
    '7' => '7 Months',
    '6' => '6 Months',
  ];

  $giving_likelihood = [
    'high' => 'High',
    'medium' => 'Medium',
    'low' => 'Low',
    'not-likely' => 'Not Likely'
  ];


  $collection = [
    'self' => 'By Myself',
    'handover_to_mad' => 'Handover collection to MAD',
  ];

  $nodata = '<p class="name center">
              <span class="error-icon glyphicon glyphicon-info-sign" aria-hidden="true"></span>
              <br/>
              No Data.
            </p>';

  $user = $sql->getAll($query_user);
  $user = $user[0];



  $query_task_show = 'SELECT *
                      FROM FAM_UserTask
                      WHERE user_id='.$user_id;

  $tasks = $sql->getAssoc($query_task_show);


  // ---------------------- Functions -------------------------

  function getPinCodeFromSheet($sheet_url) {
  	global $common;
  	require 'includes/classes/ParseCSV.php';
  	$sheet = new ParseCSV($sheet_url);

    $pincodes = array();

    foreach ($sheet as $data) {
      if(is_numeric($data['A']))
        $pincodes[] = $data['A'];
    }

    $pincodes = array_unique($pincodes);
    // unset($pincodes[0]);
  	return $pincodes;
  }

  function create_select($array,$name,$response=null, $req = false){

    if($req)
      $output = '<select name="'.$name.'" id="'.$name.'" required>';
    else
      $output = '<select name="'.$name.'" id="'.$name.'">';

    foreach ($array as $key => $value) {
      if($key==$response){
        $selected = 'selected';
      }
      else{
        $selected = '';
      }
      $output .= '<option value='.$key.' '.$selected.'>';
      $output .= $value;
      $output .= '</option>';
    }
    $output .= '</select>';

    return $output;
  }

  function create_radio($array,$name,$response=null, $req = false){

    $output = '<p class="form-label">';
    foreach ($array as $key => $value) {
      if($key==$response){
        $checked = 'checked';
      }
      else{
        $checked = '';
      }
      $output .= '<input class="radio-button-left" type="radio" id="'.$name.$key.'" name='.$name.' value="'.$key.'" '.$checked.'/>';
      $output .= '<label for="'.$name.$key.'">';
      $output .= $value;
      $output .= '</label>';
      $output .= '<br>';
    }
    $output .= '</p>';

    return $output;
  }

  function form_value($array,$key){
    if(isset($array[$key])){
      return $array[$key];
    }
    else{
      return '';
    }
  }
