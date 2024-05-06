<!-- start product detail -->
<?php
include("./site/view/product-detail.php");
?>
<!-- end product detail -->
<?php
if (isset($_SESSION['account_id'])) {
?>
    <!-- start product filtering -->
    <?php
    include("./site/view/product_filtering.php");
    ?>
    <!-- end product filtering -->
<?php
} else {
?>
    <!-- start product list -->
    <?php
    include("./site/view/product-relate.php");
    ?>
    <!-- end product list -->
<?php
}
?>