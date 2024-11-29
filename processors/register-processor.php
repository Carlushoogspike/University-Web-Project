<?php 
    require '../db/connectDB.php';

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
            header("Location: ../login-page.php");
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