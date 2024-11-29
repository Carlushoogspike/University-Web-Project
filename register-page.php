<?php
session_start();
require 'db/connectDB.php';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("<strong>Falha de conexão: </strong>" . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_usuario = $_POST['nome_usuario'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($nome_usuario) || empty($apelido) || empty($email) || empty($senha)) {
        $_SESSION['error'] = "Todos os campos são obrigatórios!";
        header("Location: register-page.php");
        exit();
    }

    if (strlen($apelido) > 32) {
        $_SESSION['error'] = "O apelido não pode ter mais de 32 caracteres!";
        header("Location: register-page.php");
        exit();
    }

    if (strlen($senha) > 32) {
        $_SESSION['error'] = "A senha não pode ter mais de 32 caracteres!";
        header("Location: register-page.php");
        exit();
    }

    if (strlen($email) > 128) {
        $_SESSION['error'] = "O e-mail não pode ter mais de 128 caracteres!";
        header("Location: register-page.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Este e-mail já está registrado!";
        header("Location: register-page.php");
        exit();
    }

    $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nome_usuario, apelido, email, senha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome_usuario, $apelido, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Conta criada com sucesso!";
        header("Location: login-page.php");
        exit();
    } else {
        $_SESSION['error'] = "Erro ao criar conta. Tente novamente!";
        header("Location: register-page.php");
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
                        <h4>Criar conta</h4>
                        <form action="register-page.php" method="POST">
                            <?php
                                if (isset($_SESSION['error'])) {
                                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                                    unset($_SESSION['error']); 
                                }
                            ?>
                            <!-- Nome do usuário -->
                            <div class="input-group">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" name="nome_usuario" placeholder="Nome do usuário"  maxlength="128">
                                    <label for="floatingInput">Nome do usuário</label>
                                </div>
                            </div>

                            <!-- Apelido -->
                            <div class="input-group mb-3">
                                <span class="input-group-text">@</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputGroup1" name="apelido" placeholder="Apelido"  maxlength="32">
                                    <label for="floatingInputGroup1">Apelido</label>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                                <label for="floatingInput">Email</label>
                            </div>

                            <!-- Senha -->
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" name="senha" placeholder="Password"  maxlength="32">
                                <label for="floatingPassword">Senha</label>
                            </div>

                            <!-- Registrar -->
                            <button class="login"><span>Registrar-se</span></button>

                            <h5>Ou</h5>

                            <!-- Link para a página de login -->
                            <button class="register" type="button" onclick="window.location.href='login-page.php';"><span>Entrar</span></button>
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 join-page-wallpaper">
        </div>
    </div>

    <script src="js/core.js"></script>
    <script src="https://kit.fontawesome.com/c3423ba623.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>