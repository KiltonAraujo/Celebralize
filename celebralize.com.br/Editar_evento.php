<!DOCTYPE html>
<html lang="en">
<?php
include('conexao.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID do evento não fornecido.";
    exit;
}

$evento_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT * FROM eventos WHERE id = ? AND usuario_id = ?");
$stmt->execute([$evento_id, $usuario_id]);
$evento = $stmt->fetch();

if (!$evento) {
    echo "Evento não encontrado ou você não tem permissão para editá-lo.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $data = trim($_POST['data']);
    $duracao = trim($_POST['duracao']);
    $descricao = trim($_POST['descricao']);

    if (!empty($nome) && !empty($data) && !empty($duracao) && !empty($descricao)) {
        try {
            $stmt = $pdo->prepare("UPDATE eventos SET nome = :nome, data = :data, duracao = :duracao, descricao = :descricao WHERE id = :id");
            $stmt->execute([
                ':nome' => $nome,
                ':data' => $data,
                ':duracao' => $duracao,
                ':descricao' => $descricao,
                ':id' => $evento_id
            ]);

            header("Location: home.php");
            exit;
        } catch (PDOException $e) {
            echo "Erro ao atualizar: " . $e->getMessage();
        }
    } else {
        echo "Preencha todos os campos!";
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="teste.css">
    <link rel="icon" type="image/x-icon" href="src/imagens/icones/celebralize.svg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Gerenciar Eventos</title>
</head>
<body>
<header>
        <figure><img src="<?= 'src/imagens/icones/celebralize.svg' ?>" alt="logo do Celebralize"></figure>
        <nav>
            <ol>
                <li><a href="home.php"><img src="<?= 'src/imagens/icones/home.svg' ?>" alt="home"></a></li>
                <li><a href="Criar_evento.php"><img src="<?= 'src/imagens/icones/criar-evento.svg' ?>" alt="crie um evento"></a></li>
                <li><a href="Meus_eventos.php"><img src="<?= 'src/imagens/icones/eventos.svg' ?>" alt="seus eventos"></a></li>
                <li><a href="Eventos_convidados.php"><img src="<?= 'src/imagens/icones/eventos-convidados.svg' ?>" alt="eventos que te convidaram"></a></li>
                <li><a href="logout.php"><img src="<?= 'src/imagens/icones/sair-icon.svg' ?>" alt="sair"></a></li>
            </ol>
        </nav>
    </header>

    <main>
        <h1>Editar Eventos</h1>
        <form method="POST">
            <input type="text" name="nome" value="<?= htmlspecialchars($evento['nome']) ?>" required>
            <input type="text" name="descricao" value="<?= htmlspecialchars($evento['descricao']) ?>" required>
            <input type="text" name="duracao" value="<?= htmlspecialchars($evento['duracao']) ?>" required>
            <input type="date" name="data" value="<?= htmlspecialchars($evento['data']) ?>" required>
            <button type="submit">Salvar Alterações</button>
            <a href="home.php">Cancelar</a>
        </form>

        <h3>Convidar Usuários</h3>
        <form method="POST" action="convidar_usuarios.php">
            <input type="hidden" name="evento_id" value="<?= $evento_id ?>">
            <?php
            $usuarios = $pdo->query("SELECT id, nome FROM usuarios");
            while ($row = $usuarios->fetch()) {
                echo "<input type='checkbox' name='usuarios[]' value='{$row['id']}'> {$row['nome']}<br>";
            }
            ?>
            <button type="submit" class="botao">Salvar alterações <img src="<?= 'src/imagens/icones/criar-colorido.svg' ?>" alt="criar"></button>
        </form>
    </main>

    <footer>
        <h1><img src="<?= 'src/imagens/icones/celebralize.svg' ?>" alt="logo do Celebralize"> <span class="colorido">Celebralize</span></h1>
        <nav>
            <ol>
                <li><a href="home.php">Home</a></li>
                <li><a href="Criar_evento.php">Criar</a></li>
                <li><a href="Meus_eventos.php">Meus eventos</a></li>
                <li><a href="Eventos_convidados.php">Eventos</a></li>
            </ol>
        </nav>
        <ol class="sociais">
            <li><a><img src="<?= 'src/imagens/icones/linkedin.svg' ?>" alt="linkedin"></a></li>
            <li><a><img src="<?= 'src/imagens/icones/facebook.svg' ?>" alt="facebook"></a></li> 
            <li><a><img src="<?= 'src/imagens/icones/twitter.svg' ?>" alt="twitter/X"></a></li>
            <li><a><img src="<?= 'src/imagens/icones/instagram.svg' ?>" alt="instagram"></a></li>
        </ol>
    </footer>
</body>
</html>
