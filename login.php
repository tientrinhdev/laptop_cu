<? require "inc/init.php";
require "inc/header.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = require "inc/db.php";
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (User::authenticate($conn, $username, $password)) {
        Auth::login($username);
        header("Location:index.php");
    } else {
        Dialog::show("Sai tên người dùng hoặc mật khẩu");
    }
}
?>



<!-- form -->
<div class="content">
    <form action="" method="post" id="frmLOGIN">
        <fieldset>
            <legend>Đăng nhập</legend>
            <div class="row">
                <!-- nhập tên người dùng -->
                <label for="username">Tên tài khoản</label>
                <span class="error">*</span>
                <input name="username" id="username" type="text" placeholder="Tên tài khoản">
               
            </div>
             <!-- nhập mật khẩu -->
            <div class="row">
                <label for="password">Mật khẩu</label>
                <span class="error">*</span>
                <input name="password" id="password" type="password" placeholder="Mật khẩu">
            </div>
            <div class="row">
                <input type="submit" class="btn" value="Đăng nhập">
                <input type="reset" class="btn" value="Thoát">
            </div>
        </fieldset>
    </form>
</div>

<? require "inc/footer.php"; ?>