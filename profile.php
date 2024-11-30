<?php
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }

  if (!isset($_SESSION['user_id'])) {
      header("Location: login-page.php");
      exit();
  }

  if (isset($_GET['id_usuario'])) {
      $friend_id = $_GET['id_usuario'];
  } else {
      header("Location: index.php");
      exit();
  }

  include 'processors/friends-processor.php';
  $friend = getUserData($friend_id); 

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Social Local | Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/feed.css">
    <link rel="stylesheet" href="css/sidebar.css">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                    include 'sidebar.php';
                ?>
            </div>
            <div class="col-md-7">
                <div class="container">
                    <div class="feeds">
                        <div class="user-background">
                            <div class="profile-info">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="<?php echo !empty($friend['foto']) ? 'data:image/jpeg;base64,'.base64_encode($friend['foto']) : 'imgs/teste.jpg'; ?>" alt="Foto do amigo" class="profile-pic">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <h4><?php echo htmlspecialchars($friend['nome_usuario']); ?></h4>
                                        </div>
                                        <div class="row">
                                            <span>@<?php echo htmlspecialchars($friend['apelido']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="title">Publicações</h4> 
                        <?php
                            include 'processors/user-processor.php';

                            if (isset($friend['id_usuario'])) {
                                obterPostagens($friend['id_usuario']);
                            } else {
                                echo '<p>Este usuário não tem postagens.</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/core.js"></script>
    <script src="https://kit.fontawesome.com/c3423ba623.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
