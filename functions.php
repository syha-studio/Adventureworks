<?php
//koneksi ke database ============================================================================
$conn = mysqli_connect("localhost","root","","adventureworks_dw");
//umum ===========================================================================================
function query ($query){
    global $conn;
    $result = mysqli_query($conn,$query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows [] = $row;
    }
    return $rows;
}
function cariproduction($keyword) {
    $query = "SELECT sum(OrderQty) c, sum(StockedQty) d, sum(scrappedQty) e, round(sum(productionCost),2) f FROM production_fact f 
                JOIN product p ON (f.product_key=p.id) WHERE category ='$keyword'";
    if ($keyword=='All'){
        $query = "SELECT sum(OrderQty) c, sum(StockedQty) d, sum(scrappedQty) e, round(sum(productionCost),2) f FROM production_fact";
    }
    return query($query);
}
function carisales($keyword) {
    $query = "SELECT sum(OrderQty) a, round(sum(LineTotal),2) b FROM sales_fact f 
                JOIN product p ON (f.product_key=p.id) WHERE category ='$keyword'";
    if ($keyword=='All'){
        $query = "SELECT sum(OrderQty) a, round(sum(LineTotal),2) b FROM sales_fact";
    }
    return query($query);
}
?>