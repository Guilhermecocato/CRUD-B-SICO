<?php
// index.php
include 'db.php';

$query = $pdo->query('SELECT * FROM users');
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

$mensagem = isset($_GET['mensagem']) ? $_GET['mensagem'] : '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Bem vindo ao CRUD de Usuários</title>
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
        <?php if ($mensagem): ?>
            <p class="mensagem"><?php echo $mensagem; ?></p>
        <?php endif; ?>
        <h2>Lista de Usuários</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>Email</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo htmlspecialchars($usuario['full_name']); ?></td>
                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $usuario['id']; ?>" class="edit">Editar</a>
                    <a href="excluir.php?id=<?php echo $usuario['id']; ?>" class="delete" onclick="return confirm('Deseja mesmo excluir este usuário?');">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
