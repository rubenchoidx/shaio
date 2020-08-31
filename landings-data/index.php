<?php
	error_reporting(E_ERROR);
	include("conexion.php");
	$llLogin=false;
	$lnRecords=0;
	$laTables=array(
					array("table"=>"corazon",
						  "caption"=>"En las mejores manos",
						  "style"=>"azul",
						  "text"=>"<span>Pon la salud de<br> tu coraz&oacute;n</span><br> en las mejores manos.",
						  "value"=>0,
						  "color"=>"#337ab7"),
					array("table"=>"tumores",
						  "caption"=>"Tratamientos sin cirug&iacute;a",
						  "style"=>"verde",
						  "text"=>"<span>Tratamos los <br> tumores cerebrales,</span><br> sin cirug&iacute;a.",
						  "value"=>0,
						  "color"=>"#5cb85c"),
					array("table"=>"preventivo",
						  "caption"=>"Una excelente decisi&oacute;n",
						  "style"=>"naranja",
						  "text"=>"<span>Practicarse un Chequeo <br> M&eacute;dico Preventivo, </span><br> una excelente decisi&oacute;n.",
						  "value"=>0,
						  "color"=>"#f0ad4e"),
					array("table"=>"davinci",
						  "caption"=>"Davinci",
						  "style"=>"rojo",
						  "text"=>"<span>Davinci</span><br>",
						  "value"=>0,
						  "color"=>"#f44336")
				);
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["txtPassword"]) && isset($_POST["txtUser"])){
			if(trim(strtolower($_POST["txtPassword"]))=="5kxepw7dj6im7s9xjh" && trim(strtolower($_POST["txtUser"]))=="developer-shaio"){
				$llLogin=true;
			}
		}		
	}
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="expires" content="-1" >		
		<title>Fundaci&oacute;n Cl&iacute;nica Shaio - Landings - Por el grupo de desarrollo Shaio</title>
		<link href="addons/bootstrap-dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		<link rel="shortcut icon" href="https://www.shaio.org/sites/all/themes/shaio/favicon.ico" type="image/vnd.microsoft.icon">
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
<a class="navbar-brand" href="#">
	<img alt="Brand" src="images/logo.png">
</a>				
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand hidden-xs" href="https://www.shaio.org"><b>Fundaci&oacute;n Cl&iacute;nica Shaio</b><br/>Landings<br/><small>Por el grupo de desarrollo Shaio</small></a>
				</div>
			</div>
		</nav>		
		<div class="container" role="main">
			<?php if($llLogin==true){ ?>
			<div class="row">
				<?php 
				for($lnTable=0;$lnTable<4;$lnTable++){ 
					$lcSql="SELECT count(*) as `registros` FROM `".$laTables[$lnTable]["table"]."`;";
					printf("<!-- %s -->",$laTables[$lnTable]["table"]);
					$loResult = mysql_query($lcSql);
					if ($loResult){
						$laResult = mysql_fetch_assoc($loResult);
				?>					
				<div class="col-sm-6 col-md-4">
					<div class="panel <?php print($laTables[$lnTable]["style"]); ?>">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-6">
									<h3><?php print($laTables[$lnTable]["caption"]); ?></h3>
								</div>
								<div class="col-xs-5 text-right">
									<div class="huge"><?php print($laResult["registros"]); ?></div>
									<div style="color:rgb(255,255,255);">Registros</div>
								</div>
							</div>
						</div>
						<a href="#<?php print($laTables[$lnTable]["table"]); ?>">
							<div class="panel-footer">
								<span class="pull-left">Ver detalles</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<?php 
					$laTables[$lnTable]["value"]=$laResult["registros"];
					$lnRecords+=$laResult["registros"];
					mysql_free_result($loResult);
					}
				} 
				?>
			</div>
			
			<div class="row hidden-xs">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading"><b>Participacion por Landing</b></div>
						<div class="panel-body">
							<svg id="svg"></svg>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading"><b>e-mails registrados</b></div>
						<div class="panel-body" style="max-height: 335px; overflow-y: scroll;">
							<ul class="list-group">
								<?php
									$lcSql="select `email`, count(*) as `registros` from (select `a`.`email` from `corazon` as `a` union all select `b`.`email` from `preventivo` as `b` union all select `c`.`email` from `tumores` as `c`) as `z` group by `z`.`email`";
									$loResult = mysql_query($lcSql);
									if ($loResult){							
										while ($laRow = mysql_fetch_array($loResult, MYSQL_ASSOC)) {
											if(!empty($laRow["email"])){
								?>
								<li class="list-group-item"><?php print($laRow["email"]); ?> <span class="badge"><?php print($laRow["registros"]); ?></span></li>
								<?php
											}
										}
									}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>			
			
			<?php 
			for($lnTable=0;$lnTable<4;$lnTable++){ 
			?>
			<a id="<?php print($laTables[$lnTable]["table"]); ?>" name="<?php print($laTables[$lnTable]["table"]); ?>"></a>
			<div class="panel panel-default">
				<div class="panel-heading <?php print($laTables[$lnTable]["style"]); ?>"><h1><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> <?php print($laTables[$lnTable]["caption"]); ?><sup style="font-size:10px;"><?php print($lnTable+1); ?></sup></h1></div>
				<div class="panel-body" style="max-height: 335px; overflow-y: scroll;">
					<div class="table-responsive">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>id</th>
									<th>nombre</th>
									<th>telefono</th>
									<th>email</th>
									<?php print("<th>Comentarios</th>"); ?>
									<th>registro</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$lcSql="SELECT * FROM `".$laTables[$lnTable]["table"]."`;";
									$loResult = mysql_query($lcSql);
									if ($loResult){							
										while ($laRow = mysql_fetch_array($loResult, MYSQL_ASSOC)) {
								?>
								<tr>
									<td class="fontMini"><?php print($laRow["id"]); ?></td>
									<td class="fontMini"><?php print(strtoupper($laRow["nombre"])); ?></td>
									<td class="fontMini"><?php print(strtolower($laRow["telefono"])); ?></td>
									<td class="fontMini"><?php print(strtolower($laRow["email"])); ?></td>
									<?php printf("<td class='fontMini' style='width: 120px;'>%s</td>",htmlentities($laRow["comentarios"], ENT_QUOTES)); ?>									
									<td class="fontMini"><?php print($laRow["timestamp"]); ?></td>
								</tr>
								<?php	
										}
										mysql_free_result($loResult);
									}
								?>
							</tbody>						
						</table>
					</div>
				</div>
			</div>
			<?php 
				} 
			?>
			<?php } else { ?>
			<div class="row">
				<div class="col-sm-6 col-md-4">
					<form action="index.php" method="post">
						<div class="form-group">
							<label for="exampleInputEmail1">Email address</label>
							<input type="text" class="form-control" name="txtUser" id="txtUser" placeholder="Usuario">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" class="form-control" name="txtPassword" id="txtPassword" placeholder="Clave">
						</div>
						<button type="submit" class="btn btn-default">Entrar</button>
					</form>
				</div>
			</div>
			<?php } ?>
		</div>
		<footer>Dg 115A 70C-75 Bogot&aacute;, Colombia | (57 1) 593 82 10  Ext. 2940 - 2366  |  318 551 12 60  |  info@shaio.org  |  <a href="#">www.shaio.org</a></footer>
		<script src="addons/jquery/jquery.min.js"></script>
		<script src="addons/bootstrap-dist/js/bootstrap.min.js"></script>
		<script src='addons/snap-svg/snap.svg-min.js'></script> 
		<script>
		var programmingSkills = [
			<?php 
			for($lnTable=0;$lnTable<4;$lnTable++){ 
				$lnValue=(($laTables[$lnTable]["value"]*100)/$lnRecords);
				print(($lnTable==0?"":",")."{value:".$lnValue.",label: '".html_entity_decode($laTables[$lnTable]["caption"])."',color: '".$laTables[$lnTable]["color"]."'}");
			}
			?>
		];
		</script> 
		<script src="addons/donut-chart-framework/svg-donut-chart-framework.js"></script>			
	</body>
</html>