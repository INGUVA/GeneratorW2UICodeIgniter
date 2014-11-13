package ciGenerator.model.tipos;

import org.json.JSONObject;

public abstract class TipoDatos {

	/**
	 * Tipos de datos internos de w2ui
	 * @author David
	 *
	 */
	public enum TipoW2UI{
		select,
		text,
		checkbox,
		email,
		date
	}
	
	/**
	 * Tipos de input html
	 * @author David
	 *
	 */
	public enum InputW2UI{
		text,
		password,
		checkbox,
		radio
	}
	
	public enum Tipos{
		Integer,	//Datos simples
		Double,
		String,
		Text,
		Boolean,
		Date,
		Password,
		Email,
		Enum,		//Datos complejos
		Combo,
		List,
		ListMulti
	}

	public static Tipos TiposFromString(String tipo){
		if(tipo.equals("Integer")){
			return Tipos.Integer;
		}
		
		if(tipo.equals("Double")){
			return Tipos.Double;
		}
		
		if(tipo.equals("String")){
			return Tipos.String;
		}
		
		if(tipo.equals("Text")){
			return Tipos.Text;
		}
		
		if(tipo.equals("Boolean")){
			return Tipos.Boolean;
		}
		
		if(tipo.equals("Date")){
			return Tipos.Date;
		}
		
		if(tipo.equals("Password")){
			return Tipos.Password;
		}
		
		if(tipo.equals("Email")){
			return Tipos.Email;
		}
		
		if(tipo.equals("Combo")){
			return Tipos.Combo;
		}
		
		if(tipo.equals("List")){
			return Tipos.List;
		}
		
		if(tipo.equals("ListMulti")){
			return Tipos.ListMulti;
		}
		
		return null;
	}
	
	public static TipoDatos CreateTipoDatos(JSONObject jObject) throws Exception{
		Tipos tipo =null;
		String jTipo = jObject.getString("Nombre");
		JSONObject jOpciones = jObject.optJSONObject("Options");
		tipo = TiposFromString(jTipo);
		
		if(tipo.equals(Tipos.String)){
			return new StringCustom(jOpciones);
		}
		
		if(tipo.equals(Tipos.Text)){
			return new Text(jOpciones);
		}
		
		if(tipo.equals(Tipos.Date)){
			return new Date(jOpciones);
		}
		
		if(tipo.equals(Tipos.List)){
			return new List(jOpciones);
		}
		
		if(tipo.equals(Tipos.Boolean)){
			return new Boolean(jOpciones);
		}
		
		throw new Exception("El tipo de datos "+jTipo+" aún no está implementado.");

	}
	
	public static TipoDatos CreateTipoDatos(String json){
		Tipos tipo =null;
		try{
			JSONObject jObject = new JSONObject(json);
			String jTipo = jObject.getString("Nombre");
			JSONObject jOpciones = jObject.optJSONObject("Options");
			tipo = TiposFromString(jTipo);
			
			if(tipo.equals(Tipos.List)){
				//Cargamos las posibles opciones
				return new List(jOpciones);
			}
			
			return null;
		}catch(Exception e){
			return null;
		}
	}
	
	/**
	 * Devuelve el tipo de datos interno de W2UI
	 * @return
	 */
	public abstract String GetTipoW2UI();
	
	/**
	 * Devuelve el tipo de input (en caso de que sea un input html)
	 * @return
	 */
	public abstract String GetInputW2UI();
	
	/**
	 * Devuelve si el tipo es un tipo simple
	 * @return
	 */
	public abstract boolean isSimple();
	
	/**
	 * Devuelve el valor por defecto
	 * @return
	 */
	public abstract Object getValorPorDefecto();
}
