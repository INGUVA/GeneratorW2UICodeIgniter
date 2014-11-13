<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accioncomerciales extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->serviceaccioncomercial->GetAccioncomercialById($recId);
		$data['accioncomercial'] = $resultado->getValue();
		$this->load->view('pages/Accioncomerciales/getAccioncomercialJson',$data);
	}

	public function getAll(){
		$accioncomerciales=$this->serviceaccioncomercial->GetAll();
		var_dump($Accioncomerciales);
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
		$resultado=$this->serviceaccioncomercial->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaAccioncomercial'] = $resultado->getValue();
		$this->load->view('pages/Accioncomerciales/getListaAccioncomercialJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Accioncomerciales/formNuevoAccioncomercial');
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
				if(isset($record['nombreNuevoAccioncomercial'])&&$record['nombreNuevoAccioncomercial']!=""){$nombre=$record['nombreNuevoAccioncomercial'];}else{$nombre= "";}
				if(isset($record['descripcionNuevoAccioncomercial'])&&$record['descripcionNuevoAccioncomercial']!=""){$descripcion=$record['descripcionNuevoAccioncomercial'];}else{$descripcion= "";}
				if(isset($record['fechaInicioNuevoAccioncomercial'])&&$record['fechaInicioNuevoAccioncomercial']!=""){$fechaInicio=$record['fechaInicioNuevoAccioncomercial'];}else{$fechaInicio= "";}
				if(isset($record['fechaFinNuevoAccioncomercial'])&&$record['fechaFinNuevoAccioncomercial']!=""){$fechaFin=$record['fechaFinNuevoAccioncomercial'];}else{$fechaFin= "";}
				if(isset($record['anuncianteNuevoAccioncomercial'])&&$record['anuncianteNuevoAccioncomercial']!=""){$anunciante=$record['anuncianteNuevoAccioncomercial'];}else{$anunciante= "";}
				if(isset($record['contenidoNuevoAccioncomercial'])&&$record['contenidoNuevoAccioncomercial']!=""){$contenido=$record['contenidoNuevoAccioncomercial'];}else{$contenido= "";}
				$resultado = $this->serviceaccioncomercial->Nuevo($nombre,$descripcion,$fechaInicio,$fechaFin,$anunciante,$contenido				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Accioncomerciales/newAccioncomercialResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Accioncomerciales/newAccioncomercialResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Accioncomerciales/newAccioncomercialResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Accioncomerciales/formModificarAccioncomercial');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombreAccioncomercial']!=""){$nombre=$record['nombreAccioncomercial'];}else{$nombre= "";}
			if($record['descripcionAccioncomercial']!=""){$descripcion=$record['descripcionAccioncomercial'];}else{$descripcion= "";}
			if($record['fechaInicioAccioncomercial']!=""){$fechaInicio=$record['fechaInicioAccioncomercial'];}else{$fechaInicio= "";}
			if($record['fechaFinAccioncomercial']!=""){$fechaFin=$record['fechaFinAccioncomercial'];}else{$fechaFin= "";}
			if($record['anuncianteAccioncomercial']!=""){$anunciante=$record['anuncianteAccioncomercial'];}else{$anunciante= "";}
			if($record['contenidoAccioncomercial']!=""){$contenido=$record['contenidoAccioncomercial'];}else{$contenido= "";}
			$resultado = $this->serviceaccioncomercial->Modificar($recid,$nombre,$descripcion,$fechaInicio,$fechaFin,$anunciante,$contenido		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Accioncomerciales/updateAccioncomercialResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->serviceaccioncomercial->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Accioncomerciales/deleteAccioncomercialResult',$data);
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
 	$this->form_validation->set_rules('record[nombreNuevoAccioncomercial]','Nombre', 'required|min_length[3]|max_length[50]');
 	$this->form_validation->set_rules('record[descripcionNuevoAccioncomercial]','Descripción', 'required|min_length[3]|max_length[50]');
 	$this->form_validation->set_rules('record[fechaInicioNuevoAccioncomercial]','Fecha de inicio', 'required');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>