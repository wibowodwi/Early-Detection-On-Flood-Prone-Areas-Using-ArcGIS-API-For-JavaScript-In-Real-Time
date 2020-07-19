<?php
require("phpMQTT.php");

$conn = mysqli_connect("localhost","root","","esp_data");
$host = "soldier.cloudmqtt.com";    // server cloudmqtt
$port =12728;                       // port cloudmqtt
$username = "pzfygrgz";             // user cloudmqtt
$password = "JHiLfNnqI9DD";         // password cloudmqtt
$mqtt = new phpMQTT($host, $port, "ultrasonic_1"); 

if(!$mqtt->connect(true, NULL, $username, $password)) {
 	exit(1);
}
	$topics['sensor/ultra'] = array("qos" => 0, "function" => "procmsg");
	$mqtt->subscribe($topics, 0);
	while($mqtt->proc()  ){
	}
	$mqtt->close();

function procmsg($topic, $msg){
	//mendecode json dari topic
       $obj = json_decode($msg);
       $id_alat=$obj->id_alat;
       $id_lokasi=$obj->id_lokasi;
       $nama_alat=$obj->nama_alat;
       $ketinggian=$obj->ketinggian;
       $longitude=$obj->longitude;
       $latitude=$obj->latitude;
       $alamat=$obj->alamat;
       if($ketinggian <100){
        mysqlinsert($id_alat,$id_lokasi, $nama_alat,$ketinggian,$longitude,$latitude,$alamat);
       }
}

function mysqlinsert($id_alat, $id_lokasi, $nama_alat,$ketinggian,$longitude,$latitude,$alamat) {
	global $conn;
  $stat;
  $air = 60 - $ketinggian;
	if($ketinggian<=25){
          $stat = "Waspada";
        }if ($ketinggian<=40 && $ketinggian>25){
          $stat = "Siaga";
        }if ($ketinggian>=41){
          $stat = "Aman";
        }
       
      
$check="SELECT * FROM id_lokasi WHERE id_lokasi = '$id_lokasi'";
$rs = mysqli_query($conn,$check);
if(mysqli_num_rows($rs) != 1) {
  $query="INSERT INTO id_lokasi (id_lokasi, alamat, longitude, latitude) VALUES 
                ('$id_lokasi','$alamat', '$longitude', '$latitude')";
                mysqli_query($conn,$query) or die(mysqli_error($conn));
}


$check="SELECT * FROM id_alat WHERE id_alat = '$id_alat'";
$rs = mysqli_query($conn,$check);
if(mysqli_num_rows($rs) != 1) {
  $query="INSERT INTO id_alat (id_alat, nama_alat, id_lokasi) VALUES 
                ('$id_alat','$nama_alat','$id_lokasi')";
                mysqli_query($conn,$query) or die(mysqli_error($conn));
}

                
        $query="INSERT INTO data_sensor (id_alat, ketinggian, status) VALUES 
                ('$id_alat','$air','$stat')";
        mysqli_query($conn,$query) or die(mysqli_error($conn));
}
