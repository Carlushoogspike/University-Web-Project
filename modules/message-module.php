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
                        <h4 class="title">Mensagens</h4>
                        <div class="message-card">
                            <div class="user-image">
                                <img src="imgs/teste.jpg" alt="">
                            </div>
                            <div class="user-info">
                                <h4>Carlos Eduardo</h4>
                                <p>@carlosEduardo</p>
                            </div>
                            <div class="last-message">
                                <div class="time">
                                    <p>3 horas atrás</p>
                                </div>
                                <div class="message-box">
                                    <p id="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod sequi labore ea accusamus, dolorum maiores alias, distinctio est ipsum id commodi incidunt quo facere nostrum iusto repellendus! Possimus, voluptate odio.</p>
                                </div>
                            </div>  
                             <button class="clean-message"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    var text = document.getElementById("text").innerText;

    if (text.length > 60) {
        document.getElementById("text").innerText = text.substring(0, 60) + '...';
    }
</script>