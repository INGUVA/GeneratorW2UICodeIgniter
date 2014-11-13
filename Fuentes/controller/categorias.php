<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->servicecategoria->GetCategoriaById($recId);
		$data['categoria'] = $resultado->getValue();
		$this->load->view('pages/Categorias/getCategoriaJson',$data);
	}

	public function getAll(){
		$categorias=$this->servicecategoria->GetAll();
		var_dump($Categorias);
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
		$resultado=$this->servicecategoria->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaCategoria'] = $resultado->getValue();
		$this->load->view('pages/Categorias/getListaCategoriaJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Categorias/formNuevoCategoria');
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
				if(isset($record['nombreNuevoCategoria'])&&$record['nombreNuevoCategoria']!=""){$nombre=$record['nombreNuevoCategoria'];}else{$nombre= "";}
				$resultado = $this->servicecategoria->Nuevo($nombre				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Categorias/newCategoriaResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Categorias/newCategoriaResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Categorias/newCategoriaResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Categorias/formModificarCategoria');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombreCategoria']!=""){$nombre=$record['nombreCategoria'];}else{$nombre= "";}
			$resultado = $this->servicecategoria->Modificar($recid,$nombre		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Categorias/updateCategoriaResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicecategoria->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Categorias/deleteCategoriaResult',$data);
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
 	$this->form_validation->set_rules('record[nombreNuevoCategoria]','Nombre', 'required|min_length[3]|max_length[80]');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>