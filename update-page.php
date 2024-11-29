<?php
    // Inicia a sessão para acessar as variáveis de sessão
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Social Local | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/feed.css">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include 'sidebar.php'; ?>
            </div>
            <div class="col-md-7">
                <div class="container">
                    <div class="feeds">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="title">Suas Configurações</h4>
                            </div>
                        </div>
                        
                        <div id="alert-message" class="alert alert-warning" style="display: none;"></div>
                        <?php 
                            if (isset($_SESSION['alert']) && isset($_SESSION['message'])) {
                                $alert = $_SESSION['alert'];
                                $message = $_SESSION['message']; 
                        
                                echo "<div class='alert alert-$alert' role='alert'>
                                        $message
                                    </div>";
                        
                                unset($_SESSION['alert']);
                                unset($_SESSION['message']);
                            }
                        ?>
                        <!-- Formulário unificado -->
                        <form method="POST" action="processors/update-processor.php" enctype="multipart/form-data">

                            <!-- Alterar Apelido -->
                            <div class="config-block">
                                <div class="info">
                                    <h4 class="sub-title">Alterar Apelido</h4>
                                    <p>Altere seu apelido como você desejar</p>
                                    <span class="block-title">Atual: </span>
                                    <span class="ident"><?php echo htmlspecialchars($apelido); ?></span>
                                </div>
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
                                </div>
                            </div>

                            <!-- Alterar Nome -->
                            <div class="config-block">
                                <div class="info">
                                    <h4 class="sub-title">Alterar Nome</h4>
                                    <p>Altere seu nome, quando, onde e como quiser</p>
                                    <span class="block-title">Atual: </span>
                                    <span class="ident"><?php echo htmlspecialchars($nome_usuario); ?></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="form-floating">
                                                <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nome">
                                                <label for="floatingName">Nome</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alterar Senha -->
                            <div class="config-block">
                                <div class="info">
                                    <h4 class="sub-title">Alterar Senha</h4>
                                    <p>Caso não esteja se sentindo seguro, altere a sua senha!</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="form-floating">
                                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Senha">
                                                <label for="floatingPassword">Senha</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Botão de visualização de senha -->
                                <div class="form-check mt-2">
                                    <input type="checkbox" id="togglePassword" class="form-check-input">
                                    <label for="togglePassword" class="form-check-label">Mostrar senha</label>
                                </div>
                            </div>

                            <!-- Alterar Foto de Perfil -->
                            <div class="config-block">
                                <div class="info">
                                    <h4 class="sub-title">Alterar foto de perfil</h4>
                                    <p>Se sinta à vontade para trocar quando quiser</p>
                                </div>
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
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/core.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            let valid = true;
            let message = "";
            const nickname = document.querySelector('input[name="nickname"]').value.trim();
            const name = document.querySelector('input[name="name"]').value.trim();
            const password = document.querySelector('input[name="password"]').value.trim();
            const profilePicture = document.querySelector('input[type="file"]').files.length;

            if (nickname === "" && name === "" && password === "" && profilePicture === 0) {
            message = "Por favor, preencha pelo menos um campo antes de enviar!";
            valid = false;
            }

            if (!valid) {
            // Exibe a mensagem de aviso
            document.getElementById("alert-message").innerText = message;
            document.getElementById("alert-message").style.display = "block";
            event.preventDefault();  // Impede o envio do formulário
            }
        });
    </script>
    <script src="https://kit.fontawesome.com/c3423ba623.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
