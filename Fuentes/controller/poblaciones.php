<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poblaciones extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->servicepoblacion->GetPoblacionById($recId);
		$data['poblacion'] = $resultado->getValue();
		$this->load->view('pages/Poblaciones/getPoblacionJson',$data);
	}

	public function getAll(){
		$poblaciones=$this->servicepoblacion->GetAll();
		var_dump($Poblaciones);
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
		$resultado=$this->servicepoblacion->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaPoblacion'] = $resultado->getValue();
		$this->load->view('pages/Poblaciones/getListaPoblacionJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Poblaciones/formNuevoPoblacion');
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
				if(isset($record['nombreNuevoPoblacion'])&&$record['nombreNuevoPoblacion']!=""){$nombre=$record['nombreNuevoPoblacion'];}else{$nombre= "";}
				$resultado = $this->servicepoblacion->Nuevo($nombre				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Poblaciones/newPoblacionResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Poblaciones/newPoblacionResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Poblaciones/newPoblacionResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Poblaciones/formModificarPoblacion');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombrePoblacion']!=""){$nombre=$record['nombrePoblacion'];}else{$nombre= "";}
			$resultado = $this->servicepoblacion->Modificar($recid,$nombre		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Poblaciones/updatePoblacionResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicepoblacion->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Poblaciones/deletePoblacionResult',$data);
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
 	$this->form_validation->set_rules('record[nombreNuevoPoblacion]','Nombre', 'required|min_length[3]|max_length[100]');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>