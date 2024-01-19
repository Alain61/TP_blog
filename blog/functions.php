<?php declare(strict_types=1);
require_once 'create.php';
// Seulement des définitions de fonctions ici ! Aucun appel

function getPDO(string $dsn, string $user, string $password):PDO
{
    return new PDO($dsn, $user, $password);
}

function getPostsWithCategories(PDO $pdo, int $page, int $perPage): array
{
    //$page-1 represente le n° de la page actuelle dont je soustrait 1 pour avoir
    // l'indice du tableau à 0 que je multiplie par le nbre d'articles par page
    $offset = ($page -1)*$perPage;
    
    $query = $pdo->prepare(
        'SELECT posts.title, posts.excerpt, posts.created_at, categories.name 
         AS category_title
         FROM posts 
         LEFT JOIN categories 
         ON posts.category_id=categories.id
         ORDER BY posts.created_at DESC
         LIMIT :perPage OFFSET :offset
    ');

    $query->bindParam(':perPage', $perPage, PDO::PARAM_INT);
    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
    $query->execute();

    //requete du nombre total d'entrées de la table posts
    $countQuery = $pdo->query('SELECT COUNT(*) FROM posts');
    $totalCount = $countQuery->fetchColumn();

    //calcul du nombre de page arrondi à l'entier supérier
    $totalPages = ceil($totalCount/$perPage);

    //construction du tableau avec les informations de pagination
    $result = [
        'count' => $totalCount,
        'per_page'=> $perPage,
        'page' => [
            'current' => $page,
            'total' => $totalPages
        ],
        'data'=>$query->fetchAll(PDO::FETCH_ASSOC),
    ];
    return $result;

}

function getPostWithCategory(int $postId, PDO $pdo ): array|false
{
    $query = $pdo->prepare(
        'SELECT  posts.*, categories.name AS category_name
        FROM posts 
        LEFT JOIN categories  ON posts.category_id=categories.id
        WHERE posts.id=:postId
        
    ');

    $query->bindParam(':postId', $postId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if(!$result){
        return false;
    }else{
        return $result ;
    }   
}


function getPostsByCategory(int $categoryId, PDO $pdo, int $page, int $perPage) :array
{
    $offset = ($page - 1) * $perPage;

    $query = $pdo->prepare(
        'SELECT posts.*, categories.name AS category_name
        FROM posts
        LEFT JOIN categories ON posts.category_id = categories.id
        WHERE categories.id = :categoryId
        ORDER BY posts.created_at DESC
        LIMIT :perPage OFFSET :offset'

    );

    $query->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    $query->bindParam(':perPage', $perPage, PDO::PARAM_INT);
    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    $countQuery = $pdo->prepare('SELECT COUNT(*) FROM posts WHERE category_id = :categoryId');
    $countQuery->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    $countQuery->execute();
    $totalCount = $countQuery->fetchColumn();

    $totalPages = ceil($totalCount/$perPage);

    $result = [
        'count' => $totalCount,
        'per_page' => $perPage,
        'page' => [
            'current' => $page,
            'total' => $totalPages,
        ],
        'data' => $query->fetchAll(PDO::FETCH_ASSOC),
    ];

    return $results;
}

function createPost(PDO $pdo, array $postData): bool
{
    //si le formulaire a été soumis
    if(!empty($postData)){
        $errors = [];

        $title = $postData['title'] ?? '';
        $body = $postData['body'] ?? '';
        $category = $postData['category'] ?? '';

        
        if(!$errors && $title !== '' && $body !== '' && $category !== '')
        {
           $query = $pdo->prepare('
           
           INSERT INTO posts (title, body, category) VALUES (:title, :body, :category);

           ');

           $query->bindValue('title', $_POST['title'], PDO::PARAM_STR);
           $query->bindValue('body', $_POST['body'], PDO::PARAM_STR);
           $query->bindValue('category', $_POST['category'], PDO::PARAM_STR);
           return $query->execute();
        }
    }
    return false;
}

function updatePost()
{

}
