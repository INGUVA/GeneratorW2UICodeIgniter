package ciGenerator.model.tipos;

import org.json.JSONObject;

public class Boolean extends TipoDatos{

	public Boolean(JSONObject jOpciones){
	}
	
	@Override
	public String GetTipoW2UI() {
		return TipoDatos.TipoW2UI.checkbox.toString();
	}

	@Override
	public String GetInputW2UI() {
		return TipoDatos.InputW2UI.checkbox.toString();
	}

	@Override
	public boolean isSimple() {
		return true;
	}

	@Override
	public Object getValorPorDefecto() {
		return false;
	}

}
