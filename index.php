<?php 
	$qtds = array();
	$tempos = array();

	$qtdsP = array();
	$potencias = array();
	
	$qtdsC = array();
	$canais = array();
	
	$cor = array();
	
	$cor[0] = '#ff3300';
	$cor[1] = '#77787A';
	$cor[2] = '#006600';
	$cor[3] = '#0000ff';
	$cor[4] = '#0A0A0A';
	$cor[5] = '#E3D519';
	$cor[6] = '#0DEFF3';
	$cor[7] = '#E3820D';
	$cor[8] = '#9BF30D';
	$cor[9] = '#9D99CA';
	$cor[10] = '#BCA57E';
	$cor[11] = '#A1B596';
	$cor[12] = '#7FACA2';
	
	$dateNow = new DateTime();
	$dateNow->setTimezone(new DateTimeZone('America/Recife'));
	$dataAtual = $dateNow->format('Y-m-d');
	
	if(!isset($_GET['data1'])){
		$data1= $dataAtual; // 2018-01-05 09:31:00
	}
	else{
		$data1=$_GET['data1'];
	}
	
	if(!isset($_GET['hora1'])){
		$hora1= '09:00';
	}
	else{
		$hora1=$_GET['hora1'];
	}
	
	if(!isset($_GET['data2'])){
		$data2= $dataAtual; // 2018-01-05 09:31:00
	}
	else{
		$data2=$_GET['data2'];
	}
	
	if(!isset($_GET['hora2'])){
		$hora2= '10:00';
	}
	else{
		$hora2=$_GET['hora2'];
	}
	
	if(!isset($_GET['intervalo'])){
		$intervalo = 5;
	}
	else{
		$intervalo = $_GET['intervalo'];
	}
	
	/*$dt1 = new DateTime($data1 . " " . $hora1);
	
	$dt2 = new DateTime($data1 . " " . $hora1);
	$dt2->modify('+ ' . $intervalo . ' min');
	
	$dtFinal = new DateTime($data2 . " " . $hora2);*/
	
	$conexao = mysqli_connect("127.0.0.1", "root", "", "meshdb");
	
	/*$pot1 = -110;
	$pot2 = $pot1 + $intervalo;
	$potX = $pot2;
	
	$dt1_Str = $dt1->format('Y-m-d H:i:s');
	$dt2_Str = $dt2->format('Y-m-d H:i:s');
	$sql = "SELECT COUNT(rssi) AS qtd FROM (SELECT rssi FROM dadosTeste WHERE datetime BETWEEN '$dt1_Str' AND '$dt2_Str' GROUP BY addr) grp WHERE rssi BETWEEN $pot1 AND $pot2";
	//$sql = "SELECT COUNT(rssi) as qtd FROM dadosTeste WHERE datetime BETWEEN $dt1_Str AND $dt2_Str";
	$resultado = mysqli_query($conexao,$sql);
	$row3 = mysqli_fetch_object($resultado);
	$row2 = $row3 -> qtd;
	
	SELECT COUNT(ch) as qtd,ch FROM dadosTeste GROUP BY ch,addr
	SELECT COUNT(ch) as qtd,ch FROM dadosMesh GROUP BY ch // contando os masc repetidos
	*/
	
	
	if(!isset($_GET['tipoBusca'])){
		$tipoBusca= 'nenhuma';
	}
	else{
		$tipoBusca= $_GET['tipoBusca'];
	}
	
	if ($tipoBusca == 'Data'){
		$i = 0;
		$dt1 = new DateTime($data1 . " " . $hora1);
		$dt2 = new DateTime($data1 . " " . $hora1);
		$dt2->modify('+ ' . $intervalo . ' min');
		$dtFinal= new DateTime($data2 . " " . $hora2);
		//$intervalo = (string)$intervalo;
		while ($dt1 < $dtFinal){
			$dt1_Str = $dt1->format('Y-m-d H:i:s');
			$dt2_Str = $dt2->format('Y-m-d H:i:s');
			
			$sql = "SELECT COUNT(addr) AS qtd FROM (SELECT addr FROM dadosMesh WHERE datetime BETWEEN '$dt1_Str' AND '$dt2_Str' GROUP BY addr) grp";
			$resultado = mysqli_query($conexao,$sql);
			$row = mysqli_fetch_object($resultado);
			$qtd = $row -> qtd;
			$qtds[$i] = $qtd;
			$tempo = $dt1_Str;
			$tempos[$i] = $tempo;
			$i = $i + 1;
			$dt1->modify('+ ' . $intervalo . ' min');
			$dt2->modify('+ ' . $intervalo . ' min');
		}
	}
	
	elseif ($tipoBusca == 'Potencia'){
		$i = 0;
		$pot1 = -110;
		$pot2 = $pot1 + $intervalo;
		$potX = $pot2;
		$dt1 = new DateTime($data1 . " " . $hora1);
		$dt2 = new DateTime($data2 . " " . $hora2);
		$dt1_Str = $dt1->format('Y-m-d H:i:s');
		$dt2_Str = $dt2->format('Y-m-d H:i:s');
		while ($pot1 < -10){
			$sql = "SELECT COUNT(rssi) AS qtd FROM (SELECT rssi FROM dadosMesh WHERE datetime BETWEEN '$dt1_Str' AND '$dt2_Str' GROUP BY addr) grp WHERE rssi BETWEEN $pot1 AND $pot2";
			$resultado = mysqli_query($conexao,$sql);
			$row = mysqli_fetch_object($resultado);
			$qtd = $row -> qtd;
			$qtdsP[$i] = $qtd;
			$potencia = $pot1;
			$potencias[$i] = $potencia;
			$i = $i + 1;
			$pot1 = $pot1 + $intervalo;
			$pot2 = $pot2 + $intervalo;
		}
	}
	
	elseif ($tipoBusca == 'Canal'){
		$i = 0;
		$dt1 = new DateTime($data1 . " " . $hora1);
		$dt2 = new DateTime($data2 . " " . $hora2);
		$dt1_Str = $dt1->format('Y-m-d H:i:s');
		$dt2_Str = $dt2->format('Y-m-d H:i:s');
		
		$sql = "SELECT COUNT(ch) as qtd,ch FROM dadosMesh WHERE datetime BETWEEN '$dt1_Str' AND '$dt2_Str' GROUP BY ch";
		//$sql = "SELECT COUNT(ch) as qtd,ch FROM dadosTeste GROUP BY ch";
		$resultado = mysqli_query($conexao,$sql);
		while ($row = mysqli_fetch_object($resultado)){
			$qtd = $row -> qtd;
			$canal = $row -> ch;
			$qtdsC[$i] = $qtd;
			$canais[$i] = $canal;
			$i = $i + 1;			
		}
	}
	
?>


<!DOCTYPE html>

<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Sistema Mesh</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<!-- Le styles -->
<script src="site/assets/js/jquery.min.js"></script>
<link href="site/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="site/assets/css/font-awesome.min.css" rel="stylesheet">
<link href="site/assets/css/style.css" rel="stylesheet">
<link href="site/assets/css/animate.css" rel="stylesheet">
<link href="site/assets/css/skin-blue.css" rel="stylesheet">
<!-- Le fav -->
<link rel="shortcut icon" href="site/assets/ico/mesh.png">
    <link href="site/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="site/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="site/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="site/assets/css/styletable.css" rel="stylesheet" />

<style>

#Section-5 {
    background-image: black;
    background-color: white;
    background-position: right bottom, left top;
    background-repeat: no-repeat, repeat;
    padding: 15px;
}
</style>

</head>
<!-- /head-->
<body data-spy="scroll" data-target=".navbar" onload="mostrarGrafs();mostrarCampoBusca();">
<nav id="topnav" class="navbar navbar-fixed-top navbar-default" role="navigation">
<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#top-section"><img width="20%" height="20%" src="site/assets/ico/mesh.png">SISTEMA MESH</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#top-section">Home</a></li>
            <li><a href="#Section-1">Gráficos</a></li>
            <li><a href="#Section-4">Desenvolvedores</a></li> 
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</div>
</nav>
<!-- HOMEPAGE -->
<header id="top-section" class="fullbg">
<div class="jumbotron">
    <div id="carousel_intro" class="carousel slide fadeing">
        <div class="carousel-inner">
            <div class="active item" id="slide_1">
                <div class="carousel-content">
                    <div class="animated fadeInDownBig">
                         <h1>Sistema Web - Redes Mesh .</h1>
                    </div>
                    <br/>
                    <a href="#Section-1" class="buttonyellow animated fadeInLeftBig"><b>Gráficos</b></a>
                </div>
            </div>
            <div class="item" id="slide_2">
                <div class="carousel-content">
                    <div class="animated fadeInDownBig">
                         <h1>Disciplinas de Redes - RSI</h1>
                    </div>
                    <br/>
                    <a href="#Section-4" class="buttoncolor animated fadeInRightBig"><b>Desenvolvedores</b></a>
                </div>
            </div>
            <div class="item" id="slide_3">
                <div class="carousel-content">
                    <div class="animated fadeInDownBig">
                         <h1>Rede Mesh com NodeMCU</h1>
                    </div>
                        <br/>
                        <a href="https://github.com/flushedlucas/MeshSniffer" class="buttonyellow animated fadeInLeftBig"><b>Projeto (Github)</b></a>
                </div>
            </div>
        </div>
    </div>
    <button class="left carousel-control" href="#carousel_intro" data-slide="prev" data-start="opacity: 0.6; left: 0%;" data-250="opacity:0; left: 5%;"><i class="fa fa-chevron-left"></i></button>
    <button class="right carousel-control" href="#carousel_intro" data-slide="next" data-start="opacity: 0.6; right: 0%;" data-250="opacity:0; right: 5%;"><i class="fa fa-chevron-right"></i></button>
</div>
<div class="inner-top-bg">
</div>
</header>
<!-- / HOMEPAGE -->

<!-- SECTION-1(Grafico1) -->
<section id="Section-1" class="fullbg color-white">
<div class="section-divider">
</div>
<div class="container demo-3">
<div class="row">
	<div class="page-header text-center col-sm-12 col-lg-12 animated fade">
		<h1>Gráficos - MAC's</h1>
	</div>
</div>

<div class="container">
	<form action = "#Section-1" class="form-inline">
				<div class="form-group">
					<caption>Opções de Consulta:</caption>
					<select class="form-control" id="tipoBusca" name="tipoBusca" value = <?php echo $tipoBusca ?>>
						<option value="Data" <?php if ($tipoBusca == 'Data') echo 'selected="selected"'; ?> >Por Intervalo de Tempo</option>
						<option value="Potencia" <?php if ($tipoBusca == 'Potencia') echo 'selected="selected"'; ?> >Por Faixa de Potência</option>
						<option value="Canal" <?php if ($tipoBusca == 'Canal') echo 'selected="selected"'; ?> >Por Canal</option>
					</select>
				</div>
				<div class="form-group">
					Data Inicial:<input class="form-control" id="data1" name="data1" type="date" value = <?php echo $data1 ?> required/>
				</div>	
				<div class="form-group">
					Hora Inicial:<input class="form-control" id="hora1" name="hora1" type="time" value = <?php echo $hora1 ?> required/>
				</div>
				<div class="form-group">	
					Data Final:<input class="form-control" id="data2" name="data2" type="date" value = <?php echo $data2 ?> required/>
				</div>
				<div class="form-group">	
					Hora Final:<input class="form-control" id="hora2" name="hora2" type="time" value = <?php echo $hora2 ?> required/>
				</div>
				
				<table style="width:100%">
				  <tr>
				    <div id="valorBusca">
					    <td>
						<div class="form-group;">
						<div id="intervaloTempo" <?php if ($tipoBusca == 'Potencia') echo 'hidden'; ?> >Intervalo de Tempo (min):</div>
						<div id="faixaPotencia" <?php if ($tipoBusca == 'Data') echo 'hidden'; ?> >Faixa de Potência (dBm):</div>
							<input class="form-control" id="intervalo" style="width:20%;" name="intervalo" type="number" value = <?php echo $intervalo ?> <?php if ($tipoBusca == 'Canal') echo 'hidden'; ?> required/>
					    </div>			    
					    </td>
					</div>
				    <td style="text-align:right;">
				    <div class="form-group">
					<input class="btn-success btn-lg align-bottom" type="submit" value="Plotar"></input>
					</div>
				    </td>

				  </tr>
				</table>
				
				
	</form>
		
</br>

<div id="grafico1">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Tempo", "Qdt", { role: "style" } ],
		<?php 
		$c = 0;
		$k = $i;
		for ($i=0; $i < $k; $i++){
		?>

		['<?php echo $tempos[$i] ?>', <?php echo $qtds[$i] ?>, '<?php echo $cor[$c] ?>'],

		<?php 
		$c = $c + 1;
		if($c > 12){
			$c = 0;
			}
			
		} ?>
        
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Quantidade de MAC's por Intervalo de Tempo",
        width: '100%',
        height: 400,
        vAxis: {title: "Quantidade de MAC's capturados"},
        hAxis: {title: "Data"},
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values1"));
      chart.draw(view, options);
  }
  </script>
  <div id="columnchart_values1" style="width:100%; height: 300px;"></div>
</div>

<div id="grafico2">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Potencia", "Qdt", { role: "style" } ],
		<?php 
		$c = 0;
		$k = $i;
		for ($i=0; $i < $k; $i++){
		?>

		['<?php echo $potencias[$i] ?>', <?php echo $qtdsP[$i] ?>, '<?php echo $cor[$c] ?>'],

		<?php 
		$c = $c + 1;
		if($c > 12){
			$c = 0;
			}
			
		} ?>
        
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Quantidade de MAC's por Faixa de Potência",
        width: '100%',
        height: 400,
        vAxis: {title: "Quantidade de MAC's capturados"},
        hAxis: {title: "Potência"},
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values2"));
      chart.draw(view, options);
  }
  </script>
  <div id="columnchart_values2" style="width: 100%; height: 300px;"></div>

</div>

<div id="grafico3">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Canal", "Qdt", { role: "style" } ],
		<?php 
		$c = 0;
		$k = $i;
		for ($i=0; $i < $k; $i++){
		?>

		['<?php echo $canais[$i] ?>', <?php echo $qtdsC[$i] ?>, '<?php echo $cor[$c] ?>'],

		<?php 
		$c = $c + 1;
		if($c > 12){
			$c = 0;
			}
			
		} ?>
        
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Quantidade de MAC's por Canal",
        width: '100%',
        height: 400,
        vAxis: {title: "Quantidade de MAC's capturados"},
        hAxis: {title: "Canal"},
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values3"));
      chart.draw(view, options);
  }
  </script>
  <div id="columnchart_values3" style="width: 100%; height: 300px;"></div>

</div>

</section>

<!-- SECTION-4(reviews) -->
<section id="Section-4" class="fullbg color-white">
<div class="section-divider">
</div>
<div class="container">
<div class="row">
    <div class="page-header text-center col-sm-12 col-lg-12 animated fade">
        <h1>Desenvolvedores</h1>
    </div>
</div>
<div class="row testimonials animated fadeInUpNow">
    <div class="col-sm-12 col-lg-12">
        <div class="arrow">
        </div>
        <div class="testimonials-slider">
            <div class="slide">
                <div class="testimonials-carousel-thumbnail">
                    <img width="120" alt="" src="site/assets/img/avatar.jpg">
                </div>
                <div class="testimonials-carousel-context">
                    <div class="testimonials-name">
                         Jobson Rocha <span>UFRPE - Aluno</span>
                    </div>
                    <div class="testimonials-carousel-content">
                        <p>
                             Telefone: (81) 91919-9191
                        </p>
                        <p>
                             E-mail: jobson@com
                        </p>
                    <div class="testimonials-name">
                         Professor: Glauco Gonçalves
                    </div>
                    </div>
                </div>
            </div>
            <div class="slide">
                <div class="testimonials-carousel-thumbnail">
                    <img width="120" alt="" src="site/assets/img/avatar.jpg">
                </div>
                <div class="testimonials-carousel-context">
                    <div class="testimonials-name">
                         Lucas Vieira <span>UFRPE - Aluno</span>
                    </div>
                    <div class="testimonials-carousel-content">
                        <p>
                             Telefone: (81) 92929-9292
                        </p>
                    </div>
                    <p>
                         E-mail: lucas@com
                    </p>
                    <div class="testimonials-name">
                         Professor: Glauco Gonçalves
                    </div>
                </div>
            </div>
            <div class="slide">
                <div class="testimonials-carousel-thumbnail">
                    <img width="120" alt="" src="site/assets/img/avatar.jpg">
                </div>
                <div class="testimonials-carousel-context">
                    <div class="testimonials-name">
                         Luiz Felipe <span>UFRPE - Aluno</span>
                    </div>
                    <div class="testimonials-carousel-content">
                        <p>
                             Telefone: (81) 93939-9393
                        </p>
                    </div>
                    <p>
                         E-mail: luiz@com
                    </p>
                    <div class="testimonials-name">
                         Professor: Glauco Gonçalves
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>

<!-- FOOTER -->
<footer id="foot-sec">
<div class="footerdivide">
</div>
<div class="container ">
<div class="row">
    <div class="text-center color-white col-sm-12 col-lg-12">
        <ul class="social-icons">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
        </ul>
        <p>
             © Your Website.com. Template by WowThemes.net
        </p>
        <p>
            <a href="">Official Website</a> | <a href="">Theme Support</a> | <a href="">F.A.Q.</a>
        </p>
    </div>
</div>
</div>
</footer>
<!-- Le javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="site/assets/js/jquery.min.js" type="text/javascript"></script>
<script src="site/assets/js/bootstrap.js"></script>
<script src="site/assets/js/jquery.parallax-1.1.3.js" type="text/javascript"></script>
<script src="site/assets/js/jquery.localscroll-1.2.7-min.js" type="text/javascript"></script>
<script src="site/assets/js/jquery.scrollTo-1.4.6-min.js" type="text/javascript"></script>
<script src="site/assets/js/jquery.bxslider.min.js"></script>
<script src="site/assets/js/jquery.placeholder.js"></script>
<script src="site/assets/js/modernizr.custom.js"></script>
<script src="site/assets/js/toucheffects.js"></script>
<script src="site/assets/js/animations.js"></script>
<script src="site/assets/js/init.js"></script>

    <script src="site/assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="site/assets/js/bootstraptable.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="site/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="site/assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="site/assets/js/custom.js"></script>
    <script src="rest-api/getLogin.js"></script>

<script>
$(document).ready(function(){
  $("#grafico1").hide();
  $("#valorBusca").show();
    $('#tipoBusca').on('change', function() {
      if ( this.value == 'Data')
      {
        $("#grafico1").show();
        $("#intervaloTempo").show();
        $("#valorBusca").show();
        $("#intervalo").show();
      }
      else
      {
        $("#grafico1").hide();
        $("#intervaloTempo").hide();
      }
    });
});
</script>

<script>
$(document).ready(function(){
  $("#grafico2").hide();
  $("#faixaPotencia").hide();
  $("#valorBusca").show();
    $('#tipoBusca').on('change', function() {
      if ( this.value == 'Potencia')
      {
        $("#grafico2").show();
        $("#faixaPotencia").show();
        $("#valorBusca").show();
        $("#intervalo").show();
      }
      else
      {
        $("#grafico2").hide();
        $("#faixaPotencia").hide();
      }
    });
});
</script>

<script>
$(document).ready(function(){
  $("#grafico3").hide();
  $("#valorBusca").hide();
  $("#intervalo").hide();
    $('#tipoBusca').on('change', function() {
      if ( this.value == 'Canal')
      {
        $("#grafico3").show();
      }
      else
      {
        $("#grafico3").hide();
        $("#valorBusca").show();
        $("#intervalo").show();
      }
    });
});
</script>

<script>
function mostrarCampoBusca() {
    var t = document.getElementById('tipoBusca');
    var i = document.getElementById('intervaloTempo');
    var f = document.getElementById('faixaPotencia');
    var c = document.getElementById('valorBusca');
    var it = document.getElementById('intervalo');

    if (t.value === 'Data') {
        i.style.display = 'block';
        f.style.display = 'none';
        c.style.display = 'none';
        it.style.display = 'block';
    }
    else if (t.value === 'Potencia') {
    	i.style.display = 'none';
        f.style.display = 'block';
        c.style.display = 'none';
        it.style.display = 'block';
    }
    else if (t.value === 'Canal') {
    	i.style.display = 'none';
        f.style.display = 'none';
        c.style.display = 'block';
        it.style.display = 'none';
    }
}
</script>

<script>
function mostrarGrafs() {
    var x = document.getElementById('grafico1');
    var y = document.getElementById('grafico2');
    var w = document.getElementById('grafico3');
    var z = document.getElementById('tipoBusca');
    //var x = document.getElementById('infoPerfil');
    //z.selectedIndex = 1;
    if (z.value === 'Data') {
        x.style.display = 'block';
        z.selectedIndex = 0;
    }
    else if (z.value === 'Potencia') {
        y.style.display = 'block';
        z.selectedIndex = 1;
    }
    else if (z.value === 'Canal') {
        w.style.display = 'block';
        z.selectedIndex = 2;
    }

}
</script>

</body>
</html>
