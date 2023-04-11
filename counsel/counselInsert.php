<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $data = file_get_contents('php://input');
    $_POST = json_decode($data, true);

    $counselRequestCode = $_POST['counselRequestCode'];
    $studentId = $_POST['studentId'];
    $teacherId = $_POST['teacherId'];
    $date = $_POST['date'];
    $counselContent = $_POST['counselContent'];
    $now = date('Y-m-d');
    $counselCodeDate = date('YmdHis');

    $counselCode = "co_" . $studentId . "_" . $counselCodeDate ;

    $sql = "INSERT INTO
                counsel
            VALUES
                ('$counselCode',
                 '$counselRequestCode',
                 '$studentId',
                 '$teacherId',
                 '$date',
                 '$counselContent',
                 '$now')";
    $result = mysqli_query($db, $sql);

    if($result) echo "상담 작성 완료";
    else echo "상담 작성 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>