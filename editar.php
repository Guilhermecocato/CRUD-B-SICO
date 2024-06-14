<?php
// editar.php
include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header('Location: index.php');
    exit();
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_completo = $_POST['nome_completo'];
    $email = $_POST['email'];
    $senha = $_POST['senha'] ? password_hash($_POST['senha'], PASSWORD_BCRYPT) : $usuario['password'];

    $stmt = $pdo->prepare('UPDATE users SET full_name = ?, email = ?, password = ? WHERE id = ?');
    if ($stmt->execute([$nome_completo, $email, $senha, $id])) {
        $mensagem = "Usuário atualizado com sucesso!";
        header("Location: index.php?mensagem=" . urlencode($mensagem));
        exit();
    } else {
        $mensagem = "Erro ao atualizar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
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
        <h2>Editar Usuário</h2>
        <?php if ($mensagem): ?>
            <p class="mensagem"><?php echo $mensagem; ?></p>
        <?php endif; ?>
        <form method="post">
            <div>
                <label for="nome_completo">Nome Completo:</label>
                <input type="text" id="nome_completo" name="nome_completo" value="<?php echo htmlspecialchars($usuario['full_name']); ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>
            <div>
                <label for="senha">Nova Senha ('Deixe em branco para não alterar'):</label>
                <input type="password" id="senha" name="senha">
            </div>
            <div>
                <input type="submit" value="Atualizar">
            </div>
        </form>
    </div>
</body>
</html>
