<?php


    require_once("../functions.php");
    $database = connect_DB();
    
    $mes_inicial = @$_GET["mesIni"];
    $ano_inicial = @$_GET["anoIni"];

    $mes_final = @$_GET["mesFim"];
    $ano_final = @$_GET["anoFim"];

    $linhas = array();
    
    $where_clause = "";

    //CASO TENHA RANGE FINAL E RANGE INICIAL
    if(!empty($ano_inicial) && !empty($mes_inicial) && !empty($ano_final) && !empty($mes_final))
    {
        $where_clause = "WHERE ano >= $ano_inicial AND ano <= $ano_final AND mes >= $mes_inicial AND mes <= $mes_final";
    }
    else if(!empty($ano_inicial) && !empty($mes_inicial))
    {
        $where_clause = "WHERE ano >= $ano_inicial AND mes >= $mes_inicial ";
    }
    else if(!empty($ano_final) && !empty($mes_final))
    {
        $where_clause = "WHERE ano <= $ano_inicial AND mes <= $mes_inicial ";
    }

    $sql = "SELECT SUM(valor) AS total,
                        despesa,
                        mes,
                        ano,
                        COUNT(*) AS qtd,
                        SUM(valor) / count(*) AS media 
                        FROM `debitovereador` $where_clause GROUP BY despesa";

    $result = @mysqli_query($database,$sql);

    while($row = @mysqli_fetch_assoc($result))
    {
        $total = $row["total"];
        $despesa = $row["despesa"];
        $qtd = $row["qtd"];
        $media = $row["media"];
        //$mes = $row["mes"];
        //$ano = $row["ano"];

        $linha = array('total'=>$total,
                        'despesa'=>$despesa,
                        'qtd'=>$qtd,
                        'media'=>$media);

        array_push($linhas, $linha);

        //echo $total."<br>";
    }
    
    echo json_encode($linhas);

?>