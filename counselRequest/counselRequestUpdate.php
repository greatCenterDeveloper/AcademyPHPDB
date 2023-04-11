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
    $counselRequestCode = $_POST['counselRequestCode'];

    $sql = "UPDATE counsel_request
            SET counsel_request_content='$content',
                counsel_request_day='$date',
                counsel_request_start_time='$startTime',
                counsel_request_end_time='$endTime'
            WHERE student_id='$studentId'
            AND counsel_request_code='$counselRequestCode'";
    $result = mysqli_query($db, $sql);

    if($result) echo "상담 신청 수정 완료";
    else echo "상담 신청 수정 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>