<?php
$pagina_atual = $args['pagina_atual'];
$termo_busca = isset($args['termo_busca']) ? $args['termo_busca'] : '';
$total_paginas = isset($args['total_paginas']) ? $args['total_paginas'] : 1;

// Se não houver resultados ou apenas uma página, não mostra a paginação
if ($total_paginas <= 1) {
    return;
}

$query_params = [];
if (!empty($termo_busca)) {
    $query_params['q'] = urlencode($termo_busca);
}
?>

<div class="pagination-container">
    <div class="col-12">
        <nav aria-label="Navegação de páginas">
            <ul class="pagination justify-content-center">
                <?php 
                $query_params['pagina'] = $pagina_atual - 1;
                $prev_url = add_query_arg($query_params, home_url());
                ?>
                <li class="back-button <?php echo ($pagina_atual <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo esc_url($prev_url); ?>" data-page="<?php echo $pagina_atual - 1; ?>" <?php echo ($pagina_atual <= 1) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>Prev</a>
                </li>

                <?php
                $inicio = max(1, $pagina_atual - 2);
                $fim = min($total_paginas, $pagina_atual + 2);
                
                for ($i = $inicio; $i <= $fim; $i++): 
                    $query_params['pagina'] = $i;
                    $page_url = add_query_arg($query_params, home_url());
                ?>
                    <li class="page-item">
                        <a class="<?php echo $i === $pagina_atual ? 'active-button' : ''; ?>" 
                           href="<?php echo esc_url($page_url); ?>" 
                           data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagina_atual < $total_paginas): 
                    $query_params['pagina'] = $pagina_atual + 1;
                    $next_url = add_query_arg($query_params, home_url());
                ?>
                    <li class="next-button">
                        <a class="page-link" href="<?php echo esc_url($next_url); ?>" data-page="<?php echo $pagina_atual + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div> 