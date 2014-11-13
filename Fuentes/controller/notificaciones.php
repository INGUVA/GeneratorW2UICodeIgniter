<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificaciones extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->servicenotificacion->GetNotificacionById($recId);
		$data['notificacion'] = $resultado->getValue();
		$this->load->view('pages/Notificaciones/getNotificacionJson',$data);
	}

	public function getAll(){
		$notificaciones=$this->servicenotificacion->GetAll();
		var_dump($Notificaciones);
	}

	public function getListJson(){
		if(isset($_POST['limit'])){$limit=$_POST['limit'];}else{$limit=30;}
		if(isset($_POST['offset'])){$offset=$_POST['offset'];}else{$offset=0;}
		//Ordenación
		if(isset($_POST['sort'])&&($_POST['sort']!=null)){
			$sort = $_POST['sort'][0];
			$campo = $sort['field'];
			$direction = $sort['direction'];
		}else{
			$campo = "";
			$direction = "";
		}
		//Busquedas
		if(isset($_POST['search']) && $_POST['search']!=""){
			$search = $_POST['search'][0];
			$field = $search['field'];
			$busqueda = $search['value'];
		}else{
			$field = "";
			$busqueda = "";
		}
		$resultado=$this->servicenotificacion->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaNotificacion'] = $resultado->getValue();
		$this->load->view('pages/Notificaciones/getListaNotificacionJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Notificaciones/formNuevoNotificacion');
		}else{
			return "";
		}
	}

	public function nuevo(){
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$record=$_POST['record'];
 			$resultadoComprobaciones = $this->ComprobacionesFormNuevo();
			if($resultadoComprobaciones->isCorrecto()){
				if(isset($record['idAnuncianteNuevoNotificacion'])&&$record['idAnuncianteNuevoNotificacion']!=""){$idAnunciante=$record['idAnuncianteNuevoNotificacion'];}else{$idAnunciante= "0";}
				if(isset($record['validadaNuevoNotificacion'])&&$record['validadaNuevoNotificacion']!=""){$validada=$record['validadaNuevoNotificacion'];}else{$validada= "false";}
				if(isset($record['fechaEnvioNuevoNotificacion'])&&$record['fechaEnvioNuevoNotificacion']!=""){$fechaEnvio=$record['fechaEnvioNuevoNotificacion'];}else{$fechaEnvio= "";}
				if(isset($record['fechaValidacionNuevoNotificacion'])&&$record['fechaValidacionNuevoNotificacion']!=""){$fechaValidacion=$record['fechaValidacionNuevoNotificacion'];}else{$fechaValidacion= "";}
				if(isset($record['fechaCreacionNuevoNotificacion'])&&$record['fechaCreacionNuevoNotificacion']!=""){$fechaCreacion=$record['fechaCreacionNuevoNotificacion'];}else{$fechaCreacion= "";}
				if(isset($record['textoNuevoNotificacion'])&&$record['textoNuevoNotificacion']!=""){$texto=$record['textoNuevoNotificacion'];}else{$texto= "";}
				$resultado = $this->servicenotificacion->Nuevo($idAnunciante,$validada,$fechaEnvio,$fechaValidacion,$fechaCreacion,$texto				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Notificaciones/newNotificacionResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Notificaciones/newNotificacionResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Notificaciones/newNotificacionResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Notificaciones/formModificarNotificacion');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['idAnuncianteNotificacion']!=""){$idAnunciante=$record['idAnuncianteNotificacion'];}else{$idAnunciante= "0";}
			if($record['validadaNotificacion']!=""){$validada=$record['validadaNotificacion'];}else{$validada= "false";}
			if($record['fechaEnvioNotificacion']!=""){$fechaEnvio=$record['fechaEnvioNotificacion'];}else{$fechaEnvio= "";}
			if($record['fechaValidacionNotificacion']!=""){$fechaValidacion=$record['fechaValidacionNotificacion'];}else{$fechaValidacion= "";}
			if($record['fechaCreacionNotificacion']!=""){$fechaCreacion=$record['fechaCreacionNotificacion'];}else{$fechaCreacion= "";}
			if($record['textoNotificacion']!=""){$texto=$record['textoNotificacion'];}else{$texto= "";}
			$resultado = $this->servicenotificacion->Modificar($recid,$idAnunciante,$validada,$fechaEnvio,$fechaValidacion,$fechaCreacion,$texto		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Notificaciones/updateNotificacionResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicenotificacion->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Notificaciones/deleteNotificacionResult',$data);
	}

	public function ComprobacionesNuevo(){
		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
	}

	public function ComprobacionesModificar(){
		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
	}

	public function ComprobacionesEliminar(){
		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
	}

	public function ComprobacionesListar(){
		return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
	}
	public function ComprobacionesFormNuevo(){
 	$this->form_validation->set_rules('record[idAnuncianteNuevoNotificacion]','Anunciante', 'required');
 	$this->form_validation->set_rules('record[validadaNuevoNotificacion]','Validada', 'required');
 	$this->form_validation->set_rules('record[fechaEnvioNuevoNotificacion]','Fecha de envío', 'required');
 	$this->form_validation->set_rules('record[textoNuevoNotificacion]','Texto de la notificaicón', '|min_length[3]|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>