<!DOCTYPE html>
<html lang="em">
<?php
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nome = $_POST['nome'];
	$telefone = $_POST['telefone'];
	$email = $_POST['email'];
	$senha = password_hash($_POST['senha'],PASSWORD_DEFAULT);

	try {
		$stmt = $pdo->prepare("INSERT INTO usuarios (nome, telefone,email,senha) VALUES (?,?,?,?)");
		$stmt ->execute([$nome,$telefone,$email,$senha]);
		echo "Cadastro realizado com sucesso! <a href=''>Fazer login</a>";
	} catch (Exception $e) {
		echo "Erro ao cadastrar: " . $e->getMessage();
	}
}
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
    <main class="criar-evento login">
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

                <p>Já possui uma conta? <a href="index.php" class="colorido">Entre!</a></p>
                <button type="submit" class="botao">Registrar</button>
            </form>
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
</body>
</html>
