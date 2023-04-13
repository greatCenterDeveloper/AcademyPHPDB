<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $attendanceCode = $_POST['attendanceCode'];
    $studentId = $_POST['studentId'];
    $theLowerHouseTime = $_POST['theLowerHouseTime'];

    $sql = "UPDATE attendance
            SET the_lower_house_academy_time='$theLowerHouseTime'
            WHERE student_id='$studentId'
            AND attendance_code='$attendanceCode'";
    $result = mysqli_query($db, $sql);

    if($result) {
        $sql = "SELECT name FROM member WHERE id='$studentId'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $studentName = $row['name'];

        echo "$studentName 하원 완료!";
    } else echo "하원 입력 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>