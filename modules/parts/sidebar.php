<link rel="stylesheet" href="css/sidebar.css">
<div class="">
    <div class="user-sidebar">
        <div class="user-image">
            <img src="imgs/teste.jpg" alt="">
        </div>
        <div class="user-id">
            <h4>Usuario Teste</h4>
            <p>@userid</p>
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
