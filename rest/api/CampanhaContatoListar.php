<?php
	header('Content-Type: application/json');
	include('db.php');
	include('common.php');

	$mJSON_model = file_get_contents("../json/contatoOUT.json");
	$data_model = json_decode($mJSON_model);
	
	$mRetorno =  parseParameterQueryType();
	//$telefone =  htmlspecialchars($_GET["telefone"]) ;
	$codigo =  @$mRetorno['codigo'];
		//$detData = $det->{'informacoes'}[1];

	//LER DE ALGUM LUGAR E GERAR O JSON
	if($codigo){
		writeLog("Recieved:\n codigo=$codigo \n Returning : \n" . json_encode($data_model));
		echo json_encode($data_model);
	}
?>