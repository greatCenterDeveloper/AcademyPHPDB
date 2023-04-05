<?php
    header('Content-Type:application/json; charset=utf-8');

    // DB 읽어오기
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');

    mysqli_query($db, 'set names utf8');
    
    $data = file_get_contents('php://input');
    $_POST = json_decode($data, true);

    $authority = $_POST['authority'];
    $profile = $_POST['profile'];
    $emailId = $_POST['emailId'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $courseArr = $_POST['courseArr'];
    $call = $_POST['call'];
    $now = date('Y-m-d');
    $courseSize = count($courseArr);

    $LoginInsertSql = "INSERT INTO login VALUES('$emailId', '$password', '$authority', '$now')";
    $memberInsertSql = "INSERT INTO member VALUES('$emailId', '$name', '$call', '$profile', '$now')";

    $result = mysqli_query($db, $LoginInsertSql);
    mysqli_query($db, $memberInsertSql);
    if($result && $authority == '선생님') {
        for($i=0; $i<$courseSize; $i++) {
            $memberCourseSql = "INSERT INTO teacher VALUES('$emailId', '$courseArr[$i]', '$now')";
            $result = mysqli_query($db, $memberCourseSql);
        }
    }

    if($authority == '학생') {
        for($i=0; $i<$courseSize; $i++) {
            $memberCourseSql = "INSERT INTO student VALUES('$emailId', '$courseArr[$i]', '$now')";
            $result = mysqli_query($db, $memberCourseSql);
        }
    }
    
    if($result) echo "회원 가입 성공";
    else echo "회원 가입 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>