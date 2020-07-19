<?php

require_once('dbConnect.php');

$sql = "SELECT data_sensor.no, data_sensor.id_alat, id_alat.nama_alat, data_sensor.ketinggian, id_lokasi.longitude, id_lokasi.latitude, id_lokasi.alamat, data_sensor.status, data_sensor.reading_time FROM data_sensor, id_alat, id_lokasi WHERE no IN (SELECT MAX(data_sensor.no) FROM `data_sensor` GROUP BY data_sensor.id_alat) AND data_sensor.id_alat=id_alat.id_alat AND id_alat.id_lokasi=id_lokasi.id_lokasi";
$sql2 = "SET time_zone ='+07:00'
        ";
        $rs2 = mysqli_query($con,$sql2);
if($_SERVER['REQUEST_METHOD']=='GET') {
$rs = mysqli_query($con,$sql);

if (!$rs) {
    echo 'An SQL error occured.\n';
    exit;
}

# Build GeoJSON feature collection array
$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);

# Loop through rows to build feature arrays
while($row = mysqli_fetch_array($rs)) {
    $feature = array(
        'type' => 'Feature', 
        'geometry' => array(
            'type' => 'Point',
            # Pass Longitude and Latitude Columns here
            'coordinates' => array($row['longitude'], $row['latitude'])
        ),
        # Pass other attribute columns here
        'properties' => array(
            'id_alat'=> $row['id_alat'],
            'nama_alat' => $row['nama_alat'],
            'alamat' => $row['alamat'],
            'ketinggian' => $row['ketinggian'],
            'status' => $row['status'],
            'waktu' => $row['reading_time']
            )
        );
    # Add feature arrays to feature collection array
    array_push($geojson['features'], $feature);
}
}
header('Content-type: application/json');
echo json_encode($geojson, JSON_NUMERIC_CHECK);
$con = NULL;
?>