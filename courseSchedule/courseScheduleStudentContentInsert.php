<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $courseScheduleCode = $_POST['courseScheduleCode'];
    $studentId = $_POST['studentId'];
    $courseScheduleContent = $_POST['courseScheduleContent'];
    $now = date('Y-m-d');

    $cssCodeDate = date('YmdHis');

    $cssCode = "css_" . $studentId . "_" . $cssCodeDate;

    // 먼저 입력했던 내용이 있는가?
    $sql = "SELECT
                course_schedule_student_code
            FROM course_schedule_student
            WHERE course_schedule_code = '$courseScheduleCode'
            AND student_id = '$studentId'
            ORDER BY
                registration DESC LIMIT 1";
    
    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    // 먼저 입력한 내용이 존재
    if($rowNum > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $courseScheduleStudentCode = $row['course_schedule_student_code'];

        $sql = "UPDATE
                    course_schedule_student
                SET
                    course_schedule_content='$courseScheduleContent'
                WHERE
                    course_schedule_student_code='$courseScheduleStudentCode'";

        $result = mysqli_query($db, $sql);

        if($result) echo "수업 메모 수정 완료";
        else echo "수업 메모 수정 실패. 다시 시도해 주세요.";
        
    } else {
        // 먼저 입력했던 내용이 존재하지 않는다면 새로 Insert 해야함 !
        $sql = "INSERT INTO
                    course_schedule_student
                VALUES
                    ('$cssCode',
                    '$courseScheduleCode',
                    '$studentId',
                    '$courseScheduleContent',
                    '$now')";

        $result = mysqli_query($db, $sql);

        if($result) echo "수업 메모 저장 완료";
        else echo "수업 메모 저장 실패. 다시 시도해 주세요.";
    }
    mysqli_close($db);
?>