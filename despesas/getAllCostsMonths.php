<?php

    require_once("../functions.php");
    $database = connect_DB();
    
    $linhas = array();

    $sql = "SELECT SUM(valor) AS total, mes FROM `debitovereador` GROUP BY mes";
    $result = @mysqli_query($database,$sql);

    while($row = @mysqli_fetch_assoc($result))
    {
        $total = $row["total"];
        $mes = $row["mes"];

        $linha = array('total'=>$total,
                        'mes'=>$mes);

        array_push($linhas, $linha);

        //echo $total."<br>";
    }
    
    echo json_encode($linhas);

?>