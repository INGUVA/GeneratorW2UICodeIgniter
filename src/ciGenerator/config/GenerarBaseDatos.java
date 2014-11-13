package ciGenerator.config;

import java.io.File;
import java.io.PrintWriter;
import java.util.ArrayList;

import ciGenerator.GenerarClase;
import ciGenerator.model.Propiedad;
import ciGenerator.model.tipos.TipoDatos.Tipos;

public class GenerarBaseDatos {
	
	/**
	 * @param args
	 */
	public static void Iniciar(String path, ArrayList<GenerarClase> clases) {
		File file = new File(path + "/config");
		if (!file.exists()) {
			file.mkdir();
		}
		
		try{
			PrintWriter writerModelo = new PrintWriter(path + "/config/nombredatabase.php", "ISO-8859-1");
			writerModelo.print(GenerarBaseDatos.CrearNombreBaseDatos(clases));
			writerModelo.close();
		}catch(Exception e){
		}
	}
	
	private static String CrearNombreBaseDatos(ArrayList<GenerarClase> clases){
		String output = "";
		
		output+="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
		output+="\n";

		for(GenerarClase clase : clases){
			output+="$config['database_"+clase.getNombre().toLowerCase()+"_Tabla'] 			= '"+clase.getNombreTablaBD()+"';\n";
			output+="$config['database_"+clase.getNombre().toLowerCase()+"_Vista'] 			= '"+clase.getNombreVistaBD()+"';\n";
			output+="$config['database_"+clase.getNombre().toLowerCase()+"_Id'] 			= 'Id';\n";
			for(Propiedad propiedad: clase.getPropiedades()){
				if(!propiedad.getTipo().isSimple()){
					output+="$config['database_"+clase.getNombre().toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"']			= 'FK_"+propiedad.getNombreBaseDatos()+"';\n";
					output+="$config['database_"+clase.getNombre().toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"Id']			= '"+propiedad.getNombreBaseDatos()+"Id';\n";
					output+="$config['database_"+clase.getNombre().toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"Nombre']		= '"+propiedad.getNombreBaseDatos()+"Nombre';\n";
				}else{
					output+="$config['database_"+clase.getNombre().toLowerCase()+"_"+propiedad.getNombreBaseDatos().toLowerCase()+"']			= '"+propiedad.getNombreBaseDatos()+"';\n";					
				}
			}
			output+="\n\n";
		}
		
		return output;
	}
}