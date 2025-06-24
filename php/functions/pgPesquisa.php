<?php session_start();?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../../styles/pgPesquisa.css">
    <title>Leyo+ - Pesquisa</title>
</head>

<body>
    <header class="navbar">
        <!-- Menu Hamburguer -->
        <div class="logo">
            <a href="../../index.php"> Leyo<span> +</span> </a>
        </div>
        <div class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div>
            <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get" onsubmit="return validarBusca()">
                <input type="text" id="barraBusca" name="busca" placeholder="Pesquise aqui" autocomplete="off"
                    value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>" />
            </form>
        </div>
        <nav>
            <ul id="nav-list">
                 <?php if (!isset($_SESSION['usuario']) && !isset($_SESSION['admin'])): ?>
    <li><a href="htmls/cadastro.html">Cadastrar-se</a></li>
    <li><a href="htmls/login.html">Login</a></li>
<?php else: ?>
    <li><a href="../..">Home</a></li>
    <li><a href="../../htmls/AboutUs.php">sobre nós</a></li>
        <img src="../../img/iconLogin.png" alt="" id="icon-login"
             style="width: 50px; height: auto; margin-top: -13px; margin-right: -30px;">
    </li>
    <li>
        <?php if (isset($_SESSION['admin'])): ?>
            <a href="../login&cadastro/admin.php">Administrador</a>
        <?php elseif (isset($_SESSION['usuario'])): ?>
            <?= htmlspecialchars($_SESSION['usuario']) ?>
        <?php endif; ?>
    </li>
    <li><a href="php/login&cadastro/logout.php">Sair</a></li>
<?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="container">
        <?php
        require '../conexao/conexao.php';

        if (isset($_GET['busca']) && !empty(trim($_GET['busca']))) {
            $busca = "%" . trim($_GET['busca']) . "%";
            $sql = "SELECT livros.*, autores.nome AS nome_autor 
                    FROM livros 
                    LEFT JOIN autores ON livros.autor_id = autores.id 
                    WHERE livros.titulo LIKE :busca OR autores.nome LIKE :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo '<div class="resultados-container">';
                echo '<h2>Resultados da pesquisa para: "' . htmlspecialchars(trim($_GET['busca'])) . '"</h2>';
                echo '<div class="livros-grid">';
                
                while ($livro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='card'>";
                    echo "<a href='../../htmls/moreInfo.php?id=" . htmlspecialchars($livro['id']) . "'>";
                    if (!empty($livro['imagem'])) {
                        echo "<img src='../../uploads/" . htmlspecialchars($livro['imagem']) . "' class='capaLivros' alt='" . htmlspecialchars($livro['titulo']) . "'><br>";
                    } else {
                        echo "<div class='capa-placeholder'></div>";
                    }
                    echo "<h3>" . htmlspecialchars($livro['titulo']) . "</h3>";
                    echo "</a>";
                    echo "</div>";
                }
                
                echo '</div></div>';
            } else {
                echo '<div class="nenhum-resultado">';
                echo '<p>Nenhum livro encontrado para: "' . htmlspecialchars(trim($_GET['busca'])) . '"</p>';
                echo '<p>Tente usar termos diferentes ou verifique a ortografia.</p>';
                echo '</div>';
            }
        } else {
            echo '<div class="nenhum-termo">';
            echo '<p>Digite um termo de pesquisa na barra acima para encontrar livros.</p>';
            echo '</div>';
        }
        ?>
    </main>

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
    

    <script>
        // Menu Hamburguer
        const menuToggle = document.getElementById('menu-toggle');
        const navList = document.getElementById('nav-list');

        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            navList.classList.toggle('active');
        });

        // Validação da busca
        function validarBusca() {
            const termo = document.getElementById('barraBusca').value.trim();
            if (termo === '') {
                alert('Por favor, digite um termo para pesquisar.');
                return false;
            }
            return true;
        }


    </script>
</body>

</html>