<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation d'un article</title>
</head>
<body>
    <h2>Creation Article</h2>
    <form action="" method="post">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" required><br>

        <label for="body">Contenu de l'article</label>
        <textarea id="body" name="body" required></textarea><br>

        <label for="category">Categorie</label>
        <input type="text" id="category" name="category" required><br>

        <input type="submit" value="Publier">
    </form>
</body>
</html>