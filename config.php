<!-- Arquivo para conexão do banco de dados -->
<?php
    $host = 'localhost';
    $dbname = 'sistema_vendas';
    $username = 'root';
    $password = ''; 

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erro: " . $e->getMessage());
    }
?>
