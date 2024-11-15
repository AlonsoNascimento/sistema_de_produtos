<?php 
    include 'principal_controller.php'; 
    include 'header.php'; 

    // Definindo a variável $nome (exemplo: pode vir de um banco de dados ou sessão)
    $nome = "Alonso"; // Você pode modificar isso ou obter de uma variável de sessão ou banco de dados
?>

<div class="flex-grow-1">
        <!-- Conteúdo da página vai aqui -->
        <h2>Olá, <?php echo htmlspecialchars($nome); ?>!</h2>

        <form method="POST" action="">
            <input type="submit" name="logout" value="Logout">
        </form>
</div>

<?php include 'footer.php'; ?>
