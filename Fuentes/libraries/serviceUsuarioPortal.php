<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceUsuarioPortal{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_nombre,$_password,$_email,$_baja,$_fechaAlta,$_fechaBaja){
          $obj= $this->CI->usuarioportal->Nuevo($_nombre,$_password,$_email,$_baja,$_fechaAlta,$_fechaBaja);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_nombre,$_password,$_email,$_baja,$_fechaAlta,$_fechaBaja ){
          $obj= $this->CI->usuarioportal->update($_id,$_nombre,$_password,$_email,$_baja,$_fechaAlta,$_fechaBaja);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->usuarioportal->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetUsuarioPortalById($id){
         $obj = $this->CI->usuarioportal->getUsuarioPortalById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit, $offset, $campo, $order, $field, $busqueda){
         $objs = $this->CI->usuarioportal->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};