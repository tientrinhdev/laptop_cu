<? require "inc/init.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $conn = require("inc/db.php");
        try {
            $fullname = Uploadfile::process();
            if(!empty($fullname)){
                $productname = $_POST['productname'];
                $branch = $_POST['branch'];
                $description = $_POST['description'];
                $price = $_POST['price'];
            
                $product = new Product($productname, $branch, $description, $price, $fullname);
                
                if($product->add($conn)){
                    header("location:index.php");
                }else{
                    unlink("uploads/$fullname");
                }
            }
        } catch (Exception $e) {
            Dialog::show($e->getMessage());
        }
    }
?>
<? require "inc/header.php" ?>

<div class="content">
    <form action="" method="post" id="frmADDPRODUCT" enctype="multipart/form-data">
        <fieldset>
            <legend>Thêm Sản Phẩm</legend>
            <div class="row">
                <label for="productname">Tên Sản Phẩm</label>
                <span class="error">*</span>
                <input name="productname" id="productname" type="text" placeholder="Tên Sản Phẩm">
            </div>

            <div class="row">
                <label for="branch">Hãng</label>
                <span class="error">*</span>
                <input name="branch" id="branch" type="text" placeholder="Hãng">
            </div>

            <div class="row">
                <label for="description">Mô tả</label>
                <span class="error">*</span>
                <input name="description" id="description" type="text" placeholder="Mô tả">
            </div>


            <div class="row">
                <label for="price">Giá</label>
                <span class="error">*</span>
                <input name="price" id="price" type="text" placeholder="Giá">
            </div>

            <div class="row">
                <label for="file">File hình ảnh</label>
                <input name="file" id="file" type="file">
            </div>
            <div class="row">
                <input type="submit" class="btn" value="Save">
                <input type="reset" class="btn" value="Cancel">
            </div>
        </fieldset>
    </form>
</div>

<? require "inc/footer.php" ?>