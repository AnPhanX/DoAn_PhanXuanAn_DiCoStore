<?php
require '../system/core/carbon/autoload.php';

use Carbon\Carbon;
use Carbon\CarbonInterval;

    $sql = "DELETE FROM metrics WHERE 1";
    $sql_query = mysqli_query($mysqli, $sql);
    

    $sql_orders = "SELECT * FROM orders WHERE order_status =3";
    $query_get_orders = mysqli_query($mysqli, $sql_orders);
    
    while($order_item = mysqli_fetch_array($query_get_orders)){
        $od_date = $order_item['order_date'];
        $od_code = $order_item['order_code'];
        $od_amount = $order_item['total_amount'];

        $sql_order_detail = "SELECT SUM(product_quantity) AS pd_quantity FROM order_detail WHERE order_code = '$od_code' GROUP BY order_code";
        $query_od_detail = mysqli_query($mysqli, $sql_order_detail);
        $od_detail = mysqli_fetch_array($query_od_detail);
        $order_quantity = $od_detail['pd_quantity'];

        $now =  date('Y-m-d', strtotime($od_date));
    

        $sql_thongke = "SELECT * FROM metrics WHERE metric_date = '$now'";
        $query_thongke = mysqli_query($mysqli, $sql_thongke);

        if (mysqli_num_rows($query_thongke) == 0) {
            $metric_sales = $od_amount;
            $metric_quantity = $order_quantity;
            $metric_order = 1;
            $sql_update_metrics = "INSERT INTO metrics (metric_date, metric_order, metric_sales, metric_quantity) 
                        VALUE ('$od_date', '$metric_order', '$metric_sales', '$metric_quantity')";
            mysqli_query($mysqli, $sql_update_metrics);
        } elseif (mysqli_num_rows($query_thongke) != 0) {
            while ($row_tk = mysqli_fetch_array($query_thongke)) {
                $metric_sales = $row_tk['metric_sales'] + $od_amount;
                $metric_quantity = $row_tk['metric_quantity'] + $order_quantity;
                $metric_order = $row_tk['metric_order'] + 1;
                $sql_update_metrics = "UPDATE metrics SET metric_order = '$metric_order', metric_sales = '$metric_sales', metric_quantity = '$metric_quantity' WHERE metric_date = '$now'";
                mysqli_query($mysqli, $sql_update_metrics);
            }
        }
    }


$now = Carbon::now('Asia/Ho_Chi_Minh')->subdays(-1)->toDateString();
$subdays = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
$query_order = mysqli_query($mysqli, "SELECT * FROM orders WHERE order_date BETWEEN '$subdays' AND '$now'");
$order_count = mysqli_num_rows($query_order);

$sql_sales = "SELECT * FROM orders WHERE order_date BETWEEN '$subdays' AND '$now'";
$query_sales = mysqli_query($mysqli, $sql_sales);
$sales = 0;
while ($order = mysqli_fetch_array($query_sales)) {
    $sales += $order['total_amount'];
}

$query_product = mysqli_query($mysqli, "SELECT * FROM product WHERE product_status = 1 ");
$product_count = mysqli_num_rows($query_product);

$query_customer = mysqli_query($mysqli, "SELECT * FROM customer");
$customer_count = mysqli_num_rows($query_customer);
?>
<div class="row">
    <div class="col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <h3 class="box-title">Sản Phẩm</h3>
                    <span class="box-number color-t-yellow"><?php echo $product_count ?></span>
                    <!-- <div class="box-number-new">
                        <p>Sản phẩm đang bán</p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <h3 class="box-title">Số đơn hàng mới trong ngày</h3>
                    <span class="box-number color-t-blue"><?php echo $order_count ?></span>
                    <!-- <div class="box-number-new">
                        <p>Đơn hàng trong ngày</p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <h3 class="box-title">Số khách hàng mới trong tháng</h3>
                    <span class="box-number color-t-red"><?php echo $customer_count ?></span>
                    <!-- <div class="box-number-new">
                        <p>khách hàng của tháng</p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <h3 class="box-title">Doanh thu hôm nay</h3>
                    <span class="box-number text-success"><?php echo number_format($sales) ?>đ</span>
                    <!-- <div class="box-number-new">
                        <p>Thống kê ngày hôm nay</p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- <div class="col-lg-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <div id="donutchart"></div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <h4>Thống kê doanh số  <b class="text-success"> 1 </b>  tháng qua</h4>
                    <div id="homechart" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php


$sql_order_metric = "SELECT * FROM orders WHERE order_date BETWEEN '$subdays' AND '$now'";
$query_metric = mysqli_query($mysqli, $sql_order_metric);

$order_live = 0;
$order_online = 0;
$order_cancel = 0;

while ($val = mysqli_fetch_array($query_metric)) {
    if ($val['order_type'] == 5) {
        $order_live++;
    } elseif ($val['order_type'] == 4 || $val['order_type'] == 1 || $val['order_type'] == 2 || $val['order_type'] == 3) {
        $order_online++;
    }
    if ($val['order_status'] == -1) {
        $order_cancel++;
    }
}


?>

<script>
    $(document).ready(function() {

        thongke();


        // var donut = new Morris.Donut({
        //     element: 'donutchart',
        //     data: [{
        //             label: "Đơn hàng tại quầy",
        //             value: <?php echo $order_live ?>
        //         },
        //         {
        //             label: "Đơn hàng online",
        //             value: <?php echo $order_online ?>
        //         },
        //         {
        //             label: "Đơn hàng hủy",
        //             value: <?php echo $order_cancel ?>
        //         }
        //     ]
        // });

        var char = new Morris.Line({

            element: 'homechart',

            xkey: 'date',

            // ykeys: ['date', 'order', 'sales', 'quantity'],
            ykeys: ['order', 'sales'],

            // labels: ['Ngày', 'Đơn hàng', 'Doanh thu', 'Số lượng']
            labels: ['Số đơn hàng', 'Doanh thu'],
            lineColors:['gray','#0e9684']
        });

        function thongke() {
            var thoigian = '28ngay';
            $.ajax({
                url: "modules/thongke.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    thoigian: thoigian
                },
                success: function(data) {
                    char.setData(data);
                }
            })
        }
    });
</script>