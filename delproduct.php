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
    $product->id = $_GET['id'];
    $oldimage = $product->imagefile;
    if ($product->deleteById($conn, $_GET['id'])) {
        if ($oldimage) {
            unlink("uploads/$oldimage");
        }
        header("Location:index.php");
        return;
    }
}

require "inc/header.php";
?>

<!-- Form thông tin -->
<div class="content">
    <form method="post" id="frmDELPRODUCT">
        <fieldset>
            <legend>Xóa Sản Phẩm</legend>
            <div class="row">
                <label for="productname">Tên Sản Phẩm</label>
                <span class="error">*</span>
                <input type="text" name="productname" id="productname" value="<?= htmlspecialchars($product->productname) ?>">
            </div>

            <div class="row">
                <label for="branch">Hãng</label>
                <span class="error">*</span>
                <input type="text" name="branch" id="branch" value="<?= htmlspecialchars($product->branch) ?>">
            </div>


            <div class="row">
                <label for="description">Description</label>
                <span class="error">*</span>
                <input type="text" name="description" id="description" value="<?= htmlspecialchars($product->description) ?>">
            </div>

            <div class="row">
                <label for="price">Giá</label>
                <span class="error">*</span>
                <input type="text" name="price" id="price" value="<?= htmlspecialchars($product->price) ?>">
            </div>

            <? if ($product->imagefile) : ?>
                <div class="row">
                    <label for="author">Hình ảnh:</label>
                </div>
                <div class="row">
                    <img src="uploads/<? echo $product->imagefile ?>" width="100">
                </div>
            <? else : ?>
                <div class="row">
                    <label for="author">Hình ảnh:</label>
                </div>
                <div class="row">
                    <img src="images/noimage.jpg" width="100">
                </div>
            <? endif; ?>

            <div class="row">
                <input class="btn" type="submit" value="Xóa" />
                <input class="btn" type="button" value="Thoát" 
                onclick="parent.location='index.php'" />
            </div>
        </fieldset>
    </form>
</div>

<?
require "inc/footer.php";
?>

<script>
    $(document)
        .ready(function() {
            $('#frmDELPRODUCT')
                .submit(function(e) {
                    e.preventDefault();
                    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm?")) {
                        var frm = $('<form>');
                        frm.attr('method', 'post');
                        frm.attr('action', $(this).attr('href'));
                        frm.appendTo('body');
                        frm.submit();
                    }
                });
        })
</script>