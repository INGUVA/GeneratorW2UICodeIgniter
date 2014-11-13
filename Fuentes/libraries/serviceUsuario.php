<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceUsuario{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_uuid,$_fechaCreacion,$_ip,$_nombre,$_apellidos,$_dni,$_telefono,$_email,$_password,$_fechaUltimaModificacion,$_alias,$_imagenBIDI){
          $obj= $this->CI->usuario->Nuevo($_uuid,$_fechaCreacion,$_ip,$_nombre,$_apellidos,$_dni,$_telefono,$_email,$_password,$_fechaUltimaModificacion,$_alias,$_imagenBIDI);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_uuid,$_fechaCreacion,$_ip,$_nombre,$_apellidos,$_dni,$_telefono,$_email,$_password,$_fechaUltimaModificacion,$_alias,$_imagenBIDI ){
          $obj= $this->CI->usuario->update($_id,$_uuid,$_fechaCreacion,$_ip,$_nombre,$_apellidos,$_dni,$_telefono,$_email,$_password,$_fechaUltimaModificacion,$_alias,$_imagenBIDI);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->usuario->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetUsuarioById($id){
         $obj = $this->CI->usuario->getUsuarioById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit, $offset, $campo, $order, $field, $busqueda){
         $objs = $this->CI->usuario->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};