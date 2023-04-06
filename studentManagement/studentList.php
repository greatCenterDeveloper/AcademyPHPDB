<?php
    header('Content-Type:application/json; charset=utf-8');

    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $id = $_GET['id'];

    $sql = "SELECT l.authority, m.profile, l.id, l.password, m.name, m.call_number, s.course_code
            FROM login AS l, member AS m, student AS s
            WHERE l.id = m.id
            AND l.id = s.id
            AND s.course_code IN (SELECT course_code FROM teacher WHERE id = '$id');"
    $result = mysqli_query($db, $sql);

    if($result) {
        $rowNum = mysqli_num_rows($result);

        $row = array();
    for($i=0; $i<$rowNum; $i++) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC); // 한 줄을 연관 배열로
        $rows[$i] = $row;
    }
        
        echo json_encode($rows);
    } else echo ""
    
    
    mysqli_close($db);
?>