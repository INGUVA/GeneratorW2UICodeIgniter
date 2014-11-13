<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceTratamiento{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_descripcion,$_fechaInicio,$_fechaFinal,$_paciente,$_finalizado){
          $obj= $this->CI->tratamiento->Nuevo($_descripcion,$_fechaInicio,$_fechaFinal,$_paciente,$_finalizado);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_descripcion,$_fechaInicio,$_fechaFinal,$_paciente,$_finalizado ){
          $obj= $this->CI->tratamiento->update($_id,$_descripcion,$_fechaInicio,$_fechaFinal,$_paciente,$_finalizado);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->tratamiento->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetTratamientoById($id){
         $obj = $this->CI->tratamiento->getTratamientoById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit=100, $offset=0, $campo='Id', $order='asc', $field='', $busqueda=''){
         $objs = $this->CI->tratamiento->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};