<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

require 'db/connectDB.php';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT nome_usuario, apelido, email, foto FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome_usuario, $apelido, $email, $foto);
        $stmt->fetch();
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
} else {
    header("Location: login-page.php");
    exit();
}
?>

<link rel="stylesheet" href="css/sidebar.css">
<div class="">
    <div class="user-sidebar">
        <div class="user-image">
            <?php
            if ($foto) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($foto) . '" alt="Foto do usuário">';
            } else {
                echo '<img src="imgs/teste.jpg" alt="Foto do usuário">';
            }
            ?>
        </div>
        <div class="user-id">
            <h4><?php echo htmlspecialchars($nome_usuario); ?></h4>
            <p>@<?php echo htmlspecialchars($apelido); ?></p>
        </div>
        <div class="user-buttons">
            <ul>
                <li id="<?php echo basename($_SERVER['PHP_SELF']) == 'user-page.php' ? 'selected' : ''; ?>">
                    <a href="user-page.php">
                        <span><i class="fa-solid fa-user"></i> Meu Perfil</span>
                    </a>
                </li>
                <li id="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'selected' : ''; ?>">
                    <a href="index.php">
                        <span><i class="fa-solid fa-compass"></i> Novidades</span>
                    </a>
                </li>
                <li id="<?php echo basename($_SERVER['PHP_SELF']) == 'msg-page.php' ? 'selected' : ''; ?>">
                    <a href="msg-page.php">
                        <span><i class="fa-solid fa-envelope"></i> Mensagens</span>
                    </a>
                </li>
                <li id="<?php echo basename($_SERVER['PHP_SELF']) == 'friends-page.php' ? 'selected' : ''; ?>">
                    <a href="friends-page.php">
                        <span><i class="fa-solid fa-users"></i> Amigos</span>
                    </a>
                </li>
                <li id="<?php echo basename($_SERVER['PHP_SELF']) == 'user-config.php' ? 'selected' : ''; ?>">
                    <a href="user-config.php">
                        <span><i class="fa-solid fa-gear"></i> Configurações</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
