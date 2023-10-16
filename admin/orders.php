<?php
include("../db.php");
include "sidenav.php";
include "topheader.php";

error_reporting(0);

if (isset($_GET['action']) && $_GET['action'] != "" && $_GET['action'] == 'delete') {
    // Check if order_id is numeric and not empty
    if (isset($_GET['order_id']) && is_numeric($_GET['order_id']) && !empty($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $query = "DELETE FROM orders WHERE order_id = $order_id";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "Order deleted successfully.";
            // JavaScript redirection
            echo "<script>window.location.href = 'http://localhost/shop/admin/index.php?page=orders';</script>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Invalid or empty order_id.";
    }
}

?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="col-md-14">
            <div class="card ">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Orders / Page <?php echo $page;?> </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive ps">
                        <table class="table table-hover table-striped " id="ordertbl">
                            <thead class="">
                                <tr>
                                    <th>Ref</th>
                                    <th>Order</th>
                                    <th>Customer Info</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $result=mysqli_query($con,"select * from orders o inner join orders_info oi on oi.order_id= o.order_id ")or die ("query 1 incorrect.....");

                                while($row=mysqli_fetch_array($result))
                                {   
                                    echo "<tr>
                                        <td>{$row['ref_id']}</td>
                                        <td>
                                            <a data-toggle='collapse' href='#prod{$row['order_id']}' role='button' aria-expanded='false' aria-controls='prod{$row['order_id']}'>Orders <span><i class='fa fa-angle-down'></i></span></a>
                                            <div class='collapse' id='prod{$row['order_id']}'>";

                                    $prod = mysqli_query($con,"SELECT * FROM order_products op inner join products p on op.product_id = p.product_id where op.order_id = ".$row['order_id']);
                                    while($prow = mysqli_fetch_assoc($prod)){
                                        echo "<small>
                                                <p><b>Product:</b>{$prow['product_title']}</p>
                                                <p><b>Price:</b>{$prow['product_price']}</p>
                                                <p><b>Qty:</b>{$prow['qty']}</p>
                                                <p><b>Total Amount:</b>{$prow['amt']}</p>
                                            </small>
                                            <hr>";
                                    }
                                    echo "</div>
                                        </td>
                                        <td>
                                            <p><b>Name :</b>".ucwords($row['f_name'])."</p>
                                            <p><b>Address :</b>{$row['address']}</p>
                                            <p><b>Email :</b>{$row['email']}</p>
                                            <p><b>Contact # :</b>{$row['contact_no']}</p>
                                        </td>
                                        <td>";

                                    if($row['status'] == 0){
                                        echo "<div class='badge badge-danger'>Cancelled</div>";
                                    } elseif($row['status'] == 1) {
                                        echo "<div class='badge badge-info'>Pending</div>";
                                    } elseif($row['status'] == 2) {
                                        echo "<div class='badge badge-warning'>Shipped</div>";
                                    } elseif($row['status'] == 3) {
                                        echo "<div class='badge badge-success'>Delivered</div>";
                                    }
                                    

                                    

                                    if($row['status'] == 1) {
                                        echo "<button class='btn btn-sm btn-primary changestatus' data-stat='2' data-id='{$row['order_id']}'>Mark as Shipped</button>";
                                    } elseif($row['status'] == 2) {
                                        echo "<button class='btn btn-sm btn-primary changestatus' data-stat='3' data-id='{$row['order_id']}'>Mark as Delivered</button>";
                                    } elseif($row['status'] == 3) {
                                        echo "<div class='badge badge-success' data-id='{$row['order_id']}' disabled>Delivered</div>";
                                    }

                                    echo "</td>
                                        <td>
                                            <a class='btn btn-danger' href='orders.php?action=delete&order_id={$row['order_id']}'>Delete</a>";

                                    echo "</td>
                                        </tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('.changestatus').click(function() {
    var conf = confirm("Are you sure you want to change the status of this order?");
    if (conf == true) {
        start_load()
        $.ajax({
            url: 'orederstatsupdate.php',
            method: "POST",
            data: {
                status: $(this).attr('data-stat'),
                id: $(this).attr('data-id')
            },
            error: err => console.log(err),
            success: function(resp) {
                if (resp == 1) {
                    alert("Order updated successfully.");
                    location.reload();
                }
            }
        })
    }
})
</script>