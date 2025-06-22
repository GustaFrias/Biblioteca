<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/pgPesquisa.css">
    <title>Leyo+ - Pesquisa</title>
</head>

<body>
    <header class="navbar">
        <!-- Menu Hamburguer -->
        <div class="logo">
            <a href="../index.php"> Leyo<span> +</span> </a>
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
                <li><a href="../index.php">Home</a></li>
                <li><a href="AboutUs.php">Sobre nós</a></li>
                <li><a href="cadastro.html">Cadastre-se</a></li>
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