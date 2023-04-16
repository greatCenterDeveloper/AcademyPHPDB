<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $id = $_POST['id'];
    $name = $_POST['name'];
    $call = $_POST['call'];
    $prevPassword = $_POST['prevPassword'];
    $password = $_POST['password'];

    $sql = "SELECT id
            FROM login
            WHERE id = '$id'
            AND password = '$prevPassword'";
    
    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    if($rowNum > 0) {
        
        $sql = "UPDATE login
                SET password = '$password'
                WHERE id = '$id'";
        
        $result = mysqli_query($db, $sql);

        $sql = "UPDATE member
                SET name = '$name',
                    call_number = '$call'
                WHERE id = '$id'";
        
        $memberResult = mysqli_query($db, $sql);


        if($result && $memberResult) echo "success";
        else echo "fail";

    } else echo "fail";

    mysqli_close($db);
?>