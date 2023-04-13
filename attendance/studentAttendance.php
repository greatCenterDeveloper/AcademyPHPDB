<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_GET['studentId'];
    $attendanceTime = $_GET['attendanceTime'];
    $now = date('Y-m-d');
    $attCodeDate = date('YmdHis');

    $attCode = "ac_" . $attCodeDate . "_" . $studentId;

    // 이미 오늘 등원 처리를 했을 경우 또 등원 처리되지 않게 하기 위해서.
    $sql = "SELECT
                attendance_code
            FROM attendance
            WHERE student_id = '$studentId'
            AND registration = '$now'";
    $result = mysqli_query($db, $sql);
    $rowNum = mysqli_num_rows($result);

    // 이미 오늘 등원 처리가 된 경우..
    if($rowNum > 0) {
        echo "이미 등원 처리되었습니다.";
    } else {
        // 오늘 등원 처리가 되지 않은 경우
        $sql = "INSERT INTO attendance
                VALUES ('$attCode',
                        '$studentId',
                        '$attendanceTime',
                        '',
                        '$now')";
        $result = mysqli_query($db, $sql);
        
        if($result) {
            $sql = "SELECT DISTINCT
                        a.attendance_code,
                        m.name
                    FROM attendance AS a,
                        student AS s,
                        member AS m
                    WHERE a.student_id = s.id
                    AND s.id = m.id
                    AND attendance_code='$attCode'";
            $result = mysqli_query($db, $sql);
            $rowNum = mysqli_num_rows($result);
            
            if($rowNum > 0) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
                $studentName = $row['name'];
                $attendanceCode = $row['attendance_code'];

                echo $attendanceCode . "," . $studentName ." 등원 완료!";
            }
        } else echo "등원 입력 실패. 다시 시도해 주세요.";
    }
    mysqli_close($db);
?>