<!DOCTYPE html>
<html lang="pt-br">
<?php
include("conexao.php");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$msg = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['criar'])) {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $duracao = trim($_POST['duracao']);    
    $data = trim($_POST['data']);
    $convidados = $_POST['usuarios'] ?? [];

    try {
        if (!empty($nome) && !empty($descricao) && !empty($duracao) && !empty($data)) {
            $stmt = $pdo->prepare("INSERT INTO eventos (usuario_id, nome, descricao, duracao, data) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$usuario_id, $nome, $descricao, $duracao, $data]);
            $evento_id = $pdo->lastInsertId(); 

            if (!empty($convidados)) {
                $stmt = $pdo->prepare("INSERT INTO confirmacoes (evento_id, usuario_id) VALUES (?, ?)");
                foreach ($convidados as $convidado_id) {
                    $stmt->execute([$evento_id, $convidado_id]);
                }
            }

            $msg = "Evento criado com sucesso!";
        } else {
            $msg = "Preencha todos os campos!";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $evento_id = $_POST['evento_id'];
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $duracao = trim($_POST['duracao']);    
    $data = trim($_POST['data']);

    if (!empty($nome) && !empty($descricao) && !empty($duracao) && !empty($data)) {
        $stmt = $pdo->prepare("UPDATE eventos SET nome=?, descricao=?, duracao=?, data=? WHERE id=? AND usuario_id=?");
        $stmt->execute([$nome, $descricao, $duracao, $data, $evento_id, $usuario_id]);
        $msg = "Evento atualizado com sucesso!";
    } else {
        $msg = "Preencha todos os campos!";
    }
}

if (isset($_GET['delete'])) {
    $evento_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM eventos WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$evento_id, $usuario_id]);
    $msg = "Evento excluído com sucesso!";
}

$edit_evento = null;
if (isset($_GET['edit'])) {
    $evento_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM eventos WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$evento_id, $usuario_id]);
    $edit_evento = $stmt->fetch();
}

$eventos = $pdo->prepare("SELECT * FROM eventos WHERE usuario_id = ?");
$eventos->execute([$usuario_id]);
?>
	
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="teste.css">
    <title>Admin - Eventos</title>
</head>
<body>
    <header>
        <h3>Admin - Eventos</h3>
        <nav>
            <a href="home.php">adm-eventos</a>
            <a href="usuarios.php">adm-usuarios</a>
            <a href="logout.php"> Sair</a>
        </nav>
    </header>

    <main class="criar-evento">
        <section>
            <form method="POST">
                <h1>Criar <span class="colorido">Celebração</span></h1>

                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">

                <input type="text" id="nome" name="nome" placeholder="Titulo" required>

                <input type="text" id="descricao" name="descricao"  placeholder="descricao" required>

                <input type="int" id="horario" name="duracao" required>

                <input type="date" id="data" name="data" placeholder="Quando?" required>

                <h2>Quem vai junto?</h2>
                <ol class="convidados_checkbox">
            <h3>Convidados:</h3>
                <?php
                    $usuarios = $pdo->query("SELECT id, nome FROM usuarios");
                    while ($row = $usuarios->fetch()) {
                        echo "<input type='checkbox' name='usuarios[]' value='{$row['id']}'> {$row['nome']}<br>";
                    }
                ?>
            
            <button type="submit" name="criar">Criar Evento</button>
        </form>
        </section>

        <h2>Lista de Eventos</h2>
        <ul>
            <?php while ($evento = $eventos->fetch()): ?>
                <li>
                    <strong><?= htmlspecialchars($evento['nome']) ?></strong> - <?= $evento['data'] ?>
                    <br><?= htmlspecialchars($evento['descricao']) ?>
                    <br>
                    <a href="?edit=<?= $evento['id'] ?>"> Editar</a> |
                    <a href="?delete=<?= $evento['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')"> Excluir</a>
                </li>
            <?php endwhile; ?>
        </ul>

        <?php if ($edit_evento): ?>
            <h2>Editar Evento</h2>
            <form method="POST">
                <input type="hidden" name="editar" value="1">
                <input type="hidden" name="evento_id" value="<?= $edit_evento['id'] ?>">
                <input type="text" name="nome" value="<?= $edit_evento['nome'] ?>" required>
                <input type="text" name="descricao" value="<?= $edit_evento['descricao'] ?>" required>
                <input type="text" name="duracao" value="<?= $edit_evento['duracao'] ?>" required>
                <input type="date" name="data" value="<?= $edit_evento['data'] ?>" required>
                <button type="submit"> Salvar Alterações</button>
                <a href="eventos.php"> Cancelar</a>
            </form>
        <?php endif; ?>
    </main>

    <footer>
        <p>Celebralize - Sistema de Eventos</p>
    </footer>
</body>
</html>