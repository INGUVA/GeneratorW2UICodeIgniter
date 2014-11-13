<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceSorteo{
    private $CI;
    public function __construct(){
          $this->CI =& get_instance();
    }

      function Nuevo($_imagen,$_titulo,$_descripcion,$_fechaSorteo,$_numeroGanadores){
          $obj= $this->CI->sorteo->Nuevo($_imagen,$_titulo,$_descripcion,$_fechaSorteo,$_numeroGanadores);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
     }

    public function Modificar($_id,$_imagen,$_titulo,$_descripcion,$_fechaSorteo,$_numeroGanadores ){
          $obj= $this->CI->sorteo->update($_id,$_imagen,$_titulo,$_descripcion,$_fechaSorteo,$_numeroGanadores);
         if($obj!=null){
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }else{
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         };
    }

    public function EliminarById($id){
         $obj = $this->CI->sorteo->eliminarById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetSorteoById($id){
         $obj = $this->CI->sorteo->getSorteoById($id);
         if($obj==null){
              return Actionconfirmation::CreateFailureActionConfirmation("ERROR", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("OK", $obj);
         }
    }

    public function GetAll($limit, $offset, $campo, $order, $field, $busqueda){
         $objs = $this->CI->sorteo->getAll($limit, $offset, $campo, $order,$field, $busqueda);
         if($objs==null || $objs==""){
              return Actionconfirmation::CreateFailureActionConfirmation("", null);
         }else{
              return Actionconfirmation::CreateSuccessActionConfirmation("", $objs);
         }
    }
};