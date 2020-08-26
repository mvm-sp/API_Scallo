SELECT row_to_json(x) AS Pacientes
	FROM (SELECT 
	      "IdPaciente" as  Id,
	      "NmPaciente" as  Nome,
	      "DtNascimento" as  data_nascimento
	      from "T0199_Paciente"  P INNER JOIN "T0000_Contato" C
	      ON P."IdPaciente"::varchar = C."IdRegistro"
	      AND C."IdEntidadeNegocio" = '0199015'
          where  ( C."CdDDD1" = left('__telefone',2) AND  REPLACE(C."NrTelefone1", '-', '') = right('__telefone',9))
           OR    ( C."CdDDD2" = left('__telefone',2) AND  REPLACE(C."NrTelefone2", '-', '') = right('__telefone',9))       
           OR    ( C."CdDDD3" = left('__telefone',2) AND  REPLACE(C."NrTelefone3", '-', '') = right('__telefone',9))
                 ) x;