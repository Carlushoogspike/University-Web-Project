<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include 'friends-processor.php';

    if (isset($_POST['friend_id'])) {
        $friendID = $_POST['friend_id'];
        if (!isset($_SESSION['user_id'])) {
            echo "Erro: Usuário não está logado.";
            exit();
        }

        $userID = $_SESSION['user_id'];  
        $response = sendFriendRequest($userID, $friendID);

        echo "<script>alert('$response'); window.location.href = '../index.php';</script>";
    } else {
        echo "Erro: Não foi possível enviar a solicitação.";
    }
?>
