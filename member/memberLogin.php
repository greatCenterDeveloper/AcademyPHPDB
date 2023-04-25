<?php
    header('Content-Type:application/json; charset=utf-8');

    $db = mysqli_connect('localhost', 'academymrhi', 'a1s2d3f4!', 'academymrhi');

    mysqli_query($db, 'set names utf8');

    $id = $_POST['id'];
    $password = $_POST['password'];

    $sql = "SELECT authority
            FROM login
            WHERE id = '$id'
            AND password = '$password'";

    $result = mysqli_query($db, $sql);
    if($result) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $authority = $row['authority'];

        if($authority == 'teacher') {
            $sql = "SELECT t.course_code
                    FROM login AS l, teacher AS t, course AS c
                    WHERE l.id = t.id
                    AND t.course_code = c.course_code
                    AND l.id = '$id'";
            $result = mysqli_query($db, $sql);
            $rowNum = mysqli_num_rows($result);

            // 강좌 목록 추가
            $courseArr = array();
            for($i=0; $i<$rowNum; $i++) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $courseArr[$i] = $row['course_code'];
            }

            // 회원 정보 추가
            $sql = "SELECT
                        l.authority,
                        m.profile,
                        l.id,
                        l.password,
                        m.name,
                        m.call_number
                    FROM login AS l,
                        member AS m
                    WHERE l.id = m.id
                    AND l.id = '$id'";
            
            $result = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
            $arr = array();
            $arr['authority']       = $row['authority'];
            $arr['profile']         = $row['profile'];
            $arr['id']              = $row['id'];
            $arr['password']        = $row['password'];
            $arr['name']            = $row['name'];
            $arr['courseArr']       = $courseArr;
            $arr['call_number']     = $row['call_number'];

            echo json_encode($arr);
        } else if($authority == 'student') {
            
            $sql = "SELECT s.course_code
                    FROM login AS l,
                        student AS s,
                        course AS c
                    WHERE l.id = s.id
                    AND s.course_code = c.course_code
                    AND l.id = '$id'";
            $result = mysqli_query($db, $sql);
            $rowNum = mysqli_num_rows($result);

            // 강좌 목록 추가
            $courseArr = array();
            for($i=0; $i<$rowNum; $i++) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $courseArr[$i] = $row['course_code'];
            }

            // 회원 정보 추가
            $sql = "SELECT
                        l.authority,
                        m.profile,
                        l.id,
                        l.password,
                        m.name,
                        m.call_number
                    FROM login AS l,
                        member AS m
                    WHERE l.id = m.id
                    AND l.id = '$id'";
            
            $result = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
            $arr = array();
            $arr['authority']   = $row['authority'];
            $arr['profile']     = $row['profile'];
            $arr['id']          = $row['id'];
            $arr['password']    = $row['password'];
            $arr['name']        = $row['name'];
            $arr['courseArr']   = $courseArr;
            $arr['call_number']        = $row['call_number'];

            echo json_encode($arr);
        }
     } else echo "정보 없음";

    mysqli_close($db);
?>