<?php

/****
 * Template name: Home
 ***/

get_header();

$api = new CatAPI(API_KEY);

// Definir página atual baseado no parâmetro GET
$pagina_atual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

// Capturar o termo de busca
$termo_busca = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

// Se houver um termo de busca, usar a função de pesquisa
if (!empty($termo_busca)) {
    $racas = $api->pesquisarRacas([
        'q' => $termo_busca,
        'limit' => 12,
        'page' => $pagina_atual - 1,
        'attach_breed' => 1,
        'order' => 'ASC'
    ]);
} else {
    // Caso contrário, listar todas as raças
    $racas = $api->listarRacas(12, $pagina_atual - 1, [
        'attach_breed' => 1,
        'order' => 'ASC'
    ]);
}

// Calcular o total de páginas
$total_items = isset($racas['total']) ? $racas['total'] : 0;
$total_paginas = ceil($total_items / 12);

?>

<main>
    <div class="container">
        <div class="columns">
            <div class="col-12 text-center">
                <h2>Take a Look at Some of Our Pets</h2>
            </div>
            <div class="navigation d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <form method="GET" action="<?php echo home_url(); ?>" class="search-form">
                    <input type="text" 
                           name="q" 
                           placeholder="search ..." 
                           value="<?php echo esc_attr($termo_busca); ?>">
                </form>
                <a href="/favoritos">My favorites</a>
            </div>
        </div>
    </div>
</main>

<?php 
get_template_part('template-parts/content', 'cats', array(
    'gatos' => $racas,
    'favoritos' => array()
));

get_template_part('template-parts/pagination', null, array(
    'pagina_atual' => $pagina_atual,
    'termo_busca' => $termo_busca,
    'total_paginas' => $total_paginas
));

get_footer();
?>
