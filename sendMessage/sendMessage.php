<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_POST['studentId'];
    $teacherId = $_POST['teacherId'];
    $message = $_POST['message'];
    $now = date('Y-m-d');

    $sql = "INSERT INTO message
                (student_id, teacher_id, messages, image, registration)
            VALUES
                ('$studentId','$teacherId','$message','','$now')";
    
    $result = mysqli_query($db, $sql);

    if($result) {
        if($index == $size) echo "문자 전송 성공";
    } 
    else echo "문자 전송 실패";
?>