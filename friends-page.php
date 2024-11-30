<?php
    include 'processors/friends-processor.php';
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
  </head>
  <body>
  <link rel="stylesheet" href="css/feed.css">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                    include 'sidebar.php';
                ?>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="container">
                            <div class="feeds">
                                <h4 class="title">Amigos</h4>
                                <!--Friend-->

                                <?php
                                    $friends = getFriends();

                                    if (count($friends) > 0) {
                                        foreach ($friends as $friend) {
                                            echo '<a href="profile.php?id_usuario=' . $friend['id_usuario'] . '" class="friend-link">';
                                            echo '<div class="friend-card">';
                                            if (!empty($friends['foto'])) {
                                                echo '<img src="data:image/jpeg;base64,' . base64_encode($friends['foto']) . '" alt="Foto do usuário">';
                                            } else {
                                                echo '<img src="imgs/teste.jpg" alt="Foto do usuário">';
                                            }                                            echo '<div class="profile">';
                                            echo '<h4>' . htmlspecialchars($friend['nome_usuario']) . '</h4>';
                                            echo '<p>@' . htmlspecialchars($friend['apelido']) . '</p>';
                                            echo '</div>';
                                            echo '<form method="post" action="processors/remove-friend.php">';
                                            echo '<input type="hidden" name="friend_id" value="' . $friend['id_usuario'] . '">'; 
                                            echo '<button type="submit" class="remove-friend"><i class="fa-solid fa-user-xmark"></i></button>';
                                            echo '</form>';
                                            echo '</div>';
                                            echo '</a>';
                                        }
                                    } else {
                                        echo "Você não tem amigos ainda.";
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="container">
                            <div class="feeds">
                                <h4 class="title">Solicitações</h4>
                                <?php include 'processors/friend-requests.php'?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="container">
                        <div class="feeds">
                            <h4 class="title">Pessoas na rede</h4>
                            <?php
                                $persons = getPersonsInWeb();

                                if (count($persons) > 0) {
                                    foreach ($persons as $person) {
                                        echo '<div class="friend-card">';
                                        
                                        if (!empty($person['foto'])) {
                                            echo '<img src="data:image/jpeg;base64,' . base64_encode($person['foto']) . '" alt="Foto do usuário">';
                                        } else {
                                            echo '<img src="imgs/teste.jpg" alt="Foto do usuário">';
                                        }

                                        echo '<div class="profile">';
                                        echo '<h4>' . htmlspecialchars($person['nome_usuario']) . '</h4>';
                                        echo '<p>@' . htmlspecialchars($person['apelido']) . '</p>';
                                        echo '</div>';
                                        
                                        echo '<form action="processors/send-friend-request.php" method="POST">
                                                <input type="hidden" name="friend_id" value="' . $person['id_usuario'] . '">
                                                <button type="submit" class="send-invite"><i class="fa-solid fa-paper-plane"></i> Enviar Solicitação</button>
                                            </form>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "Não há pessoas para sugerir.";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/c3423ba623.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>