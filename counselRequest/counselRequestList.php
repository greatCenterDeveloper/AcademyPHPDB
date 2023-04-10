<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_GET['studentId'];

    $sql = "SELECT
                counsel_request_code AS counselRequestCode,
                counsel_request_day AS date,
                counsel_request_start_time AS startTime,
                counsel_request_end_time AS endTime,
                counsel_request_content AS content,
                student_id AS studentId
            FROM
                counsel_request
            WHERE
                student_id = '$studentId'";
    $result = mysqli_query($db, $sql);
    if($result) {
        $rowNum = mysqli_num_rows($result);
        $rows = array();

        for($i=0; $i<$rowNum; $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $rows[$i] = $row;
        }

        echo json_encode($rows);
    } else echo "fail";
    
    mysqli_close($db);
?>