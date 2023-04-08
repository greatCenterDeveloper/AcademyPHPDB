<?php
    header('Content-Type:application/json; charset=utf-8');

    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $sql = "SELECT cs.day, c.course_code, c.course_name AS course, cs.period, cr.room_num AS room
            FROM course AS c, course_assign AS ca, course_room AS cr, course_schedule AS cs
            WHERE c.course_code = ca.course_code
            AND ca.room_code = cr.room_code
            AND ca.course_assign_code = cs.course_assign_code ORDER BY course_schedule_code";
    
    $result = mysqli_query($db, $sql);
    if($result) {
        $rowNum = mysqli_num_rows($result);
        $rows = array();

        $daySql = "SELECT
                    ADDDATE( CURDATE(), - WEEKDAY(CURDATE()) + 0 ) AS MONDAY,
                    ADDDATE( CURDATE(), - WEEKDAY(CURDATE()) + 1 ) AS TUESDAY,
                    ADDDATE( CURDATE(), - WEEKDAY(CURDATE()) + 2 ) AS WEDNESDAY,
                    ADDDATE( CURDATE(), - WEEKDAY(CURDATE()) + 3 ) AS THURSDAY,
                    ADDDATE( CURDATE(), - WEEKDAY(CURDATE()) + 4 ) AS FRIDAY
                   FROM
                    DUAL";
        $dayResult = mysqli_query($db, $daySql);
        $dayRow = mysqli_fetch_array($dayResult, MYSQLI_NUM);

        for($i=0; $i<$rowNum; $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
            if($i % 5 == 0) $row['date'] = $dayRow[0];
            if($i % 5 == 1) $row['date'] = $dayRow[1];
            if($i % 5 == 2) $row['date'] = $dayRow[2];
            if($i % 5 == 3) $row['date'] = $dayRow[3];
            if($i % 5 == 4) $row['date'] = $dayRow[4];


            $course = $row['course_code'];
            $studentSql = "SELECT
                                l.authority, m.profile, m.id, l.password, m.name, m.call_number
                            FROM login AS l, member AS m, student AS s
                            WHERE l.id = m.id
                            AND m.id = s.id
                            AND s.course_code = '$course'";
            $studentResult = mysqli_query($db, $studentSql);
            $studentRowNum = mysqli_num_rows($result);

            $studentRows = array();
            for($j=0; $j<$studentRowNum; $j++) {
                $studentRow = mysqli_fetch_array($studentResult, MYSQLI_ASSOC);
                if($studentRow == null) break;

                $studentId = $studentRow['id'];
                $courseSql = "SELECT c.course_name
                                FROM login AS l, student AS s, course AS c
                                WHERE l.id = s.id
                                AND s.course_code = c.course_code
                                AND s.id = '$studentId'";
                $resultCourse = mysqli_query($db, $courseSql);
                $courseRowNum = mysqli_num_rows($resultCourse);

                $courseRow = array();
                for($k=0; $k<$courseRowNum; $k++) {
                    $course = mysqli_fetch_array($resultCourse, MYSQLI_ASSOC);
                    if($course == null) break;

                    $courseRow['course'] = $course['course_name'];
                }

                $studentRow['courseArr'] = $courseRow;
                $studentRows[$j] = $studentRow;
            }
            
            $row['studentArr'] = $studentRows;
            $rows[$i] = $row;
        }

        echo json_encode($rows, JSON_UNESCAPED_UNICODE);
    } else echo "fail";
    mysqli_close($db);
?>