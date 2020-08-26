<?php
	header('Content-Type: application/json');
	include('db.php');
	include('common.php');
	$mLog = "";
	$mRetorno = parseParameterBodyType();

	if($mRetorno )
	{
		foreach($mRetorno as $key => $value)
		{
			$mLog .=  $key . " = " . $value ."\n";
		}
	}

	writeLog($mLog);
	

	//$dataDB = executeSql("SELECT * FROM \"P99_Paciente_SEL_006\"('0000100001','$telefone'); ");

	
?>