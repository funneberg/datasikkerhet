<?php

include "connection.php";

if(isset($_GET['coursecode'])){
    $coursecode = $_GET['coursecode'];

    $sql_query1 = "SELECT id, avsender, henvendelse, svar FROM henvendelse WHERE emnekode = '$coursecode'";

    $result1=mysqli_query($conn,$sql_query1);

    if (!$result1) {
        print(mysqli_error($conn));
    }

    if($result1)
    {
        $flag = array();

        while($row=mysqli_fetch_array($result1))
        {
            foreach($row as $key => $value) {
                $row[$key] = utf8_encode($value);
            }

            $arr1 = array();

            $arr1['inquiryID'] = $row[0];
            $arr1['senderEmail'] = $row[1];
            $arr1['message'] = $row[2];
            $arr1['response'] = $row[3];

            $sql_query2 = "SELECT id, avsender, kommentar FROM kommentar WHERE kommentar_til = '$row[0]'";

            $result2=mysqli_query($conn,$sql_query2);

            if (!$result2) {
                print(mysqli_error($conn));
            }

            if ($result2) {
                while($row2=mysqli_fetch_array($result2)) {
                    $arr2 = array();
                    $arr2['commentID'] = $row2[0];
                    $arr2['commenterEmail'] = $row2[1];
                    $arr2['comment'] = $row2[2];

                    $arr1['comments'][] = $arr2;
                }
            }
            else {
                $arr1['comments'][] = [];
            }

            $flag[] = $arr1;

        }

        print(json_encode($flag));
    }

    mysqli_close($conn);
}

?>