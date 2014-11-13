<?php
	$this->load->helper('date')
;    echo '{
			"total": '.count($listaFichero).',
			"records":  [';
			$i=1;
			if(count($listaFichero)>0){
				foreach($listaFichero as $fichero){
					echo ' { "recid": '.$fichero['Id'].', 
                    "nombre": "'.$fichero['nombre'].'",
                    "fechaCaptura": "'.mysql_to_w2ui($fichero["fechaCaptura"]).'",
                    "ruta": "'.$fichero['ruta'].'",
                    "pacienteId": '.$fichero['pacienteId'].',
                    "pacienteNombre": "'.$fichero['pacienteNombre'].'"
';
               	$i++;
               	if($i>count($listaFichero)){
                   	echo '	}';
               	}else{
                   	echo '	},';
               	}
               }
           }
 echo '     ]
    }';
?>