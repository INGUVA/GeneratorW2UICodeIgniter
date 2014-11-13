<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   class Paciente extends CI_Model {
	
	   const  id="Id";
      const  nombre="nombre";
      const  apellidos="apellidos";
      const  descripcion="descripcion";
      const  empresa="empresa";
      const  fechaNacimiento="fechaNacimiento";
      const  imagen="imagen";

      function __construct(){
         parent::__construct();
      }

     function GetValoresRow($row){
         $obj['Id']=$row[$this->config->item('database_paciente_Id')];
         $obj['nombre'] = $row[$this->config->item('database_paciente_nombre')];
         $obj['apellidos'] = $row[$this->config->item('database_paciente_apellidos')];
         $obj['descripcion'] = $row[$this->config->item('database_paciente_descripcion')];
         $obj['empresa'] = $row[$this->config->item('database_paciente_empresa')];
         $obj['fechaNacimiento'] = $row[$this->config->item('database_paciente_fechanacimiento')];
         $obj['imagen'] = $row[$this->config->item('database_paciente_imagen')];
         return $obj;
     }

     function SetValoresRow(){
		  $this->db->select($this->config->item('database_paciente_Id'));
         $this->db->select($this->config->item('database_paciente_nombre'));
         $this->db->select($this->config->item('database_paciente_apellidos'));
         $this->db->select($this->config->item('database_paciente_descripcion'));
         $this->db->select($this->config->item('database_paciente_empresa'));
         $this->db->select($this->config->item('database_paciente_fechanacimiento'));
         $this->db->select($this->config->item('database_paciente_imagen'));
     }

      function getPacienteById($id){
           $this->SetValoresRow();
           $this->db->where($this->config->item('database_paciente_Id'),$id);
           $this->db->from($this->config->item('database_paciente_Vista'));
           $query = $this->db->get();
           if($query!=false && $query->num_rows()>0){
               foreach($query->result_array() as $row){
                     return $this->GetValoresRow($row);
               }
           }else{
               return null;
           }
      }

      function Nuevo($_nombre,$_apellidos,$_descripcion,$_empresa,$_fechaNacimiento,$_imagen){
           $data = array(
                 $this->config->item('database_paciente_nombre')=>$_nombre,
                 $this->config->item('database_paciente_apellidos')=>$_apellidos,
                 $this->config->item('database_paciente_descripcion')=>$_descripcion,
                 $this->config->item('database_paciente_empresa')=>$_empresa,
                 $this->config->item('database_paciente_fechanacimiento')=>$_fechaNacimiento,
                 $this->config->item('database_paciente_imagen')=>$_imagen
           );
           $con = $this->db->insert($this->config->item('database_paciente_Tabla'),$data);
           if($con){
               return $this->db->insert_id();
           }else{
               return -1;
           }
      }

     function update($_id,$_nombre,$_apellidos,$_descripcion,$_empresa,$_fechaNacimiento,$_imagen){
         $data = array(
            $this->config->item('database_paciente_nombre')=>$_nombre,
            $this->config->item('database_paciente_apellidos')=>$_apellidos,
            $this->config->item('database_paciente_descripcion')=>$_descripcion,
            $this->config->item('database_paciente_empresa')=>$_empresa,
            $this->config->item('database_paciente_fechanacimiento')=>$_fechaNacimiento,
            $this->config->item('database_paciente_imagen')=>$_imagen
         );
         $this->db->where($this->config->item('database_paciente_Id'), $_id);
         $query = $this->db->update($this->config->item('database_paciente_Tabla'), $data);
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
           		$this->db->where($this->config->item('database_paciente_Id'),$id);
				}else{
           		$this->db->or_where($this->config->item('database_paciente_Id'),$id);
				}
				$clausulas++;
			}
			$i++;
	  	}
		if($clausulas>0){
      		$this->db->delete($this->config->item('database_paciente_Tabla'));
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
		$this->db->from($this->config->item('database_paciente_Vista'));
		$this->db->order_by($this->getNameColumn($campo), $ord);
		$this->db->limit($limit, $offset);
		if($field!=""){
			switch($field){
				case "nombre":
					$this->db->like($this->getNameColumn($field), $busqueda);
					break;
				
				case "apellidos":
					$this->db->like($this->getNameColumn($field), $busqueda);
					break;
				
				case "descripcion":
					$this->db->like($this->getNameColumn($field), $busqueda);
					break;
				
				case "empresa":
					$this->db->like($this->getNameColumn($field), $busqueda);
					break;
				
				case "fechaNacimiento":
					$this->db->where($this->getNameColumn($field), $busqueda);
					break;
				
				case "imagen":
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
			return $this->config->item('database_paciente_Id');
		}
		if($campo === "nombre"){
			return $this->config->item('database_paciente_nombre');
		}
		if($campo === "apellidos"){
			return $this->config->item('database_paciente_apellidos');
		}
		if($campo === "descripcion"){
			return $this->config->item('database_paciente_descripcion');
		}
		if($campo === "empresa"){
			return $this->config->item('database_paciente_empresa');
		}
		if($campo === "fechaNacimiento"){
			return $this->config->item('database_paciente_fechanacimiento');
		}
		if($campo === "imagen"){
			return $this->config->item('database_paciente_imagen');
		}
		return $campo;
	}
   }
?>
