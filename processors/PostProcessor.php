<?php
class PostProcessor {
    private $conn;
    private $user_id;

    // Construtor da classe, recebe a conexão com o banco e o ID do usuário
    public function __construct($conn, $user_id) {
        $this->conn = $conn;
        $this->user_id = $user_id;
    }

    // Método para criar uma nova postagem
    public function createPost($conteudo) {
        // Verifica se o conteúdo não está vazio
        if (!empty($conteudo)) {
            // Protege contra SQL injection
            $conteudo = mysqli_real_escape_string($this->conn, $conteudo);

            // Insere a postagem no banco de dados
            $sql = "INSERT INTO postagens (id_usuario, conteudo) VALUES ('$this->user_id', '$conteudo')";
            if (mysqli_query($this->conn, $sql)) {
                return ['status' => 'success', 'message' => 'Postagem publicada com sucesso!'];
            } else {
                return ['status' => 'error', 'message' => 'Erro ao publicar postagem!'];
            }
        } else {
            return ['status' => 'error', 'message' => 'O conteúdo da postagem não pode estar vazio!'];
        }
    }

    // Método para excluir uma postagem
    public function deletePost($post_id) {
        // Verifica se a postagem existe e pertence ao usuário
        $sql = "DELETE FROM postagens WHERE id_post = '$post_id' AND id_usuario = '$this->user_id'";
        if (mysqli_query($this->conn, $sql)) {
            return ['status' => 'success', 'message' => 'Postagem excluída com sucesso!'];
        } else {
            return ['status' => 'error', 'message' => 'Erro ao excluir postagem!'];
        }
    }

    // Método para adicionar uma curtida a uma postagem
    public function likePost($post_id) {
        // Verifica se a postagem existe
        $sql = "SELECT curtidas FROM postagens WHERE id_post = '$post_id'";
        $result = mysqli_query($this->conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            // Incrementa o número de curtidas
            $row = mysqli_fetch_assoc($result);
            $curtidas = $row['curtidas'] + 1;

            // Atualiza o número de curtidas no banco
            $sql = "UPDATE postagens SET curtidas = '$curtidas' WHERE id_post = '$post_id'";
            if (mysqli_query($this->conn, $sql)) {
                return ['status' => 'success', 'message' => 'Postagem curtida com sucesso!'];
            } else {
                return ['status' => 'error', 'message' => 'Erro ao curtir postagem!'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Postagem não encontrada!'];
        }
    }
}
?>
