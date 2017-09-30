<html>
<head>
    <title>Calcula dias Úteis</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Calcula dias Úteis</h3>
	</div>
	<div class="panel-body">
			<table class="table">
				<tr>
					<!--CANPO REFERENTE A DATA INICIAL-->
					<td>Data Inicial</td>
				    <td><input type="date" class="form-control" id="dataInicial"/></td>
				</tr>
				<tr>
					<!--CANPO REFERENTE A DATA FINAL-->
					<td>Data Final</td>
				    <td><input type="date" class="form-control" id="dataFinal" /></td>
				</tr>
				<tr>
					<!--CAMPO ONDE SERÁ EXIBIDO OS DIAS UTEIS-->
					<td>Dias Uteis</td>
				    <td><input class="form-control" id="dados2" placeholder="Dias Uteis..." readonly /></td>
				</tr>
				<tr>
					<!--BOTÃO USADO PARA DAR O START AO JQUERY-->
				    <td>
				    <button class="btn btn-lg btn-primary" type="submit" id="calcular" /><span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>
				    </td>
				    <td></td>
				</tr>
				
				
			</table>
				
	</div>
</div>
</body>

<script>
//Inicio da Função do AJAX
function calcular(dataInicial,dataFinal)
            {
                var page = "calculo.php";//Chama o SCRIPT em PHP
                $.ajax
                        ({
                            type: 'POST', //USA METODO POST
                            dataType: 'html',
                            url: page,
                            beforeSend: function () {
                                $("#dados").val("Carregando...");
                            },
                            data: {dataInicial: dataInicial,dataFinal: dataFinal },//SETA AS VARIAVEIS ASEREM PASSADAS PELO POST
                            success: function (msg)
                            {
                                $("#dados2").val(msg);//RECEBE RETORNO DO SCRIPT PHP E EXIBE NO CAMPO DADOS
                            }
                        });
            }
//SCRIPT ACIONADO PELO CLIC NO BOTÂO
//RESPONSAVEL POR CHAMAR A FUNÇÂO AJAX 
	$('#calcular').click(function () {
                calcular($("#dataInicial",).val(),$("#dataFinal",).val())
            });
			
</script>