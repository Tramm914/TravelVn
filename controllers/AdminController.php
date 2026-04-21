<?php
require_once "../config/database.php";
require_once "../models/User.php";

class AdminController {

    private $user;

    public function __construct(){
        $db = (new Database())->connect();
        $this->user = new User($db);
    }

    public function index(){
        $users = $this->user->getAllUsers();
        include "../views/admin/users.php";
    }

    public function create(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $this->user->createUser($_POST);
            header("Location: admin.php");
            exit();
        }
        include "../views/admin/create_user.php";
    }

    public function edit(){
        $id = $_GET['id'] ?? null;
        $tab = $_GET['tab'] ?? 'customer';

        $user = $this->user->getUserById($id);

        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $this->user->updateUser($id,$_POST);
            header("Location: admin.php?tab=$tab");
            exit();
        }

        include "../views/admin/edit_user.php";
    }

    public function delete(){
        $id = $_GET['id'] ?? null;
        $tab = $_GET['tab'] ?? 'customer';

        if (!$id) die("Thiếu ID");

        if ($_SESSION['user']['user_id'] == $id) {
            die("Không thể xóa chính mình");
        }

        $this->user->deleteUser($id);

        header("Location: admin.php?tab=$tab");
        exit();
    }

    public function toggle(){
        $id = $_GET['id'] ?? null;
        $tab = $_GET['tab'] ?? 'customer';

        $this->user->toggleStatus($id);

        header("Location: admin.php?tab=$tab");
        exit();
    }

    public function reset(){
        $id = $_GET['id'] ?? null;
        $tab = $_GET['tab'] ?? 'customer';

        $this->user->resetPassword($id);

        header("Location: admin.php?tab=$tab");
        exit();
    }
}
?>