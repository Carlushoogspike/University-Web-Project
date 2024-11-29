<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'friends-processor.php';

if (isset($_POST['request_id']) && isset($_POST['action'])) {
    $requestID = $_POST['request_id'];
    $action = $_POST['action'];
    $userID = $_SESSION['user_id'];

    if ($action == 'Aceitar') {
        $status = 'aceita';
        $_SESSION['status_message'] = ['type' => 'success', 'message' => 'Solicitação de amizade aceita com sucesso!'];
    } else if ($action == 'Rejeitar') {
        $status = 'rejeitada';
        $_SESSION['status_message'] = ['type' => 'error', 'message' => 'Solicitação de amizade rejeitada.'];
    } else {
        echo "Ação inválida!";
        exit;
    }

    $response = updateFriendRequestStatus($requestID, $userID, $status, $conn);

    header("Location: ../index.php");
    exit;
} else {
    echo "Erro: Solicitação inválida.";
}
?>
