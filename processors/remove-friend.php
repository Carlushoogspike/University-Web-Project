<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'friends-processor.php';

if (isset($_SESSION['user_id']) && isset($_POST['friend_id'])) {
    $userID = $_SESSION['user_id'];
    $friendID = $_POST['friend_id'];

    $success = removeFriend($userID, $friendID, $conn);

    if ($success) {
        $_SESSION['status_message'] = ['type' => 'success', 'message' => 'Amizade desfeita com sucesso!'];
    } else {
        $_SESSION['status_message'] = ['type' => 'error', 'message' => 'Houve um erro ao tentar remover a solicitação de amizade.'];
    }
} else {
    $_SESSION['status_message'] = ['type' => 'error', 'message' => 'Parâmetros inválidos ou ausentes.'];
}

header("Location: ../index.php");
exit;
?>
