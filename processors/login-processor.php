<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require '../db/connectDB.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Validar se o email e senha não estão vazios
        if (empty($email) || empty($senha)) {
            $_SESSION['error'] = "Email e senha são obrigatórios!";
            header("Location: ../login-page.php");
            exit();
        }

        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT id_usuario, nome_usuario, senha FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);  // obtem o dado em forma de string -> 's'
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verificar se a senha corresponde ao hash armazenado
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id_usuario'];
                $_SESSION['user_name'] = $user['nome_usuario'];
                $_SESSION['success'] = "Login bem-sucedido!";
                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['error'] = "Senha incorreta!";
                header("Location: ../login-page.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Usuário não encontrado!";
            header("Location: ../login-page.php");
            exit();
        }

        $stmt->close();
        $conn->close();
    }
?>