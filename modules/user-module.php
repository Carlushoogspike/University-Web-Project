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
                        <div class="user-background" style="background-image: url('imgs/praia.jpg');"></div>
                        <h4 class="title">Publicações</h4>
                        <?php include 'items/card.php'?>
                    </div>
                </div>
            </div>
        </div>
    </div>
