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
//CHUMBADAÇA
$secret_key = "Zd27YfJq3j8PAc9y6";
//HASH "chumbada" (refazer na hora)
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

    foreach ($resp as $key => $doença) {
        array_push($doencas_possiveis,$doença->Issue->Name);
        array_push($probabilidades,$doença->Issue->Accuracy);
    }

    $probabilidades = implode(",",$probabilidades);
    $doencas_possiveis = implode(",",$doencas_possiveis);

    echo $doencas_possiveis;
    echo PHP_EOL;
    echo $probabilidades;
    
    

    //MANDAR DE VOLTA PARA O FRONT
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        p{
            font-size: 200px;
        }


    </style>
</head>
<body>

<div class="teste">

    <p><?php echo $probabilidades?></p>

</div>

    
</body>
</html>
