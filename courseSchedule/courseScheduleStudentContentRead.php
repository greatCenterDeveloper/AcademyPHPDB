<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');


    // 저번 주의 메모 내용은 전부 삭제..
    $deleteSql = "DELETE FROM
                    course_schedule_student
                  WHERE registration <
                            (SELECT ADDDATE( CURDATE(), - WEEKDAY(CURDATE()) + 0 ) AS MONDAY
                            FROM DUAL)";
    mysqli_query($db, $deleteSql);


    $courseScheduleStudentCode = $_POST['courseScheduleStudentCode'];
    $studentId = $_POST['studentId'];

    $sql = "SELECT
                course_schedule_content 
            FROM course_schedule_student
            WHERE student_id = '$studentId'
            AND course_schedule_student_code = '$courseScheduleStudentCode'";

    $result = mysqli_query($db, $sql);
    
    if($result) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        $content = $row['course_schedule_content'];

        echo "$content";
    }
    mysqli_close($db);
?>