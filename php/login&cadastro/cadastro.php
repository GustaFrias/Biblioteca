<?php
require '../conexao/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>leyo ++</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="styles/index.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Leyo+</title>
</head>

<body>
    <div class="principal" id="tela">
        <header>
            <!-- Hamburguer -->
            <div class="logo">
                <a href="index.php"> Leyo<span> +</span> </a>
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav>
                <ul id="nav-list">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="htmls/AboutUs.html">Sobre Nós</a></li>
                    <li><a href="htmls/cadastro.html">Cadastrar-se</a></li>
                    <li><a href="htmls/login.html">Login</a></li>
                </ul>
            </nav>

        </header>

        <div class="home">
            <h2 class="titulo">ONDE LER É REALEZA E CADA PÁGINA, UM CONVITE AO ENCANTAMENTO.</h2>
            <div class="diminuicao"><span class="texto">Descubra um espaço onde a elegância encontra a paixão pelos
                    livros, e cada visita é uma experiência única de conforto e inspiração.</span></div>
                    
                    <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get" onsubmit="return validarBusca()">
                        <div class="caixa-input">
                         <input type="text" id="barraBusca" name="busca" placeholder="Pesquise aqui" autocomplete="off" oninput="buscarInstantaneamente()"/>
                            <i class="fas fa-search"></i>
                         </div>             
                    </form>
        </div>
    </div>

    <div class="carussel">
        <div class="principal" id="best-sellers">
            <section class="tela">
                <div class="separador" id="temas">
                    <h2 class="titulo">Best Sellers Of The Library</h2>
                    <p class="subtitle">Os livros mais amados pelos nossos leitores</p>
                </div>

                <div class="books-container">
                    <button class="scroll-btn left">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div class="book-grid">
                        <div class="book-card">
                            <div class="book-info">
                                <h3 class="book-title">Dom Casmurro</h3>
                                <p class="book-description">A clássica história de Bentinho e Capitu, cheia de dúvidas e
                                    ciúmes.</p>
                                <p class="book-author">Machado de Assis</p>
                                <p class="book-price">R$ 39,90</p>
                            </div>
                        </div>

                        <div class="book-card">
                            <div class="book-info">
                                <h3 class="book-title">O Pequeno Príncipe</h3>
                                <p class="book-description">A jornada filosófica de um príncipe por diferentes planetas.
                                </p>
                                <p class="book-author">Antoine de Saint-Exupéry</p>
                                <p class="book-price">R$ 29,90</p>
                            </div>
                        </div>

                        <div class="book-card">
                            <div class="book-info">
                                <h3 class="book-title">1984</h3>
                                <p class="book-description">Um clássico distópico sobre vigilância e controle
                                    governamental.</p>
                                <p class="book-author">George Orwell</p>
                                <p class="book-price">R$ 45,90</p>
                            </div>
                        </div>

                        <div class="book-card">
                            <div class="book-info">
                                <h3 class="book-title">Orgulho e Preconceito</h3>
                                <p class="book-description">O romance clássico de Jane Austen sobre Elizabeth Bennet e
                                    Mr. Darcy.</p>
                                <p class="book-author">Jane Austen</p>
                                <p class="book-price">R$ 37,50</p>
                            </div>
                        </div>

                        <div class="book-card">
                            <div class="book-info">
                                <h3 class="book-title">Cem Anos de Solidão</h3>
                                <p class="book-description">A saga da família Buendía na mítica cidade de Macondo.</p>
                                <p class="book-author">Gabriel García Márquez</p>
                                <p class="book-price">R$ 49,90</p>
                            </div>
                        </div>
                    </div>

                    <button class="scroll-btn right">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>
        </div>
    </div>

    <div class="principal" id="index">
        <div class="degrade">
            <section class="tela">
                <div class="separador">
                    <h2 class="titulo">
                        Um Pouco Sobre Nós
                    </h2>
                </div>
                <div class="separador">
                    <span class="texto">
                        Mais que uma livraria, somos um refúgio elegante para quem ama livros e valoriza momentos de calma e
                        beleza. Inspirados pela realeza e guiados pela paixão pela leitura, criamos um espaço onde
                        sofisticação, conforto e cultura se encontram. Cada detalhe foi pensado com carinho para oferecer
                        uma experiência única. Quer saber como esse sonho ganhou vida? Conheça nossa história completa na
                        página Sobre Nós.
                    </span>
                </div>
            </section>
        </div>
    </div>

    <footer>
        <div id="footer_items">
            <span id="copyright">
                © 2025 <span class="">Leyo</span><span class="">+</span>
            </span>
            <div class="footer_infos">
                <div class="">Entre em Contato:</div>
                <div class="">(11) 98765-4321</div>
                <div class="">Leyo+</div>
            </div>
            <div class="social-media-buttons">
                <a href="">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
            </div>
        </div>
    </footer>
</body>

<script src="styles/carussel.js"></script>

</html>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if ($senha !== $confirma_senha) {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Vish!',
                text: 'As senhas não estão iguais.'
            }).then(() => {
                window.location.href = '../../index.php';
            });
        </script>";
        exit;
    }

    $sqlCheck = "SELECT id FROM usuarios WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'E-mail já cadastrado.'
            }).then(() => {
                window.location.href = '../../index.php';
            });
        </script>";
        exit;
    }

    $sql = "INSERT INTO usuarios (nome, email, senha) 
            VALUES (:nome, :email, :senha)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);


    if ($stmt->execute()) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Cadastro realizado!',
                text: 'Redirecionando para o login...',
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '../../htmls/login.html';
            });
        </script>";
        exit;
    } else {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Erro ao cadastrar no banco de dados.'
            }).then(() => {
                window.location.href = '../../index.php';
            });
        </script>";
        exit;
    }
}
?>

</body>
</html>
