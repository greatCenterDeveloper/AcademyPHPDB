<?php
    header('Content-Type:application/json; charset=utf-8');

    // DB 읽어오기
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');

    mysqli_query($db, 'set names utf8');
    
    // @BODY로 넘어온 이름없는 파일로 넘어온 객체 받기
    $data = file_get_contents('php://input');
    $_POST = json_decode($data, true);

    $authority = $_POST['authority'];
    $profile = $_POST['profile'];
    $id = $_POST['id'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $courseArr = $_POST['courseArr'];
    $call = $_POST['call_number'];
    $now = date('Y-m-d');
    $courseSize = count($courseArr);

    $LoginInsertSql = "INSERT INTO login VALUES('$id', '$password', '$authority', '$now')";
    $memberInsertSql = "INSERT INTO member VALUES('$id', '$name', '$call', '$profile', '$now')";

    $result = mysqli_query($db, $LoginInsertSql);
    mysqli_query($db, $memberInsertSql);
    if($result && $authority == 'teacher') {
        for($i=0; $i<$courseSize; $i++) {
            $memberCourseSql = "INSERT INTO teacher VALUES('$id', '$courseArr[$i]', '$now')";
            $result = mysqli_query($db, $memberCourseSql);
        }
    }

    if($authority == 'student') {
        for($i=0; $i<$courseSize; $i++) {
            $memberCourseSql = "INSERT INTO student VALUES('$id', '$courseArr[$i]', '$now')";
            $result = mysqli_query($db, $memberCourseSql);
            
            $courseRequestCode = "cr_" . $id . "_" . $courseArr[$i];
            $courseRequestSql = "INSERT INTO course_request
                                 VALUES('$courseRequestCode',
                                        '$courseArr[$i]',
                                        '$id',
                                        '$now')";
            
            $result = mysqli_query($db, $courseRequestSql);
        }
    }
    
    if($result) echo "회원 가입 성공";
    else echo "회원 가입 실패. 다시 시도해 주세요.";

    mysqli_close($db);
?>