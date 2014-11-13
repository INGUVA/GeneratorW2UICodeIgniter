<?php
	$this->load->helper('date')
;    echo '{
			"total": '.count($listaImagen).',
			"records":  [';
			$i=1;
			if(count($listaImagen)>0){
				foreach($listaImagen as $imagen){
					echo ' { "recid": '.$imagen['Id'].', 
                    "nombre": "'.$imagen['nombre'].'",
                    "fechaCaptura": "'.mysql_to_w2ui($imagen["fechaCaptura"]).'",
                    "ruta": "'.$imagen['ruta'].'",
                    "pacienteId": '.$imagen['pacienteId'].',
                    "pacienteNombre": "'.$imagen['pacienteNombre'].'"
';
               	$i++;
               	if($i>count($listaImagen)){
                   	echo '	}';
               	}else{
                   	echo '	},';
               	}
               }
           }
 echo '     ]
    }';
?>