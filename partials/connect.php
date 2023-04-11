<?php
$conn2 =  pg_connect("host=89.39.83.238 port=56432 dbname=cernat user=adm_gis password=tesseklassek");


function select_from_land_CADGENNO($param){
	global $conn2;
	//if ($conn2->connect_error) {
	//	die("Connection failed: " . $conn2->connect_error);
	//}
	$sql = "SELECT * FROM cg_land WHERE cadgenno=".$param;
	$result = pg_query($conn2, $sql);
	//print_r($result);
	return $result;

	pg_close($conn2);
}


function select_from_address_CADGENNO($param){
	global $conn2;
	//if ($conn2->connect_error) {
//		die("Connection failed: " . $conn2->connect_error);
//	}
	$sql = "SELECT * FROM cg_address WHERE addressid in (select addressid from cg_land where cg_land.cadgenno=" . $param . ")";
	$result = pg_query($conn2, $sql);

	return $result;

	pg_close($conn2);
}

?>