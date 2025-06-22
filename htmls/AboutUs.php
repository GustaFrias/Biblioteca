<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../styles/aboutUs.css">
    <title>Leyo+</title>
</head>

<body>
    <div class="principal">
        <div class="degrade" id="right">
            <header class="navbar">
                <!-- Hamburguer -->
                <div class="logo">
                    <a href="../index.php"> Leyo<span> +</span> </a>
                </div>
                <div class="menu-toggle" id="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <nav>
                    <ul id="nav-list">
                        <li><a href="../index.php">Home</a></li>
        <?php if (!isset($_SESSION['usuario']) && !isset($_SESSION['admin'])): ?>
    <li><a href="cadastro.html">Cadastrar-se</a></li>
    <li><a href="login.html">Login</a></li>
<?php else: ?>
    <li>
        <img src="../img/iconLogin.png" alt="" id="icon-login" style="width: 50px; height: auto; margin-top: -13px; margin-right: -30px;">
    </li>
    <li>
        <a href="<?php echo isset($_SESSION['admin']) ? '../php/login&cadastro/admin.php' : ''; ?>">
            <?php
                if (isset($_SESSION['usuario'])) {
                    echo htmlspecialchars($_SESSION['usuario']);
                } elseif (isset($_SESSION['admin'])) {
                    echo 'Administrador';
                }
            ?>
        </a>
    </li>
    <li><a href="../php/login&cadastro/logout.php">Sair</a></li>
<?php endif; ?>
                </nav>

            </header>

            <section class="tela">
                <div class="separador">
                    <h2 class="titulo">
                        Ideia Inicial
                    </h2>
                </div>
                <div class="separador">
                    <span class="texto">
                        A ideia da livraria surge do desejo de unir sofisticação e cultura em um só espaço. Inspirada nos
                        salões de
                        leitura da realeza europeia, terá estantes de madeira nobre, iluminação quente e poltronas
                        confortáveis. O
                        ambiente será elegante, acolhedor e pensado para a contemplação. Música clássica suave e atendimento
                        personalizado contribuirão para a experiência refinada. Cafés e chás selecionados estarão
                        disponíveis para
                        acompanhar a leitura. A curadoria dos livros será criteriosa, com foco em obras clássicas e
                        contemporâneas
                        de qualidade. Mais que uma livraria, será um símbolo de requinte e conhecimento.
                    </span>
                </div>
            </section>
        </div>
    </div>

    <div class="principal" id="segundo">
        <section class="tela" id="centro">
            <div class="separador">
                <h2 class="titulo mudanca">
                    O Projeto
                </h2>
            </div>
            <div class="separador">
                <span class="texto mudanca">
                    O projeto da livraria nasceu de um sonho antigo, quase nostálgico, de recriar a sensação de estar em
                    um
                    lugar onde o tempo desacelera e a leitura é celebrada com elegância. Tudo começou com rabiscos em um
                    caderno
                    e visitas a antigas bibliotecas europeias em busca de inspiração. Cada detalhe foi pensado com
                    carinho: a
                    escolha da madeira, a luz suave, as poltronas que abraçam o leitor. Houve desafios, claro —
                    encontrar o
                    equilíbrio entre o clássico e o confortável, o requinte e a acessibilidade — mas a paixão por livros
                    guiou
                    cada decisão. Ver a ideia ganhar vida foi como materializar um sentimento: o de que ler pode <br> (e
                    deve) ser um
                    prazer digno da realeza.
                </span>
            </div>
        </section>
    </div>

    <div class="principal" id="terceiro">
        <div class="degrade" id="left">
            <section class="tela" id="end">
                <div class="separador">
                    <h2 class="titulo mudancas">
                        O Nosso Surgimento
                    </h2>
                </div>
                <div class="separador">
                    <span class="texto mudancas">
                        A abertura da livraria marcou a realização de um sonho cuidadosamente construído. Após meses de
                        planejamento, escolhas detalhadas e muita dedicação, as portas finalmente se abriram para receber os
                        primeiros visitantes. A emoção foi palpável: o aroma dos livros novos, o brilho suave das
                        luminárias, o som
                        discreto da música clássica preenchendo o ar. Clientes entravam encantados, explorando cada estante
                        como se
                        descobrissem um pequeno tesouro. Ver o espaço vivo, acolhendo leitores com conforto e elegância, foi
                        a
                        recompensa por cada esforço. A livraria nasceu pronta para ser mais que um comércio — um ponto de
                        encontro
                        entre pessoas, histórias e sentimentos.
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
                <div class=""> (11) 98765-4321</div>
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

<script src="../styles/script.js"></script>

</html>