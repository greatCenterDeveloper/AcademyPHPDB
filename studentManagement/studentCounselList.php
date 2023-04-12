<?php
    header('Content-Type:application/json; charset=utf-8');

    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_GET['studentId'];
    $teacherId = $_GET['teacherId'];

    $sql = "SELECT DISTINCT
                c.counsel_request_day AS date,
                m.name,
                c.counsel_content AS content
            FROM counsel AS c,
                student AS s,
                member AS m
            WHERE c.student_id = s.id
            AND s.id = m.id
            AND c.student_id = '$studentId'
            AND c.teacher_id = '$teacherId'";

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