<!DOCTYPE html>
<html lang="en">
<?php
include('conexao.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
	header("Location: index.php");
	exit;
}

$usuario_id = $_SESSION['usuario_id'];

$convites = $pdo->prepare("SELECT eventos.* FROM confirmacoes JOIN eventos ON confirmacoes.evento_id = eventos.id WHERE confirmacoes.usuario_id = ?");
$convites->execute([$usuario_id]);

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="teste.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="src/imagens/icones/celebralize.svg">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Eventos convidados</title>
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
            <h1><span class="colorido">Celebrações</span><br> que você foi convidado</h1>

            <figure>
                <img src="<?= 'src/imagens/backgrounds/destaque-evento.svg' ?>" alt="figuras ilustrativas bem coloridas">
            </figure>
        </section>
        <section id="eventos-convidados" class="meus-eventos" >
            <ol class="card-evento">
		<?php while ($evento = $convites->fetch()): ?>
                	<li>

                    	<div class="configs">
                        	<figure>
					 <img src="<?= 'src/imagens/icones/chapeu-festa.svg' ?>">
                        	</figure>
                    	</div>
                    	<section>
                        	<div class="data">
                            	<p ><?= $evento['data'] ?></p>
                            	<figure>
                                	<img src="<?= 'src/imagens/icones/people.svg' ?>">
                                	<p>54</p>
                            	</figure>
                        	</div>

                       	 	<h3><?= $evento['nome']?></h3>
                       		<div class="data-hora">
                            		<p><img src="<?= 'src/imagens/icones/local-vermelho.svg' ?>"><?= $evento['descricao']?></p>
                            		<p><img src="<?= 'src/imagens/icones/horario-vermelho.svg' ?>"><?= $evento['duracao']?></p>
                       	 	</div>
                    	</section>
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
</body>
</html>
