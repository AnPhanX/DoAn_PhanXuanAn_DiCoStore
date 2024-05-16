<link rel="stylesheet" type="text/css" href="../../../assets/css/checkregister.css" />
<section class=" pd-section">

<div class="auth-container">
    <h3><b>XÁC THỰC EMAIL ĐĂNG KÝ</b></h3>
    <form action="site/handle/account-insert.php" autocomplete="on" method="POST">
        <input class="input-code" type="text" id="authCode" name="authCode" placeholder="Nhập mã được gửi tới email đăng ký!" required>
        <button type="submit" class="btn_code text-center">XÁC THỰC</button>
        <a class="replace-code" href="../../system/library/mail/index.php">Gửi lại mã</a>
    </form>
    <div id="toast">
</div>
</section>
<script>
    function showErrorMessage() {
        alert('Mã xác thực không chính xác')
    }
</script>
<?php
if (isset($_GET['message']) && $_GET['message'] == 'error') {
    echo '<script>';
    echo 'showErrorMessage();';
    echo 'window.history.pushState(null, "", "checkcode.php");';
    echo '</script>';
}
?>
