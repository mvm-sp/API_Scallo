<?php
	header('Content-Type: application/json');
	include('db.php');
	include('common.php');

	$mQuery = file_get_contents("../sql/confirma_WhatsIN.sql");
	//$mJSON_model = file_get_contents("../json/cliente_whatsOUT.json");
	$data_model = ''; //json_decode($mJSON_model);
	
	$mRetorno =  parseParameterQueryType();
	//$telefone =  htmlspecialchars($_GET["telefone"]) ;
	$codigo =  @$mRetorno['id_atendimento'];

	//LER DE ALGUM LUGAR E GERAR O JSON
	if($codigo){

		$mQuery = str_replace("__agendamento",$codigo, $mQuery);
\
		writeLog("Query:\n $mQuery");

		$dataDB = executeTransaction($mQuery);
	
		if($dataDB>0 ){
			
			$data_model = "[{\"mensagem_sucesso\": \"Agendamento confirmado com sucesso.\"}]";
			writeLog("Recieved:\n contato=$codigo \n Returning : \n" . json_encode($data_model));
			//echo json_encode($data_model);
			echo $data_model;
		}
		else
		{
			echo "[]";
		}
	}
	else
	{
		http_response_code(400);
	}
?>