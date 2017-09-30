<?php
/*

Não encontrava nenhuma função que me ajudasse a calcular dias uteis contando com feriados
e dias da semana então ao encontrar um script que exibia as datas dos feriados brasileiros 
(http://codigofonte.uol.com.br/codigos/funcao-que-calcula-os-feriados-brasileiros-em-php)
tive essa ideia de fazer um script que calculasse os dias uteis em um periodo dado para o usuario
e depois modifica-lo para periodos em meses, que era o que eu realmete precisava.



*/





//INICIO da FUNÇÂO QUE CALCUA O DIA DOS FERIADOS
function feriados($ano = null){
  if ($ano === null)
  {
    $ano = intval(date('Y'));
  }
  //Atravéz de uma função do PHP verifica a data da páscoa 
  // (Para saber mais pesquise sobre como é calculado o dia da pascoa)
  $pascoa = easter_date($ano);
  //PEGA O dia da pascoa do mes sem zero a esquerda
  $dia_pascoa = date('j', $pascoa);
  //PEGA o mes da pascoa sem zero a esquerda
  $mes_pascoa = date('n', $pascoa);
  //PEGA o ano da pascoa com quatro digitos
  $ano_pascoa = date('Y', $pascoa);
  //ARRAY com os FERIADOS SETADOS
  $feriados = array(
    //INICIO FERIADOS FIXOS NO CALENDÁRIO
    mktime(0, 0, 0, 1,  1,   $ano), // Confraternização Universal - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 4,  21,  $ano), // Tiradentes - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 5,  1,   $ano), // Dia do Trabalhador - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 9,  7,   $ano), // Dia da Independência - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 10,  12, $ano), // N. S. Aparecida - Lei nº 6802, de 30/06/80
    mktime(0, 0, 0, 11,  2,  $ano), // Todos os santos - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 11, 15,  $ano), // Proclamação da republica - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 12, 25,  $ano), // Natal - Lei nº 662, de 06/04/49
    // INICIO FERIADOS BASEADOS NA PÁSCOA
    // Para considerar 2 dias de carnaval descomente a linha abaixo
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa),//2ºferia Carnaval
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa),//3ºferia Carnaval	
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa),//6ºfeira Santa  
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa),//Pascoa
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa),//Corpus Cirist
    );
      sort($feriados);
  
  return $feriados;
}
// FIM da FUNÇÂO QUE CALCUA O DIA DOS FERIADOS


// INICIO da FUNÇÃO QUE CALCULA FINS DE SEMANA NO MES
// RECEBE MES, ANO, DATA FINAL, E DATA INICIAL
function dias_uteis($mes,$ano,$datafinal,$datainicial){
  
  $uteis = 0;
  // Obtém o número de dias no mês através de uma função nativa do php e atribui a variavel dias_no_mes
  $dias_no_mes = $num = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

  // FAZ um for que passa dia a dia ate acabar o mes recebendo a variavel dias_no_mes como limite do FOR
  for($dia = 1; $dia <= $dias_no_mes; $dia++){

    // TRANSFORMA em TIMESTAMP a data dada pelo FOR
    $timestamp = mktime(0, 0, 0, $mes, $dia, $ano);
    
    // RETORNA numero de acordo com o dia da semana sendo
    // 1-segunda, 2-terça, 3-quarta, 4-quinta, 5-sexta, 6-sabado, 0-domingo
    $semana = date("w", $timestamp);

      // VERIFICA se a DATA em questão é >= a data inicial e <= a data  final
      if(strtotime($ano."-".$mes."-".$dia) <= strtotime($datafinal) && strtotime($ano."-".$mes."-".$dia) >= strtotime($datainicial))
        {
        // VERIFICA se não é umsabado ou domingo para adicionar 1 ao contador de dias uteis
        if($semana < 6 && $semana > 0 ) $uteis++;
        }
    
  }
  // RETORNA os dias da semana (daias uteis sem considerar feriados)
  return $uteis;

}



// FUNÇÂO RESPONSÁVEl por chamar as FUNÇOES que CAlCULA DIAS UTEIS e FERIADOS paracada PERIODO dado PELO USUARIO
// INICIO FUNÇÂO corre_anos
function corre_anos($anoinicial, $anofinal,$mesinicial,$mesfinal,$datainicial,$datafinal){

  // CONTADOR DE FERIADOS QUE CAEM EM DIAS UTEIS
  $feriados_em_dias_uteis = 0;
  //PARA CADA ANO do ano inicial ao ano final chama a função calcula feriados
  for ($ano = $anoinicial; $ano <= $anofinal ; $ano++) {
  $i = 0;

      foreach(feriados($ano) as $a)
      {
        $util['$i'] = date("Y-m-d",$a);

        date("w", strtotime($util['$i']));
        // VERIFICA se o FERIADO CAI EM DIA DE SEMANA atarves da função nativa do php que
        // RETORNA numero de acordo com o dia da semana sendo
        // 1-segunda, 2-terça, 3-quarta, 4-quinta, 5-sexta, 6-sabado, 0-domingo
        if(date("w", strtotime($util['$i'])) != 0 && date("w", strtotime($util['$i'])) != 6 && strtotime($util['$i']) <= strtotime($datafinal) && strtotime($util['$i']) >= strtotime($datainicial) )
        {
          //CASO seja dia de semana soma mais um ao contador
          $feriados_em_dias_uteis++;
        }
        
        $i++;
      }

  }

  // Invocando a função Dias Uteis
  $total_dias_uteis = 0;

  //Anda de anao em ano Do ano Inicial ao Final
  for ($ano = $anoinicial; $ano <= $anofinal  ; $ano ++) {
    /*Chama a Função dias uteis para cada mes começando do MES INICIAL DADO PELO USUARIO VOLTANDO AO MES 1
    ao FIMDE CADA ANO*/
    for ($mesinicial ; $mesinicial < 13 ; $mesinicial++) {
        $total_dias_uteis = $total_dias_uteis + dias_uteis($mesinicial,$ano,$datafinal,$datainicial);
      }
    //RETORNA CONTADOR DE MES AO MES 1 quando este chega ao "13"
    if ($mesinicial == 13){
      $mesinicial = 1;
    }
  }

  //EXIBE OS DIAS UTEIS subitraidos dos OS FERIADOS	QUE CAEM EM DIAS DE SEMANA
  echo $total_dias_uteis-$feriados_em_dias_uteis; //O AJAX PEGA COMO PADRÃO ESTE ECO
}
//FIM FUNÇÂO corre_anos

//SETANDO VARIAVEIS
//Recebe Post via AJAX referente ao campo Data Inicial
$data1 = $_POST['dataInicial']; 
//Inicio Tratamento da Data
// Eplode a data separando o DIA, MES e ANO
$parte_data1 = explode("-", $data1);
$anoinicial = $parte_data1['0'];
$mesinicial = $parte_data1['1'];
$diainicial = $parte_data1['2'];
//Concatena em um Novo Formato de DATA
$datainicial = $anoinicial."-".$mesinicial."-".$diainicial;

/*
Caso Queira Usar uma DATA com dia/mes/ano especificado Mantenha TRECHO1 não comentado 
e TRECHO2 como comentário
*/

//INICIO TRECHO 1

//Recebe Post via AJAX referente ao campo Data Inicial
$data2 = $_POST['dataFinal'];
//Inicio Tratamento da Data
// Eplode a data separando o DIA, MES e ANO
$parte_data2 = explode("-", $data2);
$anofinal = $parte_data2['0'];
$mesfinal = $parte_data2['1'];
$diafinal = $parte_data2['2'];
//Concatena em um Novo Formato de DATA
$datafinal = $anofinal."-".$mesfinal."-".$diafinal;

//FIM TRECHO 1

/*
Caso Queira Usar como parametro uma quantidade de meses ao invez de uma data final
marque como cometário o TRECHO 1 e descomente o TRECHO 2 
*/

//INICIO TRECHO 2

/*$parcelas = $_POST['palavra2'];

$nextyear = mktime(0, 0, 0, $mesinicial+$parcelas, $diainicial, $anoinicial);
$datafinal = date("Y-m-d", $nextyear);
$datatratada = explode("-",$datafinal);
$mesfinal = $datatratada['1']; 
$diafinal = $datatratada['2'];
$anofinal = $datatratada['0'];*/
//FIM TRECHO 2

//CHAMA A FUNÇÂO CORRE ANOS
corre_anos($anoinicial,$anofinal,$mesinicial,$mesfinal,$datainicial,$datafinal)

?>