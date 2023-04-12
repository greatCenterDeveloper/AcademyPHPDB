<?php
    header('Content-Type:application/json; charset=utf-8');

    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $authority = $_GET['authority'];
    $memberId = $_GET['memberId'];

    $sql = "SELECT
                 cs.day,
                 c.course_code,
                 cs.period,
                 cr.room_num
            FROM course AS c,
                 course_assign AS ca,
                 course_room AS cr,
                 course_schedule AS cs
            WHERE c.course_code = ca.course_code
            AND ca.room_code = cr.room_code
            AND ca.course_assign_code = cs.course_assign_code
            ORDER BY course_schedule_code";
    
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
            $rowTemp = array();
            
            if($i % 5 == 0) $rowTemp['date'] = $dayRow[0];
            if($i % 5 == 1) $rowTemp['date'] = $dayRow[1];
            if($i % 5 == 2) $rowTemp['date'] = $dayRow[2];
            if($i % 5 == 3) $rowTemp['date'] = $dayRow[3];
            if($i % 5 == 4) $rowTemp['date'] = $dayRow[4];

            
            $rowTemp['day'] = $row['day'];
            $rowTemp['course'] = $row['course_code'];
            $rowTemp['period'] = $row['period'];
            $rowTemp['room'] = $row['room_num'];
            
            $course = $row['course_code'];

            if($authority == 'teacher') {
                $studentSql = "SELECT
                                    l.authority,
                                    m.profile,
                                    m.id,
                                    l.password,
                                    m.name,
                                    m.call_number
                                FROM login AS l, member AS m, student AS s
                                WHERE l.id = m.id
                                AND m.id = s.id
                                AND s.course_code = '$course'
                                AND s.course_code IN (SELECT course_code FROM teacher WHERE id = '$memberId')";
                $studentResult = mysqli_query($db, $studentSql);
                $studentRowNum = mysqli_num_rows($result);

                $studentRows = array();
                for($j=0; $j<$studentRowNum; $j++) {
                    $studentRow = mysqli_fetch_array($studentResult, MYSQLI_ASSOC);
                    if($studentRow == null) break;

                    $studentId = $studentRow['id'];
                    $courseSql = "SELECT c.course_code
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
                        $courseRow[$k] = $course['course_code'];
                    }

                    $studentRow['courseArr'] = $courseRow;
                    $studentRows[$j] = $studentRow;
                }
                
                $rowTemp['studentArr'] = $studentRows;
            } else if($authority == 'student') {
                $courseSql = "SELECT course_code
                              FROM student
                              WHERE id='$memberId'
                              AND course_code='$course'";
                $resultCourse = mysqli_query($db, $courseSql);
                $courseRowNum = mysqli_num_rows($resultCourse);
                $isMyCourse = false;
                if($courseRowNum == 1) {
                    $isMyCourse = true;
                }
                $rowTemp['isMyCourse'] = $isMyCourse;
            }
            $rows[$i] = $rowTemp;
        }

        echo json_encode($rows, JSON_UNESCAPED_UNICODE);
    } else echo "fail";
    mysqli_close($db);
?>