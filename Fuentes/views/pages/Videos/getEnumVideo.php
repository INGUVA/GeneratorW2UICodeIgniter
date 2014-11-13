<?php
    echo '{
			"total": '.count($listaVideo).',
			"records":  [';
			$i=1;
			if(count($listaVideo)>0){
				foreach($listaVideo as $video){
					echo ' { "id": '.$video['Id'].', 
                    "text": "'.$video['nombre'].'"';
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