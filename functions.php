<?php 

/* Registro de estilos y scripts*/
function enqueue() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_script( 'icon-scripts', get_stylesheet_directory_uri() . "/main.js", array('jquery'), false, true );
}
add_action('wp_enqueue_scripts', 'enqueue');

/* Función del endpoint */
function coinapi($data) {
    $cache_time = get_theme_mod( 'cmtinz_coinapi_cache' );
    $cache_time = $cache_time? $cache_time * 60 : 60;
    $get_coinapi_data = get_transient('coinapi_data');
    if (!$get_coinapi_data) {
        $get_coinapi_data = get_coinapi_data();
        set_transient( 'coinapi_data', $get_coinapi_data, $cache_time );
        $get_coinapi_data['cached'] = false;
    } else {
        $get_coinapi_data['cached'] = true;
    }
    return $get_coinapi_data;
}

/* Consulta CoinAPI */
function get_coinapi_data() {
    $base_asset_id = "USD";
    $coins = array(
        array('asset_id' => 'BTC', 'name' => 'Bitcoin'),
        array('asset_id' => 'ETH', 'name' => 'Etherum'),
        array('asset_id' => 'XRP', 'name' => 'Ripple'),
        array('asset_id' => 'LTC', 'name' => 'Litecoin'),
        array('asset_id' => 'ADA', 'name' => 'Cardano')
    );
    foreach($coins as &$coin) {
        $rate = get_exchange_rate($base_asset_id, $coin['asset_id']);
        if (is_wp_error($rate)) return $rate;
        $coin['rate'] = $rate;
    }
    return array(
        'base_asset_id' => $base_asset_id,
        'coins' => $coins
        );
}

/* Registro de Endpoint REST */
add_action( 'rest_api_init', function () {
    register_rest_route( 'cmtinz/v1', '/coinapi', array(
        'methods' => 'GET',
        'callback' => 'coinapi',
    ) );
    } );

/* Buscar tasa de cambio*/
function get_exchange_rate($base, $quote) {
    $key = get_theme_mod( 'cmtinz_coinapi_key' );
    if (empty($key)) return new WP_Error('internal_error', __('Clave de API no especificada', 'cmtinz'));
    $url = "https://rest.coinapi.io/v1/exchangerate/$quote/$base";
    $args = array(
        "headers" => array('X-CoinAPI-Key' => $key)
    );
    $request = wp_safe_remote_get($url, $args);
    if (is_wp_error($request))  {return $request;}
    $response = json_decode(wp_remote_retrieve_body($request), true);
    if ($response['error']) return new WP_Error('internal_error', __('Error del servidor', 'cmtinz'), $response);
    return is_numeric( $rate = $response['rate'] )? $rate: new WP_Error('internal_error', __('No hay respuesta numérica por parte del serividor', 'cmtinz'), $response);
}

function registrar_opciones($wp_customize) {

    /* Agrega la sección CoinAPI */
	$wp_customize->add_section('cmtinz_coinapi', array(
		'title' => __( 'CoinAPI', 'cmtinz' ),
		'description' => __('Opciones de CoinAPI', 'cmtinz'),
		'capability' => 'edit_theme_options',
		'prority' => 30
	));

    /* Agrega item Api Key */
    $wp_customize->add_setting( "cmtinz_coinapi_key", array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => 'default',
		) );

	$wp_customize->add_control( "cmtinz_coinapi_key", array(
	'type' => 'text',
	'section' => 'cmtinz_coinapi',
	'label' => __( "Clave de CoinAPI", 'cmtinz' )
    ) );

    /* Agrega item Tiempo de Cache */
    $wp_customize->add_setting( "cmtinz_coinapi_cache", array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '60',
		'transport' => 'default',
		) );

	$wp_customize->add_control( "cmtinz_coinapi_cache", array(
	'type' => 'number',
	'section' => 'cmtinz_coinapi',
    'label' => __( "Tiempo de vida del cache", 'cmtinz' ),
    'description' => __('Tiempo de vida del cache en minutos.'),
    'input_attrs' => array('min' => 0)
    ) );
}
add_action('customize_register', 'registrar_opciones');
?>