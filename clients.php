<?php
include 'dbconnect.php';
class Client{
// Lấy danh sách người dùng
function getUsers() {
    global $conn;
    $result = $conn->query("SELECT * FROM clients");
    $clients = [];
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
    return $clients;
}
public function getUserById($id)
    {
        // Lấy thông tin người dùng theo ID
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $client = $result->fetch_assoc();
        $stmt->close();

        return $client;
    }


// Cập nhật người dùng
function updateUser($id, $name, $email, $phone,$address) {
    global $conn;
    $stmt = $conn->prepare("UPDATE clients SET name = ?, email = ?, phone = ?,address = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
    $stmt->execute();
    $stmt->close();
}

// Xóa người dùng
function deleteUser($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
}
