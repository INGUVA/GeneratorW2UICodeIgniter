package ciGenerator.model.tipos;

import org.json.JSONObject;

public class Text extends TipoDatos {

	public Text(JSONObject jOpciones){
		
	}
	
	@Override
	public String GetTipoW2UI() {
		return TipoW2UI.text.toString();
	}

	@Override
	public String GetInputW2UI() {
		return null;
	}

	@Override
	public boolean isSimple() {
		return true;
	}

	@Override
	public Object getValorPorDefecto() {
		return "";
	}

}
