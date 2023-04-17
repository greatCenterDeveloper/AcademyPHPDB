<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $teacherId = $_GET['teacherId'];

    $sql = "SELECT DISTINCT
                c.counsel_request_code AS counselRequestCode,
                cr.counsel_request_content AS counselRequestContent,
                s.id AS studentId,
                sm.name AS studentName,
                t.id AS teacherId,
                tm.name AS teacherName,
                c.counsel_request_day AS date,
                c.counsel_content AS counselContent,
                c.counsel_code AS counselCode,
                c.registration
            FROM counsel AS c,
                counsel_request AS cr,
                teacher AS t,
                member AS tm,
                student AS s,
                member AS sm
            WHERE c.teacher_id = t.id
            AND c.counsel_request_code = cr.counsel_request_code
            AND t.id = tm.id
            AND c.student_id = s.id
            AND s.id = sm.id
            AND t.id = '$teacherId'
            ORDER BY c.registration DESC";

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