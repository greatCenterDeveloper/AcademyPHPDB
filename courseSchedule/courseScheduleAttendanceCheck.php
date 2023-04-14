<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $courseScheduleCode     = $_POST['courseScheduleCode'];
    $studentId              = $_POST['studentId'];
    $attendanceState        = $_POST['attendanceState'];
    $attendanceTime         = $_POST['attendanceTime'];
    $now = date('Y-m-d');

    $caCodeDate = date('YmdHis');

    $caCode = "ca_" . $caCodeDate . "_" . $studentId;

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


    // 먼저 입력했던 내용이 있는가?
    $sql = "SELECT
                course_attendance_code
            FROM
                course_attendance
            WHERE
                course_schedule_code = '$courseScheduleCode'
            AND
                course_request_code  = '$courseRequestCode'
            ORDER BY
                registration DESC LIMIT 1";
    
    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    // 먼저 입력한 내용이 존재
    if($rowNum > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $courseAttendanceCode = $row['course_attendance_code'];
        
        $sql = "UPDATE
                    course_attendance
                SET
                    attendance_state = '$attendanceState',
                    attendance_time = '$attendanceTime'
                WHERE
                    course_attendance_code='$courseAttendanceCode'";

        $result = mysqli_query($db, $sql);

        if($result) echo $attendanceState . " 처리 완료";
        else echo $attendanceState . " 처리 실패. 다시 시도해 주세요.";

    } else {
        // 먼저 입력했던 내용이 존재하지 않는다면 새로 Insert 해야함 !
        $sql = "INSERT INTO
                    course_attendance
                VALUES
                    ('$caCode',
                    '$courseScheduleCode',
                    '$courseRequestCode',
                    '$attendanceState',
                    '$attendanceTime',
                    '$now')";

        $result = mysqli_query($db, $sql);

        if($result) echo $attendanceState . " 처리 완료";
        else echo $attendanceState . " : " . $attendanceTime . " : " . $now;
    }
    mysqli_close($db);
?>