<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServicePacientes{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_nombre,$_apellidos,$_fechaNacimiento){
          $obj= $this->CI->pacientes->Nuevo($_nombre,$_apellidos,$_fechaNacimiento);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_nombre,$_apellidos,$_fechaNacimiento ){
          $obj= $this->CI->pacientes->update($_id,$_nombre,$_apellidos,$_fechaNacimiento);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->pacientes->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetPacientesById($id){
         $obj = $this->CI->pacientes->getPacientesById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit, $offset, $campo, $order, $field, $busqueda){
         $objs = $this->CI->pacientes->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};