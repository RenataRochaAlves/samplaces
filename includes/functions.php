<?php 

include("conexao.php");

// função para adicionar usuários ao banco de dados
function adicionaUser($nome, $user, $bairro, $email, $senha, $foto){

    global $db;

    // procura no bd se o bairro informado já foi cadastrado
    $query = $db->prepare("SELECT * FROM bairros WHERE nome LIKE :bairro");
    $query->execute(["bairro"=>$bairro]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // se já tiver cadastrado, guarda o id para ser usado no cadastro do usuário
    if($result){
        $bairro = $result["id"];
    // se não tiver, cria um novo bairro e guarda o id para ser usado
    } else {
        $query = $db->prepare("INSERT INTO bairros(id, nome) VALUES(DEFAULT, :nome)");
        $query->execute(["nome"=>$bairro]);

        $query = $db->prepare("SELECT * FROM bairros WHERE nome LIKE :bairro");
        $query->execute(["bairro"=>$bairro]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $bairro = $result["id"];
    }

    // adiciona o usuário ao banco de dados 
    $query = $db->prepare("INSERT INTO users(id, user, nome, email, senha, foto, bairros_id) 
    VALUES(DEFAULT, :user, :nome, :email, :senha, :foto, :bairro)");

    $query->execute(["user"=>$user, "nome"=>$nome, "email"=>$email, "senha"=>password_hash($senha, PASSWORD_DEFAULT),
    "foto"=>$foto, "bairro"=>$bairro]);
}

// função que verifica se o user já existe
function verificaUser($user) {
    global $db;

    // procura no banco de dados o user que a pessoa quer inserir
    $query = $db->prepare("SELECT * FROM users WHERE user LIKE :user");
    $query->execute(["user"=>$user]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // compara se o resultado encontrado é igual o que a pessoa quer inserir
    return $result;
}

// função que verifica se o e-mail já foi cadastrado
function verificaEmail($email) {
    global $db;

    // procura no banco de dados o user que a pessoa quer inserir
    $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
    $query->execute(["email"=>$email]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // compara se o resultado encontrado é igual o que a pessoa quer inserir
    return is_array($result);
}

// function para carregar as informações de um usuário
function carregaUser($user){
    global $db;

    // procura os dados no bd com base no user recebido
    $query = $db->prepare("SELECT 
                                u.id,
                                u.user,
                                u.nome,
                                u.email,
                                u.senha,
                                u.foto,
                                b.nome as bairro
                            FROM 
                                users as u
                            INNER JOIN
                                bairros as b
                            ON u.bairros_id = b.id
                            WHERE u.user LIKE :user");

    $query->execute(["user"=>$user]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // retorna o array com as informações do usuário
    return $result;
}

// função que deleta usuário
function deletaUser($user){
    global $db;

    $query = $db->prepare("DELETE FROM users WHERE user = :user");
    $query->execute(['user'=>$user]);
}

// função que altera os dados do usuário
function editaUser($id, $nome, $user, $bairro, $email, $senha, $foto) {

    global $db;

    // procura no bd se o bairro informado já foi cadastrado
    $query = $db->prepare("SELECT * FROM bairros WHERE nome LIKE :bairro");
    $query->execute(["bairro"=>$bairro]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // se já tiver cadastrado, guarda o id para ser usado no cadastro do usuário
    if($result){
        $bairro = $result["id"];
    // se não tiver, cria um novo bairro e guarda o id para ser usado
    } else {
        $query = $db->prepare("INSERT INTO bairros(id, nome) VALUES(DEFAULT, :nome)");
        $query->execute(["nome"=>$bairro]);

        $query = $db->prepare("SELECT * FROM bairros WHERE nome LIKE :bairro");
        $query->execute(["bairro"=>$bairro]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $bairro = $result["id"];
    }

    // atualiza as informações no cadastro do usuário
    $query = $db->prepare("UPDATE users SET user = :user, nome = :nome, email = :email, 
    senha = :senha, foto = :foto, bairros_id = :bairro WHERE id = :id");
    $query->execute(['user'=>$user, 'nome'=>$nome, 'email'=>$email, 'senha'=>$senha,
    'foto'=>$foto, 'bairro'=>$bairro, 'id'=>$id]);

}

// function para carregar as informações de um tipo de favorito
function carregaTipoFavorito($curto){
    global $db;

    // procura os dados no bd com base no nome curto recebido
    $query = $db->prepare("SELECT * FROM tipo_favorito WHERE curto LIKE :curto");

    $query->execute(["curto"=>$curto]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // retorna o array com as informações do favorito
    return $result;
}

// função para adicionar um novo favorito
function adicionaFavorito($lugar, $texto, $foto, $user, $tipo){
    global $db;

    // procura no bd se o lugar informado já foi cadastrado
    $query = $db->prepare("SELECT * FROM lugar WHERE nome LIKE :lugar");
    $query->execute(["lugar"=>$lugar]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // se já tiver cadastrado, guarda o id para ser usado no cadastro do usuário
    if($result){
        $lugar = $result["id"];
    // se não tiver, cria um novo lugar e guarda o id para ser usado
    } else {
        $query = $db->prepare("INSERT INTO lugar(id, nome) VALUES(DEFAULT, :nome)");
        $query->execute(["nome"=>$lugar]);

        $query = $db->prepare("SELECT * FROM lugar WHERE nome LIKE :lugar");
        $query->execute(["lugar"=>$lugar]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $lugar = $result["id"];  
    }

    // insere os dados no bd
            $query = $db->prepare("INSERT INTO favorito(id, descricao, foto, users_id, lugar_id, tipo_favorito_id) 
            VALUES (DEFAULT, :texto, :foto, :user, :lugar, :tipo)");
            $query->execute(['texto'=>$texto, 'foto'=>$foto, 'user'=>$user, 'lugar'=>$lugar, 'tipo'=>$tipo]);
}

// função que edita um favorito
function editaFavorito($lugar, $texto, $foto, $user, $userid, $tipo){
    global $db;

    // carrega as informações do favorito já criado
    $favorito = carregaFavUserTipo($user, $tipo);

    // procura no bd se o lugar informado já foi cadastrado
    $query = $db->prepare("SELECT * FROM lugar WHERE nome LIKE :lugar");
    $query->execute(["lugar"=>$lugar]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // se já tiver cadastrado, guarda o id para ser usado no cadastro do usuário
    if($result){
        $lugar = $result["id"];
    // se não tiver, cria um novo lugar e guarda o id para ser usado
    } else {
        $query = $db->prepare("INSERT INTO lugar(id, nome) VALUES(DEFAULT, :nome)");
        $query->execute(["nome"=>$lugar]);

        $query = $db->prepare("SELECT * FROM lugar WHERE nome LIKE :lugar");
        $query->execute(["lugar"=>$lugar]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $lugar = $result["id"];  
    }

    // insere os dados no bd
    $query = $db->prepare("UPDATE favorito SET id = :id, descricao = :texto, foto = :foto, 
    users_id = :userid, lugar_id = :lugar, tipo_favorito_id = :tipo WHERE id = :id");
    $query->execute(['texto'=>$texto, 'foto'=>$foto, 'lugar'=>$lugar, 'id'=>$favorito['id'],
    'userid'=>$userid, 'tipo'=>$tipo]);
}

// função que carrega um favorito de acordo com o user e o tipo
function carregaFavUserTipo($user, $tipo){

    global $db;

    $query = $db->prepare("SELECT 
                            f.id,
                            f.descricao,
                            f.foto,
                            u.user,
                            l.nome as lugar,
                            l.id as idlugar,
                            t.nome as tipo
                        FROM 
                            favorito as f
                        INNER JOIN
                            users as u
                        INNER JOIN
                            lugar as l
                        INNER JOIN
                            tipo_favorito as t
                        ON u.id = f.users_id AND l.id = f.lugar_id AND t.id = f.tipo_favorito_id
                        WHERE u.user = :user AND t.id = :tipo");
    $query->execute(['user'=>$user, 'tipo'=>$tipo]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
}

// função para começar a seguir um usuário
function seguir($seguidor, $seguido){

    global $db;

    $query = $db->prepare("INSERT INTO users_has_users(users_id, users_id1) VALUES (:seguidor, :seguido)");
    $query->execute(['seguidor'=>$seguidor, 'seguido'=>$seguido]);
}

// função para deixar de seguir um usuário
function excluirSeguir($seguidor, $seguido){

    global $db;

    $query = $db->prepare("DELETE FROM users_has_users WHERE users_id = :seguidor AND users_id1 = :seguido");
    $query->execute(['seguidor'=>$seguidor, 'seguido'=>$seguido]);
}

// verifica se está seguindo o usuário
function verificaSeguir($seguidor, $seguido) {
    global $db;

    // procura no banco de dados o user que a pessoa quer inserir
    $query = $db->prepare("SELECT * FROM users_has_users WHERE users_id = :seguidor AND users_id1 = :seguido");
    $query->execute(['seguidor'=>$seguidor, 'seguido'=>$seguido]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // compara se o resultado encontrado é igual o que a pessoa quer inserir
    return is_array($result);
}

// função que exibe todas as pessoas que o usuario segue
function exibirSeguindo($userid){
    global $db;

    $query = $db->prepare("SELECT 
                                u.user,
                                u.id,
                                u.nome,
                                u.foto
                            FROM 
                                users as u
                            INNER JOIN
                                users_has_users as s
                            ON u.id = s.users_id1
                            WHERE s.users_id = :id");
    $query->execute(['id'=>$userid]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

// função que verifica quantos vezes um lugar foi favoritado pelo tipo
function quantFav($idLugar, $idTipo){
    global $db;


    $query = $db->prepare("SELECT COUNT(lugar_id) AS qtd FROM favorito WHERE lugar_id = :lugar AND tipo_favorito_id = :tipo");
    $query->execute(['lugar'=>$idLugar, 'tipo'=>$idTipo]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    $result = $result['qtd'];

    return $result;
}

// função que carrega todos os registros de um lugar
function exibirLugar($idLugar){
    global $db;

    $query = $db->prepare("SELECT 
                                f.foto,
                                f.lugar_id,
                                l.nome,
                                f.users_id,
                                u.foto as foto_user,
                                u.user,
                                t.id as id_tipo,
                                t.curto as tipo
                            FROM 
                                users as u
                            INNER JOIN
                                favorito as f
                            INNER JOIN
                                lugar as l
                            JOIN
                                tipo_favorito as t
                            ON f.users_id = u.id AND f.lugar_id = l.id AND f.tipo_favorito_id = t.id
                            WHERE f.lugar_id = :lugar");
    $query->execute(['lugar'=>$idLugar]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

// função que exibe todos os registros do lugar filtrando por tipo
function exibirLugarTipo($idLugar, $idTipo){
    global $db;

    $query = $db->prepare("SELECT 
                                f.foto,
                                f.lugar_id,
                                l.nome,
                                f.users_id,
                                u.foto as foto_user,
                                u.user,
                                t.id as id_tipo,
                                t.curto as tipo
                            FROM 
                                users as u
                            INNER JOIN
                                favorito as f
                            INNER JOIN
                                lugar as l
                            JOIN
                                tipo_favorito as t
                            ON f.users_id = u.id AND f.lugar_id = l.id AND f.tipo_favorito_id = t.id
                            WHERE f.lugar_id = :lugar AND f.tipo_favorito_id = :tipo");
    $query->execute(['lugar'=>$idLugar, 'tipo'=>$idTipo]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

// função que exibe todos os posts dos amigos de uma pessoa
function exibirLugarAmigos($idUser) {
    global $db;

    $query = $db->prepare("SELECT 
                                f.id as id_favorito,
                                f.foto,
                                f.lugar_id,
                                l.nome,
                                f.users_id,
                                u.foto as foto_user,
                                u.user,
                                t.id as id_tipo,
                                t.curto as tipo
                            FROM 
                                users as u
                            INNER JOIN
                                favorito as f
                            INNER JOIN
                                lugar as l
                            JOIN
                                tipo_favorito as t
                            JOIN 
                                users_has_users as p
                            ON p.users_id1 = f.users_id AND p.users_id1 = u.id 
                            AND f.lugar_id = l.id AND f.tipo_favorito_id = t.id
                            WHERE p.users_id = :id
                            ORDER BY f.id DESC");
    $query->execute(['id'=>$idUser]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

// função que exibe os favoritos mais recentes
function exibirRecente(){
    global $db;

    $query = $db->prepare("SELECT 
                                f.id as id_favorito,
                                f.foto,
                                f.lugar_id,
                                l.nome,
                                f.users_id,
                                u.foto as foto_user,
                                u.user,
                                t.id as id_tipo,
                                t.curto as tipo
                            FROM 
                                users as u
                            INNER JOIN
                                favorito as f
                            INNER JOIN
                                lugar as l
                            JOIN
                                tipo_favorito as t
                            ON u.id = f.users_id AND f.lugar_id = l.id AND f.tipo_favorito_id = t.id
                            ORDER BY f.id DESC");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


// função que busca um lugar pelo nome
function buscaLugar($busca){
    global $db;

    $busca = "%" . $busca . "%";

    $query = $db->prepare("SELECT id, nome FROM lugar WHERE nome LIKE :busca");
    $query->execute(['busca'=>$busca]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
}

// função que busca por um usuário
function buscaUser($busca){
    global $db;

    $busca = "%" . $busca . "%";

    $query = $db->prepare("SELECT user FROM users WHERE user LIKE :busca OR nome LIKE :busca");
    $query->execute(['busca'=>$busca]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
}

// função que retorna os lugares mais registrados
function topLugares(){
    global $db;

    $query = $db->prepare("SELECT
                                count(f.lugar_id) as vezes,
                                l.nome as lugar,
                                l.id
                            FROM 
                                favorito as f
                            INNER JOIN 
                                lugar as l
                            ON f.lugar_id = l.id
                            GROUP BY l.nome
                            ORDER BY vezes DESC
                            LIMIT 5;");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

// função que retorna os lugares mais registrados de acordo com o tipo
function topLugaresTipo($idTipo){
    global $db;

    $query = $db->prepare("SELECT
                                count(f.lugar_id) as vezes,
                                l.nome as lugar,
                                l.id,
                                t.nome as tipo
                            FROM 
                                favorito as f
                            INNER JOIN 
                                lugar as l
                            JOIN
                                tipo_favorito as t
                            ON f.lugar_id = l.id AND f.tipo_favorito_id = t.id
                            WHERE t.id = :id
                            GROUP BY l.nome
                            ORDER BY vezes DESC
                            LIMIT 5");
    $query->execute(['id'=>$idTipo]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

// função que exibe um post de cada um do top 3
function exibirTopPosts ($arrayTop) {
    for($i=0; $i < 3; $i++){
        $lugar = exibirLugar($arrayTop[$i]['id']);

        $lugar = end($lugar);

        $top[] = $lugar;
    }

    return $top;
}


?>