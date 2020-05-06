<?php

include "connection.php";

$sql="SELECT e.*, f.navn, f.epost, f.bilde
FROM emner e LEFT JOIN foreleser_has_emner ehf ON (e.EmneID = ehf.emnekode)
LEFT JOIN foreleser f ON (ehf.foreleserEpost = f.epost)";

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