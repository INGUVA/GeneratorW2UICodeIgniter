<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceNotificacion{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_idAnunciante,$_validada,$_fechaEnvio,$_fechaValidacion,$_fechaCreacion,$_texto){
          $obj= $this->CI->notificacion->Nuevo($_idAnunciante,$_validada,$_fechaEnvio,$_fechaValidacion,$_fechaCreacion,$_texto);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_idAnunciante,$_validada,$_fechaEnvio,$_fechaValidacion,$_fechaCreacion,$_texto ){
          $obj= $this->CI->notificacion->update($_id,$_idAnunciante,$_validada,$_fechaEnvio,$_fechaValidacion,$_fechaCreacion,$_texto);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->notificacion->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetNotificacionById($id){
         $obj = $this->CI->notificacion->getNotificacionById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit, $offset, $campo, $order, $field, $busqueda){
         $objs = $this->CI->notificacion->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};