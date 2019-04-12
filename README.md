# wp-coinapi

## La prueba consiste en

* Construir un template de wordpress desde 0, cuya única función sea consumir la api de coinapi.io

* El consumo puede ser mediante php o javascript.

* La idea es mostrar los precios de al menos 5 monedas en tiempo real.

* El diseño es libre, solo se medira la calidad del css.

Una vez terminado enviar zip e instrucciones de instalación.

## Síntaxis Docker

- Base de datos creada previamente.
- docker run --name wp-coinapi -e WORDPRESS_TABLE_PREFIX=coin_ --link mysql-db:mysql -v /Users/User/Documents/wp-coinapi:/var/www/html/wp-content/themes/wp-coinapi -p 8080:80 -d wordpress