<?php
include 'produtos_controller.php';

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Pega todos os produtos para preencher os dados da tabela
$produtos = getProdutos();

// Variável que guarda o ID do produto que será editado
$produtoToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
// e se há um ID para edição de produto
if (isset($_GET['edit'])) {
    $produtoToEdit = getProduto($_GET['edit']);
}
?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>

    <!-- Link para o Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        function clearForm() {
            document.getElementById('nome').value = '';
            document.getElementById('descricao').value = '';
            document.getElementById('marca').value = '';
            document.getElementById('modelo').value = '';
            document.getElementById('valorUnitario').value = '';
            document.getElementById('categoria').value = '';
            document.getElementById('ativo').value = '';
            document.getElementById('url_img').value = '';
            document.getElementById('id').value = '';
        }
    </script>
</head>
<body>
    <div class="container mt-5">

        <!-- Título da Página -->
        <h2 class="mb-4">Cadastro de Produtos</h2>

        <!-- Formulário de Cadastro de Produtos -->
        <form method="POST" action="" class="mb-5">
            <input type="hidden" id="id" name="id" value="<?php echo $produtoToEdit['id'] ?? ''; ?>">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $produtoToEdit['nome'] ?? ''; ?>" required>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" required><?php echo $produtoToEdit['descricao'] ?? ''; ?></textarea>
            </div>

            <!-- Marca -->
            <div class="mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" value="<?php echo $produtoToEdit['marca'] ?? ''; ?>" required>
            </div>

            <!-- Modelo -->
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo $produtoToEdit['modelo'] ?? ''; ?>" required>
            </div>

            <!-- Valor Unitário -->
            <div class="mb-3">
                <label for="valorUnitario" class="form-label">Valor Unitário:</label>
                <input type="number" step="0.01" id="valorUnitario" name="valorUnitario" class="form-control" value="<?php echo $produtoToEdit['valorUnitario'] ?? '0.00'; ?>" required>
            </div>


            <!-- Categoria -->
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" value="<?php echo $produtoToEdit['categoria'] ?? ''; ?>" required>
            </div>

            <!-- Ativo -->
            <div class="mb-3">
                <label for="ativo" class="form-label">Ativo:</label>
                <select id="ativo" name="ativo" class="form-control" required>
                    <option value="1" <?php echo isset($produtoToEdit['ativo']) && $produtoToEdit['ativo'] == 1 ? 'selected' : ''; ?>>Sim</option>
                    <option value="0" <?php echo isset($produtoToEdit['ativo']) && $produtoToEdit['ativo'] == 0 ? 'selected' : ''; ?>>Não</option>
                </select>
            </div>

            <!-- URL da Imagem -->
            <div class="mb-3">
                <label for="url_img" class="form-label">URL da Imagem:</label>
                <input type="text" id="url_img" name="url_img" class="form-control" value="<?php echo $produtoToEdit['url_img'] ?? ''; ?>" required>
            </div>

            <!-- Botões -->
            <div class="d-flex justify-content-between">
                <button type="submit" name="save" class="btn btn-primary">Salvar</button>
                <button type="submit" name="update" class="btn btn-warning">Atualizar</button>
                <button type="button" onclick="clearForm()" class="btn btn-secondary">Novo</button>
            </div>
        </form>

        <!-- Tabela de Produtos -->
        <h2 class="mb-4">Produtos Cadastrados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Categoria</th>
                    <th>Valor Unitário</th>
                    <th>Ativo</th>
                    <th>Imagem</th>
                </tr>
            </thead>
            <tbody>
                <!-- Faz um loop para preencher a tabela com os produtos -->
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo $produto['id']; ?></td>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $produto['marca']; ?></td>
                        <td><?php echo $produto['modelo']; ?></td>
                        <td><?php echo $produto['categoria']; ?></td>
                        <td><?php echo number_format(floatval($produto['valorUnitario'] ?? 0), 2, ',', '.'); ?></td>                       
                        <td><?php echo $produto['ativo'] ? 'Sim' : 'Não'; ?></td>
                        <td><img src="<?php echo $produto['url_img'] ?? 'caminho/para/imagem/default.jpg'; ?>" alt="Imagem do produto" width="100" height="100"></td>
                        <td>
                            <a href="?edit=<?php echo $produto['id']; ?>" class="btn btn-info btn-sm">Editar</a>
                            <a href="?delete=<?php echo $produto['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <!-- Link para os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
<?php include 'footer.php'; ?>
