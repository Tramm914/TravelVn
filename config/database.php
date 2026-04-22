<?php
class Database {
    private $host = "mysql-35ac1384-doantram0901-18fb.h.aivencloud.com";
    private $db_name = "defaultdb";
    private $username = "avnadmin";
    private $password = "AVNS_Ie7puDhztib91Fyx4pj";
private $port = "28476"; // Lấy trên Aiven, VD: 18452

    public function connect() {
        $conn = null;

        try {
            // Lấy đường dẫn tuyệt đối đến file ca.pem nằm cùng thư mục config
            $ca_cert = __DIR__ . '/ca.pem';
            
            // Khai báo DSN có thêm thuộc tính port
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            
            // Thêm mảng options để cấu hình SSL cho PDO
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_SSL_CA => $ca_cert,
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true
            );

            // Khởi tạo PDO với mảng options
            $conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $conn;
    }
}
?>