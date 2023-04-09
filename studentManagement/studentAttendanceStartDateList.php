<?php
    header('Content-Type:application/json; charset=utf-8');
    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $teacherId = $_GET['teacherId'];
    $startDate = $_GET['startDate'];
    
    $sql = "SELECT DISTINCT
                a.registration,
                m.name,
                a.attendance_academy_time,
                a.the_lower_house_academy_time
            FROM attendance AS a,
                 student AS s,
                 member AS m
            WHERE a.student_id = s.id
            AND   s.id = m.id
            AND   a.registration >= '$startDate'
            AND   s.id IN  (SELECT DISTINCT
                                    st.id
                            FROM student AS st, teacher AS t
                            WHERE st.course_code = t.course_code
                            AND t.id = '$teacherId')
            ORDER BY a.registration DESC, a.attendance_academy_time";
    $result = mysqli_query($db, $sql);

    if($result) {
        $rowNum = mysqli_num_rows($result);

        $rows = array();
        for($i=0; $i<$rowNum; $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $rowTemp = array();
            $rowTemp['attendanceDate'] = $row['registration'];
            $rowTemp['student'] = $row['name'];
            $rowTemp['attendanceTime'] = $row['attendance_academy_time'];
            $rowTemp['gohomeTime'] = $row['the_lower_house_academy_time'];

            $rows[$i] = $rowTemp;
        }

        echo json_encode($rows);
    } else echo "fail";
    mysqli_close($db);
?>