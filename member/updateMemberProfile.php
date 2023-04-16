<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $id = $_POST['id'];
    $profile = $_POST['profile'];

    $sql = "UPDATE member
            SET profile='$profile'
            WHERE id='$id'";

    $result = mysqli_query($db, $sql);

    if($result) echo "수정 성공";
    else echo "수정 실패";

    mysqli_close($db);
?>