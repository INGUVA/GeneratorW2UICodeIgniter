<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   class Tratamiento extends CI_Model {
	
	   const  id="Id";
      const  descripcion="descripcion";
      const  fechaInicio="fechaInicio";
      const  fechaFinal="fechaFinal";
	const	pacienteId = "pacienteId";
	const	pacienteNombre = "pacienteNombre";
      const  finalizado="finalizado";

      function __construct(){
         parent::__construct();
      }

     function GetValoresRow($row){
         $obj['Id']=$row[$this->config->item('database_tratamiento_Id')];
         $obj['descripcion'] = $row[$this->config->item('database_tratamiento_descripcion')];
         $obj['fechaInicio'] = $row[$this->config->item('database_tratamiento_fechainicio')];
         $obj['fechaFinal'] = $row[$this->config->item('database_tratamiento_fechafin')];
         $obj['pacienteId'] = $row[$this->config->item('database_tratamiento_pacienteId')];
         $obj['pacienteNombre'] = $row[$this->config->item('database_tratamiento_pacienteNombre')];
         $obj['finalizado'] = $row[$this->config->item('database_tratamiento_finalizado')];
         return $obj;
     }

     function SetValoresRow(){
		  $this->db->select($this->config->item('database_tratamiento_Id'));
         $this->db->select($this->config->item('database_tratamiento_descripcion'));
         $this->db->select($this->config->item('database_tratamiento_fechainicio'));
         $this->db->select($this->config->item('database_tratamiento_fechafin'));
         $this->db->select($this->config->item('database_tratamiento_pacienteId'));
         $this->db->select($this->config->item('database_tratamiento_pacienteNombre'));
         $this->db->select($this->config->item('database_tratamiento_finalizado'));
     }

      function getTratamientoById($id){
           $this->SetValoresRow();
           $this->db->where($this->config->item('database_tratamiento_Id'),$id);
           $this->db->from($this->config->item('database_tratamiento_Vista'));
           $query = $this->db->get();
           if($query!=false && $query->num_rows()>0){
               foreach($query->result_array() as $row){
                     return $this->GetValoresRow($row);
               }
           }else{
               return null;
           }
      }

      function Nuevo($_descripcion,$_fechaInicio,$_fechaFinal,$_paciente,$_finalizado){
           $data = array(
                 $this->config->item('database_tratamiento_descripcion')=>$_descripcion,
                 $this->config->item('database_tratamiento_fechainicio')=>$_fechaInicio,
                 $this->config->item('database_tratamiento_fechafin')=>$_fechaFinal,
                 $this->config->item('database_tratamiento_paciente')=>$_paciente,
                 $this->config->item('database_tratamiento_finalizado')=>$_finalizado
           );
           $con = $this->db->insert($this->config->item('database_tratamiento_Tabla'),$data);
           if($con){
               return $this->db->insert_id();
           }else{
               return -1;
           }
      }

     function update($_id,$_descripcion,$_fechaInicio,$_fechaFinal,$_paciente,$_finalizado){
         $data = array(
            $this->config->item('database_tratamiento_descripcion')=>$_descripcion,
            $this->config->item('database_tratamiento_fechainicio')=>$_fechaInicio,
            $this->config->item('database_tratamiento_fechafin')=>$_fechaFinal,
            $this->config->item('database_tratamiento_paciente')=>$_paciente,
            $this->config->item('database_tratamiento_finalizado')=>$_finalizado
         );
         $this->db->where($this->config->item('database_tratamiento_Id'), $_id);
         $query = $this->db->update($this->config->item('database_tratamiento_Tabla'), $data);
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
           		$this->db->where($this->config->item('database_tratamiento_Id'),$id);
				}else{
           		$this->db->or_where($this->config->item('database_tratamiento_Id'),$id);
				}
				$clausulas++;
			}
			$i++;
	  	}
		if($clausulas>0){
      		$this->db->delete($this->config->item('database_tratamiento_Tabla'));
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
		$this->db->from($this->config->item('database_tratamiento_Vista'));
		$this->db->order_by($this->getNameColumn($campo), $ord);
		$this->db->limit($limit, $offset);
		if($field!=""){
			switch($field){
				case "descripcion":
					$this->db->like($this->getNameColumn($field), $busqueda);
					break;
				
				case "fechaInicio":
					$this->db->where($this->getNameColumn($field), $busqueda);
					break;
				
				case "fechaFinal":
					$this->db->where($this->getNameColumn($field), $busqueda);
					break;
				
				case "paciente":
					$this->db->like($this->getNameColumn($field), $busqueda);
					break;
				
				case "finalizado":
					$this->db->where($this->getNameColumn($field), $busqueda);
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
			return $this->config->item('database_tratamiento_Id');
		}
		if($campo === "descripcion"){
			return $this->config->item('database_tratamiento_descripcion');
		}
		if($campo === "fechaInicio"){
			return $this->config->item('database_tratamiento_fechainicio');
		}
		if($campo === "fechaFinal"){
			return $this->config->item('database_tratamiento_fechafin');
		}
		if($campo === "pacienteId"){
			return $this->config->item('database_tratamiento_pacienteId');
		}
		if($campo === "pacienteNombre"){
			return $this->config->item('database_tratamiento_pacienteNombre');
		}
		if($campo === "paciente"){
			return $this->config->item('database_tratamiento_paciente');
		}
		if($campo === "finalizado"){
			return $this->config->item('database_tratamiento_finalizado');
		}
		return $campo;
	}
   }
?>
