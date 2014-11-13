package ciGenerator.model.tipos;

import org.json.JSONObject;

public class List extends TipoDatos{

	private String urlOpciones = "";
	private int valorDefecto=-1;

	public List(JSONObject jOpciones){
		if(jOpciones!=null){
			setUrlOpciones(jOpciones.optString("Url"));
			try{
				valorDefecto = (jOpciones.optInt("Default", -1));
			}catch(Exception e){
				new Throwable("El tipo de datos List solamente puede tener valores enteros.");
			}
		}
	}

	public String getUrlOpciones() {
		return urlOpciones;
	}

	public void setUrlOpciones(String urlOpciones) {
		this.urlOpciones = urlOpciones;
	}

	@Override
	public String GetTipoW2UI() {
		return TipoDatos.TipoW2UI.select.toString();
	}

	@Override
	public String GetInputW2UI() {
		return null;
	}

	@Override
	public boolean isSimple() {
		return false;
	}

	@Override
	public Object getValorPorDefecto() {
		return valorDefecto;
	}
}
