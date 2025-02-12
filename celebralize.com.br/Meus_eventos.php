<!DOCTYPE html>
<html lang="en">
<?php
include('conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$meus_eventos = $pdo->prepare("SELECT * FROM eventos WHERE usuario_id = ?");
$meus_eventos->execute([$usuario_id]);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="teste.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/x-icon" href="src/imagens/icones/celebralize.svg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Meus eventos</title>
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
        <section class="destaque-home">
            <div id="seus-eventos">
                <h1>Seus <span class="colorido">Eventos</span></h1>
                <a href="Criar_evento.php" class="botao">Criar evento <img src="<?= 'src/imagens/icones/criar-colorido.svg' ?>" alt="criar"></a>
            </div>
            <figure>
                <img src="<?= 'src/imagens/backgrounds/destaque-evento.svg' ?>" alt="figuras ilustrativas bem coloridas">
            </figure>
        </section>
        <section class="meus-eventos">
            <ol class="card-evento">
                <?php while ($evento = $meus_eventos->fetch()): ?>
                    <li>
                        <div class="configs">
                            <figure>
                                <img src="<?= 'src/imagens/icones/festa.svg' ?>" alt="ícone de evento">
                                <button type="button" class="opcoes"><img src="<?= 'src/imagens/icones/_. ..svg' ?>" alt="opções"></button>
                            </figure>
                        </div>
                        <section>
                            <div class="data">
                                <p><?= $evento['data'] ?></p>
                                <figure>
                                    <img src="<?= 'src/imagens/icones/people.svg' ?>" alt="participantes">
                                    <p>54</p>
                                </figure>
                            </div>
                            <h3><?= $evento['nome'] ?></h3>
                            <div class="data-hora">
                                <p><img src="<?= 'src/imagens/icones/local-azul.svg' ?>" alt="local"> <?= $evento['descricao'] ?></p>
                                <p><img src="<?= 'src/imagens/icones/horario-azul.svg' ?>" alt="horário"> <?= $evento['duracao'] ?></p>
                            </div>
                        </section>
                        <div class="acoes">
                            <a href="Editar_evento.php">Editar</a>
                            <button type="submit" class="excluir"><a href="delete_event.php?id=<?= $evento['id'] ?>">Excluir</a></button>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ol>
        </section>
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
    <script>
        document.querySelectorAll('.opcoes').forEach(button => {
            button.addEventListener('click', () => {
                const acoesDiv = button.closest('li').querySelector('.acoes');
                acoesDiv.classList.toggle('visivel');
            });
        });
    </script>
</body>
</html>
