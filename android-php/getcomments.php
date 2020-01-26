<?php

include "connection.php";

$sql="select * from henvendelse h left join kommentar k on h.henvendelseID = k.kommentarTil";

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