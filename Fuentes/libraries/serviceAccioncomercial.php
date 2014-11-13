<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceAccioncomercial{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_nombre,$_descripcion,$_fechaInicio,$_fechaFin,$_anunciante,$_contenido){
          $obj= $this->CI->accioncomercial->Nuevo($_nombre,$_descripcion,$_fechaInicio,$_fechaFin,$_anunciante,$_contenido);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_nombre,$_descripcion,$_fechaInicio,$_fechaFin,$_anunciante,$_contenido ){
          $obj= $this->CI->accioncomercial->update($_id,$_nombre,$_descripcion,$_fechaInicio,$_fechaFin,$_anunciante,$_contenido);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->accioncomercial->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAccioncomercialById($id){
         $obj = $this->CI->accioncomercial->getAccioncomercialById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit, $offset, $campo, $order, $field, $busqueda){
         $objs = $this->CI->accioncomercial->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};