<?
class User
{
    public $id;
    public $username;
    public $password;

    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    // Xác thực người dùng
    public static function authenticate($conn, $username, $password)
    {
        $sql = "select * from users where username=:username";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            $hash = $user->password;
            return password_verify($password, $hash);
        }
    }

    //Kiểm tra
    private function validate()
    {
        return $this->username != '' && $this->password != '';
    }

    //Thêm một người dùng mới
    public function addUser($conn)
    {
        if ($this->validate()) {
            $sql = "insert into users(username, password)
                    values (:username, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $hash = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
            return $stmt->execute();
        } else
            return false;
    }
    //lấy ra thông tin 1 người theo username và password
    public static function getByUsername($conn, $username, $password)
    {

        try {
            $sql = "select * from users where username=:username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user->password)) {
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    //Thay đổi mật khẩu
    public function updatePassWord($conn, $username, $password)
    {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "update users
            set password =:password where username=:username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //Xóa user

    public function deleteUser($conn, $username)
    {
        try {
            $sql = "delete from users where username=:username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
