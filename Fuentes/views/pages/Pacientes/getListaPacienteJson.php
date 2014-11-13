<?php
	$this->load->helper('date')
;    echo '{
			"total": '.count($listaPaciente).',
			"records":  [';
			$i=1;
			if(count($listaPaciente)>0){
				foreach($listaPaciente as $paciente){
					echo ' { "recid": '.$paciente['Id'].', 
                    "nombre": "'.$paciente['nombre'].'",
                    "apellidos": "'.$paciente['apellidos'].'",
                    "descripcion": "'.$paciente['descripcion'].'",
                    "empresa": "'.$paciente['empresa'].'",
                    "fechaNacimiento": "'.mysql_to_w2ui($paciente["fechaNacimiento"]).'",
                    "imagen": "'.$paciente['imagen'].'"';
               	$i++;
               	if($i>count($listaPaciente)){
                   	echo '	}';
               	}else{
                   	echo '	},';
               	}
               }
           }
 echo '     ]
    }';
?>