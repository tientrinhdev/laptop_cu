<?
    include("inc/init.php");
    if (Auth::isLoggedIn() == false) {
        header("location:login.php");
        exit();
    }
    $username = $_SESSION['logged_in'];
    $passwordError = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $password = $_POST['password'];

        $conn = require("inc/db.php");
        $user = User::getByUsername($conn, $username, $password);
        if(!empty($user)){
            if($user->deleteUser($conn, $username)){
                Auth::logout();
                header("Location: index.php");
            }

        }else{
            Dialog::show("Mật khẩu không đúng.");
        }
    }
    include("inc/header.php");
?>


<!-- form xóa user-->
<div class="content">
    <form action="" method="post" id="frmDELUSER">
        <fieldset>
            <legend>Đổi mật khẩu</legend>

            <div class="row">
                <label for="username">Tên tài khoản</label>
                <span class="error">*</span>
                <input value="<? echo $username ?>" name="username" disabled id="username" type="text" placeholder="Tên tài khoản" >

            </div>
            <div class="row">
                <!-- Nhập lại mật khẩu -->
                <label for="password">Nhập lại mật khẩu</label>
                <span class="error">*</span>
                <input name="password" id="password" type="password" placeholder="Nhập lại mật khẩu">
                <? echo "<span class = 'error'>$passwordError</span>"; ?>
            </div>
            <div class="row">
                <input type="submit" class="btn" value="Xóa Tài Khoản">
                <input type="reset" class="btn" value="Thoát">
            </div>
        </fieldset>
    </form>
</div>

<?
include("inc/footer.php");
?>