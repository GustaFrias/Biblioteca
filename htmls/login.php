
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Leyo ++</title>
</head>

<body>
    <header>

        <img src="#" alt="#">

        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Contato</a></li>
                <li><a href="#">Cadastrar-se</a></li>
            </ul>
        </nav>

    </header>

    <div class="">
        <h2>Login</h2>
        <p style="color:red;">
            <?php if (isset($_GET['erro'])) { echo "Login inválido!"; 
                } 
                if (isset($_GET['cadastro'])) {
                    echo "<p style='color:green;'>Cadastro realizado com sucesso! Faça login.</p>";
                }
            ?>
        </p>
        <form method="POST" action="login.php">
            <div class="">
                <input type="text" name="Email" required>
                <label for="">Email</label>
            </div>

            <div class="">
                <input type="password" name="senha" required>
                <label for="">Senha</label>
            </div>

            <button type="submit">Entrar</button>

            <p>Ainda não tem conta? <a href="#">Cadastre-se</a></p>

        </form>
    </div>

    <footer>

    </footer>
</body>

</html>
