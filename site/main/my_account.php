<?php
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    unset($_SESSION['account_email']);
    unset($_SESSION['account_id']);
    header('Location:index.php');
}
    if (isset($_GET['tab'])) {
        $tab = $_GET['tab'];
    }else {
        $tab = '';
    }
?>

<!-- start my account -->
<section class="my-account pd-section-my-acc">
    <div class="container">
    <?php 
    if (isset($_SESSION['account_email'])) {
        $account_id = $_SESSION['account_id'];
        $sql_account = "SELECT * FROM account where account_id = $account_id ";
        $query_account = mysqli_query($mysqli, $sql_account);
        while ($row_account = mysqli_fetch_array($query_account)) {
        ?>
        <h3 class="h3 my-account__heading"><b>THÔNG TIN TÀI KHOẢN : </b><?php echo $row_account['account_name'] ?></h3>
        <?php
                }
                ?>

            <?php
            } else {
            ?>
           <h3 class="h4 my-account__heading">Thông tin tài khoản</h3>
            <?php
            }
            ?>
            
        <div class="my-account__container">
            <div class="row">
                <div class="col" style="--w-md: 3">
                    <ul class="my-account__menu">
                        <li class="my-account__item <?php if($tab == 'account_info') { echo 'active';} ?>">
                            <a href="index.php?page=my_account&tab=account_info" class="">Tài khoản</a>
                        </li>
                        <li class="my-account__item <?php if($tab == 'account_order') { echo 'active';} ?>">
                            <a href="index.php?page=my_account&tab=account_order" class="">Đơn hàng đang xử lý</a>
                        </li>
                        <li class="my-account__item <?php if($tab == 'account_history') { echo 'active';} ?>">
                            <a href="index.php?page=my_account&tab=account_history" class="">Lịch sử mua hàng</a>
                        </li>
                        <!-- <li class="my-account__item <?php if($tab == 'account_settings') { echo 'active';} ?>">
                            <a href="index.php?page=my_account&tab=account_settings" class="">Cài đặt tài khoản</a>
                        </li> -->
                        <!-- <li class="my-account__item">
                            <a href="index.php?logout=1" onclick="return confirm('Bạn có đăng xuất không?')"
                                class="">Đăng xuất</a>
                        </li> -->
                    </ul>
                </div>
                <div class="col" style="--w-md: 9">
                    <?php
                        if ($tab == 'account_order') {
                            include('./site/view/account-order.php');
                        }
                        elseif ($tab == 'account_history') {
                            include("./site/view/account-history.php");
                        }
                        elseif ($tab == 'account_settings') {
                            include("./site/view/account-settings.php");
                        }
                        else {
                            include("./site/view/account-info.php");
                        }
                        
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end my account -->