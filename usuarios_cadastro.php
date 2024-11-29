<?php
include 'usuarios_controller.php';

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Pega todos os usuários para preencher os dados da tabela
$users = getUsers();

// Variável que guarda o ID do usuário que será editado
$userToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
// e se há um ID para edição de usuário
if (isset($_GET['edit'])) {
    $userToEdit = getUser($_GET['edit']);
}
?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuários</title>

    <!-- Link para o Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        function clearForm() {
            document.getElementById('nome').value = '';
            document.getElementById('telefone').value = '';
            document.getElementById('email').value = '';
            document.getElementById('senha').value = '';
            document.getElementById('id').value = '';
        }
    </script>
</head>
<body>
    <div class="container mt-5">

        <!-- Título da Página -->
        <h2 class="mb-4">Cadastro de Usuários</h2>

        <!-- Formulário de Cadastro de Usuários -->
        <form method="POST" action="" class="mb-5">
            <input type="hidden" id="id" name="id" value="<?php echo $userToEdit['id'] ?? ''; ?>">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $userToEdit['nome'] ?? ''; ?>" required>
            </div>

            <!-- Telefone -->
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="text" id="telefone" name="telefone" class="form-control" value="<?php echo $userToEdit['telefone'] ?? ''; ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $userToEdit['email'] ?? ''; ?>" required>
            </div>

            <!-- Senha -->
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
            </div>

            <!-- Botões -->
            <div class="d-flex justify-content-between">
                <button type="submit" name="save" class="btn btn-primary">Salvar</button>
                <button type="submit" name="update" class="btn btn-warning">Atualizar</button>
                <button type="button" onclick="clearForm()" class="btn btn-secondary">Novo</button>
            </div>
        </form>

        <!-- Tabela de Usuários -->
        <h2 class="mb-4">Usuários Cadastrados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Faz um loop para preencher a tabela com os usuários -->
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['nome']; ?></td>
                        <td><?php echo $user['telefone']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <a href="?edit=<?php echo $user['id']; ?>" class="btn btn-info btn-sm">Editar</a>
                            <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');" class="btn btn-danger btn-sm">Excluir</a>
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
