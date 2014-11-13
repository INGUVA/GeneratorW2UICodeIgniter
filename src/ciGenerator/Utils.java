package ciGenerator;

import ciGenerator.model.tipos.TipoDatos.Tipos;

public class Utils {

	public static String ConvertirAPlurar(String nombre){
		String ultimoCaracter = nombre.substring(nombre.length()-1);
		if(ultimoCaracter.equals("a")||ultimoCaracter.equals("e")||ultimoCaracter.equals("i")||ultimoCaracter.equals("o")||ultimoCaracter.equals("u")){
			return nombre.concat("s");
		}else{
			return nombre.concat("es");
		}
	}}
