<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Establecimientos extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->serviceestablecimiento->GetEstablecimientoById($recId);
		$data['establecimiento'] = $resultado->getValue();
		$this->load->view('pages/Establecimientos/getEstablecimientoJson',$data);
	}

	public function getAll(){
		$establecimientos=$this->serviceestablecimiento->GetAll();
		var_dump($Establecimientos);
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
		$resultado=$this->serviceestablecimiento->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaEstablecimiento'] = $resultado->getValue();
		$this->load->view('pages/Establecimientos/getListaEstablecimientoJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Establecimientos/formNuevoEstablecimiento');
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
				if(isset($record['nombreNuevoEstablecimiento'])&&$record['nombreNuevoEstablecimiento']!=""){$nombre=$record['nombreNuevoEstablecimiento'];}else{$nombre= "";}
				if(isset($record['direccionNuevoEstablecimiento'])&&$record['direccionNuevoEstablecimiento']!=""){$direccion=$record['direccionNuevoEstablecimiento'];}else{$direccion= "";}
				if(isset($record['idProvinciaNuevoEstablecimiento'])&&$record['idProvinciaNuevoEstablecimiento']!=""){$idProvincia=$record['idProvinciaNuevoEstablecimiento'];}else{$idProvincia= "";}
				if(isset($record['idLocalidadNuevoEstablecimiento'])&&$record['idLocalidadNuevoEstablecimiento']!=""){$idLocalidad=$record['idLocalidadNuevoEstablecimiento'];}else{$idLocalidad= "";}
				if(isset($record['cpNuevoEstablecimiento'])&&$record['cpNuevoEstablecimiento']!=""){$cp=$record['cpNuevoEstablecimiento'];}else{$cp= "0";}
				if(isset($record['telefonoNuevoEstablecimiento'])&&$record['telefonoNuevoEstablecimiento']!=""){$telefono=$record['telefonoNuevoEstablecimiento'];}else{$telefono= "";}
				if(isset($record['telefono2NuevoEstablecimiento'])&&$record['telefono2NuevoEstablecimiento']!=""){$telefono2=$record['telefono2NuevoEstablecimiento'];}else{$telefono2= "";}
				if(isset($record['emailNuevoEstablecimiento'])&&$record['emailNuevoEstablecimiento']!=""){$email=$record['emailNuevoEstablecimiento'];}else{$email= "";}
				if(isset($record['webNuevoEstablecimiento'])&&$record['webNuevoEstablecimiento']!=""){$web=$record['webNuevoEstablecimiento'];}else{$web= "";}
				if(isset($record['facebookNuevoEstablecimiento'])&&$record['facebookNuevoEstablecimiento']!=""){$facebook=$record['facebookNuevoEstablecimiento'];}else{$facebook= "";}
				if(isset($record['twitterNuevoEstablecimiento'])&&$record['twitterNuevoEstablecimiento']!=""){$twitter=$record['twitterNuevoEstablecimiento'];}else{$twitter= "";}
				if(isset($record['fechaAltaNuevoEstablecimiento'])&&$record['fechaAltaNuevoEstablecimiento']!=""){$fechaAlta=$record['fechaAltaNuevoEstablecimiento'];}else{$fechaAlta= "";}
				if(isset($record['fechaBajaNuevoEstablecimiento'])&&$record['fechaBajaNuevoEstablecimiento']!=""){$fechaBaja=$record['fechaBajaNuevoEstablecimiento'];}else{$fechaBaja= "";}
				if(isset($record['latitudNuevoEstablecimiento'])&&$record['latitudNuevoEstablecimiento']!=""){$latitud=$record['latitudNuevoEstablecimiento'];}else{$latitud= "0.0";}
				if(isset($record['longitudNuevoEstablecimiento'])&&$record['longitudNuevoEstablecimiento']!=""){$longitud=$record['longitudNuevoEstablecimiento'];}else{$longitud= "0.0";}
				if(isset($record['descripcionNuevoEstablecimiento'])&&$record['descripcionNuevoEstablecimiento']!=""){$descripcion=$record['descripcionNuevoEstablecimiento'];}else{$descripcion= "";}
				$resultado = $this->serviceestablecimiento->Nuevo($nombre,$direccion,$idProvincia,$idLocalidad,$cp,$telefono,$telefono2,$email,$web,$facebook,$twitter,$fechaAlta,$fechaBaja,$latitud,$longitud,$descripcion				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Establecimientos/newEstablecimientoResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Establecimientos/newEstablecimientoResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Establecimientos/newEstablecimientoResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Establecimientos/formModificarEstablecimiento');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombreEstablecimiento']!=""){$nombre=$record['nombreEstablecimiento'];}else{$nombre= "";}
			if($record['direccionEstablecimiento']!=""){$direccion=$record['direccionEstablecimiento'];}else{$direccion= "";}
			if($record['idProvinciaEstablecimiento']!=""){$idProvincia=$record['idProvinciaEstablecimiento'];}else{$idProvincia= "";}
			if($record['idLocalidadEstablecimiento']!=""){$idLocalidad=$record['idLocalidadEstablecimiento'];}else{$idLocalidad= "";}
			if($record['cpEstablecimiento']!=""){$cp=$record['cpEstablecimiento'];}else{$cp= "0";}
			if($record['telefonoEstablecimiento']!=""){$telefono=$record['telefonoEstablecimiento'];}else{$telefono= "";}
			if($record['telefono2Establecimiento']!=""){$telefono2=$record['telefono2Establecimiento'];}else{$telefono2= "";}
			if($record['emailEstablecimiento']!=""){$email=$record['emailEstablecimiento'];}else{$email= "";}
			if($record['webEstablecimiento']!=""){$web=$record['webEstablecimiento'];}else{$web= "";}
			if($record['facebookEstablecimiento']!=""){$facebook=$record['facebookEstablecimiento'];}else{$facebook= "";}
			if($record['twitterEstablecimiento']!=""){$twitter=$record['twitterEstablecimiento'];}else{$twitter= "";}
			if($record['fechaAltaEstablecimiento']!=""){$fechaAlta=$record['fechaAltaEstablecimiento'];}else{$fechaAlta= "";}
			if($record['fechaBajaEstablecimiento']!=""){$fechaBaja=$record['fechaBajaEstablecimiento'];}else{$fechaBaja= "";}
			if($record['latitudEstablecimiento']!=""){$latitud=$record['latitudEstablecimiento'];}else{$latitud= "0.0";}
			if($record['longitudEstablecimiento']!=""){$longitud=$record['longitudEstablecimiento'];}else{$longitud= "0.0";}
			if($record['descripcionEstablecimiento']!=""){$descripcion=$record['descripcionEstablecimiento'];}else{$descripcion= "";}
			$resultado = $this->serviceestablecimiento->Modificar($recid,$nombre,$direccion,$idProvincia,$idLocalidad,$cp,$telefono,$telefono2,$email,$web,$facebook,$twitter,$fechaAlta,$fechaBaja,$latitud,$longitud,$descripcion		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Establecimientos/updateEstablecimientoResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->serviceestablecimiento->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Establecimientos/deleteEstablecimientoResult',$data);
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
 	$this->form_validation->set_rules('record[nombreNuevoEstablecimiento]','Nombre', 'required|min_length[3]|max_length[150]');
 	$this->form_validation->set_rules('record[direccionNuevoEstablecimiento]','Direccion', 'required');
 	$this->form_validation->set_rules('record[idProvinciaNuevoEstablecimiento]','Provincia', 'required');
 	$this->form_validation->set_rules('record[idLocalidadNuevoEstablecimiento]','Localidad', 'required');
 	$this->form_validation->set_rules('record[cpNuevoEstablecimiento]','C.P.', '|max_length[5]');
 	$this->form_validation->set_rules('record[telefonoNuevoEstablecimiento]','Teléfono', '|max_length[15]');
 	$this->form_validation->set_rules('record[telefono2NuevoEstablecimiento]','Teléfono 2', '|max_length[15]');
 	$this->form_validation->set_rules('record[emailNuevoEstablecimiento]','Email', '|max_length[255]|valid_email');
 	$this->form_validation->set_rules('record[webNuevoEstablecimiento]','Web', '|max_length[255]');
 	$this->form_validation->set_rules('record[facebookNuevoEstablecimiento]','Facebook', '|max_length[255]');
 	$this->form_validation->set_rules('record[twitterNuevoEstablecimiento]','Twitter', '|max_length[255]');
 	$this->form_validation->set_rules('record[fechaAltaNuevoEstablecimiento]','Fecha alta', '|max_length[10]');
 	$this->form_validation->set_rules('record[fechaBajaNuevoEstablecimiento]','Fecha baja', '|max_length[10]');
 	$this->form_validation->set_rules('record[latitudNuevoEstablecimiento]','Latitud', '|max_length[12]');
 	$this->form_validation->set_rules('record[longitudNuevoEstablecimiento]','Longitud', '|max_length[12]');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>