<?php
session_start();
require 'db/connectDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validar se o email e senha não estão vazios
    if (empty($email) || empty($senha)) {
        $_SESSION['error'] = "Email e senha são obrigatórios!";
        header("Location: login-page.php");
        exit();
    }

    // Conectar ao banco de dados
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Usar prepared statement para evitar SQL injection
    $stmt = $conn->prepare("SELECT id_usuario, nome_usuario, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);  // "s" significa string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Depuração: Verificar o valor do hash armazenado
        echo "Hash da senha armazenada: " . $user['senha'] . "<br>";

        // Verificar se a senha corresponde ao hash armazenado
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['user_name'] = $user['nome_usuario'];
            $_SESSION['success'] = "Login bem-sucedido!";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Senha incorreta!";
            header("Location: login-page.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Usuário não encontrado!";
        header("Location: login-page.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Troca de Ideia | Entrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/core.css">
</head>
  <body>

    <div class="row join-page-form">
        <div class="col-md-6">
            <div class="container login-form">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <?php
                            if (isset($_SESSION['error'])) {
                                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                                unset($_SESSION['error']); // Limpa a mensagem de erro após exibí-la
                            }

                            if (isset($_SESSION['success'])) {
                                echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
                                unset($_SESSION['success']); // Limpa a mensagem de sucesso após exibí-la
                            }
                        ?>
                        <h4>Entrar</h4>
                        <p>Entre com uma conta já existente em nosso site, caso não tenha uma conta você deverá clicar no botão abaixo escrito "cadastrar-se"</p>
                        <form action="login-page.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" name="senha" placeholder="Password" required>
                                <label for="floatingPassword">Senha</label>
                            </div>
                            <button class="login" type="submit"><span>Entrar</span></button>
                        </form>
                        <h5>Ou</h5>
                        <button class="register" onclick="window.location.href='register-page.php';"><span>Registrar-se</span></button>
                        </div>
                    <div class="col-md-3"></div>
                </div>
            </div>

        </div>
        <div class="col-md-6 join-page-wallpaper">

        </div>
    </div>  

    <script src="https://kit.fontawesome.com/c3423ba623.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>