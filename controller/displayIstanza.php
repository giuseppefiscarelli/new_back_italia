<?php


if(!empty($_SESSION['message'])){
    $message = $_SESSION['message'];
    $alertType = $_SESSION['success'] ? 'success':'danger';
    $iconType = $_SESSION['success'] ? 'check':'exclamation-triangle';
    require 'view/template/message.php';
    unset($_SESSION['message'],$_SESSION['success']);
  }
                  
  $id = getParam('id',0);
 
  if($id){
      $i = getIstanza($id);
  }else{
    $utente= $_SESSION['userData']['email'];
    $i = getIstanzaUser($utente);
}
  // var_dump($i);
  
  
         require_once 'view/istanze/istanza_page.php';

         ?>