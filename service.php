<?php
require('dbConnect.php');

$sql = "SELECT data_sensor.no, data_sensor.id_alat, id_alat.nama_alat, data_sensor.ketinggian, id_lokasi.longitude, id_lokasi.latitude, id_lokasi.alamat, data_sensor.status, data_sensor.reading_time FROM data_sensor, id_alat, id_lokasi WHERE data_sensor.id_alat=id_alat.id_alat AND id_alat.id_lokasi=id_lokasi.id_lokasi AND id_alat.id_alat='sensorA1' ORDER BY no ";
$sql2 = "SET time_zone ='+07:00'
        ";
        $rs2 = mysqli_query($con,$sql2);
$result = $con->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
	$obj = array();
    while($row = $result->fetch_assoc()) {
		$element = array($row["no"],$row["nama_alat"],$row["ketinggian"],$row["reading_time"]);
       	array_push($obj,$element);
	}
	echo json_encode($obj);
} else {
    echo "0 results";
}
$con->close();
?>



