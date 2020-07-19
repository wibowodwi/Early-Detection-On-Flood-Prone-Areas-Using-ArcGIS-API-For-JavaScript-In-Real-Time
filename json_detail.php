<?php
require('dbConnect.php');

$sql = "SELECT data_sensor.no, data_sensor.id_alat, id_alat.nama_alat, data_sensor.ketinggian, id_lokasi.longitude, id_lokasi.latitude, id_lokasi.alamat, data_sensor.status, data_sensor.reading_time FROM data_sensor, id_alat, id_lokasi WHERE no IN (SELECT MIN(data_sensor.no) FROM `data_sensor` GROUP BY data_sensor.id_alat) AND data_sensor.id_alat=id_alat.id_alat AND id_alat.id_lokasi=id_lokasi.id_lokasi";
$sql2 = "SET time_zone ='+07:00'
        ";
        $rs2 = mysqli_query($con,$sql2);
$result = $con->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
	$obj = array();
    while($row = $result->fetch_assoc()) {
		$element = array($row["no"],
		$row["id_alat"],
		$row["nama_alat"],
		$row["longitude"],
		$row["latitude"],
		$row["alamat"]);
       	array_push($obj,$element);
	}
	echo json_encode($obj);
} else {
    echo "0 results";
}
$con->close();
?>



