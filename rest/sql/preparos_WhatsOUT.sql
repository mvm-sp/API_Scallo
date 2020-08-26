SELECT row_to_json(x) AS preparos
	FROM (SELECT CFG."VlConfiguracao" AS orientacoes_e_preparo
FROM "T0000_Configuracao" CFG 
INNER JOIN "T0199_Procedimento" PRD 
ON PRD."IdProcedimento" = CFG."IdRegistro"
INNER JOIN "T0102_Agendamento" AGD
ON AGD."IdProcedimento" =  PRD."IdProcedimento"
WHERE AGD."IdAgendamento"  = __agendamento
AND CFG."IdEntidadeNegocio" = '0199019'
) x