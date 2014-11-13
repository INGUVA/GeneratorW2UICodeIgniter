<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceGaleria{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_Nombre,$_Orden,$_Principal){
          $obj= $this->CI->galeria->Nuevo($_Nombre,$_Orden,$_Principal);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_Nombre,$_Orden,$_Principal ){
          $obj= $this->CI->galeria->update($_id,$_Nombre,$_Orden,$_Principal);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->galeria->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetGaleriaById($id){
         $obj = $this->CI->galeria->getGaleriaById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit, $offset, $campo, $order, $field, $busqueda){
         $objs = $this->CI->galeria->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};