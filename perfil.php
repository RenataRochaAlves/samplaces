<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isabella Gonçalves | Samplaces</title>
</head>
<body>

    <header>
        <img src="img/logo-site.png" alt="samplaces">
        <nav>
            <ul>
                <a href="#"><li>top</li></a>
                <a href="#"><li>recentes</li></a>
                <a href="#"><li>amigos</li></a>
                <a href="#"><li>logout</li></a>
            </ul>
            <input type="text" name="busca" id="busca" value="">
            <img src="img/busca.png" alt="buscar"> 
        </nav>
    </header>

    <main>
        <div class="conteudo">

            <article class="favorito">
                <h3>lugar favorito ever</h3>
                <div class="imagem-grande">
                    <img src="img/places/martinelli.jpg" alt="Martinelli">
                </div>
                <div class="info">
                    <h4>Lorem ipsum dolor</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat nulla in, qui 
                    atque aut minus sint incidunt architecto molestiae rerum suscipit minima, fugiat hic 
                    inventore, sunt voluptatibus voluptates praesentium error?</p>
                    <div class="icones">
                        <a href="#">
                            <div id="fav">
                                <img src="img/favorito.png" alt="favorito">
                                <h6>368</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div id="amigos">
                                <img src="img/amigos.png" alt="amigos">
                                <h6>368</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div id="date">
                                <img src="img/date.png" alt="date">
                                <h6>368</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div id="domingo">
                                <img src="img/domingo.png" alt="domingo">
                                <h6>368</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div id="salvo">
                                <img src="img/salvo.png" alt="salvo">
                                <h6>368</h6>
                            </div>
                        </a>
                    </div>
                    <a href="#"><button class="botao-grande">passear</button></a>
                </div>
            </article>

            <div class="fav-outros">
                <div class="fav-amigos">
                    <h5>encontrar os amigos</h5>
                    <a href="#">
                        <img src="img/places/pe-na-porta.jpg" alt="pé na porta">
                        <h6>Lorem ipsum dolor</h6>
                        <button>ver mais   >>></button>
                    </a>
                </div>
                <div class="fav-date">
                    <h5>favorito para um date</h5>
                    <a href="#">
                        <img src="img/places/praca-por-do-sol.jpg" alt="praça pôr-do-sol">
                        <h6>Lorem ipsum dolor</h6>
                        <button>ver mais   >>></button>
                    </a>
                </div>
                <div class="fav-domingo">
                    <h5>favorito de domingo</h5>
                    <a href="#">
                        <img src="img/places/paulista.jpg" alt="avenida paulista">
                        <h6>Lorem ipsum dolor</h6>
                        <button>ver mais   >>></button>
                    </a>
                </div>
            </div>
        </div>

        <div class="usuario">
            <img src="img/users/user.jpg" alt="Isabella Gonçalves">
            <h5>Isabella Gonçalves</h5>
            <p>Mooca, São Paulo</p>

            <nav class="fav-user">
                <ul>
                    <a href="#"><li>lugar favorito ever</li></a>
                    <a href="#"><li>favorito para encontrar os amigos</li></a>
                    <a href="#"><li>favorito para um date</li></a>
                    <a href="#"><li>favorito de domingo</li></a>
                </ul>
            </nav>

            <nav class="menu-user">
                <ul>
                    <a href="#"><li>salvos</li></a>
                    <a href="#"><li>configurações</li></a>
                    <a href="#"><li>sair</li></a>
                </ul>
            </nav>
        </div>
    </main>

    <footer>
        <img src="img/logo-branco.png" alt="samplaces">
        <nav>
            <ul>
                <a href="#"><li>top</li></a>
                <a href="#"><li>recentes</li></a>
                <a href="#"><li>amigos</li></a>
            </ul>
        </nav>
        <a href="#">
            <img src="img/github.png" alt="GitHub">
        </a>     
    </footer>
</body>
</html>