<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_GET['studentId'];
    $teacherId = $_GET['teacherId'];
    $message = $_GET['message'];
    $date = $_GET['date'];

    $sql = "SELECT
                image
            FROM message
            WHERE student_id = '$studentId'
            AND teacher_id = '$teacherId'
            AND messages = '$message'
            AND registration = '$date'";
    
    $result = mysqli_query($db, $sql);
    if($result) {
        $rowNum = mysqli_num_rows($result);
        $rows = array();
        
        for($i=0; $i<$rowNum; $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $rows[$i] = $row['image'];
        }

        echo json_encode($rows);
    } else echo "fail";
    
    mysqli_close($db);
?>