<?php
require 'config.php';
     // count percorre o tamanho da array
    //     for($i=0; $i < count($doencas); $i++) 


$nome = filter_input(INPUT_POST,'nome');
$data = filter_input(INPUT_POST, 'data');
$phone = filter_input(INPUT_POST,'phone');
$sexo = filter_input(INPUT_POST,'sexo');
$cep = filter_input(INPUT_POST,'cep');





if(isset($nome) and isset($nome) and isset($nome) and isset($nome) and isset($nome)){

    // RECEBER VALOR DAS CHECKBOXES
    $sintomas = null;
    
    if(isset($_POST['ckSintomas'])){
    
        $sintomas = $_POST['ckSintomas'];
        
    }
    
    print_r($sintomas);




    if($sintomas !== null){
    
    
        // variavel com os valores com implode
        $sintomasString = implode(",", $sintomas);
        print $sintomasString;
    
    
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
