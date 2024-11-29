<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

require 'db/connectDB.php';

// Verifica conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login-page.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Processa os dados enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualizar apelido
    if (isset($_POST['nickname']) && !empty(trim($_POST['nickname']))) {
        $nickname = trim($_POST['nickname']);
        $sql = "UPDATE usuarios SET apelido = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nickname, $user_id);
        if ($stmt->execute()) {
            echo "Apelido atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar apelido.";
        }
        $stmt->close();
    }

    // Atualizar nome
    if (isset($_POST['name']) && !empty(trim($_POST['name']))) {
        $name = trim($_POST['name']);
        $sql = "UPDATE usuarios SET nome_usuario = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $user_id);
        if ($stmt->execute()) {
            echo "Nome atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar nome.";
        }
        $stmt->close();
    }

    // Atualizar senha
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sql = "UPDATE usuarios SET senha = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $password, $user_id);
        if ($stmt->execute()) {
            echo "Senha atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar senha.";
        }
        $stmt->close();
    }

    // Atualizar foto de perfil
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_picture'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $destination = 'uploads/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $sql = "UPDATE usuarios SET foto = ? WHERE id_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $destination, $user_id);
            if ($stmt->execute()) {
                echo "Foto de perfil atualizada com sucesso!";
            } else {
                echo "Erro ao atualizar foto de perfil.";
            }
            $stmt->close();
        } else {
            echo "Erro ao salvar a foto de perfil.";
        }
    }
}

$conn->close();

header("Location: user-config.php");
exit();
?>
