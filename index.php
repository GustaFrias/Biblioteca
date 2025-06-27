<?php session_start();
    require_once "php/conexao/conexao.php";
?>

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
            <div class="logo">
                <a href="index.php">Leyo<span> +</span></a>
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav>
                <ul id="nav-list">
                    <li><a href="htmls/AboutUs.php">Sobre Nós</a></li>

                    <?php if (!isset($_SESSION['usuario']) && !isset($_SESSION['admin'])): ?>
                    <li><a href="htmls/cadastro.html">Cadastrar-se</a></li>
                    <li><a href="htmls/login.html">Login</a></li>
                    <?php else: ?>
                    <li>
                        <img src="img/iconLogin.png" alt="" id="icon-login"
                            style="width: 50px; height: auto; margin-top: -13px; margin-right: -30px;">
                    </li>
                    <li>
                        <a href="<?php echo isset($_SESSION['admin']) ? 'php/login&cadastro/admin.php' : '#'; ?>">
                            <?php
                                    if (isset($_SESSION['usuario'])) {
                                        echo htmlspecialchars($_SESSION['usuario']);
                                    } elseif (isset($_SESSION['admin'])) {
                                        echo 'Administrador';
                                    }
                                ?>
                        </a>
                    </li>
                    <li><a href="php/login&cadastro/logout.php">Sair</a></li>
                    <?php endif; ?>

                </ul>
            </nav>
        </header>

        <div class="home">
            <h2 class="titulo">ONDE LER É REALEZA E CADA PÁGINA, UM CONVITE AO ENCANTAMENTO.</h2>
            <div class="diminuicao">
                <span class="texto">
                    Descubra um espaço onde a elegância encontra a paixão pelos livros, e cada visita é uma experiência
                    única de conforto e inspiração.
                </span>
            </div>

            <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get" onsubmit="return validarBusca()">
                <div class="caixa-input">
                    <input type="text" id="barraBusca" name="busca" placeholder="Pesquise aqui" autocomplete="off"
                        oninput="buscarInstantaneamente()" />
                    <i class="fas fa-search"></i>
                </div>
            </form>
        </div>
    </div>
    
    <div class="carussel">
        <div class="principal" id="best-sellers">
            <section class="tela">
                <div class="separador" id="temas">
                    <h2 class="titulo">Os livros mais vendidos e amados pelos leitores</h2>
                    <p class="subtitle">Descubra o que está fazendo sucesso!</p>
                </div>

                <div class="books-container">
                    <button class="scroll-btn left">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div class="book-grid">
                        <?php
                       $idsDesejados = [1, 2, 3, 4, 5, 6]; // coloque os IDs desejados aqui

                        $placeholders = implode(',', array_fill(0, count($idsDesejados), '?'));

                        $sql = "SELECT livros.*, autores.nome AS nome_autor
                        FROM livros
                        LEFT JOIN autores ON livros.autor_id = autores.id
                        WHERE livros.id IN ($placeholders)
                        ORDER BY FIELD(livros.id, $placeholders)";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(array_merge($idsDesejados, $idsDesejados));
                        $livros = $stmt->fetchAll();

                        foreach ($livros as $livro):
                        ?>
                        <a href="htmls/moreInfo.php?id=<?= $livro['id'] ?>" class="book-card">
                            <div class="book-column-left">
                                <img src="uploads/<?= htmlspecialchars($livro['imagem']) ?>"
                                    alt="<?= htmlspecialchars($livro['titulo']) ?>">
                                <p class="book-author">
                                    <?= htmlspecialchars($livro['titulo']) ?>
                                </p>
                            </div>
                           
                        </a>
                        <?php endforeach; ?>
                    </div>

                    <button class="scroll-btn right">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>
        </div>
       
        <div class="principal" id="best-sellers">
            <section class="tela">
                <div class="separador" id="temas">
                    <h2 class="titulo">Outros livros da nossa livraria</h2>
                    <p class="subtitle">there will be a small title here</p>
                </div>

                <div class="books-container">
                    <button class="scroll-btn left">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div class="book-grid">
                        <?php
                        $sql = "SELECT livros.*, autores.nome AS nome_autor
                                FROM livros
                                LEFT JOIN autores ON livros.autor_id = autores.id
                                ORDER BY livros.id DESC
                                LIMIT 10"; 

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $livros = $stmt->fetchAll();

                        foreach ($livros as $livro):
                        ?>
                        <a href="htmls/moreInfo.php?id=<?= $livro['id'] ?>" class="book-card">
                            <div class="book-column-left">
                                <img src="uploads/<?= htmlspecialchars($livro['imagem']) ?>"
                                    alt="<?= htmlspecialchars($livro['titulo']) ?>">
<<<<<<< HEAD
                                 <p class="book-author">
=======
                                <p class="book-author">
>>>>>>> 617b381ed84741588e29a0563bf250c361a84d59
                                    <?= htmlspecialchars($livro['titulo']) ?>
                                </p>
                            </div>
                            
                        </a>
                        <?php endforeach; ?>
                    </div>

                    <button class="scroll-btn right">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>
        </div>
    </div>
    
   <div class="carussel">     <!-- romance -->
    <div class="principal" id="best-sellers">
        <section class="tela">
            <div class="separador" id="temas">
                <h2 class="titulo">Romance</h2>
            </div>

            <div class="books-container">
                <button class="scroll-btn left">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="book-grid">
                    <?php
                    $sql = "SELECT livros.*, autores.nome AS nome_autor
                            FROM livros
                            LEFT JOIN autores ON livros.autor_id = autores.id
                            WHERE livros.categoria_id = 2
                            ORDER BY livros.id DESC
                            LIMIT 10";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $livros = $stmt->fetchAll();

                    foreach ($livros as $livro):
                    ?>
<<<<<<< HEAD
                     <a href="htmls/moreInfo.php?id=<?= $livro['id'] ?>" class="book-card">
                            <div class="book-column-left">
                                <img src="uploads/<?= htmlspecialchars($livro['imagem']) ?>"
                                    alt="<?= htmlspecialchars($livro['titulo']) ?>">
                                 <p class="book-author">
                                    <?= htmlspecialchars($livro['titulo']) ?>
                                </p>
                            </div>
                            
                        </a>
=======
                    <a href="htmls/moreInfo.php?id=<?= $livro['id'] ?>" class="book-card">
                        <div class="book-column-left">
                            <img src="uploads/<?= htmlspecialchars($livro['imagem']) ?>"
                                alt="<?= htmlspecialchars($livro['titulo']) ?>">
                            <p class="book-author">
                                <?= htmlspecialchars($livro['titulo']) ?>
                            </p>
                        </div>
                    </a>
>>>>>>> 617b381ed84741588e29a0563bf250c361a84d59
                    <?php endforeach; ?>
                </div>

                <button class="scroll-btn right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </section>
    </div>
</div>

<div class="carussel">
    <div class="principal" id="best-sellers">
        <section class="tela">
            <div class="separador" id="temas">
                <h2 class="titulo">Fantasia</h2>
            </div>

            <div class="books-container">
                <button class="scroll-btn left">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="book-grid">
                    <?php
                    $sql = "SELECT livros.*, autores.nome AS nome_autor
                            FROM livros
                            LEFT JOIN autores ON livros.autor_id = autores.id
                            WHERE livros.categoria_id = 3
                            ORDER BY livros.id DESC
                            LIMIT 10";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $livros = $stmt->fetchAll();

                    foreach ($livros as $livro):
                    ?>
                     <a href="htmls/moreInfo.php?id=<?= $livro['id'] ?>" class="book-card">
                            <div class="book-column-left">
                                <img src="uploads/<?= htmlspecialchars($livro['imagem']) ?>"
                                    alt="<?= htmlspecialchars($livro['titulo']) ?>">
                                 <p class="book-author">
                                    <?= htmlspecialchars($livro['titulo']) ?>
                                </p>
                            </div>
                            
                        </a>
                    <?php endforeach; ?>
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
                    <h2 class="titulo">Um Pouco Sobre Nós</h2>
                </div>
                <div class="separador">
                    <span class="texto">
                        Mais que uma livraria, somos um refúgio elegante para quem ama livros e valoriza momentos de
                        calma e beleza. Inspirados pela realeza e guiados pela paixão pela leitura, criamos um espaço
                        onde sofisticação, conforto e cultura se encontram. Cada detalhe foi pensado com carinho para
                        oferecer uma experiência única. Quer saber como esse sonho ganhou vida? Conheça nossa história
                        completa na página Sobre Nós.
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
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </footer>

    <script src="styles/carussel.js"></script>
</body>

</html>