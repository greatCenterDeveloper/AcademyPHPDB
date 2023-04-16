<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $id = $_POST['id'];

    $sql = "SELECT m.profile
            FROM login AS l,
                member AS m
            WHERE l.id = m.id
            AND m.id = '$id'";

    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    if($rowNum > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $profile = $row['profile'];
        echo $profile;
    } else echo "fail";

    mysqli_close($db);
?>