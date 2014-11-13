<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->serviceusuario->GetUsuarioById($recId);
		$data['usuario'] = $resultado->getValue();
		$this->load->view('pages/Usuarios/getUsuarioJson',$data);
	}

	public function getAll(){
		$usuarios=$this->serviceusuario->GetAll();
		var_dump($Usuarios);
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
		$resultado=$this->serviceusuario->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaUsuario'] = $resultado->getValue();
		$this->load->view('pages/Usuarios/getListaUsuarioJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Usuarios/formNuevoUsuario');
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
				if(isset($record['uuidNuevoUsuario'])&&$record['uuidNuevoUsuario']!=""){$uuid=$record['uuidNuevoUsuario'];}else{$uuid= "";}
				if(isset($record['fechaCreacionNuevoUsuario'])&&$record['fechaCreacionNuevoUsuario']!=""){$fechaCreacion=$record['fechaCreacionNuevoUsuario'];}else{$fechaCreacion= "";}
				if(isset($record['ipNuevoUsuario'])&&$record['ipNuevoUsuario']!=""){$ip=$record['ipNuevoUsuario'];}else{$ip= "";}
				if(isset($record['nombreNuevoUsuario'])&&$record['nombreNuevoUsuario']!=""){$nombre=$record['nombreNuevoUsuario'];}else{$nombre= "";}
				if(isset($record['apellidosNuevoUsuario'])&&$record['apellidosNuevoUsuario']!=""){$apellidos=$record['apellidosNuevoUsuario'];}else{$apellidos= "";}
				if(isset($record['dniNuevoUsuario'])&&$record['dniNuevoUsuario']!=""){$dni=$record['dniNuevoUsuario'];}else{$dni= "";}
				if(isset($record['telefonoNuevoUsuario'])&&$record['telefonoNuevoUsuario']!=""){$telefono=$record['telefonoNuevoUsuario'];}else{$telefono= "";}
				if(isset($record['emailNuevoUsuario'])&&$record['emailNuevoUsuario']!=""){$email=$record['emailNuevoUsuario'];}else{$email= "";}
				if(isset($record['passwordNuevoUsuario'])&&$record['passwordNuevoUsuario']!=""){$password=$record['passwordNuevoUsuario'];}else{$password= "";}
				if(isset($record['fechaUltimaModificacionNuevoUsuario'])&&$record['fechaUltimaModificacionNuevoUsuario']!=""){$fechaUltimaModificacion=$record['fechaUltimaModificacionNuevoUsuario'];}else{$fechaUltimaModificacion= "";}
				if(isset($record['aliasNuevoUsuario'])&&$record['aliasNuevoUsuario']!=""){$alias=$record['aliasNuevoUsuario'];}else{$alias= "";}
				if(isset($record['imagenBIDINuevoUsuario'])&&$record['imagenBIDINuevoUsuario']!=""){$imagenBIDI=$record['imagenBIDINuevoUsuario'];}else{$imagenBIDI= "";}
				$resultado = $this->serviceusuario->Nuevo($uuid,$fechaCreacion,$ip,$nombre,$apellidos,$dni,$telefono,$email,$password,$fechaUltimaModificacion,$alias,$imagenBIDI				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Usuarios/newUsuarioResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Usuarios/newUsuarioResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Usuarios/newUsuarioResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Usuarios/formModificarUsuario');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['uuidUsuario']!=""){$uuid=$record['uuidUsuario'];}else{$uuid= "";}
			if($record['fechaCreacionUsuario']!=""){$fechaCreacion=$record['fechaCreacionUsuario'];}else{$fechaCreacion= "";}
			if($record['ipUsuario']!=""){$ip=$record['ipUsuario'];}else{$ip= "";}
			if($record['nombreUsuario']!=""){$nombre=$record['nombreUsuario'];}else{$nombre= "";}
			if($record['apellidosUsuario']!=""){$apellidos=$record['apellidosUsuario'];}else{$apellidos= "";}
			if($record['dniUsuario']!=""){$dni=$record['dniUsuario'];}else{$dni= "";}
			if($record['telefonoUsuario']!=""){$telefono=$record['telefonoUsuario'];}else{$telefono= "";}
			if($record['emailUsuario']!=""){$email=$record['emailUsuario'];}else{$email= "";}
			if($record['passwordUsuario']!=""){$password=$record['passwordUsuario'];}else{$password= "";}
			if($record['fechaUltimaModificacionUsuario']!=""){$fechaUltimaModificacion=$record['fechaUltimaModificacionUsuario'];}else{$fechaUltimaModificacion= "";}
			if($record['aliasUsuario']!=""){$alias=$record['aliasUsuario'];}else{$alias= "";}
			if($record['imagenBIDIUsuario']!=""){$imagenBIDI=$record['imagenBIDIUsuario'];}else{$imagenBIDI= "";}
			$resultado = $this->serviceusuario->Modificar($recid,$uuid,$fechaCreacion,$ip,$nombre,$apellidos,$dni,$telefono,$email,$password,$fechaUltimaModificacion,$alias,$imagenBIDI		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Usuarios/updateUsuarioResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->serviceusuario->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Usuarios/deleteUsuarioResult',$data);
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
 	$this->form_validation->set_rules('record[uuidNuevoUsuario]','UUID', '|max_length[50]');
 	$this->form_validation->set_rules('record[ipNuevoUsuario]','IP', '|max_length[15]');
 	$this->form_validation->set_rules('record[nombreNuevoUsuario]','Nombre', '|max_length[45]');
 	$this->form_validation->set_rules('record[apellidosNuevoUsuario]','Apellidos', '|max_length[45]');
 	$this->form_validation->set_rules('record[dniNuevoUsuario]','DNI', '|max_length[10]');
 	$this->form_validation->set_rules('record[telefonoNuevoUsuario]','Telefono', '|max_length[15]');
 	$this->form_validation->set_rules('record[emailNuevoUsuario]','Email', '|max_length[120]|valid_email');
 	$this->form_validation->set_rules('record[passwordNuevoUsuario]','Password', '|max_length[45]');
 	$this->form_validation->set_rules('record[aliasNuevoUsuario]','Nick', '|max_length[45]');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>