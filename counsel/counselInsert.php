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

    // 학생의 상담 신청 내용을 보고 상담한 것이라면..
    if($counselRequestCode != "insert") {
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
    } else {
        // 선생님이 학생 상세 페이지에서 상담하기 버튼으로 넘어온 것이라면..
        $crCodeDate = date('YmdHis');
        $crCode = "cr_" . $studentId . "_" . $crCodeDate;
        $counselRequestSql = "INSERT INTO
                                counsel_request
                              VALUES
                                ('$crCode',
                                '$studentId',
                                '선생님 임의 상담',
                                '$date',
                                '',
                                '',
                                '$now')";
        $result = mysqli_query($db, $counselRequestSql);
        if($result) {
            $sql = "INSERT INTO
                counsel
                VALUES
                    ('$counselCode',
                    '$crCode',
                    '$studentId',
                    '$teacherId',
                    '$date',
                    '$counselContent',
                    '$now')";
            $result = mysqli_query($db, $sql);
            if($result) echo "상담 작성 완료";
            else echo "상담 작성 실패. 다시 시도해 주세요.";
        }
    }
    mysqli_close($db);
?>