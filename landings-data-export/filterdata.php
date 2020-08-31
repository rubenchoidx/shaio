<?php 
if (isset($_POST['filter']) && $_SERVER['REQUEST_METHOD'] == 'POST'){	
	include("conexion.php");
	$fini = $_POST["fini"]." 00:00:00";
	$ffin = $_POST["ffin"]." 23:59:59";
	$tabla = $_POST["tabla"];
	$start = $_POST["start"];
	$length = $_POST["length"];

	$sql = "SELECT * FROM $tabla WHERE `timestamp` BETWEEN '$fini' AND '$ffin' ORDER BY id DESC ";
	$sql2 = " LIMIT $start, $length";
	$number_filter = mysqli_num_rows(mysqli_query($conn, $sql));
	$result = mysqli_query($conn, $sql.$sql2);

	if($number_filter > 0){
		while ($row = mysqli_fetch_assoc($result)) {		
			$sub_array = array();
			$sub_array[] = $row["id"];
			$sub_array[] = $row["nombre"];
			$sub_array[] = $row["telefono"];
			$sub_array[] = $row["email"];
			$sub_array[] = htmlentities($row["comentarios"], ENT_QUOTES);
			$sub_array[] = $row["timestamp"];
			$data[] = $sub_array;			            
		}
	}else{
		$sub_array = array();
		$sub_array[] = "0 resultado";
		$sub_array[] = "";
		$sub_array[] = "";
		$sub_array[] = "";
		$sub_array[] = "";
		$sub_array[] = "";
		$data[] = $sub_array;
	}		

	function get_all_data($conn, $tabla){
		$query = "SELECT * FROM $tabla";
		$result = mysqli_query($conn, $query);
		return mysqli_num_rows($result);

	}

	$output = array(
		"draw" => intval($_POST["draw"]),
		"recordsTotal" => get_all_data($conn,$tabla),
		"recordsFiltered" => $number_filter,
		"data" => $data
	);
	echo json_encode($output);

	mysqli_close($conn);

}


?>