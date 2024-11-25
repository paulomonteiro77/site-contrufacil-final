<?php
include 'conexao.php';

$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);

$produtos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
} else {
    $produtos = null;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($produtos);
?>
