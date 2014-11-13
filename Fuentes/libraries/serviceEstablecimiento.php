<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceEstablecimiento{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_nombre,$_direccion,$_idProvincia,$_idLocalidad,$_cp,$_telefono,$_telefono2,$_email,$_web,$_facebook,$_twitter,$_fechaAlta,$_fechaBaja,$_latitud,$_longitud,$_descripcion){
          $obj= $this->CI->establecimiento->Nuevo($_nombre,$_direccion,$_idProvincia,$_idLocalidad,$_cp,$_telefono,$_telefono2,$_email,$_web,$_facebook,$_twitter,$_fechaAlta,$_fechaBaja,$_latitud,$_longitud,$_descripcion);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_nombre,$_direccion,$_idProvincia,$_idLocalidad,$_cp,$_telefono,$_telefono2,$_email,$_web,$_facebook,$_twitter,$_fechaAlta,$_fechaBaja,$_latitud,$_longitud,$_descripcion ){
          $obj= $this->CI->establecimiento->update($_id,$_nombre,$_direccion,$_idProvincia,$_idLocalidad,$_cp,$_telefono,$_telefono2,$_email,$_web,$_facebook,$_twitter,$_fechaAlta,$_fechaBaja,$_latitud,$_longitud,$_descripcion);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->establecimiento->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetEstablecimientoById($id){
         $obj = $this->CI->establecimiento->getEstablecimientoById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit, $offset, $campo, $order, $field, $busqueda){
         $objs = $this->CI->establecimiento->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};