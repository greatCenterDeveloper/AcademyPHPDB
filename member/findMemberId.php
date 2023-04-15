<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $call = $_POST['call'];

    $sql = "SELECT l.id
            FROM login AS l,
                member AS m
            WHERE l.id = m.id
            AND m.call_number = '$call'";

    $result = mysqli_query($db, $sql);
    if($result) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $id = $row['id'];
        echo "회원님의 아이디는 $id 입니다.";
        
    } else echo "없는 휴대폰 번호 입니다. 다시 입력해주세요.";

    mysqli_close($db);
?>