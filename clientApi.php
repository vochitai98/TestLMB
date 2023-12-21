<?php

include_once 'Clients.php';

$client = new Client();
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Kiểm tra xem có tham số 'id' hay không
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            $user = $client->getUserById($userId);
            echo json_encode($user);
        } else {
            // Nếu không có 'id', lấy danh sách người dùng
            $clients = $client->getUsers();
            echo json_encode($clients);
        }
        break;

    case 'POST':
        //$data = json_decode(file_get_contents('php://input'), true);
        $userId = isset($_GET['id']) ? $_GET['id'] : null;
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        if ($userId !== null) {
            // Cập nhật người dùng
            $client->updateUser($userId, $name, $email, $phone,$address);
            echo json_encode(['message' => 'User updated']);
        } else {
            // Trả về thông báo lỗi nếu dữ liệu hoặc ID không đúng
            echo json_encode(['message' => 'Invalid data or user ID']);
        }
        break;
    case 'DELETE':
        // Xóa người dùng
        $data = json_decode(file_get_contents('php://input'), true);
        $userId = isset($_GET['id']) ? $_GET['id'] : null;
        $client->deleteUser($userId);
        echo json_encode(['message' => 'User deleted']);
        break;
    default:
        echo json_encode(['message' => 'Invalid method']);
        break;
}
