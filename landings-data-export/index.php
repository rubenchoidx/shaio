<?php 
$login = false;
$msj = "";
if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST'){	
	if(trim(strtolower($_POST["user"]))=="shaio" && trim(strtolower($_POST["pswd"]))=="bf4xzmgk14q5"){
		$login=true;
		$tablas=array('corazon','tumores','preventivo','davinci');
	}
	else{
	 $msj = 'Datos incorrectos!';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="expires" content="-1" >		
	<title>Fundaci&oacute;n Cl&iacute;nica Shaio - Landings Data Export</title>				
	<link rel="shortcut icon" href="https://www.shaio.org/sites/all/themes/shaio/favicon.ico" type="image/vnd.microsoft.icon">
	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">	
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" href="css/stylesDataExport.css">	
</head>
<body>
<header>
<div class="container-fluid p-0">
	<div class="clearfix">
	  <span class="float-left bg-rojo p-2">
	  	<img alt="Brand" src="images/logo.png" width="70px">
	  </span>
	  <h1 class="m-0 float-left p-4">Landings Data Export</h1>
	  <span class="float-right p-4">
	  	<a href="/landings-data-export"><?php if($login) echo 'Salir'; ?></a>
	  	<img alt="Brand" src="images/iconos_r1_c3.jpg">
	  </span>
	</div>
</div>
</header>
<main class="container">
	<?php if ($login){ ?>	
	<div class="data-export mt-5">
		<!-- Nav pills -->
		<ul class="nav nav-pills nav-justified">
		  <li class="nav-item">
		    <a class="nav-link active" data-toggle="pill" href="#landing1">En las mejores manos</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" data-toggle="pill" href="#landing2">Tratamientos sin cirugía</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" data-toggle="pill" href="#landing3">Una excelente decisión</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" data-toggle="pill" href="#landing4">Davinci</a>
		  </li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<?php 
			include("conexion.php");			
			$id = 0;
			for($x=0;$x<count($tablas);$x++){
				$sql = "SELECT * FROM $tablas[$x]";				
				$result = mysqli_query($conn, $sql);																			
				if($x == 0)
					$active = 'active';
				else $active = 'fade';
				$id++;
			?>
		  <div class="tab-pane container p-4 <?php echo $active ?>" id="landing<?php echo $id; ?>">
		  	<div class="my-3 w-50">
		  		<div id="reportrange_<?php echo $id; ?>" class="d-inline-block reportrange">
    				<i class="fa fa-calendar"></i>&nbsp;
    				<span>Elegir rango de fecha</span> <i class="fa fa-caret-down"></i>
				</div>				
		  	</div>

			<table id="landing_<?php echo $id; ?>" class="display">
			    <thead>
			        <tr>
			            <th>Id</th>
			            <th>Nombres</th>
			            <th>Tel&eacute;fono</th>
			            <th>Email</th>
			            <th>Comentarios</th>
			            <th>Registro</th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php 
			    		while($row = mysqli_fetch_assoc($result)) {
			    	?>
			        <tr>
			            <td> <?php print($row["id"]); ?> </td>
			            <td> <?php print($row["nombre"]); ?> </td>
			            <td> <?php print($row["telefono"]); ?> </td>
			            <td> <?php print($row["email"]); ?> </td>
			            <td> <?php print(htmlentities($row["comentarios"], ENT_QUOTES)); ?> </td>
			            <td> <?php print($row["timestamp"]); ?> </td>
			        </tr>
			        <?php } ?>			        
			    </tbody>
			</table>		  					
		  </div>
		  <?php } mysqli_close($conn);?>
		  
		</div>
	</div>
	<?php }else{ ?>	
	<div class="form-login pb-5 mx-auto mt-5">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">				
			<h4 class="text-center py-3 mb-4">Iniciar Sesíon</h4>
			<label class="px-4"><?php echo $msj; ?></label>
			<div class="px-4">
				<div class="form-group">		    	
			      	<input type="text" required class="form-control" id="user" placeholder="Usuario" name="user">
		    	</div>
		    	<div class="form-group">	      		
		      		<input type="password" required class="form-control" id="pwd" placeholder="Contraseña" name="pswd">
		    	</div>		    
		    	<button type="submit" name="login" class="btn w-100">Entrar</button>
	    	</div>
	  </form>
	</div>
	<?php } ?>
</main>

<footer>
	Dg 115A 70C-75 Bogotá, Colombia | (57 1) 593 82 10  |  info@shaio.org  |  <a href="/">www.shaio.org</a>
</footer>


  <script src="js/jquery/jquery.min.js"></script>
  <script src="js/jquery/popper.min.js"></script>
  <script src="js/jquery/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>  
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>    
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>  

  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script type="text/javascript">
$(function(){
 
   var tablas = [];	

	for (var i = 1; i <= 4; i++) {  			  		
		$('#landing_'+i).DataTable({
			"order": [[ 0, "desc" ]],
			dom: 'Bfrtip',
			buttons: [
		    'csv', 'excel'
			]
		});		
	}	

	var start = moment().subtract(29, 'days');
    var end = moment();

	function cb1(start, end) {    	
        //$('#reportrange_1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));               
        $('#reportrange_1 span').html(start.format('YYYY-MM-DD') + ' | ' + end.format('YYYY-MM-DD'));
        
    	drawDatatable(1,'corazon',start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));		    	
        
    }
    function cb2(start, end) {    	           
        $('#reportrange_2 span').html(start.format('YYYY-MM-DD') + ' | ' + end.format('YYYY-MM-DD'));        
        drawDatatable(2,'tumores',start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
    }
    function cb3(start, end) {    	        
        $('#reportrange_3 span').html(start.format('YYYY-MM-DD') + ' | ' + end.format('YYYY-MM-DD'));   
        drawDatatable(3,'preventivo',start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));             
    }
    function cb4(start, end) {    	        
        $('#reportrange_4 span').html(start.format('YYYY-MM-DD') + ' | ' + end.format('YYYY-MM-DD'));        
        drawDatatable(4,'davinci',start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));             
    }

    function drawDatatable(i,tabla,fini,ffin){
    	$('#landing_'+i).DataTable().destroy();
    	$('#landing_'+i).DataTable({					        
			"order": [[ 0, "desc" ]],
			dom: 'Bfrtip',
			buttons: [
		    'csv', 'excel'
			],
			"processing" : true,
			"serverSide" : true,
			"ajax" : {
				url: "filterdata.php",
				type: "POST",
				data:{
					filter: true, fini:fini, ffin:ffin, tabla:tabla
				}
			}			
		});
    }

	$('#reportrange_1').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Hoy': [moment(), moment()],
           'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
           'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
           'Éste mes': [moment().startOf('month'), moment().endOf('month')],
           'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb1);	    
    $('#reportrange_2').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Hoy': [moment(), moment()],
           'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
           'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
           'Éste mes': [moment().startOf('month'), moment().endOf('month')],
           'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb2);
    $('#reportrange_3').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Hoy': [moment(), moment()],
           'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
           'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
           'Éste mes': [moment().startOf('month'), moment().endOf('month')],
           'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb3);
    $('#reportrange_4').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Hoy': [moment(), moment()],
           'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
           'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
           'Éste mes': [moment().startOf('month'), moment().endOf('month')],
           'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb4);    


});

</script>
</body>
</html>