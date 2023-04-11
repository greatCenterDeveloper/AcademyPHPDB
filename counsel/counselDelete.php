<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $counselCode = $_GET['counselCode'];

    $sql = "DELETE FROM counsel WHERE counsel_code='$counselCode'";
    $result = mysqli_query($db, $sql);

    $sql = "SELECT counsel_code FROM counsel WHERE counsel_code='$counselCode'";
    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    if($rowNum == 0) echo "상담 내용 삭제 완료";
    else echo "상담 내용 삭제 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>