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
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="title">Suas Configurações</h4>
                            </div>
                        </div>

                        <!--Alterar apelido do usuario-->
                        <div class="config-block">
                            <div class="info">
                                <h4 class="sub-title">Alterar de Apelido</h4>
                                <p>Altere seu apelido como você desejar</p>
                                <span class="block-title">Atual: </span>
                                <span class="ident">@carloseduardo</span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                    <span class="input-group-text">@</span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="floatingInputGroup1" placeholder="Nickname">
                                            <label for="floatingInputGroup1">Apelido</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button class="change">Alterar</button>
                                </div>
                            </div>
                        </div>

                        <!--Alterar nome do usuario-->
                        <div class="config-block">
                            <div class="info">
                                <h4 class="sub-title">Alterar Nome</h4>
                                <p>Altere seu nome, quando, onde e como quiser</p>
                                <span class="block-title">Atual: </span>
                                <span class="ident">Carlos Eduardo</span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Username">
                                            <label for="floatingInput">Meu nome</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button class="change">Alterar</button>
                                </div>
                            </div>
                        </div>

                        <div class="config-block">
                            <div class="info">
                                <h4 class="sub-title">Alterar Senha</h4>
                                <p>Caso não esteja se sentido seguro, altere a sua senha!</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                            <label for="floatingPassword">Senha</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button class="change">Alterar</button>
                                </div>
                            </div>
                        </div>

                        <div class="config-block">
                            <div class="info">
                                <h4 class="sub-title">Alterar foto de perfil</h4>
                                <p>Se sinta a voltade para trocar quando quiser</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Anexe aqui a sua foto!</label>
                                        <input class="form-control" type="file" id="formFile">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button class="change" style="margin-top: 10px;">Alterar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
