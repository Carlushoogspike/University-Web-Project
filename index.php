<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location: login-page.php");
        exit();
    }

    $statusMessage = isset($_SESSION['status_message']) ? $_SESSION['status_message'] : null;

    unset($_SESSION['status_message']);
    
    include 'db/connectDB.php';
    include 'processors/PostProcessor.php'; //---> Classe da postagem


    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $postProcessor = new PostProcessor($conn, $_SESSION['user_id']); //---> Cria uma classe para se referir a classe
    $statusLike = null;

    // Verifica se o formulário de criação de postagem foi enviado
    if (isset($_POST['postar'])) {
        $conteudo = $_POST['conteudo'];
        $statusLike = $postProcessor->createPost($conteudo);
    }
  
    // Verifica se o botão de curtir foi clicado
    if (isset($_POST['like_post'])) {
        $post_id = $_POST['like_post'];
        $statusLike = $postProcessor->likePost($post_id);
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

                        <?php if ($statusMessage): ?>
                            <script>
                                alert("<?= $statusMessage['message']; ?>");
                            </script>
                        <?php endif; ?>

                        <!-- Bloco para o usuario fazer a publicação - Inicio -->

                        <h4 class="title">Novidades</h4>
                        <form method="POST">
                          <div class="share-something">
                              <div class="share-text">
                                  <div class="form-floating">
                                      <textarea class="form-control" placeholder="Deixe um comentário aqui" id="floatingTextarea" name="conteudo"></textarea>
                                      <label for="floatingTextarea">Compartilhe algo!</label>
                                  </div>
                              </div>
                              <button type="submit" class="share-button" name="postar">Publicar</button>
                          </div>
                        </form>
                            
                        <!-- Bloco para o usuario fazer a publicação - Fim -->

                        <!-- Bloco de Postagem - Inicio -->

                        <div class="container">

                            <!-- Inicio das postagens -->
                            <?php
                            // Consulta as postagens no banco de dados
                                $sql = "SELECT * FROM postagens ORDER BY id_post DESC";
                                $result = mysqli_query($conn, $sql);

                                while ($post = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <div class="post-card">
                                        <div class="post-header">
                                            <img src="imgs/teste.jpg" alt="">
                                            <div class="post-user">
                                                <h5>Usuário Teste</h5>
                                                <p class="post-time"><?= date('H:i', strtotime($post['data_post'])) ?> ago</p>
                                            </div>
                                        </div>
                                        <div class="post-body">
                                            <p><?= htmlspecialchars($post['conteudo']) ?></p>
                                        </div>
                                        <div class="post-image">
                                            <!-- Imagem opcional para o post -->
                                        </div>
                                        <div class="post-buttons">
                                            <form method="POST" style="display:inline;">
                                                <button type="submit" class="like-button" name="like_post" value="<?= $post['id_post'] ?>">
                                                    <?= $post['curtidas'] ?> <i class="fa-solid fa-heart"></i> Curtir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                            <!-- Fim das postagens -->

                        </div>

                        <!-- Bloco de Postagem - Fim -->

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