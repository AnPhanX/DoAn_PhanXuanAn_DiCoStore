<?php
if (isset($_POST['customer_add'])) {
    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];

    $sql_insert_customer = "INSERT INTO customer(customer_name, customer_email, customer_phone, customer_address)
        VALUE('" . $customer_name . "','" . $customer_email . "','" . $customer_phone . "','" . $customer_address . "')";
    $query_insert_customer = mysqli_query($mysqli, $sql_insert_customer);
}
?>
<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.113115808304!2d105.80123181437827!3d21.02815949317594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab424a50fff9%3A0xbe3a7f3670c0a45f!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBHaWFvIHRow7RuZyBW4bqtbiB04bqjaQ!5e0!3m2!1svi!2s!4v1664623059752!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
</div>
<!-- start contact -->
<section class="contact pd-top">
    <div class="container">
        <div class="contact__container">
            <p style="text-align: center;">
            <span style="font-family:Arial,Helvetica,sans-serif;"><span style="font-size:18px;">---<br>
<strong>CHI NHÁNH HÀ NỘI:</strong></span><br>
<span style="font-size:14px;">49-51 Hồ Đắc Di, Phường&nbsp;Nam Đồng, Quận&nbsp;Đống Đa</span><br>
<span style="font-size:18px;">---<br>
<strong>CHI NHÁNH HƯNG YÊN:</strong></span><br>
<span style="font-size:14px;">PT.TV 136 - Mega Grand World - Ocean Park, Quận Văn Giang<br>
<strong>---</strong></span><br>
<span style="font-size:18px;"><strong>CHI NHÁNH BIÊN HÒA:</strong></span><br>
<span style="font-size:14px;">151A Phan Trung, Phường Tân Mai, Tp. Biên Hòa, Tỉnh Đồng Nai<br>
<strong>---</strong></span><br>
</p>
            <!-- <div class="contact__form pd-section">
                <form action="" method="POST">
                    <div class="row contact__input--double">
                        <div class="col" style="--w-lg: 6">
                            <div class="contact__input">
                                <input class="w-100 btn" type="text" name="customer_name" placeholder="Tên khách hàng" />
                            </div>
                        </div>
                        <div class="col" style="--w-lg: 6;">
                            <div class="contact__input">
                                <input class="w-100 btn" type="email" name="customer_email" placeholder="Email" />
                            </div>
                        </div>
                        <div class="col" style="--w-lg: 12;">
                            <div class="contact__input">
                                <input class="w-100 btn" type="text" name="customer_phone" placeholder="Số điện thoại" />
                            </div>
                        </div>
                        <div class="col" style="--w-lg: 12;">
                            <div class="contact__textarea w-100 h-100">
                                <textarea class="w-100 h-100 btn" name="customer_address" id="" cols="30" rows="10" placeholder="Địa chỉ"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn contact__btn" name="customer_add" type="submit">
                                Gửi
                            </button>
                        </div>
                    </div>
                </form>
            </div> -->
        </div>
    </div>
</section>
<!-- end contact -->