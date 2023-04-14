<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $courseCode = $_GET['courseCode'];
    $studentId = $_GET['studentId'];
    $teacherId = $_GET['teacherId'];

    $sql = "SELECT cs.day, cs.period,
                   ca.attendance_time,
                   ca.attendance_state,
                   ca.registration
            FROM course AS c,
                member AS m,
                student AS s,
                course_attendance AS ca,
                course_schedule AS cs,
                course_request AS cr,
                course_assign AS cas
            WHERE c.course_code = s.course_code
            AND m.id = s.id
            AND ca.course_schedule_code = cs.course_schedule_code
            AND ca.course_request_code = cr.course_request_code
            AND cs.course_assign_code = cas.course_assign_code
            AND cr.course_code = c.course_code
            AND cr.student_id = s.id
            AND c.course_code = '$courseCode'
            AND s.id = '$studentId'";
    
    $result = mysqli_query($db, $sql);

    if($result) {
        $rowNum = mysqli_num_rows($result);

        $rows = array();
        for($i=0; $i<$rowNum; $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $rowTemp = array();
            $rowTemp['day'] = $row['day'];
            $rowTemp['period'] = $row['period'];
            $rowTemp['attendanceTime'] = $row['attendance_time'];
            $rowTemp['attendanceState'] = $row['attendance_state'];
            $rowTemp['attendanceDay'] = $row['registration'];
            $rows[$i] = $rowTemp;
        }

        echo json_encode($rows);
    } else echo "fail";
    mysqli_close($db);
?>