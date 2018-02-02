<?php 
	$qtds = array();
	$tempos = array();
	$cor = array();
	
	$cor[0] = '#ff3300';
	$cor[1] = '#0000ff';
	$cor[2] = '#006600';
	$cor[3] = '#ff0066';
	
	$dateNow = new DateTime();
	$dateNow->setTimezone(new DateTimeZone('America/Recife'));
	$fdateNow = $dateNow->format('Y-m-d H:i:s');
	$dateEndInitial = $fdateNow;
	$dateNow->modify('-30 day');
	$dateBeginInitial = $dateNow->format('Y-m-d H:i:s');
	
	if(!isset($_GET['data1'])){
		$data1= $dateBeginInitial; //$dateBeginInitial;// 
	}
	else{
		$data1=$_GET['data1'];
	}
	
	if(!isset($_GET['data2'])){
		$data2= $dateEndInitial; //$dateEndInitial;
	}
	else{
		$data2=$_GET['data2'];
	}
	
	
	$conexao = mysqli_connect("127.0.0.1", "root", "", "meshdb");
	
	$sql = "select qtd,tempo from sistemaTeste where time between '$data1' and '$data2'";
	//$sql = "select * from sistemaTeste where tempo > 12"; 
	
	//$sql = "select * from sistemaTeste";
	$resultado = mysqli_query($conexao,$sql);
	
	$i = 0;
	
	while ($row = mysqli_fetch_object($resultado)){
		$qtd = $row -> qtd;
		$tempo = $row -> tempo;
		$qtds[$i] = $qtd;
		$tempos[$i] = $tempo;
		$i = $i + 1;
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
<body data-spy="scroll" data-target=".navbar" onload="escondeInfo();">
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
            <li><a href="#Section-2">Gráfico 2</a></li>
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
		<h1>Gráfico 1 - MAC's</h1>
	</div>
</div>
<div class="row animated fadeInUpNow">
		<form action = "index.php#Section-1" >
				<caption>Opções de busca:</caption>
						<select class="form-control" id="tipoBusca" name="tipoBusca">
							<option selected="selected" value="">Todos</option>
							<option value="Data" >Por data</option>
						</select>

						<div id="busca_data">
							Data Inicial:<input class="form-control" id="data1" name="data1" type="date" />
							Data Final:<input class="form-control" id="data2" name="data2" type="date" />
						</div>

						<input class="btn-primary btn-lg pull-right" type="submit" value="Plotar"></input>
		</form>
		</br>
		<?php echo "Data 1 = $data1" ?> </br>
		<?php echo "Data 2 = $data2" ?>
		
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Tempo", "Qdt", { role: "style" } ],
		<?php 
		$k = $i;
		for ($i=0; $i < $k; $i++){
		?>

		['<?php echo $tempos[$i] ?>', <?php echo $qtds[$i] ?>, '<?php echo $cor[$i] ?>'],

		<?php } ?>
        
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Quantidade de MAC's por janelas de Tempo",
        width: 800,
        height: 400,
        vAxis: {title: "Quantidade de MAC's capturados"},
        hAxis: {title: "Tempo (min)"},
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
</div>
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

<script>
function mostraInfo() {
    var x = document.getElementById('info');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    }
}
</script>

<script>
function escondeInfo() {
    var x = document.getElementById('info');
        x.style.display = 'none';
}
</script>

    <script src="site/assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="site/assets/js/bootstraptable.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="site/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="site/assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="site/assets/js/custom.js"></script>
    <script src="rest-api/getLogin.js"></script>

</body>
</html>