<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= wp_get_document_title() ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <h1>WP CoinAPI</h1>
    </header>
    <main>
        <p>Cuerpo principal</p>
    </main>
    <footer>
        <p>Autor: Carlos Martínez P.</p>
    </footer>
</body>
<?php wp_footer(); ?>
</html>