<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_GET['studentId'];
    $counselRequestCode = $_GET['counselRequestCode'];

    $sql = "DELETE FROM
                counsel_request
            WHERE student_id='$studentId'
            AND counsel_request_code='$counselRequestCode'";

    $result = mysqli_query($db, $sql);

    $sql = "SELECT counsel_request_code
            FROM counsel_request
            WHERE student_id='$studentId'
            AND counsel_request_code='$counselRequestCode'";
    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    if($rowNum == 0) echo "상담 신청 삭제 완료";
    else echo "상담 신청 삭제 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>