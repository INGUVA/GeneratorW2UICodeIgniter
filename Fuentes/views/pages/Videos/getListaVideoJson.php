<?php
	$this->load->helper('date')
;    echo '{
			"total": '.count($listaVideo).',
			"records":  [';
			$i=1;
			if(count($listaVideo)>0){
				foreach($listaVideo as $video){
					echo ' { "recid": '.$video['Id'].', 
                    "nombre": "'.$video['nombre'].'",
                    "fechaCaptura": "'.mysql_to_w2ui($video["fechaCaptura"]).'",
                    "ruta": "'.$video['ruta'].'",
                    "pacienteId": '.$video['pacienteId'].',
                    "pacienteNombre": "'.$video['pacienteNombre'].'"
';
               	$i++;
               	if($i>count($listaVideo)){
                   	echo '	}';
               	}else{
                   	echo '	},';
               	}
               }
           }
 echo '     ]
    }';
?>