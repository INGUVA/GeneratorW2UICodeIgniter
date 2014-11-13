<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Galerias extends CI_Controller {
    private $CI;


	public function get(){
		$recId = $_GET['recid'];
		$resultado=$this->servicegaleria->GetGaleriaById($recId);
		$data['galeria'] = $resultado->getValue();
		$this->load->view('pages/Galerias/getGaleriaJson',$data);
	}

	public function getAll(){
		$galerias=$this->servicegaleria->GetAll();
		var_dump($Galerias);
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
		$resultado=$this->servicegaleria->GetAll($limit, $offset,$campo, $direction ,$field, $busqueda);
		$data['listaGaleria'] = $resultado->getValue();
		$this->load->view('pages/Galerias/getListaGaleriaJson',$data);
	}

	public function formNuevo(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeCrear = $this->ComprobacionesNuevo();
		if($actionPuedeCrear->isCorrecto()){
			$this->load->view('pages/Galerias/formNuevoGaleria');
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
				if(isset($record['NombreNuevoGaleria'])&&$record['NombreNuevoGaleria']!=""){$Nombre=$record['NombreNuevoGaleria'];}else{$Nombre= "";}
				if(isset($record['OrdenNuevoGaleria'])&&$record['OrdenNuevoGaleria']!=""){$Orden=$record['OrdenNuevoGaleria'];}else{$Orden= "0";}
				if(isset($record['PrincipalNuevoGaleria'])&&$record['PrincipalNuevoGaleria']!=""){$Principal=$record['PrincipalNuevoGaleria'];}else{$Principal= "false";}
				$resultado = $this->servicegaleria->Nuevo($Nombre,$Orden,$Principal				);
				$data['resultado'] = $resultado;
				$this->load->view('pages/Galerias/newGaleriaResult',$data);
				return ;
			}else{
				$data['resultado'] = $resultadoComprobaciones;
				$this->load->view('pages/Galerias/newGaleriaResult',$data);
				return ;
			}
		}else{
			$resultado = $actionPuedeCrear;
			$data['resultado'] = $resultado;
			$this->load->view('pages/Galerias/newGaleriaResult',$data);
			return ;
		}
	}

	public function formModificar(){
		header('Content-Type: text/html; charset=ISO-8859-1');
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$this->load->view('pages/Galerias/formModificarGaleria');
		}else{
			return "";
		}
	}

	public function modificar(){
		$actionPuedeModificar = $this->ComprobacionesModificar();
		if($actionPuedeModificar->isCorrecto()){
			$record=$_POST['record'];
			$recid = $_POST['recid'];
			if($record['NombreGaleria']!=""){$Nombre=$record['NombreGaleria'];}else{$Nombre= "";}
			if($record['OrdenGaleria']!=""){$Orden=$record['OrdenGaleria'];}else{$Orden= "0";}
			if($record['PrincipalGaleria']!=""){$Principal=$record['PrincipalGaleria'];}else{$Principal= "false";}
			$resultado = $this->servicegaleria->Modificar($recid,$Nombre,$Orden,$Principal		);
		}else{
			$resultado = $actionPuedeModificar;
		}
		$data['resultado'] = $resultado;
		$this->load->view('pages/Galerias/updateGaleriaResult',$data);
	}

	public function eliminar(){
		$actionPuedeEliminar = $this->ComprobacionesEliminar();
		$selected=$_POST['selected'];
		if($actionPuedeEliminar->isCorrecto()){
			$data['resultado']=$this->servicegaleria->EliminarById($selected);
		}else{
			$data['resultado'] = $actionPuedeEliminar();
		}
			$this->load->view('pages/Galerias/deleteGaleriaResult',$data);
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
 	$this->form_validation->set_rules('record[NombreNuevoGaleria]','Nombre', 'required|min_length[3]|max_length[100]');
 	$this->form_validation->set_rules('record[OrdenNuevoGaleria]','Orden', 'required|min_length[3]|max_length[100]');
 	$this->form_validation->set_rules('record[PrincipalNuevoGaleria]','Principal', 'required');
		if ($this->form_validation->run() == FALSE){
			return ActionConfirmation::CreateFailureActionConfirmation(validation_errors(), null);
		}else{
			return ActionConfirmation::CreateSuccessActionConfirmation('ok',null);
		}
	}
}
?>