<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $id = $_POST['id'];
    $call = $_POST['call'];

    $sql = "SELECT l.password
            FROM login AS l,
                member AS m
            WHERE l.id = m.id
            AND l.id = '$id'
            AND m.call_number = '$call'";

    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    if($rowNum > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $password = $row['password'];
        echo "회원님의 비밀번호는 $password 입니다.";
        
    } else echo "없는 회원 정보 입니다.\n다시 입력해주세요.";

    mysqli_close($db);
?>