<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $teacherId = $_GET['teacherId'];

    $sql = "SELECT
                cr.counsel_request_code AS counselRequestCode,
                s.id AS studentId,
                m.name,
                cr.registration AS date,
                cr.counsel_request_day AS counselDate,
                cr.counsel_request_start_time AS counselStartTime,
                cr.counsel_request_end_time AS counselEndTime,
                cr.counsel_request_content AS counselContent,
                cr.registration
            FROM counsel_request AS cr,
                student AS s,
                member AS m
            WHERE cr.student_id = s.id
            AND s.id = m.id
            AND cr.counsel_request_code NOT IN (SELECT
                                                    counsel_request_code
                                                FROM counsel
                                                WHERE teacher_id = '$teacherId')
            AND s.course_code IN (SELECT
                                    course_code
                                FROM teacher
                                WHERE id = '$teacherId')
            ORDER BY cr.registration DESC";

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