<?php
require('dbcon.php');

class user
{
    public $user_id;
    public $user_name;
    public $name;
    public $dateofsignup;
    public $mobile;
    public $isblock;
    public $password;
    public $role;

    function login($user_name, $password, $conn)
    {
        $errors = array();


        if (sizeof($errors) == 0) {
            $password = md5($password);
            $sql = "SELECT * FROM user WHERE
              `user_name`='$user_name' AND `password`='$password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['role'] == 1) {

                        $_SESSION['userdata'] = array('username' => $row['name'], 'user_id' => $row['user_id'], 'role' => $row['role']);
                        header('Location: admin.php');
                    }
                    if ($row['isblock'] == 0) {
                        echo '<p class="bg-danger text-center text-white">Bạn không được ADMIN cho phép</p>';
                    }
                    if ($row['isblock'] == 1) {
                        $_SESSION['userdata'] = array('username' => $row['name'], 'user_id' => $row['user_id'], 'role' => $row['role'], 'cab_type' => $row['vehicle_type']);
                        if ($row['role'] == 3) {
                            if (isset($_SESSION['book'])) {
                                $pickup = $_SESSION['book']['pickup'];
                                $drop = $_SESSION['book']['drop'];
                                $cabtype = $_SESSION['book']['cabtype'];
                                $lugg = $_SESSION['book']['lugg'];
                                $far = $_SESSION['book']['fare'];
                                $dist = $_SESSION['book']['dist'];

                                date_default_timezone_set('asia/kolkata');
                                $datetime = date("Y-m-d h:i");
                                $id = $_SESSION['userdata']['user_id'];
                                $user = new user();
                                $dbcon = new dbcon();
                                $save = $user->book($pickup, $drop, $cabtype, $dist, $far, $lugg, $datetime, $id, $dbcon->conn);

                                echo '<script>alert("Your Ride request from ' . $pickup . ' to ' . $drop . ' BY ' . $cabtype . ' has been sent");
                                window.location.href = "dash.php";</script>';
                            }
                        }
                        header('Location: dash.php');
                    }
                }
            } else {
                $errors[] = array('input' => 'form', 'msg' => 'Thông tin đăng nhập không hợp lệ');
                echo '<p class="bg-danger text-center">Thông tin đăng nhập không hợp lệ</p>';
            }
        }
    }

    function register($username, $password, $password2, $email, $mobile, $datetime, $role, $vehicle_type, $licensePath, $insurancePath, $registrationPath, $conn)
    {
        $message = '';
        $errors = array();
        if ($password != $password2) {
            $errors[] = array('input' => 'password', 'msg' => 'Mật khẩu không khớp');
            echo '<p class="bg-danger text-center">Mật khẩu không khớp</p>';
        }
        if ($password == $password2) {
            $sql = "SELECT * from user WHERE user_name like '$email'";
            $sql2 = "SELECT * from user WHERE mobile like '$mobile'";
            $result = $conn->query($sql);
            $result2 = $conn->query($sql2);
            if ($result->num_rows > 0) {
                $errors[] = array('input' => 'result', 'msg' => 'Email đã được sử dụng');
                echo '<p class="bg-danger text-center">Email đã được sử dụng</p>';
            }
            if ($result2->num_rows > 0) {
                $errors[] = array('input' => 'result', 'msg' => 'Số điện thoại đã được sử dụng');
                echo '<p class="bg-danger text-center">Số điện thoại đã được sử dụng</p>';
            }
        }

        if ($role == 2) {
            $sql = "INSERT INTO vehicle_documents(`mobile`, `license`, `insurance`, `registration`) VALUES('" . $mobile . "' , '" . $licensePath . "', '" . $insurancePath . "', '" . $registrationPath . "')";
            if (!$conn->query($sql)) {
                $errors[] = array('input' => 'file', 'msg' => 'Lỗi khi tải lên file');
                echo '<p class="bg-danger text-center">Lỗi khi tải lên file</p>';
            }
        }


        if (count($errors) == 0) {
            setcookie("email", $email, time() + 60 * 60 * 24);
            $password = md5($password);
            $sql = "INSERT INTO user(`name`, `password`, `user_name`,`mobile`,`dateofsignup`,`isblock`,`role`, `vehicle_type`) VALUES('" . $username . "', '" . $password . "', '" . $email . "', '" . $mobile . "', '" . $datetime . "',0, '" . $role . "', '" . $vehicle_type . "')";

            if ($conn->query($sql) === true) {
                echo '<script>alert("Đăng ký thành công, chuyển tới trang đăng nhập!");
                     window.location.href = "login.php";</script>';
            } else {
            }
        }
    }

    function allride($id, $conn)
    {
        $sql = "SELECT * FROM ride WHERE customer_user_id='$id'";
        $result = $conn->query($sql);
        $appr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($appr, $row);
        }
        return $appr;
    }

    function ridec($ap, $id, $conn)
    {
        if ($ap == 1) {
            $sql = "UPDATE ride SET status=0 WHERE ride_id=" . $id . "";
            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }

    function penride($id, $conn)
    {
        $sql = "SELECT * FROM ride WHERE status=1 AND customer_user_id='$id'";
        $result = $conn->query($sql);
        $appr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($appr, $row);
        }
        return $appr;
    }

    function pendriver($cab_type, $conn)
    {
        $sql = "SELECT * FROM ride WHERE status=1 AND cab_type= '$cab_type' AND driver_id='0'";
        $result = $conn->query($sql);
        $appr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($appr, $row);
        }
        return $appr;
    }

    function rideup($ap, $id, $driver_id, $conn)
    {
        if ($ap == 1) {
            $sql = "UPDATE ride SET status=2,driver_id=" . $driver_id . " WHERE ride_id=" . $id . "";

            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Lỗi khi cập nhật bản ghi: " . $conn->error;
            }
        }
        if ($ap == 2) {
            $sql = "UPDATE ride SET status=0 WHERE ride_id=" . $id . "";

            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Lỗi khi cập nhật bản ghi: " . $conn->error;
            }
        }
        if ($ap == 0) {
            $sql = "DELETE FROM ride WHERE ride_id=" . $id . "";

            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Lỗi khi xóa bản ghi: " . $conn->error;
            }
        }
    }

    function canride($id, $conn)
    {
        $sql = "SELECT * FROM ride WHERE status=0 AND customer_user_id='$id'";
        $result = $conn->query($sql);
        $appr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($appr, $row);
        }
        return $appr;
    }

    function comride($id, $role, $conn)
    {
        $sql = "";
        if ($role == 2) {
            $sql = "SELECT * FROM ride WHERE status=2 AND driver_id='$id'";
        } else {
            $sql = "SELECT * FROM ride WHERE status=2 AND customer_user_id='$id'";
        }
        $result = $conn->query($sql);
        $appr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($appr, $row);
        }
        return $appr;
    }

    function earn($id, $conn)
    {
        $sql = "SELECT * FROM ride WHERE status=2 AND customer_user_id='$id'";
        $result = $conn->query($sql);
        $appr = 0;
        while ($row = $result->fetch_assoc()) {
            $appr = $appr + $row['total_fare'];
        }
        return $appr;
    }

    function uprof($name, $mobile, $vehicle_type, $documents_id, $license, $insurance, $registration, $ida, $conn)
    {
        $sql = "UPDATE user SET name='" . $name . "', mobile='" . $mobile . "', vehicle_type='" . $vehicle_type . "' WHERE user_id=$ida";
        if ($conn->query($sql) === true) {
            $query = '';
            if(!empty($documents_id)){
                $query = "UPDATE vehicle_documents SET mobile='" . $mobile . "', license='" . $license . "', insurance='" . $insurance . "', registration='" . $registration . "' WHERE id='$documents_id'";
            }else{
                $query = "INSERT INTO vehicle_documents(`mobile`, `license`, `insurance`, `registration`) VALUES('" . $mobile . "' , '" . $license . "', '" . $insurance . "', '" . $registration . "')";
            }
            $conn->query($query);
            $_SESSION['userdata']['username'] = $name;
            echo '<script>alert("Cập nhật hồ sơ thành công.");
                window.location.href = "usrprofile.php"</script>';
        } else {
            echo '<p class="bg-danger text-center text-white">Đã xảy ra sự cố</p>';
        }
    }

    function prof($id, $conn)
    {
        $sql = "SELECT * FROM user WHERE user_id='$id'";
        $result = $conn->query($sql);
        $appr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($appr, $row);
        }
        return $appr;
    }


    function changep($old, $new, $rnew, $idp, $conn)
    {
        $sql = "SELECT * FROM user WHERE user_id='$idp'";
        $result = $conn->query($sql);
        $pass = "";
        while ($row = $result->fetch_assoc()) {
            $pass = $row['password'];
        }
        $old = md5($old);

        if ($pass == $old) {
            $errors = array();
            if ($new != $rnew) {
                $errors[] = array('input' => 'password', 'msg' => 'password should be same');
                echo '<p class="bg-danger text-center">Mật khẩu mới and re-password should be same</p>';
            }
            if (count($errors) == 0) {
                $new = md5($new);
                $sql = "UPDATE user SET password='$new' WHERE user_id='$idp'";

                if ($conn->query($sql) === true) {
                    echo '<script>alert("Đổi mật khẩu thành công, vui lòng đăng nhập lại.");
                    window.location.href = "logout.php";</script>';
                } else {
                    echo $conn->errors;
                }
            }
        } else {
            echo '<p class="bg-danger text-center">Mật khẩu cũ Does Not Match</p>';
        }
    }

    function countride($id, $conn)
    {
        $sql = "SELECT * FROM ride WHERE customer_user_id='$id'";
        $result = $conn->query($sql);
        $count = $result->num_rows;
        return $count;
    }

    function pcountride($id, $role, $cab_type, $conn)
    {
        $sql = "";
        if ($role == 2) {
            $sql = "SELECT * FROM ride WHERE status=1 AND cab_type='$cab_type' AND driver_id='0'";
        } else {
            $sql = "SELECT * FROM ride WHERE status=1 AND customer_user_id='$id'";
        }
        $result = $conn->query($sql);
        $count = $result->num_rows;
        return $count;
    }

    function cocountride($id, $role, $conn)
    {
        $sql = "";
        if ($role == 2) {
            $sql = "SELECT * FROM ride WHERE status=2 AND driver_id='$id'";
        } else {
            $sql = "SELECT * FROM ride WHERE status=2 AND customer_user_id='$id'";
        }
        $result = $conn->query($sql);
        $count = $result->num_rows;
        return $count;
    }

    function cacountride($id, $conn)
    {
        $sql = "SELECT * FROM ride WHERE status=0 AND customer_user_id='$id'";
        $result = $conn->query($sql);
        $count = $result->num_rows;
        return $count;
    }

    function sort($sot, $id, $conn)
    {
        if ($sot == 'week') {
            $sql = "SELECT * FROM ride WHERE ride_date > DATE_SUB(NOW(), INTERVAL 7 DAY) AND customer_user_id='$id'";
            $result = $conn->query($sql);
            $appr = array();
            while ($row = $result->fetch_assoc()) {
                array_push($appr, $row);
            }
            return $appr;
        } elseif ($sot == 'month') {
            $sql = "SELECT * FROM ride WHERE ride_date > DATE_SUB(NOW(), INTERVAL 30 DAY) AND customer_user_id='$id'";
            $result = $conn->query($sql);
            $appr = array();
            while ($row = $result->fetch_assoc()) {
                array_push($appr, $row);
            }
            return $appr;
        } elseif ($sot == 'none') {
            $sql = "SELECT * FROM ride WHERE customer_user_id='$id'";
            $result = $conn->query($sql);
            $count = $result->num_rows;
            $appr = array();
            while ($row = $result->fetch_assoc()) {
                array_push($appr, $row);
            }

            return $appr;
        }
    }
    function iallride($id, $conn)
    {
        $sql = "SELECT * FROM ride WHERE ride_id='$id'";
        $result = $conn->query($sql);
        $appr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($appr, $row);
        }
        return $appr;
    }

    function ialluser($cid, $conn)
    {
        $sql = "SELECT * FROM user WHERE user_id='$cid'";
        $result = $conn->query($sql);
        $appr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($appr, $row);
        }
        return $appr;
    }

    function book($pickup, $drop, $cabtype, $dist, $far, $lugg, $datetime, $id, $conn)
    {
        echo $sql = "INSERT INTO ride(`ride_date`,`from_distance`,`to_distance`,`cab_type`,`total_distance`,`luggage`,`total_fare`,`status`,`customer_user_id`) VALUES('" . $datetime . "','" . $pickup . "','" . $drop . "','" . $cabtype . "','" . $dist . "','" . $lugg . "','" . $far . "',1,'" . $id . "')";
        if ($conn->query($sql) === TRUE) {
            return;
        } else {
            $conn->error;
        }
    }

    function getImages($mo, $conn)
    {
        $sql = "SELECT * FROM vehicle_documents WHERE mobile='$mo'";
        $result = $conn->query($sql);
        $appr = array();
        while ($row = $result->fetch_assoc()) {
            array_push($appr, $row);
        }
        return $appr;
    }
}
