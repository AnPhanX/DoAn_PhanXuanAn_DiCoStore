<?php
	require('../../config/config.php');
    require('../../../system/library/tcpdf/tcpdf.php');

    $total=0;
    $order_code = $_GET['order_code'];
    $sql_order = "SELECT * FROM orders JOIN delivery ON orders.delivery_id = delivery.delivery_id WHERE orders.order_code = '" . $order_code . "' LIMIT 1";
    $query_order = mysqli_query($mysqli, $sql_order);
    $row_info = mysqli_fetch_array($query_order);
    // extend TCPF with custom functions
    class MYPDF extends TCPDF {
        
        // Load table data from file
        public function LoadData() {
            require('../../config/config.php');
            $order_code = $_GET['order_code'];
            $sql_order_detail_list = "SELECT od.order_detail_id, p.product_id,od.variant_id, p.product_name, od.order_code, od.product_quantity, od.product_price, od.product_sale, p.product_image FROM order_detail od JOIN product p ON od.product_id = p.product_id WHERE od.order_code = '" . $order_code . "' ORDER BY od.order_detail_id DESC";
            $query_order_detail_list = mysqli_query($mysqli, $sql_order_detail_list);
        
            $sql_order = "SELECT * FROM orders JOIN delivery ON orders.delivery_id = delivery.delivery_id WHERE orders.order_code = '" . $order_code . "' LIMIT 1";
            $query_order = mysqli_query($mysqli, $sql_order);
            return $query_order_detail_list;
            // $row_info = mysqli_fetch_array($query_order);
        }

        
        // Colored table
        public function ColoredTable($header,$data) {
            require('../../config/config.php');
            
            // Colors, line width and bold font
            $this->SetFillColor(40, 40, 40);
            $this->SetTextColor(255);
            $this->SetDrawColor(0, 0, 0);
            $this->SetLineWidth(0.3);
            $this->SetFont('dejavusans', 'B');
            // Header
            $w = array(10,10,80,15,10,23,33);
            $num_headers = count($header);
            for($i = 0; $i < $num_headers; ++$i) {
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
            }
            $this->Ln();
            // Color and font restoration
            $this->SetFillColor(224, 235, 255);
            $this->SetTextColor(0);
            $this->SetFont('');
            // Data
            $fill = 0;
            $i=0;
            foreach($data as $row) {
                $sql_variant = "SELECT * FROM product_size WHERE variant_id ='".$row['variant_id']."' LIMIT 1";
		        $query_variant = mysqli_query($mysqli, $sql_variant);
                $variant = mysqli_fetch_array($query_variant);
                $i++;
                $total+=($row['product_price'] - ($row['product_price'] / 100 * $row['product_sale']))*$row['product_quantity'];
                $this->Cell($w[0], 8, $i, 'LR', 0, 'C', $fill);
                $this->Cell($w[1], 8, $row["product_id"], 'LR', 0, 'C', $fill);
                $this->Cell($w[2], 8, $row["product_name"], 'LR', 0, 'L', $fill);
                $this->Cell($w[3], 8, $variant['variant_name'], 'LR', 0, 'C', $fill);
                $this->Cell($w[4], 8, $row["product_quantity"], 'LR', 0, 'C', $fill);
                $this->Cell($w[5], 8, number_format($row['product_price'] - ($row['product_price'] / 100 * $row['product_sale'])),'LR',0,'R',$fill);
                $this->Cell($w[6], 8, number_format(($row['product_price'] - ($row['product_price'] / 100 * $row['product_sale']))*$row['product_quantity']),'LR',0,'R',$fill);
                
                $this->Ln();
                $fill=!$fill;
            }
            // $this->Write(10,'Tổng tiền đơn hàng: '.number_format($total).'đ');
            $this->Cell(array_sum($w), 0, '', 'T');
            $this->Ln();
            $this->Cell(0,0,'TỔNG: '.number_format($total).' đ',0,0,'R');
        }

    

        
    }


    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetTitle('Hóa Đơn');
    
   
    // set default header data
     $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,'          HÓA ĐƠN DICO STORE    ', );
    
    // set header and footer fonts
    $pdf->setHeaderFont(Array('dejavusans', '', 16));
    // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    // set default monospaced font
    // $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // set auto page breaks
    // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // set image scale factor
    // $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    
    // ---------------------------------------------------------
    
    // set font
    $pdf->SetFont('dejavusans', '', 11);
    
    // add a page
    $pdf->AddPage();
    
	$pdf->Cell(0,0,"Tên người nhận: ".$row_info['delivery_name'],0,0,'L');
    $pdf->Cell(0,0,"Mã đơn hàng: ".$row_info['order_code'].'                   ',0,0,'R');
	$pdf->Ln(10);

	$pdf->Cell(0,0,"Điện thoại: ".$row_info['delivery_phone'],0,0,'L');
    $pdf->Cell(0,0,"Ngày lập: ".$row_info['order_date'],0,0,'R');
	$pdf->Ln(10);

	$pdf->Cell(0,0,"Địa chỉ: ".$row_info['delivery_address'],0,0,'L');
	$pdf->Ln(15);
    // column titles
    $header = array('STT', 'MÃ', 'TÊN SẢN PHẨM', 'SIZE','SL','GIÁ','TỔNG');
    
    // data loading
    $data = $pdf->LoadData();
    
    // print colored table
    $pdf->ColoredTable($header, $data);
    
    $pdf->Ln(10);
    $pdf->Cell(0,0,"...........ngày.....,tháng.....,năm.........",0,0,'R');
    $pdf->Ln(10);
    $pdf->Cell(0,0,"          KHÁCH HÀNG",0,0,'L');
    $pdf->Cell(0,0,"NGƯỜI LẬP HÓA ĐƠN         ",0,0,'R');
    // ---------------------------------------------------------
    
    // close and output PDF document
    $pdf->Output('pdf.pdf', 'I');
 
    ?>