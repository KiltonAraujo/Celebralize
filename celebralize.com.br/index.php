<!DOCTYPE html>
<html lang="en">
<?php
include('conexao.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
	$stmt->execute([$email]);
	$usuario = $stmt->fetch();

	if ($usuario && password_verify($senha,$usuario['senha'])) {
		$_SESSION['usuario_id'] = $usuario['id'];
		header("Location: home.php");
		exit;
	} else {
		echo "Email ou senha incorretos!";
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
        <figure><img src="src/imagens/icones/celebralize.svg" alt="logo do Celebralize"></figure>
        <nav>
            <ol>
                <li><a href="home.php"><img src="src/imagens/icones/home.svg" alt="home"></a></li>
                <li><a href="Criar_evento.php"><img src="src/imagens/icones/criar-evento.svg" alt="crie um evento"></a></li>
                <li><a href="Meus_eventos.php"><img src="src/imagens/icones/eventos.svg" alt="seus eventos"></a></li>
                <li><a href="Eventos_convidados.php"><img src="src/imagens/icones/eventos-convidados.svg" alt="eventos que te convidaram"></a></li>
                <li><a href="#"><img src="src/imagens/icones/sair-icon.svg" alt="sair"></a></li>
            </ol>
        </nav>
    </header>
    <main class="criar-evento login">
        <section>
            <form method="POST">
                <h1>Venha <span class="colorido">Celebrar</span><br> com a gente!</h1>
                <input type="email" id="email" name="email" placeholder="email" required>
                <input type="password" id="senha" name="senha"  placeholder="senha" required>
                <p>Não possui uma conta? <a href="registrar.php" class="colorido">Registre-se</a></p>

                <button type="submit" class="botao"><a href="home.php">Entrar</a></button>
            </form>

            <figure class="destaque-login">
                <img src="src/imagens/backgrounds/destaque-conta.svg" alt="amigos">
            </figure>
        </section>
    </main>
    <footer>
        <h1><img src="src/imagens/icones/celebralize.svg" alt="logo do Celebralize"> <span class="colorido">Celebralize</span></h1>
        <nav>
            <ol>
                <li><a href="home.php">Home</a></li>
                <li><a href="Criar_evento.php">Criar</a></li>
                <li><a href="Meus_eventos.php">Meus eventos</a></li>
                <li><a href="Eventos_convidados.php">Eventos</a></li>
            </ol>
        </nav>

        <ol class="sociais">
            <li><a><img src="src/imagens/icones/linkedin.svg" alt="linkedin"></a></li>
            <li><a><img src="src/imagens/icones/facebook.svg" alt="facebook"></a></li> 
            <li><a><img src="src/imagens/icones/twitter.svg" alt="twitter/X"></a></li>
            <li><a><img src="src/imagens/icones/instagram.svg" alt="instagram"></a></li>
        </ol>
    </footer>
</body>
</html>
