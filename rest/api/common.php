<?php
include('rtf.php');
    
function parseParameterKeyBodyType($pAgente){

    try{
        $mens = "Lendo parâmetro json...";
        @$paramDecode=  urldecode($_GET["json"]) ;
        //$paramDecode= urldecode("%7B%22Ligacao%22%3A%7B%22uniqueid%22%3A%20%22000001.01%22%2C%22uuid%22%3A%20%22000001.02%22%2C%22direcao%22%3A%20%22entrada%22%2C%22src%22%3A%20%2211981081011%22%2C%22dst%22%3A%20%221142106262%22%2C%22calldate%22%3A%20%222020-04-08%2012%3A00%3A00%22%2C%22calldateend%22%3A%20%222020-04-08%2012%3A01%3A00%22%2C%22status%22%3A%20%22answer%22%2C%22ura%22%3A%20%22Principal%2CAgendamento%22%2C%22fila%22%3A%20%22principal%22%2C%22classificacao%22%3A%20%22Normal%22%2C%22cpf%22%3A%20%2219119119100%22%2C%22src_cidade%22%3A%20%22S%C3%A3o%20Paulo%22%2C%22src_uf%22%3A%20%22SP%22%2C%22src_ramal%22%3A%20%220001%22%2C%22src_agente%22%3A%20%222001%22%2C%22dst_ramal%22%3A%20%220002%22%2C%20%22dst_agente%22%3A%20%222002%22%7D%2C%20%22Options%22%3A%20%7B%22key%22%3A%20%2281245e4778577e3315dbe49ace4443e5%22%7D%7D");
        //$paramDecode= '{"Ligacao":{"uniqueid": "000001.01","uuid": "000001.02","direcao": "entrada","src": "11981081011","dst": "1142106262","calldate": "2020-04-08 12:00:00","calldateend": "2020-04-08 12:01:00","status": "answer","ura": "Principal,Agendamento","fila": "principal","classificacao": "Normal","cpf": "19119119100","src_cidade": "São Paulo","src_uf": "SP","src_ramal": "0001","src_agente": "2001","dst_ramal": "0002", "dst_agente": "2002"}, "Options": {"key": "81245e4778577e3315dbe49ace4443e5"}}';
        if($paramDecode)
        {
            $mens = "Parse do parêmetro JSON...";
            $data_model = json_decode($paramDecode);
            if($data_model){

                $mens = "Obtendo propriedade key...";
                @$key =  $data_model->{'Options'};
                if($key){

                    $mens = "Validação da Key...";
                    $mJSON_model = json_decode(file_get_contents("../json/options.json"));

                    $mInternalKey = $mJSON_model->{'Options'};
                    if($mInternalKey->{'key'} != $key->{'key'})
                    {
                        throw new Exception($mens);
                    }	

                    $mens = "Obtendo Dados do Objeto $pAgente...";
                    @$detData =$data_model->{$pAgente};
                    if($detData)
                    {
                        return $detData;
                    }
                    else
                    {
                        throw new Exception($mens);
                    }
                }
                else
                {
                    throw new Exception($mens);
                }

            }
            else
            {
                throw new Exception($mens);
            }

        }
        else
        {
            throw new Exception($mens);
        }

    }
    catch(Exception $ex)
    {
        writeLog('Erro : '. $ex ."\n");
        http_response_code(400);
        echo "Erro: " . $ex->getMessage();
    }

}

function parseParameterBodyType(){

    try{
        $mens = "Lendo parâmetro json...";
        @$paramDecode = file_get_contents('php://input');
        writeLog("Parâmetros recebidos: $paramDecode " );
        /*@$paramDecode= '{
        "codigo": "1111"
        }';*/
    
        //@$paramDecode=  urldecode($_POST[$pVarPost]) ;
        //$paramDecode= urldecode("%7B%22Ligacao%22%3A%7B%22uniqueid%22%3A%20%22000001.01%22%2C%22uuid%22%3A%20%22000001.02%22%2C%22direcao%22%3A%20%22entrada%22%2C%22src%22%3A%20%2211981081011%22%2C%22dst%22%3A%20%221142106262%22%2C%22calldate%22%3A%20%222020-04-08%2012%3A00%3A00%22%2C%22calldateend%22%3A%20%222020-04-08%2012%3A01%3A00%22%2C%22status%22%3A%20%22answer%22%2C%22ura%22%3A%20%22Principal%2CAgendamento%22%2C%22fila%22%3A%20%22principal%22%2C%22classificacao%22%3A%20%22Normal%22%2C%22cpf%22%3A%20%2219119119100%22%2C%22src_cidade%22%3A%20%22S%C3%A3o%20Paulo%22%2C%22src_uf%22%3A%20%22SP%22%2C%22src_ramal%22%3A%20%220001%22%2C%22src_agente%22%3A%20%222001%22%2C%22dst_ramal%22%3A%20%220002%22%2C%20%22dst_agente%22%3A%20%222002%22%7D%2C%20%22Options%22%3A%20%7B%22key%22%3A%20%2281245e4778577e3315dbe49ace4443e5%22%7D%7D");
        //$paramDecode= '{"Ligacao":{"uniqueid": "000001.01","uuid": "000001.02","direcao": "entrada","src": "11981081011","dst": "1142106262","calldate": "2020-04-08 12:00:00","calldateend": "2020-04-08 12:01:00","status": "answer","ura": "Principal,Agendamento","fila": "principal","classificacao": "Normal","cpf": "19119119100","src_cidade": "São Paulo","src_uf": "SP","src_ramal": "0001","src_agente": "2001","dst_ramal": "0002", "dst_agente": "2002"}, "Options": {"key": "81245e4778577e3315dbe49ace4443e5"}}';
        if($paramDecode)
        {
            $mens = "Parse do parêmetro JSON...";
            @$data_model = json_decode($paramDecode);

            if($data_model)
            {
                return get_object_vars($data_model);
            }
            else
            {
                throw new Exception($mens);
            }

        }
        else
        {
            throw new Exception($mens);
        }

    }
    catch(Exception $ex)
    {
        writeLog('Erro : '. $ex ."\n");
        http_response_code(400);
        echo "Erro: " . $ex->getMessage();
    }

}

function parseParameterQueryType(){

    try{
        $return = [];
        $mens = "Lendo parâmetro da QueryString...";
        @$paramDecode = urldecode($_SERVER['QUERY_STRING']);
        writeLog("Parâmetros recebidos: $paramDecode " );
        //writeLog("URL " . urldecode($_SERVER['QUERY_STRING']));
        
        /*@$paramDecode= '{
        "codigo": "1111"
        }';*/
    
        //@$paramDecode=  urldecode($_POST[$pVarPost]) ;
        //$paramDecode= urldecode("%7B%22Ligacao%22%3A%7B%22uniqueid%22%3A%20%22000001.01%22%2C%22uuid%22%3A%20%22000001.02%22%2C%22direcao%22%3A%20%22entrada%22%2C%22src%22%3A%20%2211981081011%22%2C%22dst%22%3A%20%221142106262%22%2C%22calldate%22%3A%20%222020-04-08%2012%3A00%3A00%22%2C%22calldateend%22%3A%20%222020-04-08%2012%3A01%3A00%22%2C%22status%22%3A%20%22answer%22%2C%22ura%22%3A%20%22Principal%2CAgendamento%22%2C%22fila%22%3A%20%22principal%22%2C%22classificacao%22%3A%20%22Normal%22%2C%22cpf%22%3A%20%2219119119100%22%2C%22src_cidade%22%3A%20%22S%C3%A3o%20Paulo%22%2C%22src_uf%22%3A%20%22SP%22%2C%22src_ramal%22%3A%20%220001%22%2C%22src_agente%22%3A%20%222001%22%2C%22dst_ramal%22%3A%20%220002%22%2C%20%22dst_agente%22%3A%20%222002%22%7D%2C%20%22Options%22%3A%20%7B%22key%22%3A%20%2281245e4778577e3315dbe49ace4443e5%22%7D%7D");
        //$paramDecode= '{"Ligacao":{"uniqueid": "000001.01","uuid": "000001.02","direcao": "entrada","src": "11981081011","dst": "1142106262","calldate": "2020-04-08 12:00:00","calldateend": "2020-04-08 12:01:00","status": "answer","ura": "Principal,Agendamento","fila": "principal","classificacao": "Normal","cpf": "19119119100","src_cidade": "São Paulo","src_uf": "SP","src_ramal": "0001","src_agente": "2001","dst_ramal": "0002", "dst_agente": "2002"}, "Options": {"key": "81245e4778577e3315dbe49ace4443e5"}}';
        if($paramDecode)
        {
            $mens = "Parse dos parêmetros da QueryString...";
            @$data_model = explode('&',$paramDecode);

            if($data_model)
            {
                foreach ($data_model as $pair) {

                    $keyVal = explode('=',$pair);
                    $key = &$keyVal[0];
                    $val = urlencode($keyVal[1]);
                    $return[$key] = $val;
                    
                }
                return $return;
            }
            else
            {
                throw new Exception($mens);
            }

        }
        else
        {
            throw new Exception($mens);
        }

    }
    catch(Exception $ex)
    {
        writeLog('Erro : '. $ex ."\n");
        http_response_code(400);
        echo "Erro: " . $ex->getMessage();
    }

}

function writeLog($pLogMsg)
{   
    $pLogMsg = 'Called ' . $_SERVER['REQUEST_URI'] . ": \n{" . $pLogMsg . '}'; 
    $log_filename = "../log";
    if (!file_exists($log_filename)) 
    {
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
    
    file_put_contents($log_file_data, date('H:i:s') .' - ' . $pLogMsg . "\n", FILE_APPEND);
} 

function GetHTML($pJSON, $pKey)
{
    writeLog("Corpo do RTF = ".$pJSON->{$pKey});
    $reader = new RtfReader();
     $reader->Parse($pJSON->{$pKey});
    //$reader->root->dump(); // to see what the reader read
    $formatter = new RtfHtml();
    $formatter->Format($reader->root);       
    $Ret = $formatter->Format($reader->root);
    writeLog("Corpo do HTML = ".$Ret);
    return $Ret;
}

function RTF2HTML($pJSON, $pKey)
{
    $mHTML =GetHTML($pJSON, $pKey);
    $pJSON->{$pKey} = $mHTML;
}

function Convert2Base64($pJSON, $pKey)
{
    $pJSON->{$pKey} = base64_encode($pJSON->{$pKey});
}

function RTF2Base64($pJSON, $pKey)
{

    RTF2HTML($pJSON, $pKey);
    Convert2Base64($pJSON, $pKey);

}

?>