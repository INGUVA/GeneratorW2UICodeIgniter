<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UsuarioPortales extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->serviceusuarioportal->GetUsuarioPortalById($recId);
		$data['usuarioportal'] = $resultado->getValue();
		$this->load->view('pages/UsuarioPortales/getUsuarioPortalJson',$data);
	}

	public function getAll(){
		$usuarioportales=$this->serviceusuarioportal->GetAll();
		var_dump($UsuarioPortales);
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
		$resultado=$this->serviceusuarioportal->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaUsuarioPortal'] = $resultado->getValue();
		$this->load->view('pages/UsuarioPortales/getListaUsuarioPortalJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/UsuarioPortales/formNuevoUsuarioPortal');
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
				if(isset($record['nombreNuevoUsuarioPortal'])&&$record['nombreNuevoUsuarioPortal']!=""){$nombre=$record['nombreNuevoUsuarioPortal'];}else{$nombre= "";}
				if(isset($record['passwordNuevoUsuarioPortal'])&&$record['passwordNuevoUsuarioPortal']!=""){$password=$record['passwordNuevoUsuarioPortal'];}else{$password= "";}
				if(isset($record['emailNuevoUsuarioPortal'])&&$record['emailNuevoUsuarioPortal']!=""){$email=$record['emailNuevoUsuarioPortal'];}else{$email= "";}
				if(isset($record['bajaNuevoUsuarioPortal'])&&$record['bajaNuevoUsuarioPortal']!=""){$baja=$record['bajaNuevoUsuarioPortal'];}else{$baja= "false";}
				if(isset($record['fechaAltaNuevoUsuarioPortal'])&&$record['fechaAltaNuevoUsuarioPortal']!=""){$fechaAlta=$record['fechaAltaNuevoUsuarioPortal'];}else{$fechaAlta= "";}
				if(isset($record['fechaBajaNuevoUsuarioPortal'])&&$record['fechaBajaNuevoUsuarioPortal']!=""){$fechaBaja=$record['fechaBajaNuevoUsuarioPortal'];}else{$fechaBaja= "";}
				$resultado = $this->serviceusuarioportal->Nuevo($nombre,$password,$email,$baja,$fechaAlta,$fechaBaja				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/UsuarioPortales/newUsuarioPortalResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/UsuarioPortales/newUsuarioPortalResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/UsuarioPortales/newUsuarioPortalResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/UsuarioPortales/formModificarUsuarioPortal');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['nombreUsuarioPortal']!=""){$nombre=$record['nombreUsuarioPortal'];}else{$nombre= "";}
			if($record['passwordUsuarioPortal']!=""){$password=$record['passwordUsuarioPortal'];}else{$password= "";}
			if($record['emailUsuarioPortal']!=""){$email=$record['emailUsuarioPortal'];}else{$email= "";}
			if($record['bajaUsuarioPortal']!=""){$baja=$record['bajaUsuarioPortal'];}else{$baja= "false";}
			if($record['fechaAltaUsuarioPortal']!=""){$fechaAlta=$record['fechaAltaUsuarioPortal'];}else{$fechaAlta= "";}
			if($record['fechaBajaUsuarioPortal']!=""){$fechaBaja=$record['fechaBajaUsuarioPortal'];}else{$fechaBaja= "";}
			$resultado = $this->serviceusuarioportal->Modificar($recid,$nombre,$password,$email,$baja,$fechaAlta,$fechaBaja		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/UsuarioPortales/updateUsuarioPortalResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->serviceusuarioportal->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/UsuarioPortales/deleteUsuarioPortalResult',$data);
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
 	$this->form_validation->set_rules('record[nombreNuevoUsuarioPortal]','Nombre', 'required|max_length[12]');
 	$this->form_validation->set_rules('record[passwordNuevoUsuarioPortal]','Password', 'required|max_length[25]');
 	$this->form_validation->set_rules('record[emailNuevoUsuarioPortal]','Email', '|max_length[45]|valid_email');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>