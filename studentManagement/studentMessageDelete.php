<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_POST['studentId'];
    $teacherId = $_POST['teacherId'];
    $message = $_POST['message'];
    $date = $_POST['date'];

    $sql = "DELETE FROM message
            WHERE student_id = '$studentId'
            AND teacher_id = '$teacherId'
            AND messages = '$message'
            AND registration = '$date'";
    
    $result = mysqli_query($db, $sql);

    $sql = "SELECT
                messages
            FROM message
            WHERE student_id = '$studentId'
            AND teacher_id = '$teacherId'
            AND messages = '$message'
            AND registration = '$date'";
    
    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    if($rowNum == 0) echo "문자 삭제 완료";
    else echo "문자. 다시 시도해 주세요.";

    mysqli_close($db);
?>