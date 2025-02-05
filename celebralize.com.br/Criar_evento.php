<!DOCTYPE html>
<html lang="en">
<?php
include('conexao.php');
ini_set('session.use_only_cookies',1);
ini_set('session.use_trans_sid',0);
session_start();

if (!isset($_SESSION['usuario_id'])) {
	header("Location: index.php");
	$usuario_id = $_POST['usuario_id'];
	var_dump($_SESSION);
	exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$usuario_id = $_POST['usuario_id'];
	$nome = $_POST['nome'];
	$data = $_POST['data'];
	$duracao = $_POST['duracao'];
	$descricao = $_POST['descricao'];
	$convidados = $_POST['usuarios'] ?? [];

	try {
		$pdo->beginTransaction();
	
		$stmt = $pdo->prepare("INSERT INTO eventos (usuario_id,nome,data,duracao,descricao) VALUES (?,?,?,?,?)");
		$stmt->execute([$usuario_id,$nome,$data,$duracao,$descricao]);
		$evento_id = $pdo->LastInsertId();

		if (!empty($convidados)) {
			$stmt = $pdo->prepare("INSERT INTO confirmacoes (evento_id,usuario_id) VALUES (?,?)");
			foreach ($convidados as $convidado_id) {
				$stmt->execute([$evento_id, $convidado_id]);
			}
		}

		$pdo->commit();
		echo "Evento criado";
	} catch (Exception $e) {
		$pdo->rollBack();
		echo "Erro: " . $e->getMessage();
	}
}
?>	
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="teste.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="src/imagens/icones/celebralize.svg">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Criar evento</title>
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
                <li><a href="logout.php"><img src="src/imagens/icones/sair-icon.svg" alt="sair"></a></li>
            </ol>
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
	           <?php

		    $usuarios = $pdo->query("SELECT id, nome FROM usuarios");
		    while ($row = $usuarios->fetch()) {
			echo "<input type='checkbox' name='usuarios[]' value='{$row['id']}'> {$row['nome']}<br>";
		    }
		    
		    ?>
                </ol>
                <button type="submit" class="botao">Criar Evento<img src="src/imagens/icones/criar-colorido.svg" alt="criar"></button>
            </form>
        </section>
    </main>
    <footer>
        <h1><img src="src/imagens/icones/celebralize.svg" alt="logo do Celebralize"> <span class="colorido">Celebralize</span></h1>
        <nav>
            <ol>
                <li><a href="home.php">Home</a></li>
                <li><a href="Criar_evento.php">Criar</a></li>
                <li><a href="Meus_eventos.php">Meus eventos</a></li>
                <li><a href="Eventos_convidados.php.php">Eventos</a></li>
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
