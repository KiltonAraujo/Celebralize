<!DOCTYPE html>
<html lang="en">
<?php
include('conexao.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
	header("Location: login.php");
	exit;
}

$usuario_id = $_SESSION['usuario_id'];

$meus_eventos = $pdo->prepare("SELECT * FROM eventos WHERE usuario_id = ?");
$meus_eventos->execute([$usuario_id]);


$convites = $pdo->prepare("SELECT eventos.* FROM confirmacoes JOIN eventos ON confirmacoes.evento_id = eventos.id WHERE confirmacoes.usuario_id = ?");
$convites->execute([$usuario_id]);

if (isset($_GET['delete'])) {
    $evento_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM eventos WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$evento_id, $usuario_id]);
    $msg = "Evento excluído com sucesso!";
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
    <title>Celebralize</title>
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
            <div>
                <h1>Organizar nunca foi tão<br> fácil, <span class="colorido">Celebrar nunca foi<br> tão divertido!</span></h1>
                <p>Com o Celebralize, você pode criar eventos de forma simples, reunir seus amigos sem complicações e aproveitar cada instante ao máximo.</p>
                <a href="Criar_evento.php" class="botao">Criar evento <img src="src/imagens/icones/criar-colorido.svg" alt="criar"></a>
            </div>

            <figure>
                <img src="src/imagens/backgrounds/destaque-home.svg" alt="figuras ilustrativas bem coloridas">
            </figure>
        </section>
        <section id="eventos-convidados">
            <div class="ver-mais">
             <h2>Seus<span class="colorido">Eventos</span></h2>
             <a href="Meus_eventos.php" style="color: #356773;">Ver mais</a>
            </div>
            <ol class="card-evento meu">
            <?php while ($evento = $meus_eventos->fetch()): ?>
			        <li>
                    		<div class="configs">
                        	<figure>
                            		<img src="src/imagens/icones/festa.svg">
                            		<button type="button" class="opcoes"><img src="src/imagens/icones/_. ..svg"></button>
                        	</figure>
                    		</div>
                    		<section>
                        		<div class="data">
                            			<p ><?= $evento['data']?></p>
                            			<figure>
                                			<img src="src/imagens/icones/people.svg">
                                			<p>54</p>
                            			</figure>
                        		</div>
                        
                        		<h3><?= $evento['nome']?></h3>
                        		<div class="data-hora">
                            			<p><img src="src/imagens/icones/local-azul.svg"><?= $evento['descricao']?></p>
                           			 <p><img src="src/imagens/icones/horario-azul.svg"><?= $evento['duracao']?></p>
                        		</div>
                    		</section>
                    		<div class="acoes">
                        		<a href="Editar_evento.php?id=<?= $evento['id'] ?>">Editar</a>
                        		<a href="?delete=<?= $evento['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
                    		</div>
                	</li>
		        <?php endwhile; ?>
 
                
            </ol>
         </section>

        <section id="eventos-convidados">
           <div class="ver-mais">
            <h2><span class="colorido">Celebrações</span> que você foi convidado</h2>
            <a href="Eventos_convidados.php">Ver mais</a>
           </div>
            <ol class="card-evento">

            <?php while ($evento = $convites->fetch()): ?>
                	<li>

                    	<div class="configs">
                        	<figure>
					 <img src="src/imagens/icones/chapeu-festa.svg">
                        	</figure>
                    	</div>
                    	<section>
                        	<div class="data">
                            	<p ><?= $evento['data'] ?></p>
                            	<figure>
                                	<img src="src/imagens/icones/people.svg">
                                	<p>54</p>
                            	</figure>
                        	</div>

                       	 	<h3><?= $evento['nome']?></h3>
                       		<div class="data-hora">
                            		<p><img src="src/imagens/icones/local-vermelho.svg"><?= $evento['descricao']?></p>
                            		<p><img src="src/imagens/icones/horario-vermelho.svg"><?= $evento['duracao']?></p>
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
