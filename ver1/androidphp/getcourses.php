<?php

include "connection.php";

$sql="SELECT e.emnekode, e.emnenavn, f.navn, f.epost, f.bilde FROM emner e, foreleser f WHERE e.foreleser = f.epost";


$result=mysqli_query($conn,$sql);

if($result)
{
    while($row=mysqli_fetch_array($result))
    {
        foreach($row as $key => $value) {
            $row[$key] = utf8_encode($value);
        }
        $flag[]=$row;
    }

    print(json_encode($flag));
}

mysqli_close($conn);


?>