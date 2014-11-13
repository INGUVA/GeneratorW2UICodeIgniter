<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceVideo{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_nombre,$_fechaCaptura,$_ruta,$_paciente){
          $obj= $this->CI->video->Nuevo($_nombre,$_fechaCaptura,$_ruta,$_paciente);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_nombre,$_fechaCaptura,$_ruta,$_paciente ){
          $obj= $this->CI->video->update($_id,$_nombre,$_fechaCaptura,$_ruta,$_paciente);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->video->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetVideoById($id){
         $obj = $this->CI->video->getVideoById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit=100, $offset=0, $campo='Id', $order='asc', $field='', $busqueda=''){
         $objs = $this->CI->video->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};