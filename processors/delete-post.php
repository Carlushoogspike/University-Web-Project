<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location: login-page.php");
        exit();
    }

    include '../db/connectDB.php';
    include 'PostProcessor.php';

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verifica se o post id foi passado
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: ../index.php");
        exit();
    }

    $post_id = $_GET['id'];
    $sql = "SELECT * FROM postagens WHERE id_post = $post_id AND id_usuario = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);

    // Verifica se o post existe e se o usuário é o autor
    if (mysqli_num_rows($result) == 0) {
        header("Location: ../index.php");
        exit();
    }

    // Deleta o post
    $delete_sql = "DELETE FROM postagens WHERE id_post = $post_id";
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['status_message'] = ['message' => 'Postagem excluída com sucesso!'];
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['status_message'] = ['message' => 'Erro ao excluir a postagem.'];
        header("Location: ../index.php");
        exit();
    }
?>
