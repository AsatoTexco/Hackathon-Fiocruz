<?php
require 'config.php';
     // count percorre o tamanho da array
    //     for($i=0; $i < count($doencas); $i++) 


$nome = filter_input(INPUT_POST,'nome');
$data = filter_input(INPUT_POST, 'data');
$phone = filter_input(INPUT_POST,'phone');
$sexo = filter_input(INPUT_POST,'sexo');
$cep = filter_input(INPUT_POST,'cep');





if(isset($nome) and isset($data) and isset($phone) and isset($sexo) and isset($cep)){

    // RECEBER VALOR DAS CHECKBOXES
    $sintomas = null;
    
    if(isset($_POST['ckSintomas'])){
    
        $sintomas = $_POST['ckSintomas'];
        
    }
    
    // print_r($sintomas);




    if($sintomas !== null){
    
    
        // variavel com os valores com implode
        $sintomasString = implode(",", $sintomas);
        // print $sintomasString;
    
    
        $sql= $pdo->prepare("INSERT INTO user (nome,nascimento,telefone,sexo,cep,sintomas) VALUES (:nome, :data, :phone,:sexo,:cep,:sintomas)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':data', $data);
        $sql->bindValue(':phone', $phone);
        $sql->bindValue(':sexo', $sexo);
        $sql->bindValue(':cep', $cep);
        $sql->bindValue(':sintomas', $sintomasString);
        $sql->execute();
    
    
        
    }



    // $sql= $pdo->prepare("INSERT INTO user VALUES (:nome, :data, :phone,:sexo,:cep,:sintomas)");
    // $sql->bindValue();
}




// $doencas esta com valores das checkboxes


//inserir no banco de dados














// FILTRAR VALOR DO TOKEN E POR EM VARIAVEL
// 
// $token_sintomas = '{"Token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpwX2R1cHJhdEBob3RtYWlsLmNvbSIsInJvbGUiOiJVc2VyIiwiaHR0cDovL3NjaGVtYXMueG1sc29hcC5vcmcvd3MvMjAwNS8wNS9pZGVudGl0eS9jbGFpbXMvc2lkIjoiMTE0NTkiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3ZlcnNpb24iOiIyMDAiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xpbWl0IjoiOTk5OTk5OTk5IiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwIjoiUHJlbWl1bSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbGFuZ3VhZ2UiOiJlbi1nYiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvZXhwaXJhdGlvbiI6IjIwOTktMTItMzEiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL21lbWJlcnNoaXBzdGFydCI6IjIwMjItMTEtMjYiLCJpc3MiOiJodHRwczovL3NhbmRib3gtYXV0aHNlcnZpY2UucHJpYWlkLmNoIiwiYXVkIjoiaHR0cHM6Ly9oZWFsdGhzZXJ2aWNlLnByaWFpZC5jaCIsImV4cCI6MTY2OTQ5NDczOCwibmJmIjoxNjY5NDg3NTM4fQ.X2py1ZJJPtuvi0Pvw5BFlyRpggDnzAe_yN7QSyw4Dzs","ValidThrough":7200}';
// $tokenDecodificado = json_decode($token_sintomas);
// $token_sintomas_final = $tokenDecodificado->Token;
// echo $token_sintomas_final;

//COISAS DA API

//declarando variaveis
$api_key = "jp_duprat@hotmail.com";
//Mudar para fazer cálculo depois!
$secret_key = "Zd27YfJq3j8PAc9y6";
$computed_hash = "w8Af5h04oz9IcBvQYUinDg==";

$url = "https://sandbox-authservice.priaid.ch/login";

$hash = hash_hmac('md5', $url, $secret_key);
$hashed_credentials = base64_encode ($hash);


$token = $api_key.":".$computed_hash;

//TROCAR POR VARIAVEIS DO ARTHUR
$genero = $sexo;
$ano = "2002";

//function jwt_request($token, $post) 

    header('Content-Type: text/html'); // Specify the type of data
    $ch = curl_init($url); // Initialise cURL
   // $post = json_encode($post); // Encode the data array into a JSON string
    $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
    $result = curl_exec($ch); // Execute the cURL statement
    curl_close($ch); // Close the cURL connection
    //return json_decode($result); // Return the received data

    //decodificando token
    $token_sintomas = $result;

    $token_decodificado = json_decode($token_sintomas);
    // print_r($decode);

    $token_sintomas_final =  $token_decodificado->Token;

    //criando url do pedido atual
    $vars = array(
    '{token}'       => $token_sintomas_final,
    '{gender}'        => $genero,
    '{ano}' => $ano,
    '{sintomas}' => "[".$sintomasString."]"
    );    

    $url_doenca = "https://sandbox-healthservice.priaid.ch/diagnosis?token={token}&symptoms={sintomas}&gender={gender}&year_of_birth={ano}&language=en-gb";

    $url_doenca = strtr($url_doenca, $vars);
    //INiciando curl
    $curl = curl_init($url_doenca);
    curl_setopt($curl, CURLOPT_URL, $url_doenca);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $resp = curl_exec($curl);
    curl_close($curl);
    

    $resp = json_decode($resp);

    $doencas_possiveis = [];
    $probabilidades = [];


    $ids = [];
    foreach ($resp as $key => $doença) {

        array_push($ids, $doença->Issue->ID);
        array_push($doencas_possiveis,$doença->Issue->Name);
        array_push($probabilidades,$doença->Issue->Accuracy);
    }

    
    $probabilidades1 = implode(",",$probabilidades);
    $doencas_possiveis1 = implode(",",$doencas_possiveis);

    // echo $doencas_possiveis;
    // echo PHP_EOL;
    // echo $probabilidades;
    
    

    //MANDAR DE VOLTA PARA O FRONT (fim do api saude)

     //COISAS DA API CEP

     $vars2 = array(
    '{cep}'  => $cep
    );    

    $url_cep = "https://viacep.com.br/ws/{cep}/json/";

    $url_cep = strtr($url_cep, $vars2);

     //INiciando curl
     $curl = curl_init($url_cep);
     curl_setopt($curl, CURLOPT_URL, $url_cep);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
     $cep_json = curl_exec($curl);
     curl_close($curl);
    
     $cep_json = json_decode($cep_json);
     


     function traduzir($id){
        $doencasArray = array(
            170 => "Aborto",
            509 => "Hidrocele",
            113 => "Pneumonia",
            495 => "Barriga inchada",
            211 => "Síndrome da fadiga crônica",
            80 => "Resfriado",
            53 => "Constipação",
            86 => "Doença arterial coronariana",
            47 => "Depressão",
            266 => "Criptorquidia",
            431 => "Efeito colateral de drogas",
            237 => "Problemas de ereção",
            181 => "Sentimento excessivo de medo",
            11 => "Gripe",
            281 => "Intoxicação alimentar",
            107 => "Rubéola",
            104 => "Dor de cabeça",
            87 => "Ataque cardíaco",
            434 => "Coração acelerado",
            130 => "Hérnia",
            209 => "Doença de Huntington",
            15 => "Reação de hipersensibilidade",
            83 => "Meningite",
            235 => "Epididimite",
            44 => "Inflamação do nariz e garganta",
            504 => "Inflamação da próstata",
            331 => "Inflamação dos testículos",
            131 => "Artrite infecciosa",
            324 => "Pedra no rim",
            109 => "Doença do beijo",
            166 => "Listeriose",
            51 => "Diarréia",
            79 => "Doença de Lyme",
            357 => "Câncer de próstata",
            50 => "Menopausa",
            489 => "Cólica menstrual", 
            347 => "Fimose",
            167 => "Embolia pulmonar",
            446 => "Gravidez",
            18 => "Refluxo gastroesofágico",
            376 => "Escarlatina",
            68 => "Paralisia Agitante",
            67 => "Enxaqueca",
            103 => "Hérnia de disco",
            19 => "Fumar",
            510 => "Espermatocele",
            476 => "Sangramento gastrointestinal",
            488 => "Tensão nas costas",
            151 => "Torção testicular",
            497 => "Doença inflamatória pélvica (DIP)",
            59 => "Infecção urinária",
            2059 => "NOVO COVID 2022"
        );
    
        if ($doencasArray[$id]) {
            return $doencasArray[$id];
        }else{
            return "ERRO";
        }
    
    }   
     
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 0px;
    background: #fff;
    display: grid;
    gap: 50px;
    justify-items: center;
    padding-top: 70px;
  }

  .resposta{ 
    background-color: #f7f7f7;
    border: solid 1px #04AA6D;
    border-radius: 20px;
    padding: 1.5rem;
  }

  .doenca{
    font-size: 20px;

  }
    </style>
</head>
<body>
    

<div class="resposta">
    <div class="bairro"><?php 
        if ($cep_json != null){
        
            if ($cep_json->localidade == "Campo Grande"){
              echo "Você esta no bairro: ".$cep_json->bairro.", Procure a unidade de saúde mais próxima de você";
            
                if($cep_json->bairro == "Conjunto Aero Rancho" or $cep_json->bairro == "Jardim Aero Rancho"){


                    echo "<br><br>Unidade Sugerida: Endereço: R. Leonor García Rosa Píres - Conj. Aero Rancho, Campo Grande - MS, 79084-210";

                }
                else if($cep_json->bairro == "Vila Cidade Morena"){


                    echo "<br><br>Unidade Sugerida: Endereço: R. Jaguariuna, 543 - Vila Cidade Morena, Campo Grande - MS, 79073-041";

                }
                else if($cep_json->bairro == "Nova Lima"){


                    echo "<br><br>Unidade Sugerida: Endereço: R. Ida Baís, 19 - Nova Lima, Campo Grande - MS, 79017-084";

                }
                else if($cep_json->bairro == "Vila Carvalho"){


                    echo "<br><br>Unidade Sugerida: Endereço: Av. Joaquim Manoel de Carvalho, 605 - Vila Carvalho, Campo Grande - MS, 79005-580";

                }
                else if($cep_json->bairro == "Caiçara"){


                    echo "<br><br>Unidade Sugerida: Endereço: R. Vital Brasil, 1 - Caicara, Campo Grande - MS, 79090-222";

                }
            
            
            }
            
            }  ?></div><br>
        
        
        <h2>Atenção</h2>
    <p>Isso é apenas uma pré-triagem, procure seu médico de confiança para que o devido diagnóstico possa ser feito<p>
        <br>

    <?php 

    
    
    $cont = 0;
    
    foreach($doencas_possiveis as $doencas1):?>
    
    
    <div class="doenca">
        
        <?php 
        echo (traduzir($ids[$cont]).": " . ($probabilidades[$cont]."%" ) );
        $cont = $cont + 1;
    
        ?>

    </div>
    
    <br>
    


    <?php endforeach; ?>

    

    
</div>

    
</body>
</html>
