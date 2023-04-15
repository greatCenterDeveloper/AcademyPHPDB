<?php
    header('Content-Type:application/json; charset=utf-8');

    // DB 읽어오기
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');

    mysqli_query($db, 'set names utf8');

    $id = $_GET['id'];

    $sql = "SELECT * FROM login WHERE id = '$id'";

    $result = mysqli_query($db, $sql);
    if($result) {
        $rowNum = mysqli_num_rows($result);

        if($rowNum > 0) echo "이미 사용 중인 아이디 입니다.";
        else echo "사용 가능한 아이디 입니다.";
    }
?>