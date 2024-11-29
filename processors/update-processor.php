<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); 
    }

    require '../db/connectDB.php'; // Conexão com o banco de dados

    // Verifica conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verifica se o usuário está autenticado
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login-page.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $alert = '';
        $message = '';
    
        // Verificar se pelo menos um campo foi enviado com dados
        if (!empty($_POST['nickname']) || !empty($_POST['name']) || !empty($_POST['password']) || isset($_FILES['profile_picture'])) {
    
            // Atualizar apelido, se não estiver vazio
            if (isset($_POST['nickname']) && !empty(trim($_POST['nickname']))) {
                $nickname = trim($_POST['nickname']);
                
                if ($nickname === $apelido) {
                    $alert = 'warning';
                    $message = "O apelido inserido é o mesmo que o atual. Nenhuma alteração foi feita.";
                } else {
                    $sqlCheck = "SELECT id_usuario FROM usuarios WHERE apelido = ? AND id_usuario != ?";
                    $stmtCheck = $conn->prepare($sqlCheck);
                    $stmtCheck->bind_param("si", $nickname, $user_id);
                    $stmtCheck->execute();
                    $stmtCheck->store_result();
                
                    if ($stmtCheck->num_rows > 0) {
                        $alert = 'danger';
                        $message = "Este apelido já está em uso. Por favor, escolha outro.";
                    } else {
                        // Atualizar o apelido, já que não é duplicado
                        $sqlUpdate = "UPDATE usuarios SET apelido = ? WHERE id_usuario = ?";
                        $stmtUpdate = $conn->prepare($sqlUpdate);
                        $stmtUpdate->bind_param("si", $nickname, $user_id);
                        if ($stmtUpdate->execute()) {
                            $alert = 'success';
                            $message = "Dados atualizados com sucesso";
                        } else {
                            $alert = 'danger';
                            $message = "Erro ao atualizar apelido.";
                        }
                        $stmtUpdate->close();
                    }
                    $stmtCheck->close();
                }
            }
    
            // Atualizar nome, se não estiver vazio
            if (isset($_POST['name']) && !empty(trim($_POST['name']))) {
                $name = trim($_POST['name']);
                $sql = "UPDATE usuarios SET nome_usuario = ? WHERE id_usuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $name, $user_id);
                if ($stmt->execute()) {
                    $alert = 'success';
                    $message = "Dados atualizados com sucesso";
                } else {
                    $alert = 'danger';
                    $message = "Erro ao atualizar nome.";
                }
                $stmt->close();
            }
    
            // Atualizar senha, se não estiver vazio
            if (isset($_POST['password']) && !empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $sql = "UPDATE usuarios SET senha = ? WHERE id_usuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $password, $user_id);
                if ($stmt->execute()) {
                    $alert = 'success';
                    $message = "Dados atualizados com sucesso";
                } else {
                    $alert = 'danger';
                    $message = "Erro ao atualizar senha.";
                }
                $stmt->close();
            }
    
            // Atualizar foto de perfil, se estiver definida
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
                $file = $_FILES['profile_picture'];
                
                $imageData = file_get_contents($file['tmp_name']);
                
                $sql = "UPDATE usuarios SET foto = ? WHERE id_usuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("bi", $null, $user_id);
                $null = null;
                $stmt->send_long_data(0, $imageData);
                if ($stmt->execute()) {
                    $alert = 'success';
                    $message = "Dados atualizados com sucesso";
                } else {
                    $alert = 'danger';
                    $message = "Erro ao atualizar foto de perfil no banco de dados.";
                }
                $stmt->close();
            }
    
            $_SESSION['alert'] = $alert;
            $_SESSION['message'] = $message;
        } else {
            $_SESSION['alert'] = 'warning';
            $_SESSION['message'] = "Por favor, faça pelo menos uma alteração antes de enviar.";
        }
    
        $conn->close();
    
        header("Location: ../update-page.php");
        exit();
    }
?>
