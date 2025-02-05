<!DOCTYPE html>
<html lang="pt-br">
    <?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['criar'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); 

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, telefone, senha_hash) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nome, $email, $telefone, $senha])) {
            $msg = "Usuário cadastrado!";
        } else {
            $msg = "Erro ao cadastrar!";
        }
    } else {
        $msg = "Preencha todos os campos!";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);

    if (!empty($nome) && !empty($email)) {
        $stmt = $pdo->prepare("UPDATE usuarios SET nome=?, email=?, telefone=? WHERE id=?");
        $stmt->execute([$nome, $email, $telefone, $id]);
        $msg = "Usuário atualizado!";
    } else {
        $msg = "Preencha todos os campos!";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $msg = "Usuário excluído!";
}

$edit_usuario = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $edit_usuario = $stmt->fetch();
}

$usuarios = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="teste.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/x-icon" href="src/imagens/icones/celebralize.svg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Celebralize!</title>
</head>
<body>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="teste.css">
    <title>Admin - Usuarios</title>
</head>
<body>
    <header>
        <h3>Admin - Usuarios</h3>
        <nav>
            <a href="home.php">adm-eventos</a>
            <a href="usuarios.php">adm-usuarios</a>
            <a href="logout.php"> Sair</a>
        </nav>
    </header>

    <main class="criar-evento">
    <h1>Gerenciar Usuários</h1>

    <?php if (isset($msg)) echo "<p>$msg</p>"; ?>

    <h2>Adicionar Usuário</h2>
        <section>
            <figure>
                <img src="src/imagens/backgrounds/destaque-conta.svg" alt="amigos">
            </figure>
            <form method="POST">
                <h1>Venha <span class="colorido">Celebrar</span><br> com a gente!</h1>
                <input type="text" id="nome" name="nome" placeholder="nome" required>
                <input type="email" id="email" name="email" placeholder="email" required>
                <input type="number" id="telefone" name="telefone"  placeholder="telefone" required>
                <input type="password" id="senha" name="senha"  placeholder="senha" required>

                <p>Já possui uma conta? <a href="index.html" class="colorido">Entre!</a></p>

                <button type="submit" class="botao">Registrar Usuario</button>
            </form>
        </section>
    

    <h2>Lista de Usuários</h2>
    <ul>
        <?php while ($usuario = $usuarios->fetch()): ?>
            <li>
                <div class="configs">
                    <section>
                    <div class="data">
                        <strong><?= htmlspecialchars($usuario['nome']) ?></strong> - <?= htmlspecialchars($usuario['email']) ?>
                        <br><?= htmlspecialchars($usuario['telefone'] ?: "Não informado") ?>
                        <br>
                        <a href="?edit=<?= $usuario['id'] ?>"> Editar</a> |
                        <a href="?delete=<?= $usuario['id'] ?>" onclick="return confirm('Tem certeza?')"> Excluir</a>
                    </div>
                    </section>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>

    <?php if ($edit_usuario): ?>
        <h2>Editar Usuário</h2>
        <form method="POST" class="criar-evento">
            <input type="hidden" name="id" value="<?= $edit_usuario['id'] ?>">
            <input type="text" name="nome" value="<?= $edit_usuario['nome'] ?>" required>
            <input type="email" name="email" value="<?= $edit_usuario['email'] ?>" required>
            <input type="text" name="telefone" value="<?= $edit_usuario['telefone'] ?>">
            <button type="submit" name="editar">Salvar</button>
            <a href="usuarios.php">Cancelar</a>
        </form>
    <?php endif; ?>
    </main>
</body>
</html>
