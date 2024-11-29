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

    $sql = "SELECT nome_usuario, apelido FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome_usuario, $apelido);
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

<link rel="stylesheet" href="css/feed.css">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                    include 'parts/sidebar.php';
                ?>
            </div>
            <div class="col-md-7">
                <div class="container">
                    <div class="feeds">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="title">Suas Configurações</h4>
                            </div>
                        </div>

                        <!--Alterar apelido do usuario-->
                        <div class="config-block">
                            <div class="info">
                                <h4 class="sub-title">Alterar de Apelido</h4>
                                <p>Altere seu apelido como você desejar</p>
                                <span class="block-title">Atual: </span>
                                <span class="ident"><?php echo htmlspecialchars($apelido); ?></span>
                            </div>
                            <form method="POST" action="update-profile.php">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">@</span>
                                            <div class="form-floating">
                                                <input type="text" name="nickname" class="form-control" id="floatingNickname" placeholder="Nickname">
                                                <label for="floatingNickname">Apelido</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="change">Alterar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!--Alterar nome do usuario-->
                        <div class="config-block">
                            <div class="info">
                                <h4 class="sub-title">Alterar Nome</h4>
                                <p>Altere seu nome, quando, onde e como quiser</p>
                                <span class="block-title">Atual: </span>
                                <span class="ident"><?php echo htmlspecialchars($nome_usuario); ?></span>
                            </div>
                            <form method="POST" action="update-profile.php">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="form-floating">
                                                <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nome">
                                                <label for="floatingName">Nome</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="change">Alterar</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!--Altera a senha-->
                        <div class="config-block">
                            <div class="info">
                                <h4 class="sub-title">Alterar Senha</h4>
                                <p>Caso não esteja se sentido seguro, altere a sua senha!</p>
                            </div>
                            <form method="POST" action="update-profile.php">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="form-floating">
                                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Senha">
                                                <label for="floatingPassword">Senha</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="change">Alterar</button>
                                    </div>
                                </div>
                                
                                <!--Botão de visulização de senha-->
                                <div class="form-check mt-2">
                                    <input type="checkbox" id="togglePassword" class="form-check-input">
                                    <label for="togglePassword" class="form-check-label">Mostrar senha</label>
                                </div>
                            </form>
                        </div>

                        <!--Altera a foto de perfil-->
                        <div class="config-block">
                            <div class="info">
                                <h4 class="sub-title">Alterar foto de perfil</h4>
                                <p>Se sinta a voltade para trocar quando quiser</p>
                            </div>
                            <form method="POST" action="update-profile.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Anexe aqui a sua foto!</label>
                                            <input class="form-control" type="file" name="profile_picture" id="formFile">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="change" style="margin-top: 10px;">Alterar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
