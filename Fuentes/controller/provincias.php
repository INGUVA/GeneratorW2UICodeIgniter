<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Provincias extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->serviceprovincia->GetProvinciaById($recId);
		$data['provincia'] = $resultado->getValue();
		$this->load->view('pages/Provincias/getProvinciaJson',$data);
	}

	public function getAll(){
		$provincias=$this->serviceprovincia->GetAll();
		var_dump($Provincias);
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
		$resultado=$this->serviceprovincia->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaProvincia'] = $resultado->getValue();
		$this->load->view('pages/Provincias/getListaProvinciaJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Provincias/formNuevoProvincia');
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
				if(isset($record['provinciaNuevoProvincia'])&&$record['provinciaNuevoProvincia']!=""){$provincia=$record['provinciaNuevoProvincia'];}else{$provincia= "";}
				if(isset($record['visibleNuevoProvincia'])&&$record['visibleNuevoProvincia']!=""){$visible=$record['visibleNuevoProvincia'];}else{$visible= "false";}
				$resultado = $this->serviceprovincia->Nuevo($provincia,$visible				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Provincias/newProvinciaResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Provincias/newProvinciaResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Provincias/newProvinciaResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Provincias/formModificarProvincia');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['provinciaProvincia']!=""){$provincia=$record['provinciaProvincia'];}else{$provincia= "";}
			if($record['visibleProvincia']!=""){$visible=$record['visibleProvincia'];}else{$visible= "false";}
			$resultado = $this->serviceprovincia->Modificar($recid,$provincia,$visible		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Provincias/updateProvinciaResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->serviceprovincia->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Provincias/deleteProvinciaResult',$data);
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
 	$this->form_validation->set_rules('record[provinciaNuevoProvincia]','Provincia', 'required|min_length[3]|max_length[30]');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>