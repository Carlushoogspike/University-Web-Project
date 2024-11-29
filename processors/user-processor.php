<?php
    require './db/connectDB.php'; // Conexão com o banco de dados

// Função para obter as postagens do usuário
    function obterPostagens($user_id) {
        global $conn;

        // Query para pegar as postagens do usuário
        $sql = "SELECT p.id_post, p.conteudo, p.curtidas, p.data_post, u.nome_usuario, u.foto
                FROM postagens p
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                WHERE p.id_usuario = ?
                ORDER BY p.data_post DESC"; // Ordena pela data da postagem

        // Prepara a consulta
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $user_id); // Vincula o ID do usuário à consulta
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id_post, $conteudo, $curtidas, $data_post, $nome_usuario, $foto);

                while ($stmt->fetch()) {
                    $data_post_formatada = date('d/m/Y H:i', strtotime($data_post));
                    
                    ?>
                    <div class="container">
                        <div class="post-card">
                            <div class="post-header">
                                <?php
                                if ($foto) {
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($foto) . '" alt="Foto de perfil">';
                                } else {
                                    echo '<img src="imgs/teste.jpg" alt="Foto de perfil">';
                                }
                                ?>
                                <div class="post-user">
                                    <h5><?php echo htmlspecialchars($nome_usuario); ?></h5>
                                    <p class="post-time"><?php echo $data_post_formatada; ?> </p>
                                </div>
                            </div>
                            <div class="post-body">
                                <p><?php echo nl2br(htmlspecialchars($conteudo)); ?></p>
                            </div>
                            <div class="post-image">
                            </div>
                            <div class="post-buttons">
                                <button class="like-button">
                                    <?php echo $curtidas; ?> <i class="fa-solid fa-heart"></i> Curtidas
                                </button>
                                <button class="comment-button">
                                    <i class="fa-solid fa-message"></i> Comentários
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>Nenhuma postagem encontrada.</p>';
            }
            $stmt->close();
        } else {
            echo "Erro ao obter postagens.";
        }
    }
?>