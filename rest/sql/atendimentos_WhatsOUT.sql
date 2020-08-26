    SELECT row_to_json(x) AS atendimentos
	FROM (SELECT DISTINCT
		AGD."IdAgendamento"		AS id,
		CASE 
			WHEN PTC."StResultadoDisponivel" = FALSE AND AGD."StConfirmado" = FALSE THEN 'AGENDADO'
			WHEN PTC."StResultadoDisponivel" = FALSE AND AGD."StConfirmado" = TRUE  THEN 'CONFIRMADO'
			WHEN STR."IdRegistro" IS NOT NULL THEN 'ATENDIDO'
			WHEN PTC."DtEntrega" IS NOT NULL THEN 'ENTREGUE'
			WHEN PTC."StResultadoExpirado" = FALSE THEN 'DISPONÍVEL'
			ELSE 'EXPIRADO' 
		END :: CHARACTER VARYING		AS Status
	, TO_CHAR(AGD."DtAgendamento", 'DD/MM/YYYY')::CHARACTER(10) 	AS  data_agendado
	, TO_CHAR(AGD."DtAgendamento", 'HH24:MI')::CHARACTER(5) AS hora_agendado
	, TO_CHAR((AGD."DtAgendamento"  + INTERVAL '30 day'), 'DD/MM/YYYY') AS previsao_entrega 
	, MDL."IdModalidade" AS id_modalidade
	, MDL."NmModalidade" AS nome_modalidade
	, PRD."IdProcedimento" AS id_procedimento
	, PRD."NmApelido" AS nome_procedimento
	, (COALESCE(EDR."DsEndereco", '') || ' , ' || COALESCE(EDR."NrEndereco", '') || ' - ' || COALESCE(EDR."NmComplemento", '')) AS endereco
	FROM		
		"T0102_Agendamento"				AGD	
	INNER JOIN
		"T0199_Procedimento"					PRD
	ON
		PRD."IdProcedimento"					= AGD."IdProcedimento"
	AND PRD."StExclusao"				= FALSE
	INNER JOIN 
		"T0199_Modalidade" MDL
	ON 
		PRD."IdModalidade" = MDL."IdModalidade"
	INNER JOIN "T0000_Endereco" EDR
	ON AGD."IdUnidade" = EDR."IdRegistro"
	AND EDR."IdEntidadeNegocio" = '0199013'
	LEFT JOIN
		"T0102_Atendimento_Agendamento"	AAT
	ON
		AAT."IdAgendamento"				= AGD."IdAgendamento"
	AND AAT."StExclusao"				= FALSE
	LEFT  JOIN 
		"T0102_Atendimento" 				ATD
	ON 
		ATD."IdAtendimento"					= AAT."IdAtendimento"
	AND ATD."IdPaciente"					=  AGD."IdPaciente"
	LEFT JOIN 
		"T0102_Protocolo" PTC
	ON 
		ATD."IdAtendimento" = PTC."IdAtendimento"
	LEFT JOIN
		"T0000_AssociacaoRegistros"			ASR
	ON
		ASR."IdEntidadeNegocioA"			= '0102009'
	AND	ASR."IdEntidadeNegocioB"			= '0102012'
	AND ASR."IdRegistroB"					= PTC."IdProtocolo"::CHARACTER VARYING
	AND ASR."StExclusao"					= FALSE
	LEFT JOIN 
		"T0000_StatusRegistro" 				STR
	ON
		STR."IdEntidadeNegocio" 			= '0102009'
	AND STR."IdRegistro" 					= ASR."IdRegistroA"
	AND STR."IdEtapa" 						= '0102001005'
	AND STR."IdStatus" 						= '0102001005001'
	WHERE 		
		AGD."IdPaciente"				= __paciente
	AND AGD."StExclusao"				= FALSE
	AND AGD."StCancelado"				= FALSE
	ORDER BY 
		AGD."IdAgendamento") x