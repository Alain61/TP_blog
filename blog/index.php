<?php declare(strict_types=1);

// Seulement des appels de fonctions ici ! Aucune définition
require_once 'functions.php';
require_once 'create.php';

$pdo = getPDO('mysql:host=localhost;dbname=blog','root','');


$perPage = 10;
$page = 2;
/*
$postsWithCategories = getPostsWithCategories($pdo, $page, $perPage);
*/

/*
$postId = 8; 
$postWithCategory = getPostWithCategory($postId, $pdo);

if ($postWithCategory !== false) {
    
    var_dump($postWithCategory);

} else {
    // si l'article n'existe pas
    echo "L'article avec l'ID $postId n'existe pas.";
}
*/


/*
$categoryId = 1; 
$postsByCategory = getPostsByCategory($categoryId, $pdo, $page, $perPage);

// si des articles existent pour cette catégorie, on peut utiliser les données
if (!empty($postsByCategory)) {
    
    foreach ($postsByCategory as $post) {
        echo'<pre>';
        var_dump($post);
        echo'</pre>';
    
    }
} else {
    // si aucun article pour cette catégorie
    echo "Aucun article pour la catégorie avec l'ID $categoryId.";
}

echo'<pre>';
var_dump($postsByCategory);
echo'</pre>';
*/

//appel de la fonction createPost
if(createPost($pdo, $_POST))
{
    return true;
}else{
    return false;
}