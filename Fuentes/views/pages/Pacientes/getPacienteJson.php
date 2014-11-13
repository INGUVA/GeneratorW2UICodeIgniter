<?php
	$this->load->helper('date')
;    echo '{
          status: "success",
          record:  ';
               echo ' { "recid": '.$paciente->getId().', 
                    "nombre": "'.$paciente['nombre'].'",
                    "apellidos": "'.$paciente['apellidos'].'",
                    "descripcion": "'.$paciente['descripcion'].'",
                    "empresa": "'.$paciente['empresa'].'",
                    "fechaNacimiento": "'.mysql_to_w2ui($paciente["fechaNacimiento"]).'",
                    "imagen": "'.$paciente['imagen'].'"';
 echo '     		}
     }';
?>