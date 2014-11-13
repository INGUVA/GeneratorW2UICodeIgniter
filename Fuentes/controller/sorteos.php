<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sorteos extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->servicesorteo->GetSorteoById($recId);
		$data['sorteo'] = $resultado->getValue();
		$this->load->view('pages/Sorteos/getSorteoJson',$data);
	}

	public function getAll(){
		$sorteos=$this->servicesorteo->GetAll();
		var_dump($Sorteos);
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
		$resultado=$this->servicesorteo->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaSorteo'] = $resultado->getValue();
		$this->load->view('pages/Sorteos/getListaSorteoJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Sorteos/formNuevoSorteo');
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
				if(isset($record['imagenNuevoSorteo'])&&$record['imagenNuevoSorteo']!=""){$imagen=$record['imagenNuevoSorteo'];}else{$imagen= "";}
				if(isset($record['tituloNuevoSorteo'])&&$record['tituloNuevoSorteo']!=""){$titulo=$record['tituloNuevoSorteo'];}else{$titulo= "";}
				if(isset($record['descripcionNuevoSorteo'])&&$record['descripcionNuevoSorteo']!=""){$descripcion=$record['descripcionNuevoSorteo'];}else{$descripcion= "";}
				if(isset($record['fechaSorteoNuevoSorteo'])&&$record['fechaSorteoNuevoSorteo']!=""){$fechaSorteo=$record['fechaSorteoNuevoSorteo'];}else{$fechaSorteo= "";}
				if(isset($record['numeroGanadoresNuevoSorteo'])&&$record['numeroGanadoresNuevoSorteo']!=""){$numeroGanadores=$record['numeroGanadoresNuevoSorteo'];}else{$numeroGanadores= "0";}
				$resultado = $this->servicesorteo->Nuevo($imagen,$titulo,$descripcion,$fechaSorteo,$numeroGanadores				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Sorteos/newSorteoResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Sorteos/newSorteoResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Sorteos/newSorteoResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Sorteos/formModificarSorteo');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['imagenSorteo']!=""){$imagen=$record['imagenSorteo'];}else{$imagen= "";}
			if($record['tituloSorteo']!=""){$titulo=$record['tituloSorteo'];}else{$titulo= "";}
			if($record['descripcionSorteo']!=""){$descripcion=$record['descripcionSorteo'];}else{$descripcion= "";}
			if($record['fechaSorteoSorteo']!=""){$fechaSorteo=$record['fechaSorteoSorteo'];}else{$fechaSorteo= "";}
			if($record['numeroGanadoresSorteo']!=""){$numeroGanadores=$record['numeroGanadoresSorteo'];}else{$numeroGanadores= "0";}
			$resultado = $this->servicesorteo->Modificar($recid,$imagen,$titulo,$descripcion,$fechaSorteo,$numeroGanadores		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Sorteos/updateSorteoResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicesorteo->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Sorteos/deleteSorteoResult',$data);
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
 	$this->form_validation->set_rules('record[tituloNuevoSorteo]','Título', '|max_length[255]');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>