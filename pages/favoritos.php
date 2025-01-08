<?php
/**
 * Template Name: Favoritos
 */

get_header();

$api = new CatAPI(API_KEY);

// Define itens por página
$itens_por_pagina = 4;
$pagina_atual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

// Busca todos os favoritos primeiro
$favoritos = $api->listarFavoritos(100); 

// Busca todas as raças com detalhes
$racas = $api->listarRacas(100, 0, [
    'attach_breed' => 1,
    'order' => 'ASC'
]);

// Filtra as raças para mostrar apenas as que estão nos favoritos
$racas_filtradas = array_filter($racas['data'], function($raca) use ($favoritos) {
    return in_array($raca['reference_image_id'], array_column($favoritos['data'], 'image_id'));
});

// Calcula o total de páginas
$total_itens = count($racas_filtradas);
$total_paginas = ceil($total_itens / $itens_por_pagina);

// Aplica a paginação
$offset = ($pagina_atual - 1) * $itens_por_pagina;
$racas_paginadas = array_slice($racas_filtradas, $offset, $itens_por_pagina);

$racas_favoritas = array(
    'data' => $racas_paginadas,
    'total' => $total_itens
);

?>

<main>
    <div class="container">
        <div class="columns">
            <div class="col-12 text-center py-5">
                <h2>You liked these:</h2>
            </div>
        </div>
    </div>
</main>

<?php 
// Passa as raças filtradas e os favoritos para o template
get_template_part('template-parts/content', 'cats', array(
    'gatos' => $racas_favoritas,
    'favoritos' => $favoritos
));

?>

<?php if ($total_paginas > 1): ?>
<div class="pagination text-center mb-4 d-flex justify-content-center align-items-center">
    <!-- Botão Anterior -->
    <a href="<?php echo $pagina_atual > 1 ? '?pagina=' . ($pagina_atual - 1) : '#'; ?>" 
       class="<?php echo $pagina_atual <= 1 ? 'disabled' : ''; ?>"
       <?php echo $pagina_atual <= 1 ? 'aria-disabled="true"' : ''; ?>>
        Prev
    </a>

    <!-- Números das páginas -->
    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
        <a href="?pagina=<?php echo $i; ?>" 
           class="<?php echo $i === $pagina_atual ? 'active-button' : ''; ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <!-- Botão Próximo -->
    <a href="<?php echo $pagina_atual < $total_paginas ? '?pagina=' . ($pagina_atual + 1) : '#'; ?>" 
       class="<?php echo $pagina_atual >= $total_paginas ? 'disabled' : ''; ?>"
       <?php echo $pagina_atual >= $total_paginas ? 'aria-disabled="true"' : ''; ?>>
        Next
    </a>
</div>
<?php endif; ?>

<?php get_footer(); ?>