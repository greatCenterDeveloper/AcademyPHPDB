<?php
    header('Content-Type:application/json; charset=utf-8');

    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $teacherId = $_GET['teacherId'];
    $course = $_GET['course'];

    $sql = '';
    if($course != '선택안함' ) {
        $sql = "SELECT DISTINCT
                    l.authority,
                    m.profile,
                    l.id,
                    l.password,
                    m.name,
                    m.call_number
                FROM login AS l,
                    member AS m,
                    student AS s
                WHERE l.id = m.id
                AND l.id = s.id
                AND s.course_code = '$course'
                AND s.course_code IN (SELECT
                                        course_code
                                    FROM teacher
                                    WHERE id = '$teacherId')";
    } else {
        $sql = "SELECT DISTINCT
                    l.authority,
                    m.profile,
                    l.id,
                    l.password,
                    m.name,
                    m.call_number,
                    s.registration
                FROM login AS l,
                    member AS m,
                    student AS s
                WHERE l.id = m.id
                AND l.id = s.id
                AND s.course_code IN (SELECT
                                        course_code
                                    FROM teacher
                                    WHERE id = '$teacherId')
                ORDER BY s.registration";
    }

    $result = mysqli_query($db, $sql);
    if($result) {
        $rowNum = mysqli_num_rows($result);
        $rows = array();

        for($i=0; $i<$rowNum; $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC); // 한 줄을 연관 배열로

            $studentId = $row['id'];
            $courseSql = "SELECT c.course_name
                            FROM login AS l, student AS s, course AS c
                            WHERE l.id = s.id
                            AND s.course_code = c.course_code
                            AND s.id = '$studentId'";
            $resultCourse = mysqli_query($db, $courseSql);
            $courseRowNum = mysqli_num_rows($resultCourse);

            $courseRow = array();
            for($j=0; $j<$courseRowNum; $j++) {
                $course = mysqli_fetch_array($resultCourse, MYSQLI_ASSOC);
                $courseRow[$j] = $course['course_name'];
            }

            $row['courseArr'] = $courseRow;
            $rows[$i] = $row;
        }
        echo json_encode($rows);
    } else echo "fail";
    
    mysqli_close($db);
?>