<!-- start header -->
<?php
include("./site/view/header.php");
?>
<!-- end header -->

<?php
    if (isset($_GET['page'])) {
        $action = $_GET['page'];
    }else {
        $action = '';
    }

    if ($action == 'about') {
        include("./site/main/about.php");
    }
    elseif ($action == 'blog') {
        include("./site/main/blog.php");
    }
    elseif ($action == 'article') {
        include("./site/main/article.php");
    }
    elseif ($action == 'contact') {
        include("./site/main/contact.php");
    }
    elseif ($action == 'cart') {
        include("./site/main/cart.php");
    }
    elseif ($action == 'products') {
        include("./site/main/products.php");
    }
    elseif ($action == 'search'){
        include("./site/main/search.php");
    }
    elseif ($action == 'product_detail'){
        include("./site/main/product_detail.php");
    }
    elseif ($action == 'checkout'){
        include("./site/main/checkout.php");
    }
    elseif ($action == 'thankiu'){
        include("./site/main/thankiu.php");
    }
    elseif ($action == 'login'){
        include("./site/main/login.php");
    }
    elseif ($action == 'register'){
        include("./site/main/register.php");
    }
    elseif ($action == 'checkcode'){
        include("./site/view/checkcode.php");
    }
    elseif ($action == 'my_account'){
        include("./site/main/my_account.php");
    }
    elseif ($action == 'order_detail'){
        include("./site/view/order-detail.php");
    }
    elseif ($action == 'password_change'){
        include("./site/view/password-change.php");
    }
    elseif ($action == '404'){
        include("./site/main/404.php");
    }
    else {
        include("./site/main/home.php");
    }
?>

<!-- start footer -->
<?php
include("./site/view/footer.php");
?>
<!-- end footer -->