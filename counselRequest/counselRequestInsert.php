<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $data = file_get_contents('php://input');
    $_POST = json_decode($data, true);

    $date = $_POST['date'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $content = $_POST['content'];
    $studentId = $_POST['studentId'];
    $now = date('Y-m-d');
    $crCodeDate = date('YmdHis');

    $crCode = "cr_" . $studentId . "_" . $crCodeDate;
    
    $sql = "INSERT INTO
                counsel_request
            VALUES
                ('$crCode',
                 '$studentId',
                 '$content',
                 '$date',
                 '$startTime',
                 '$endTime',
                 '$now')";
    $result = mysqli_query($db, $sql);

    if($result) echo "상담 신청 완료";
    else echo "상담 신청 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>