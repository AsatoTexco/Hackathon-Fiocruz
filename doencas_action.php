<?php
require 'config.php';
     // count percorre o tamanho da array
    //     for($i=0; $i < count($doencas); $i++) 


$nome = filter_input(INPUT_POST,'nome');

echo $nome;


$sintomas = null;

if(isset($_POST['ckSintomas'])){

    $sintomas = $_POST['ckSintomas'];
    
}

// $doencas esta com valores das checkboxes

print_r($sintomas);

//inserir no banco de dados


if($sintomas !== null){


    $sintomasString = implode(",", $sintomas);
    print $sintomasString;
    $sql = $pdo->prepare("INSERT INTO user (sintomas) VALUES (:sintomas)" );
    $sql->bindValue(':sintomas', $sintomasString);
    $sql->execute();

    
}


// FILTRAR VALOR DO TOKEN E POR EM VARIAVEL


// $token_sintomas = '{"Token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpwX2R1cHJhdEBob3RtYWlsLmNvbSIsInJvbGUiOiJVc2VyIiwiaHR0cDovL3NjaGVtYXMueG1sc29hcC5vcmcvd3MvMjAwNS8wNS9pZGVudGl0eS9jbGFpbXMvc2lkIjoiMTE0NTkiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3ZlcnNpb24iOiIyMDAiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL2xpbWl0IjoiOTk5OTk5OTk5IiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9tZW1iZXJzaGlwIjoiUHJlbWl1bSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbGFuZ3VhZ2UiOiJlbi1nYiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvZXhwaXJhdGlvbiI6IjIwOTktMTItMzEiLCJodHRwOi8vZXhhbXBsZS5vcmcvY2xhaW1zL21lbWJlcnNoaXBzdGFydCI6IjIwMjItMTEtMjYiLCJpc3MiOiJodHRwczovL3NhbmRib3gtYXV0aHNlcnZpY2UucHJpYWlkLmNoIiwiYXVkIjoiaHR0cHM6Ly9oZWFsdGhzZXJ2aWNlLnByaWFpZC5jaCIsImV4cCI6MTY2OTQ5NDczOCwibmJmIjoxNjY5NDg3NTM4fQ.X2py1ZJJPtuvi0Pvw5BFlyRpggDnzAe_yN7QSyw4Dzs","ValidThrough":7200}';
// $tokenDecodificado = json_decode($token_sintomas);
// $token_sintomas_final = $tokenDecodificado->Token;
// echo $token_sintomas_final;


// PEGAR 3 PRIMEIROS DOENÇAS PROVAVEIS


$name_accuracy = '{"Issue":{"ID":11,"Name":"Flu","Accuracy":90,"Icd":"J10;J11","IcdName":"Influenza due to other identified influenza virus;Influenza, virus not identified","ProfName":"Influenza","Ranking":1},"Specialisation":[{"ID":15,"Name":"General practice","SpecialistID":0},{"ID":19,"Name":"Internal medicine","SpecialistID":0}]},{"Issue":{"ID":113,"Name":"Acute inflammation of lung","Accuracy":48.2142868,"Icd":"J12;J13;J14;J15;J16;J17;J18;P23","IcdName":"Viral pneumonia, not elsewhere classified;Pneumonia due to Streptococcus pneumoniae;Pneumonia due to Haemophilus influenzae;Bacterial pneumonia, not elsewhere classified;Pneumonia due to other infectious organisms, not elsewhere classified;Pneumonia in diseases classified elsewhere;Pneumonia, organism unspecified;Congenital pneumonia","ProfName":"Pneumonia","Ranking":2},"Specialisation":[{"ID":15,"Name":"General practice","SpecialistID":0},{"ID":19,"Name":"Internal medicine","SpecialistID":0},{"ID":35,"Name":"Pulmonology","SpecialistID":0}]}';
// print($name_accuracy);
$decode = json_decode($name_accuracy);
print_r($decode);








