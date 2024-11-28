    <link rel="stylesheet" href="css/feed.css">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                    include 'parts/user-info.php';
                ?>
            </div>
            <div class="col-md-7">
                <div class="container">
                    <div class="feeds">
                        <h4 class="title">Mensagens</h4>
                        <?php
                            include 'items/message.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
