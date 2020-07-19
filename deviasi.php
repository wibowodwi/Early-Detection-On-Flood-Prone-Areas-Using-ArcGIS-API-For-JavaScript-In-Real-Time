<?php
function Stand_Deviation($arr) 
{ 
    $jumlah_elemen = count($arr); 
      
    $varian = 0.0; 
      
    $mean = array_sum($arr)/$jumlah_elemen; 
      
    foreach($arr as $i) 
    { 
        $varian += pow(($i - $mean), 2); 
    } 

    $n = $jumlah_elemen - 1;

    if($n >0 )
    { 
        return (float)sqrt($varian/$n); 
    } 
    else 
    {
        return 0;
    }
} 