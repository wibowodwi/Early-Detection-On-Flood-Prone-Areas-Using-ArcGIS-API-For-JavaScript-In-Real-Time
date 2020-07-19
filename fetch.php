<?php
include('dbConnect.php');
include ("deviasi.php");

if(isset($_POST['view'])){

$query = 'SELECT id_alat, ketinggian FROM ( SELECT id_alat, no, (@row:=if(@prev=id_alat, @row +1, if(@prev:= id_alat, 1, 1))) rn, ketinggian FROM data_sensor t  CROSS JOIN (SELECT @row:=0, @prev:=null) c WHERE id_alat="sensorA1" ORDER BY id_alat, no DESC ) src WHERE rn <= 10  ORDER BY id_alat , no ASC';
 
$array = array();
//Dev : '.$dev.'<br />
$result = mysqli_query($con, $query);
while($arr = mysqli_fetch_array($result)){ 
    $array[] = $arr['ketinggian'];
    $dev = Stand_Deviation($array);
    if ($dev <= 10 && $arr["ketinggian"] <20){
        $output = '
        
        <strong>ID Alat : '.$arr["id_alat"].'</strong><br />
        <small><em>Ketinggian : '.$arr["ketinggian"].' cm</em></small><br />
        <small>Status : Aman </small>';
         } 
    elseif ($dev <=10 && $arr["ketinggian"] >=20 && $arr["ketinggian"] <40){
        $output = '
        <strong>ID Alat : '.$arr["id_alat"].'</strong><br />
        <small><em>Ketinggian : '.$arr["ketinggian"].' cm</em></small><br />
        <small>Status : Siaga </small>';
         } 
    elseif ($dev <= 10 && $arr["ketinggian"] >=40){
        $output = '<strong>ID Alat : '.$arr["id_alat"].'</strong><br />
        <small><em>Ketinggian : '.$arr["ketinggian"].' cm</em></small><br />
        <small>Status : Waspada </small>';
         }
    elseif ($dev > 10){
        $output = '
        <strong>ID Alat : '.$arr["id_alat"].'</strong><br />
        <small><em>Ketinggian : '.$arr["ketinggian"].' cm</em></small><br />
        <small>Air tidak stabil</small>';
         }
   
 } 


$status_query = 'SELECT data_sensor.no, data_sensor.id_alat, id_alat.nama_alat, data_sensor.ketinggian, id_lokasi.longitude, id_lokasi.latitude, id_lokasi.alamat, data_sensor.status, data_sensor.reading_time FROM data_sensor, id_alat, id_lokasi WHERE no IN (SELECT MAX(data_sensor.no) FROM `data_sensor` GROUP BY data_sensor.id_alat) AND data_sensor.id_alat=id_alat.id_alat AND id_alat.id_lokasi=id_lokasi.id_lokasi AND data_sensor.id_alat = "sensorA1"';

//"SELECT * FROM comments WHERE comment_status=0";
$result_query = mysqli_query($con, $status_query);
$count = mysqli_num_rows($result_query);
$data = array(
    'notification' => $output,
    'unseen_notification'  => $count
);

echo json_encode($data);

}

?>