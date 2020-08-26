SELECT row_to_json(x) AS procedimentos
	FROM (SELECT PRD."IdProcedimento" AS Id,
       PRD."NmApelido" AS Nome,
       CFG."VlConfiguracao" AS orientacoes_e_preparo
FROM "T0000_Configuracao" CFG INNER JOIN "T0199_Procedimento" PRD ON CFG."IdRegistro" = PRD."IdProcedimento"
AND PRD."IdProcedimento" = '__procedimento'
AND cfg."IdEntidadeNegocio" = '0199019') x