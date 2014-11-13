<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServicePaciente{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_nombre,$_apellidos,$_descripcion,$_empresa,$_fechaNacimiento,$_imagen){
          $obj= $this->CI->paciente->Nuevo($_nombre,$_apellidos,$_descripcion,$_empresa,$_fechaNacimiento,$_imagen);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_nombre,$_apellidos,$_descripcion,$_empresa,$_fechaNacimiento,$_imagen ){
          $obj= $this->CI->paciente->update($_id,$_nombre,$_apellidos,$_descripcion,$_empresa,$_fechaNacimiento,$_imagen);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->paciente->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetPacienteById($id){
         $obj = $this->CI->paciente->getPacienteById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit=100, $offset=0, $campo='Id', $order='asc', $field='', $busqueda=''){
         $objs = $this->CI->paciente->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};