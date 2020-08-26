<?php
	header('Content-Type: application/json');
	include('db.php');
	include('common.php');

	writeLog("Iniciando Futurofone/clientes");

	$mQuery = file_get_contents("../sql/clientes_WhatsOUT.sql");
	//$mJSON_model = file_get_contents("../json/cliente_whatsOUT.json");
	$data_model = ''; //json_decode($mJSON_model);
	
	$mRetorno =  parseParameterQueryType();
	//$telefone =  htmlspecialchars($_GET["telefone"]) ;
	$codigo =  @$mRetorno['contato'];


	
	//LER DE ALGUM LUGAR E GERAR O JSON
	if($codigo){

		$mQuery = str_replace("__telefone",$codigo, $mQuery);

		writeLog("Query:\n $mQuery");

		$dataDB = executeSql($mQuery);
	
		if($dataDB ){
			$data_model = "[";
			foreach($dataDB as  $arrRow )
			{
				if($data_model!="[")
				{
					$data_model .= ' , ';
				}
				
				$data_model .= $arrRow["pacientes"];;
			}
			$data_model .= "]";
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