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
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="title">Publicações</h4>
                            </div>
                            <div class="col-md-6">
                                <h4 class="title">Amizades</h4>
                            </div>
                        </div>
                        <?php include 'items/card.php'?>
                    </div>
                </div>
            </div>
        </div>
    </div>
