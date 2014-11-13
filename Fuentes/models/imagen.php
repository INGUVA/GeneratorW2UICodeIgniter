<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   class Imagen extends CI_Model {
	
	   const  id="Id";
      const  nombre="nombre";
      const  fechaCaptura="fechaCaptura";
      const  ruta="ruta";
	const	pacienteId = "pacienteId";
	const	pacienteNombre = "pacienteNombre";

      function __construct(){
         parent::__construct();
      }

     function GetValoresRow($row){
         $obj['Id']=$row[$this->config->item('database_imagen_Id')];
         $obj['nombre'] = $row[$this->config->item('database_imagen_nombre')];
         $obj['fechaCaptura'] = $row[$this->config->item('database_imagen_fechacaptura')];
         $obj['ruta'] = $row[$this->config->item('database_imagen_ruta')];
         $obj['pacienteId'] = $row[$this->config->item('database_imagen_pacienteId')];
         $obj['pacienteNombre'] = $row[$this->config->item('database_imagen_pacienteNombre')];
         return $obj;
     }

     function SetValoresRow(){
		  $this->db->select($this->config->item('database_imagen_Id'));
         $this->db->select($this->config->item('database_imagen_nombre'));
         $this->db->select($this->config->item('database_imagen_fechacaptura'));
         $this->db->select($this->config->item('database_imagen_ruta'));
         $this->db->select($this->config->item('database_imagen_pacienteId'));
         $this->db->select($this->config->item('database_imagen_pacienteNombre'));
     }

      function getImagenById($id){
           $this->SetValoresRow();
           $this->db->where($this->config->item('database_imagen_Id'),$id);
           $this->db->from($this->config->item('database_imagen_Vista'));
           $query = $this->db->get();
           if($query!=false && $query->num_rows()>0){
               foreach($query->result_array() as $row){
                     return $this->GetValoresRow($row);
               }
           }else{
               return null;
           }
      }

      function Nuevo($_nombre,$_fechaCaptura,$_ruta,$_paciente){
           $data = array(
                 $this->config->item('database_imagen_nombre')=>$_nombre,
                 $this->config->item('database_imagen_fechacaptura')=>$_fechaCaptura,
                 $this->config->item('database_imagen_ruta')=>$_ruta,
                 $this->config->item('database_imagen_paciente')=>$_paciente
           );
           $con = $this->db->insert($this->config->item('database_imagen_Tabla'),$data);
           if($con){
               return $this->db->insert_id();
           }else{
               return -1;
           }
      }

     function update($_id,$_nombre,$_fechaCaptura,$_ruta,$_paciente){
         $data = array(
            $this->config->item('database_imagen_nombre')=>$_nombre,
            $this->config->item('database_imagen_fechacaptura')=>$_fechaCaptura,
            $this->config->item('database_imagen_ruta')=>$_ruta,
            $this->config->item('database_imagen_paciente')=>$_paciente
         );
         $this->db->where($this->config->item('database_imagen_Id'), $_id);
         $query = $this->db->update($this->config->item('database_imagen_Tabla'), $data);
         if($query){
              return true;
         }else{
              return false;
         }
     }

     function eliminarById($ids){
		$i=0;
		$clausulas=0;
		foreach($ids as $id){
			if($id>0){
				if($i==0){
           		$this->db->where($this->config->item('database_imagen_Id'),$id);
				}else{
           		$this->db->or_where($this->config->item('database_imagen_Id'),$id);
				}
				$clausulas++;
			}
			$i++;
	  	}
		if($clausulas>0){
      		$this->db->delete($this->config->item('database_imagen_Tabla'));
      		if($this->db->affected_rows()>0){
           	return true;
      		}else{
        	   return false;
      		}
		}else{
			return true;		}
     }

	function getAll($limit=50, $offset=0, $campo="Id", $ord="Asc",$field="", $busqueda=""){
		$this->SetValoresRow();
		$this->db->from($this->config->item('database_imagen_Vista'));
		$this->db->order_by($this->getNameColumn($campo), $ord);
		$this->db->limit($limit, $offset);
		if($field!=""){
			switch($field){
				case "nombre":
					$this->db->like($this->getNameColumn($field), $busqueda);
					break;
				
				case "fechaCaptura":
					$this->db->where($this->getNameColumn($field), $busqueda);
					break;
				
				case "ruta":
					$this->db->like($this->getNameColumn($field), $busqueda);
					break;
				
				case "paciente":
					$this->db->like($this->getNameColumn($field), $busqueda);
					break;
				
			}
		}
		$query = $this->db->get();
		$objs = array();
		if($query!=false && $query->num_rows()>0){
			foreach($query->result_array() as $row){
				$objs[] = $this->GetValoresRow($row);
			}
		}
		return $objs;
	}

	function getNameColumn($campo){
		if($campo==='' || $campo === "Id"){
			return $this->config->item('database_imagen_Id');
		}
		if($campo === "nombre"){
			return $this->config->item('database_imagen_nombre');
		}
		if($campo === "fechaCaptura"){
			return $this->config->item('database_imagen_fechacaptura');
		}
		if($campo === "ruta"){
			return $this->config->item('database_imagen_ruta');
		}
		if($campo === "pacienteId"){
			return $this->config->item('database_imagen_pacienteId');
		}
		if($campo === "pacienteNombre"){
			return $this->config->item('database_imagen_pacienteNombre');
		}
		if($campo === "paciente"){
			return $this->config->item('database_imagen_paciente');
		}
		return $campo;
	}
   }
?>
