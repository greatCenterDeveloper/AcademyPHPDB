<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $courseScheduleCode     = $_POST['courseScheduleCode'];
    $studentId              = $_POST['studentId'];

    $sql = "SELECT
                ca.course_code 
            FROM course_schedule AS cs,
                course_assign AS ca
            WHERE cs.course_assign_code = ca.course_assign_code
            AND cs.course_schedule_code = '$courseScheduleCode'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $courseCode = $row['course_code'];

    $sql = "SELECT
                course_request_code
            FROM
                course_request
            WHERE
                course_code = '$courseCode'
            AND
                student_id='$studentId'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    $courseRequestCode = $row['course_request_code'];

    $sql = "SELECT
                attendance_state
            FROM
                course_attendance
            WHERE
                course_schedule_code = '$courseScheduleCode'
            AND
                course_request_code  = '$courseRequestCode'
            ORDER BY
                registration DESC LIMIT 1";

    $result = mysqli_query($db, $sql);

    if($result) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $attendanceState = $row['attendance_state'];
        
        echo $attendanceState;
    }else echo "";
    mysqli_close($db);
?>