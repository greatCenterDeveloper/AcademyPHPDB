<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $courseScheduleStudentCode = $_GET['courseScheduleStudentCode'];
    $studentId = $_GET['studentId'];

    $sql = "DELETE FROM
                course_schedule_student
            WHERE student_id='$studentId'
            AND course_schedule_student_code='$courseScheduleStudentCode'";

    $result = mysqli_query($db, $sql);

    $sql = "SELECT
                course_schedule_student_code
            FROM
                course_schedule_student
            WHERE
                student_id='$studentId'
            AND
                course_schedule_student_code='$courseScheduleStudentCode'";
    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    if($rowNum == 0) echo "메모 삭제 완료";
    else echo "메모 삭제 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>