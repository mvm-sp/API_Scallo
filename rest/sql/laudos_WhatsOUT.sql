SELECT row_to_json(x) AS laudos
	FROM (SELECT CFG."VlConfiguracao" AS laudo
FROM "T0000_Configuracao" CFG 
INNER JOIN "T0105_Laudo" LAU  ON CFG."IdRegistro" = LAU."IdLaudo"::varchar
INNER JOIN "T0102_Agendamento" AGD
ON AGD."IdAgendamento" = LAU."IdAgendamento"
INNER JOIN "T0199_Procedimento" PRD 
ON PRD."IdProcedimento" = AGD."IdProcedimento"
WHERE AGD."IdAgendamento"  = __agendamento
AND CFG."IdEntidadeNegocio" = '0105003'
AND 1=1 ) x;
