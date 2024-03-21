<?  require "inc/init.php";
    require "inc/header.php";
    $usernameError = "";
    $passwordError = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $user_pattern = '/^[A-Za-z0-9]{5,}$/';
        if(!preg_match($user_pattern, $username)){
            $usernameError = "Tên người dùng phải có ít nhất 5 kí tự.";
        }
        $password = $_POST['password'];
        $pass_pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{5,}$/";
        if(!preg_match($pass_pattern, $password)){
            $passwordError = "Có ít nhất 8 ký tự, ít nhất 1 kí tự hoa, ít nhất 1 kí tự thường, ít nhất 1 chữ số, ít nhất 1 kí tự đặc biệt.";
        }
        else if($_POST['password'] != $_POST['rpassword']){
            $passwordError = "Thông tin mật khẩu nhập lại không đúng.";
        }
    if($usernameError == "" && $passwordError == ""){
        $conn = require"inc/db.php";
        $user = new User($username, $password);
        try{
            if($user->addUser($conn)){
                Dialog::show("Thêm người dùng thành công.");
            }else{
                Dialog::show("Không thể thêm người dùng.");
            }
        }
        catch(PDOException $e){
            Dialog::show($e->getMessage());

        }
    }else{
        Dialog::show('Error !!!');
    }
    }
?>

<div class="content">
    <form action="" method="post" id="frmADDUSER">
        <fieldset>
            <legend>Đăng Kí Người Dùng</legend>
            <div class="row">
                <!-- Nhập tên tài khoản -->
                <label for="username">Tên tài khoản</label>
                <input name="username" id="username" type="text" placeholder="Tên tài khoản">
                <?echo "<span class = 'error'> $usernameError </span>";?>
                <!-- Nhập mật khẩu -->
                <div class="row">
                    <label for="password">Mật khẩu</label>
                    <input name="password" id="password" type="password" placeholder="Mật khẩu">
                    <?echo "<span class = 'error'> $passwordError </span>";?>
                </div>
                <!-- Nhập lại mật khẩu -->
                <div class="row">
                    <label for="rpassword">Nhập lại mật khẩu</label>
                    <input name="rpassword" id="rpassword" type="password" placeholder="Nhập lại mật khẩu">
                    <?echo "<span class = 'error'> $passwordError </span>";?>
                </div>
                <div class="row">
                    <input  class="btn" type="submit" value="Đăng kí">
                    <input  class="btn" type="reset" value="Thoát">
                </div>
        </fieldset>
    </form>
</div>

<? require "inc/footer.php"; ?>