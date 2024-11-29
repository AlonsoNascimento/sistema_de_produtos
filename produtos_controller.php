<?php
include 'db.php';

// Função para salvar um novo produto
function saveProduto($nome, $descricao, $marca, $modelo, $valorUnitario, $categoria, $ativo, $url_img) {
    global $conn;
    $valorUnitario = is_numeric($valorUnitario) ? floatval($valorUnitario) : 0.00;
    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, marca, modelo, valorUnitario, categoria, ativo, url_img) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssddis", $nome, $descricao, $marca, $modelo, $valorUnitario, $categoria, $ativo, $url_img);
    return $stmt->execute();
}

// Função para obter todos os produtos
function getProdutos() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Função para obter um produto específico pelo id
function getProduto($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Função para atualizar um produto existente
function updateProduto($id, $nome, $descricao, $marca, $modelo, $valorUnitario, $categoria, $ativo, $url_img) {
    global $conn;
    $valorUnitario = is_numeric($valorUnitario) ? floatval($valorUnitario) : 0.00;
    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, descricao = ?, marca = ?, modelo = ?, valorUnitario = ?, categoria = ?, ativo = ?, url_img = ? WHERE id = ?");
    $stmt->bind_param("ssssdsisi", $nome, $descricao, $marca, $modelo, $valorUnitario, $categoria, $ativo, $url_img, $id);
    return $stmt->execute();
}

// Função para excluir um produto
function deleteProduto($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        $valorUnitario = isset($_POST['valorUnitario']) ? $_POST['valorUnitario'] : null;
        saveProduto($_POST['nome'], $_POST['descricao'], $_POST['marca'], $_POST['modelo'], $valorUnitario, $_POST['categoria'], isset($_POST['ativo']) ? 1 : 0, $_POST['url_img']);
    } elseif (isset($_POST['update'])) {
        $valorUnitario = isset($_POST['valorUnitario']) ? $_POST['valorUnitario'] : null;
        updateProduto($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['marca'], $_POST['modelo'], $valorUnitario, $_POST['categoria'], isset($_POST['ativo']) ? 1 : 0, $_POST['url_img']);
    }
}


// Processamento da exclusão
if (isset($_GET['delete'])) {
    deleteProduto($_GET['delete']);
}
?>
