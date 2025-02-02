<?
require "inc/init.php";
if (isset($_GET['id'])) {
    $conn = require("inc/db.php");
    $product = Product::getById($conn, $_GET['id']);
    if (!$product) {
        Dialog::show('Không tìm thấy sản phẩm');
        return;
    }
} else {
    Dialog::show('Vui lòng nhập ID');
    return;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try{
        $fullname = Uploadfile::process();
        if(!empty($fullname)){
            $oldimage = $product->imagefile;
            $product->imagefile = $fullname;
            $product->id = $_GET['id'];
            if($product->updateImage($conn, $_GET['id'], $fullname)){
                if($oldimage){
                    unlink("uploads/$oldimage");
                }
                header("Location:index.php");
                exit();
            }
        }  
    }catch(PDOException $e){
        Dialog::show($e->getMessage());
    }
}
?>
<? require "inc/header.php"; ?>

<div class="content">
    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Edit Image</legend>
            <? if ($product->imagefile) : ?>
                <div class="row">
                    <img src="uploads/<?=$product->imagefile ?>" width="180" height="180">
                </div>
            <? else : ?>
                <img src="images/noimage.jpg" width="180" height="180">
            <? endif; ?>
            <div class="row">
                <label for="file">File hình ảnh</label>
                <input type="file" name="file" id="file">
            </div>
            <div class="row">
                    <input class="btn" type="submit" value="Cập nhật"/>
                    <input class="btn" type="button" value="Thoát" 
                            onclick="parent.location='index.php'"/>       
                </div>
        </fieldset>
    </form>
</div>

<? require "inc/footer.php"; ?>