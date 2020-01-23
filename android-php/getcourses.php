<?php

include "connection.php";

$sql="SELECT * FROM emner";

$result=mysqli_query($conn,$sql);

if($result)
{
    while($row=mysqli_fetch_array($result))
    {
        $flag[]=$row;
    }

    print(json_encode($flag));

}

mysqli_close($conn);


?>