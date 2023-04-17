<?php
    header('Content-Type:application/json; charset=utf-8');

    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');
    mysqli_query($db, 'set names utf8');

    $studentId = $_GET['studentId'];
    $teacherId = $_GET['teacherId'];

    $sql = "SELECT DISTINCT
                m.profile,
                s.course_code AS course,
                t.id AS teacher,
                s.id AS studentId,
                m.name AS studentName
            FROM member AS m,
                 teacher AS t,
                 student AS s
            WHERE m.id = s.id
            AND s.course_code = t.course_code
            AND s.id = '$studentId'
            AND t.id = '$teacherId'";
    
    $result = mysqli_query($db, $sql);

    if($result) {
        $rowNum = mysqli_num_rows($result);
        $rows = array();

        for($i=0; $i<$rowNum; $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $rowTemp = array();
            $rowTemp['profile'] = $row['profile'];
            $rowTemp['course'] = $row['course'];
            $rowTemp['teacher'] = $row['teacher'];
            $rowTemp['studentId'] = $row['studentId'];
            $rowTemp['studentName'] = $row['studentName'];

            $courseCode = $row['course'];

            $attendanceSql  =  "SELECT DISTINCT
                                        COUNT(ca.attendance_state) AS attendance
                                FROM student AS s,
                                     course_attendance AS ca,
                                     course_request AS cr
                                WHERE ca.course_request_code = cr.course_request_code
                                AND cr.course_code = s.course_code
                                AND cr.student_id = s.id
                                AND s.course_code = '$courseCode'
                                AND s.id = '$studentId'
                                AND ca.attendance_state='출석'";
            
            $attendanceResult = mysqli_query($db, $attendanceSql);
            $attendanceRow = mysqli_fetch_array($attendanceResult, MYSQLI_ASSOC);

            $rowTemp['attendance'] = $attendanceRow['attendance'];
            

            $absenceSql  = "SELECT DISTINCT
                                    COUNT(ca.attendance_state) AS absence
                            FROM student AS s,
                                course_attendance AS ca,
                                course_request AS cr
                            WHERE ca.course_request_code = cr.course_request_code
                            AND cr.course_code = s.course_code
                            AND cr.student_id = s.id
                            AND s.course_code = '$courseCode'
                            AND s.id = '$studentId'
                            AND ca.attendance_state='결석'";
            
            $absenceResult = mysqli_query($db, $absenceSql);
            $absenceRow = mysqli_fetch_array($absenceResult, MYSQLI_ASSOC);
            
            $rowTemp['absence'] = $absenceRow['absence'];

            $rows[$i] = $rowTemp;
        }
        
        echo json_encode($rows);
    } else echo "fail";
    mysqli_close($db);
?>