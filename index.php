<?php 
	$qtds = array();
	$tempos = array();

	$qtdsP = array();
	$potencias = array();
	
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
	$row2 = $row3 -> qtd;*/
	
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
	
	//SELECT COUNT(rssi) AS qtd FROM (SELECT rssi FROM dadosTeste where datetime between '$dt1_Str' and '$dt2_Str' GROUP BY addr) grp
	//SELECT COUNT(rssi) AS qtd FROM (SELECT rssi FROM dadosTeste GROUP BY addr) grp WHERE rssi BETWEEN -96 AND -90
	
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
<body data-spy="scroll" data-target=".navbar">
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
            <li><a href="#Section-1">Gráfico 1</a></li>
            <li><a href="#Section-3">Gráfico 2</a></li>
            <li><a href="#Section-4">Alunos</a></li>
            
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
                    <a href="#Section-1" class="buttonyellow animated fadeInLeftBig"><b>Gráfico 1</b></a>
                </div>
            </div>
            <div class="item" id="slide_2">
                <div class="carousel-content">
                    <div class="animated fadeInDownBig">
                         <h1>Disciplinas de Redes - RSI</h1>
                    </div>
                    <br/>
                    <a href="#Section-4" class="buttoncolor animated fadeInRightBig"><b>Alunos</b></a>
                </div>
            </div>
            <div class="item" id="slide_3">
                <div class="carousel-content">
                    <div class="animated fadeInDownBig">
                         <h1>Redes Mesh ...</h1>
                    </div>
                        <br/>
                        <a href="https://github.com/flushedlucas/MeshSniffer" class="buttonyellow animated fadeInLeftBig"><b>Projeto</b></a>
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
<div class="row animated fadeInUpNow">
		<form action = "index.php#Section-1" >
				<caption>Opções de busca:</caption>
						<select class="form-control" id="tipoBusca" name="tipoBusca" value = <?php echo $tipoBusca ?>>
							<option value="">Escolha uma opção</option>
							<option value="Data" >Por data</option>
							<option value="Potencia" >Por Faixa de Potência</option>
						</select>

						<div>
							Data Inicial:<input class="form-control" id="data1" name="data1" type="date" value = <?php echo $data1 ?> required/>
							Hora Inicial:<input class="form-control" id="hora1" name="hora1" type="time" value = <?php echo $hora1 ?> required/>
							Data Final:<input class="form-control" id="data2" name="data2" type="date" value = <?php echo $data2 ?> required/>
							Hora Final:<input class="form-control" id="hora2" name="hora2" type="time" value = <?php echo $hora2 ?> required/>
							Intervalo de Tempo:<input class="form-control" id="intervalo" name="intervalo" type="number" value = <?php echo $intervalo ?> required/>
						</div>

						<input class="btn-primary btn-lg pull-right" type="submit" value="Plotar"></input>
		</form>
		
</br></br></br>

<div id="grafico1">

<script type="text/javascript" src="site/loader.js"></script>
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
        width: 800,
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
  <div id="columnchart_values1" style="width: 900px; height: 300px;"></div>

</div>

<div id="grafico2">

<script type="text/javascript" src="site/loader.js"></script>
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
        width: 800,
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
  <div id="columnchart_values2" style="width: 900px; height: 300px;"></div>

</div>


</section>

<!-- SECTION-4(reviews) -->
<section id="Section-4" class="fullbg color-white">
<div class="section-divider">
</div>
<div class="container">
<div class="row">
    <div class="page-header text-center col-sm-12 col-lg-12 animated fade">
        <h1>Alunos</h1>
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
                         Aluno 1 <span>redesmesh</span>
                    </div>
                    <div class="testimonials-carousel-content">
                        <p>
                             Telefone: (81) 91919-9191
                        </p>
                        <p>
                             E-mail: aluno1@com
                        </p>
                    </div>
                </div>
            </div>
            <div class="slide">
                <div class="testimonials-carousel-thumbnail">
                    <img width="120" alt="" src="site/assets/img/avatar.jpg">
                </div>
                <div class="testimonials-carousel-context">
                    <div class="testimonials-name">
                         Aluno 2 <span>redesmesh</span>
                    </div>
                    <div class="testimonials-carousel-content">
                        <p>
                             Telefone: (81) 92929-9292
                        </p>
                    </div>
                    <p>
                         E-mail: aluno2@com
                    </p>
                </div>
            </div>
            <div class="slide">
                <div class="testimonials-carousel-thumbnail">
                    <img width="120" alt="" src="site/assets/img/avatar.jpg">
                </div>
                <div class="testimonials-carousel-context">
                    <div class="testimonials-name">
                         Aluno 3 <span>redesmesh</span>
                    </div>
                    <div class="testimonials-carousel-content">
                        <p>
                             Telefone: (81) 93939-9393
                        </p>
                    </div>
                    <p>
                         E-mail: aluno3@com
                    </p>
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
    $('#tipoBusca').on('change', function() {
      if ( this.value == 'Data')
      {
        $("#grafico1").show();
      }
      else
      {
        $("#grafico1").hide();
      }
    });
});
</script>

<script>
$(document).ready(function(){
  $("#grafico2").hide();
    $('#tipoBusca').on('change', function() {
      if ( this.value == 'Potencia')
      {
        $("#grafico2").show();
      }
      else
      {
        $("#grafico2").hide();
      }
    });
});
</script>

</body>
</html>
