<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/somativa/db/connectDB.php';

    $userID = $_SESSION['user_id'];

    $requests = getFriendRequests($userID, $conn);

    if (count($requests) > 0) {
        foreach ($requests as $request) {
            $requisitanteID = $request['id_usuario_requisitante'];
            $stmt = $conn->prepare("SELECT nome_usuario, apelido, foto FROM usuarios WHERE id_usuario = ?");
            $stmt->bind_param("i", $requisitanteID);
            $stmt->execute();
            $userInfo = $stmt->get_result()->fetch_assoc();
    
            echo "<div class='friend-card'>";
    
            if (!empty($userInfo['foto'])) {
                echo "<img src='data:image/jpeg;base64," . base64_encode($userInfo['foto']) . "' alt='Foto do usuário'>";
            } else {
                echo "<img src='imgs/teste.jpg' alt='Foto do usuário'>";
            }
    
            echo "<div class='profile'>";
            echo "<h4>" . htmlspecialchars($userInfo['nome_usuario']) . "</h4>";
            echo "<p>@" . htmlspecialchars($userInfo['apelido']) . "</p>";
            echo "</div>";
    
            echo "<form method='post' action='processors/process-request.php' style='display: flex; gap: 10px;'>";
            echo "<input type='hidden' name='request_id' value='" . $request['id_solicitacao'] . "'>";
            echo "<button type='submit' name='action' value='Aceitar' class='add-friend'><i class='fa-solid fa-user-plus'></i></button>";
            echo "<button type='submit' name='action' value='Rejeitar' class='reject-friend'><i class='fa-solid fa-user-slash'></i></button>";
            echo "</form>";
    
            echo "</div>";
        }
    } else {
        echo "<p>Não há solicitações pendentes.</p>";
    }
?>
