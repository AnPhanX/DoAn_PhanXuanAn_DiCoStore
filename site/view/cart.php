<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
// unset($_SESSION['cart']);
?>
<div id="toast_message"></div>
<section class="cart pd-bottom">
    <div class="container">
        <div class="cart__header d-flex space-between align-center">
            <h3 class=""><b>Giỏ hàng</b></h3>
            <a class="h4 btn__back__cart text-center" href="index.php?page=products">
                <i class="mdi mdi-reply"></i>
                Cửa hàng
            </a>
        </div>
        <?php
        if (isset($_SESSION['cart'])) {
            
            $total = 0;
        ?>
        <div class="cart__container">
            <div class="cart__heading">
                <div class="cart__item d-grid">
                    <div class="cart__image">
                        <span class="h6"><b>SẢN PHẨM</b></span>
                    </div>
                    <div class="cart__title"></div>
                    <div class="cart__quantity">
                        <span class=" h6 lg-initital pd-l-30"><b>SỐ LƯỢNG</b></span>
                    </div>
                    <div class="cart__total">
                        <span class="h6"><b>GIÁ TIỀN</b></span>
                    </div>
                </div>
            </div>
            <div class="cart__content">
                <?php
                    $validate = true;
                    foreach ($_SESSION['cart'] as $cart_item) {
                        $query_product = mysqli_query($mysqli, "SELECT * FROM product AS p JOIN product_size AS pv ON p.product_id=pv.product_id WHERE p.product_id = '" . $cart_item['product_id'] . "' AND pv.variant_id = '" . $cart_item['variant_id'] . "' LIMIT 1");
                        $product = mysqli_fetch_array($query_product);
                        if ($product['product_quantity'] >= $cart_item['product_quantity']) {
                            $price = ($product['product_price'] - ($product['product_price'] / 100 * $product['product_sale'])) * $cart_item['product_quantity'];
                            $total += ($product['product_price'] - ($product['product_price'] / 100 * $product['product_sale'])) * $cart_item['product_quantity'];
                    ?>
                <div class="cart__item d-grid">
                    <div class="cart__image ">
                        <a href="index.php?page=product_detail&product_id=<?php echo $cart_item['product_id'] ?>"><img
                                class="w-100"
                                src="admin/modules/product/uploads/<?php echo $cart_item['product_image'] ?>"
                                alt="product" /></a>
                    </div>
                    <div class="cart__title ">
                        <h3 class="cart__name h4"><?php echo $cart_item['product_name'] ?></h3>
                        <span class="cart__color d-block">
                            Loại:
                            <?php 
                                            //$sql_variant = "SELECT * FROM product_size WHERE product_id = '".$cart_item['product_id']."' AND variant_id = '".$cart_item['variant_id']."' LIMIT 1";
                                            //$query_variant = mysqli_query($mysqli, $sql_variant);
                                            //while ($variant = mysqli_fetch_array($query_variant)) {
                                                //echo $variant['variant_name'];
                                            //}
                                            echo $product['variant_name'];
                                        ?>
                        </span>
                        <?php
                                    if ($product['product_sale'] > 0) {
                                    ?>
                        <span class="cart__color">Giá: </span><del
                            class="product__price--old cart__color "><?php echo number_format($product['product_price']) . ' ₫' ?></del>
                        <?php
                                    }
                                    ?>

                        <span
                            class="product__price--new cart__color"><?php echo (number_format($product['product_price'] - ($product['product_price'] / 100 * $product['product_sale']))) . ' ₫' ?></span>
                        <!-- <span class="cart__color d-block" style="width:200px;">Giá: <span class="product__price"><?php //echo (number_format( ($cart_item['product_price'] - ($cart_item['product_price'] / 100 * $cart_item['product_sale'])))) . ' ₫'?></span></span> -->
                        <!-- <span class="cart__color d-block">Còn lại: <span class="product__quantity"><?php //echo $product['product_quantity'] ?></span> sản phẩm</span> -->
                    </div>
                    <div class="cart__quantity ">
                        <div class="cart__quantity--container d-flex align-center">
                            <?php 
                                            //$sql_variant = "SELECT * FROM product_size WHERE product_id = '".$cart_item['product_id']."' AND variant_id = '".$cart_item['variant_id']."' LIMIT 1";
                                            //$query_variant = mysqli_query($mysqli, $sql_variant);
                                            //while ($variant = mysqli_fetch_array($query_variant)) {
                                    ?>

                            <div class="select__number p-relative">
                                <a href="site/handle/addtocart.php?div=<?php echo $cart_item['product_id']?>&product_type=<?php echo $product['variant_id']?>"
                                    class="select__number--minus cursor-pointer p-absolute d-flex align-center justify-center">
                                    <img src="./assets/images/icon/minus.svg" alt="" />
                                </a>
                                <input type="text" value="<?php echo $cart_item['product_quantity'] ?>"
                                    class="select__number--value heading-6 w-100 h-100" />
                                <a href="site/handle/addtocart.php?sum=<?php echo $cart_item['product_id']?>&product_type=<?php echo $product['variant_id']?>"
                                    class="select__number--plus cursor-pointer p-absolute d-flex align-center justify-center">
                                    <img src="./assets/images/icon/plus.svg" alt="" />
                                </a>
                            </div>
                            <div class="cart__delete cursor-pointer d-flex align-center justify-center">
                                <a
                                    href="site/handle/addtocart.php?delete=<?php echo $cart_item['product_id'] ?>&product_type=<?php echo $product['variant_id']?>">
                                    <img src="./assets/images/icon/delete.svg" alt="delete" />
                                </a>
                            </div>
                            <?php
                                    //}
                                    ?>
                        </div>
                    </div>
                    <div class="cart__total h4 ">
                        <?php echo (number_format(($product['product_price'] - ($product['product_price'] / 100 * $product['product_sale']))* $cart_item['product_quantity'])) . ' ₫' ?>
                    </div>
                </div>
                <?php

                        } else {
                            $validate = false;
                        ?>
                <div class="cart__item d-grid">
                    <div class="cart__image opacity-50">
                        <a href="index.php?page=product_detail&product_id=<?php echo $cart_item['product_id'] ?>"><img
                                class="w-100"
                                src="admin/modules/product/uploads/<?php echo $cart_item['product_image'] ?>"
                                alt="product" /></a>
                    </div>
                    <div class="cart__title">
                        <h3 class="cart__name h4 opacity-50"><?php echo $cart_item['product_name'] ?></h3>
                        <span class="cart__color color-wanning">Còn lại: <span
                                class="product__quantity"><?php echo $product['product_quantity'] ?></span> sản
                            phẩm</span>
                    </div>
                    <div class="cart__quantity">
                        <div class="cart__quantity--container d-flex align-center">
                            <div class="select__number p-relative">
                                <a href="site/handle/addtocart.php?div=<?php echo $cart_item['product_id'] ?>"
                                    class="select__number--minus cursor-pointer p-absolute d-flex align-center justify-center">
                                    <img src="./assets/images/icon/minus.svg" alt="" />
                                </a>
                                <input type="text" value="<?php echo $cart_item['product_quantity'] ?>"
                                    class="select__number--value heading-6 w-100 h-100" />
                                <a href="site/handle/addtocart.php?sum=<?php echo $cart_item['product_id'] ?>"
                                    class="select__number--plus cursor-pointer p-absolute d-flex align-center justify-center">
                                    <img src="./assets/images/icon/plus.svg" alt="" />
                                </a>
                            </div>
                            <div class="cart__delete cursor-pointer d-flex align-center justify-center">
                                <a href="site/handle/addtocart.php?delete=<?php echo $cart_item['product_id'] ?>">
                                    <img src="./assets/images/icon/delete.svg" alt="delete" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="cart__total h4 ">
                        <?php echo (number_format(($product['product_price'] - ($product['product_price'] / 100 * $product['product_sale']))* $cart_item['product_quantity'])) . ' ₫' ?>
                    </div>
                </div>
                <?php
                        }
                    }
                    ?>
            </div>
        </div>
        <div class="cart__footer w-100 h-100">
            <div class="cart__footer--total h4">
                TỔNG TIỀN: <?php echo number_format((float) $total) . '₫' ?>
            </div>
            <!-- <p class="cart__footer--context">
                    Thuế và phí vận chuyển được tính khi thanh toán
                </p> -->
            <?php

                if (isset($_SESSION['account_email'])) {
                    if ($validate == true) {
                ?>
            <a href="index.php?page=checkout" class="btn cart__btn btn__solid text-center">ĐẶT HÀNG</a>
            <?php } else {
                    ?>
            <button class="btn cart__btn btn__solid text-center opacity-50" onclick="showErrorMessage();">ĐẶT
                HÀNG</button>
            <?php
                    }
                } else {
                    ?>
            <a href="index.php?page=login"><button class="btn cart__btn btn__outline">ĐĂNG NHẬP ĐẶT HÀNG</button></a>
            <?php
                }
                ?>

        </div>
        <?php
        } else {
        ?>
        <h5 class="text-center">Không có sản phẩm nào trong giỏ hàng! </h5>
        <?php
        }
        ?>
    </div>
</section>
<!-- end cart -->
<script>
function showSuccessMessage() {
    toast({
        title: "Success",
        message: "Cập nhật thành công",
        type: "success",
        duration: 1000,
    });
}

function showErrorMessage() {
    toast({
        title: "Error",
        message: "Số sản phẩm không hợp lệ",
        type: "error",
        duration: 1000,
    });
}
</script>
<?php
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo '<script>';
    echo 'showSuccessMessage();';
    echo 'window.history.pushState(null, "", "index.php?page=cart");';
    echo '</script>';
} elseif (isset($_GET['message']) && $_GET['message'] == 'error') {
    echo '<script>';
    echo 'showErrorMessage();';
    echo 'window.history.pushState(null, "", "index.php?page=cart");';
    echo '</script>';
}
?>