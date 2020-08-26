<?php
	header('Content-Type: application/json');
	include('db.php');
	include('common.php');

	$mJSON_model = file_get_contents("../json/pacienteOUT.json");
	$data_model = json_decode($mJSON_model);
	
	$mRetorno =  parseParameterBodyType();
	//$telefone =  htmlspecialchars($_GET["telefone"]) ;
	$telefone =  $mRetorno['telefone'];
	$inf =$data_model;//->{'PainelCliente'};
	$det = $inf->{'informacoes'};
	//$detData = $det->{'informacoes'}[1];


	$dataDB = executeSql("SELECT * FROM \"P0199_Paciente_SEL_006\"('0000100001','$telefone'); ");

	if($dataDB ){
		foreach($dataDB as  $arrRow )
		{

			$inf->{'uid'}  = $arrRow["IdPaciente"];
			$inf->{'nome'} = $arrRow["NmPaciente"];
			$det[0]->{'titulo'}="Linha";
			$det[0]->{'informacoes'}[1][0]=$arrRow["NrCPFCNPJ"];
			$det[0]->{'informacoes'}[1][1]=$arrRow["DtNascimento"];
			$det[0]->{'informacoes'}[1][2]=$arrRow["StPessoaComDeficiencia"];
			$det[0]->{'informacoes'}[1][3]=$arrRow["QtIdade"];
			$det[0]->{'informacoes'}[1][4]=$arrRow["DtAgendamento"];
			$det[0]->{'informacoes'}[1][5]=$arrRow["NrTelefone1"];
			$det[0]->{'informacoes'}[1][6]=$arrRow["NrTelefone2"];

		}

		echo json_encode($data_model);
	}
?>