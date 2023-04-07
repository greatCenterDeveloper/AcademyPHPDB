<?php
    header('Content-Type:application/json; charset=utf-8');

    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_GET['studentId'];
    $teacherId = $_GET['teacherId'];

    $sql = "SELECT DISTINCT m.profile, s.course_code AS course, t.id AS teacher, s.id AS studentId FROM member AS m, teacher AS t, student AS s WHERE m.id = s.id AND s.course_code = t.course_code AND s.id = '$studentId' AND t.id = '$teacherId'";
    
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