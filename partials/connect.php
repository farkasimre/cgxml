<?php
 $conn = mysqli_connect("localhost","root","", "cgxml");



function select_from_land_CADGENNO($param){
	global $conn;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM land WHERE CADGENNO=".$param;
	$result = $conn->query($sql);

	return $result;

	$conn->close();
}

function select_from_parcel_CADGENNO($param){
	global $conn;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM parcel WHERE LANDID in (select LANDID from land where land.CADGENNO=" . $param . ")";
	$result = $conn->query($sql);

	return $result;

	$conn->close();
}

function select_from_building_CADGENNO($param){
	global $conn;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM building WHERE LANDID in (select LANDID from land where land.CADGENNO=".$param . ")";
	$result = $conn->query($sql);

	return $result;

	$conn->close();
}

function select_from_address_CADGENNO($param){
	global $conn;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM address WHERE ADDRESSID in (select ADDRESSID from land where land.CADGENNO=" . $param . ")";
	$result = $conn->query($sql);

	return $result;

	$conn->close();
}


function test(){
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM land";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
		while($row = $result->fetch_assoc()) {
			echo "<br> id: ". $row["CADGENNO"] . "<br>";
		}
	} else {
		echo "0 results";
	}

	$conn->close();
}

?>