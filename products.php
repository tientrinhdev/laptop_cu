<?
    require "inc/init.php";
    $conn = require ("inc/db.php");
    $total = Product::count($conn);
    $limit = 5;
    $currentpage = $_GET['page'] ?? 1;
    $config = [
        'total' =>$total,
        'limit' => $limit,
        'full' => false
    ];
    
    $products = Product::getPaging($conn, $limit, ($currentpage - 1) * $limit);

    require "inc/header.php";
?>
<div class="content">
    <?php foreach($products as $p): ?>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <img src="uploads/<?php echo $p->imagefile ?>" alt="Ảnh">
                    <?echo $p->productname?>
                </div>
                <div class="flip-card-back">
                    <h2><?php echo $p->branch ?></h2>
                    
                    <p><?php echo $p->price ?></p>
                </div>
            </div>
        </div>
    <? endforeach; ?>
    <br>
    <br>
    <br>
</div>

<div class="content">
    <?
    //Khởi tạo chuyển trang
    $page = new Pagination($config);

    echo $page->getPagination();
    ?>
</div>

<? require "inc/footer.php"; ?>
