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
        <h1><?= get_bloginfo('title') ?></h1>
    </header>
    <main>
        
    </main>
    <footer>
        <p>Autor: <a href="https://github.com/cmtinz">Carlos Martínez P.</a> Basado en <a href="https://coinapi.io">CoinAPI.io</a></p>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>