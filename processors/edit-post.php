<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header("Location: login-page.php");
        exit();
    }

    include '../db/connectDB.php';
    include 'PostProcessor.php';

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verifica se o post id foi passado
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: ../index.php");
        exit();
    }

    $post_id = $_GET['id'];
    $sql = "SELECT * FROM postagens WHERE id_post = $post_id AND id_usuario = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);

    // Verifica se o post existe e se o usuário é o autor
    if (mysqli_num_rows($result) == 0) {
        header("Location: ../index.php");
        exit();
    }

    $post = mysqli_fetch_assoc($result);

    // Verifica se o formulário de edição foi enviado
    if (isset($_POST['editar'])) {
        $conteudo = $_POST['conteudo'];
        $update_sql = "UPDATE postagens SET conteudo = '$conteudo' WHERE id_post = $post_id";
        
        if (mysqli_query($conn, $update_sql)) {
            $_SESSION['status_message'] = ['message' => 'Postagem editada com sucesso!'];
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Erro ao editar a postagem.";
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Postagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/feed.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include '../sidebar.php'?>
            </div>
            <div class="col-md-7">
                <div class="feeds">
                    <h4 class="title">Editar Postagem</h4>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label for="conteudo">Conteúdo</label>
                            <textarea class="form-control" id="conteudo" name="conteudo" rows="4"><?= htmlspecialchars($post['conteudo']) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" name="editar">Salvar alterações</button>
                        <a href="../index.php" class="btn btn-secondary mt-3">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/core.js"></script>
    <script src="https://kit.fontawesome.com/c3423ba623.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
