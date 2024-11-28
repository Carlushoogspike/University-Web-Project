<link rel="stylesheet" href="css/feed.css">

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                    include 'parts/sidebar.php';
                ?>
            </div>
            <div class="col-md-4">
                <div class="container">
                    <div class="feeds">
                        <h4 class="title">Amigos</h4>
<!--Friend-->
                        <div class="friend-card">
                            <img src="imgs/teste.jpg" alt="">
                            <div class="profile">
                                <h4>Carlos</h4>
                                <p>@carlos</p>
                            </div>
                            <button class="send-message"><i class="fa-solid fa-paper-plane"></i></button>
                            <button class="remove-friend"><i class="fa-solid fa-user-xmark"></i></button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container">
                    <div class="feeds">
                        <h4 class="title">Solicitações</h4>
                        <div class="friend-card">
                            <img src="imgs/teste.jpg" alt="">
                            <div class="profile">
                                <h4>Carlos</h4>
                                <p>@carlos</p>
                            </div>
                            <button class="add-friend"><i class="fa-solid fa-user-plus"></i></button>
                            <button class="reject-friend"><i class="fa-solid fa-user-slash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>