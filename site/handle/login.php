<?php
    session_start();
    include('../../admin/config/config.php');
    if (isset($_POST['login'])) {
        $account_email = $_POST['account_email'];
        $account_password = md5($_POST['account_password']);
        $sql_account = "SELECT * FROM account WHERE account_email='".$account_email."' AND account_password='".$account_password."'";
        $query_account = mysqli_query($mysqli, $sql_account);
        $row = mysqli_fetch_array($query_account);
        $count = mysqli_num_rows($query_account);
        if ($count>0) {
            $_SESSION['account_id'] = $row['account_id'];
            $_SESSION['account_email'] = $row['account_email'];

            $accemail = $_SESSION['account_email'];
            $cartUnKey = md5($accemail);
                
                if (isset($_COOKIE['cart_'.$cartUnKey])) {
                    $encodedCartGet = $_COOKIE['cart_'.$cartUnKey];
                    $cartCook = json_decode($encodedCartGet, true);
                    
                    $_SESSION['cart'] = $cartCook; // Khôi phục giỏ hàng vào session
                  }
            
            // header('Location:../../index.php?page=my_account&tab=account_info&message=success');
            header('Location:../../index.php');
        }else {
            header('Location:../../index.php?page=login&message=errorlogin');
            //echo '<script>alert("Tài khoản hoặc mật khẩu không chính xác, vui lòng nhập lại");</script>';
        }
    }
