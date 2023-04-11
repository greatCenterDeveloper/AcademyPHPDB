<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $data = file_get_contents('php://input');
    $_POST = json_decode($data, true);

    $counselCode = $_POST['counselCode'];
    $counselContent = $_POST['counselContent'];

    $sql = "UPDATE counsel
            SET counsel_content='$counselContent'
            WHERE counsel_code='$counselCode'";

    $result = mysqli_query($db, $sql);

    if($result) echo "상담 수정 완료";
    else echo "상담 수정 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>