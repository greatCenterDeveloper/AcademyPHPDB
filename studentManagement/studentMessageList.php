<?php
    header('Content-Type:application/json; charset=utf-8');

    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_POST['studentId'];
    $teacherId = $_POST['teacherId'];

    $sql = "SELECT messages, registration
            FROM message
            WHERE student_id='$studentId' AND teacher_id='$teacherId'";
    $result = mysqli_query($db, $sql);
    if($result) {
        $rowNum = mysqli_num_rows($result);
        $rows = array();

        for($i=0; $i<$rowNum; $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $rowTemp = array();
            $rowTemp['message'] = $row['content'];
            $rowTemp['date'] = $row['registration'];
            $rows[$i] = $rowTemp;
        }

        echo json_encode($rows);
    } else echo "fail";
    mysqli_close($db);
?>