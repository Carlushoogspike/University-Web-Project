<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/somativa/db/connectDB.php';

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    function getFriends() {
        global $conn;
        
        $userID = $_SESSION["user_id"];
    
        $sql = "SELECT DISTINCT u.id_usuario, u.nome_usuario, u.apelido, u.foto 
                FROM usuarios u
                JOIN amigos a ON (a.id_usuario1 = u.id_usuario OR a.id_usuario2 = u.id_usuario)
                WHERE (a.id_usuario1 = ? OR a.id_usuario2 = ?) AND u.id_usuario != ?";
    
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . $conn->error);
        }
    
        $stmt->bind_param("iii", $userID, $userID, $userID);
    
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $friends = [];
            while ($row = $result->fetch_assoc()) {
                $friends[] = $row;
            }
            return $friends;
        } else {
            return [];
        }
    
        $stmt->close();
    }
    

    function getPersonsInWeb() {
        global $conn;
        
        $userID = $_SESSION["user_id"];
    
        // Modificamos a consulta para verificar se já existe uma solicitação pendente
        $sql = "SELECT u.id_usuario, u.nome_usuario, u.apelido, u.foto
                FROM usuarios u
                WHERE u.id_usuario != ? 
                AND u.id_usuario NOT IN (
                    SELECT id_usuario2 FROM amigos WHERE id_usuario1 = ?
                    UNION
                    SELECT id_usuario1 FROM amigos WHERE id_usuario2 = ?
                )
                AND u.id_usuario NOT IN (
                    SELECT id_usuario_destinatario FROM solicitacoes_amizade 
                    WHERE id_usuario_requisitante = ? AND status = 'pendente'
                    UNION
                    SELECT id_usuario_requisitante FROM solicitacoes_amizade 
                    WHERE id_usuario_destinatario = ? AND status = 'pendente'
                )";
    
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . $conn->error);
        }
    
        $stmt->bind_param("iiiii", $userID, $userID, $userID, $userID, $userID);
    
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $persons = [];
            while ($row = $result->fetch_assoc()) {
                $persons[] = $row;
            }
            return $persons; 
        } else {
            return []; 
        }
    
        $stmt->close();
    }
    

    function sendFriendRequest($userID, $friendID) {
        global $conn;
    
        $sqlCheck = "SELECT * FROM solicitacoes_amizade 
                     WHERE (id_usuario_requisitante = ? AND id_usuario_destinatario = ?) 
                     OR (id_usuario_requisitante = ? AND id_usuario_destinatario = ?)";
    
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("iiii", $userID, $friendID, $friendID, $userID);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
    
        if ($resultCheck->num_rows > 0) {
            return "Já existe uma solicitação de amizade pendente ou uma amizade entre os dois usuários.";
        } else {
            $sqlInsert = "INSERT INTO solicitacoes_amizade (id_usuario_requisitante, id_usuario_destinatario, status) 
                          VALUES (?, ?, 'pendente')";
            
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("ii", $userID, $friendID);
            if ($stmtInsert->execute()) {
                return "Solicitação de amizade enviada com sucesso!";
            } else {
                return "Erro ao enviar solicitação de amizade.";
            }
        }
    }

    function getFriendRequests($userID, $conn) {
        $stmt = $conn->prepare("SELECT * FROM solicitacoes_amizade WHERE id_usuario_destinatario = ? AND status = 'pendente'");
        $stmt->bind_param("i", $userID);
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $requests = [];
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        
        $stmt->close();
        
        return $requests;
    }
    

    function updateFriendRequestStatus($requestID, $userID, $status, $conn) {
        $conn->begin_transaction();
        
        try {
            $stmt = $conn->prepare("SELECT * FROM solicitacoes_amizade WHERE id_solicitacao = ? AND id_usuario_destinatario = ?");
            $stmt->bind_param("ii", $requestID, $userID);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE solicitacoes_amizade SET status = ? WHERE id_solicitacao = ?");
                $stmt->bind_param("si", $status, $requestID);
                $stmt->execute();
                
                if ($status == 'aceita') {
                    $row = $result->fetch_assoc();
                    $friendID = $row['id_usuario_requisitante']; 
                    
                    $stmt = $conn->prepare("INSERT INTO amigos (id_usuario1, id_usuario2) VALUES (?, ?), (?, ?)");
                    $stmt->bind_param("iiii", $userID, $friendID, $friendID, $userID);
                    $stmt->execute();
                }

                $stmt = $conn->prepare("DELETE FROM solicitacoes_amizade WHERE id_solicitacao = ?");
                $stmt->bind_param("i", $requestID);
                $stmt->execute();
                
                $conn->commit();
                
                header("Location: ../index.php");
                exit;
            } else {
                throw new Exception("Solicitação não encontrada ou você não tem permissão para aceitar/rejeitar.");
            }
        } catch (Exception $e) {
            $conn->rollback();
            
            header("Location: index.php");
            exit;
        }
    }


    function removeFriend($userID, $friendID, $conn) {
        $stmt = $conn->prepare("DELETE FROM amigos WHERE (id_usuario1 = ? AND id_usuario2 = ?) OR (id_usuario1 = ? AND id_usuario2 = ?)");
        $stmt->bind_param("iiii", $userID, $friendID, $friendID, $userID);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    

?>
