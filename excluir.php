<?php
// excluir.php
include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
if ($stmt->execute([$id])) {
    $mensagem = "Usuário excluído com sucesso!";
    header("Location: index.php?mensagem=" . urlencode($mensagem));
    exit();
} else {
    $mensagem = "Erro ao excluir usuário.";
}

// Se o código acima falhar, ainda exibirá esta mensagem
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Excluir Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Bem vindo ao CRUD de Usuários</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="cadastrar.php">Cadastrar Usuário</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <h2>Excluir Usuário</h2>
        <?php if ($mensagem): ?>
            <p class="mensagem"><?php echo $mensagem; ?></p>
        <?php endif; ?>
        <p>Deseja mesmo excluir este usuário?</p>
        <form method="post">
            <input type="submit" value="Confirmar Exclusão">
            <a href="index.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
