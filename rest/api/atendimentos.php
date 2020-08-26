<?php
	header('Content-Type: application/json');
	include('db.php');
	include('common.php');

	$mQuery = file_get_contents("../sql/atendimentos_WhatsOUT.sql");
	//$mJSON_model = file_get_contents("../json/cliente_whatsOUT.json");
	$data_model = ''; //json_decode($mJSON_model);
	
	$mRetorno =  parseParameterQueryType();
	//$telefone =  htmlspecialchars($_GET["telefone"]) ;
	$codigo =  @$mRetorno['id_cliente'];


	
	//LER DE ALGUM LUGAR E GERAR O JSON
	if($codigo){

		$mQuery = str_replace("__paciente",$codigo, $mQuery);

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
				
				$data_model .= $arrRow["atendimentos"];;
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