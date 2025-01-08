<?php

$api = new CatAPI(API_KEY);

$gatos = $args['gatos'];

$favoritos = $api->listarFavoritos(100); 
?>

<div class="container my-4 content-cats">
    <div class="row">
        <?php if (!empty($gatos['data'])): ?>
            <?php foreach ($gatos['data'] as $gato):
                if (!empty($gato['image']['url'])):
            ?>
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card h-100">
                        <?php if ($gato['rare'] == 1): ?>
                            <div class="rare-card">
                                <img src="<?php echo get_template_directory_uri() . '/assets/images/rare.png'; ?>" alt="Rare">
                            </div>
                        <?php endif; ?>
                        <img src="<?php echo esc_url($gato['image']['url']); ?>"
                            class="card-img-top"
                            alt="Gato">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-between col-12">
                                <h5><?php echo $gato['name']; ?></h5>
                                <?php if (is_user_logged_in()): ?>
                                    <?php 
                                    $image_id = $gato['reference_image_id'];
                                    $favorite_id = false;
                                    
                                    foreach ($favoritos['data'] as $favorito) {
                                        if ($favorito['image_id'] === $image_id) {
                                            $favorite_id = $favorito['id'];
                                            break;
                                        }
                                    }
                                    
                                    $favorite = in_array($gato['reference_image_id'], array_column($favoritos['data'], 'image_id'));
                                    ?>
                                    <div class="favoritar-gato <?php echo $favorite ? 'favoritado' : ''; ?>"
                                         data-image-id="<?php echo $image_id; ?>"
                                         data-favorite-id="<?php echo $favorite_id; ?>">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="transparent" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" stroke="black" stroke-width="2" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-infos col-12 row">
                                <span class="col-12">
                                    <?php echo !(empty($gato['alt_names'])) ? $gato['alt_names'] : 'No alt names'; ?>
                                </span>
                                <b class="col-12">
                                    <?php echo $gato['temperament']; ?>
                                </b>
                            </div>
                            <div class="card-location col-12 d-flex align-items-center gap-2">

                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="location_on">
                                        <g id="Vector">
                                            <path d="M7.99992 1.33334C5.41992 1.33334 3.33325 3.42001 3.33325 6.00001C3.33325 9.50001 7.99992 14.6667 7.99992 14.6667C7.99992 14.6667 12.6666 9.50001 12.6666 6.00001C12.6666 3.42001 10.5799 1.33334 7.99992 1.33334ZM4.66659 6.00001C4.66659 4.16001 6.15992 2.66668 7.99992 2.66668C9.83992 2.66668 11.3333 4.16001 11.3333 6.00001C11.3333 7.92001 9.41325 10.7933 7.99992 12.5867C6.61325 10.8067 4.66659 7.90001 4.66659 6.00001Z" fill="#0A453A" />
                                            <path d="M7.99992 7.66668C8.92039 7.66668 9.66659 6.92049 9.66659 6.00001C9.66659 5.07954 8.92039 4.33334 7.99992 4.33334C7.07944 4.33334 6.33325 5.07954 6.33325 6.00001C6.33325 6.92049 7.07944 7.66668 7.99992 7.66668Z" fill="#0A453A" />
                                        </g>
                                    </g>
                                </svg>

                                <h6 class="">
                                    <?php echo $gato['origin'] . "," . $gato['country_code'] ?>
                                </h6>
                            </div>

                            <div class="card-points col-12 d-flex align-items-center justify-content-between flex-wrap">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Life Span
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['life_span']) ? $gato['life_span'] : '0'; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Indoor
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['indoor']) ? $gato['indoor'] : '0'; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Lap
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['lap']) ? $gato['lap'] : '0'    ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Adaptability
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['adaptability']) ? $gato['adaptability'] : '0'  ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Affection
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['affection_level']) ? $gato['affection_level'] : '0'    ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Child Friendly
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['child_friendly']) ? $gato['child_friendly'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Grooming
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['grooming']) ? $gato['grooming'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Health Issues
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['health_issues']) ? $gato['health_issues'] : '0'        ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Intelligence
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['intelligence']) ? $gato['intelligence'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Shedding
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['shedding_level']) ? $gato['shedding_level'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Social Needs
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['social_needs']) ? $gato['social_needs'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Stranger Friendly
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['stranger_friendly']) ? $gato['stranger_friendly'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Vocalization
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['vocalisation']) ? $gato['vocalisation'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Experimental
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['experimental']) ? $gato['experimental'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Hairless
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['hairless']) ? $gato['hairless'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Natural
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['natural']) ? $gato['natural'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Rex
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['rex']) ? $gato['rex'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Supressed tail
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['suppressed_tail']) ? $gato['suppressed_tail'] : '0'      ; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>
                                        Hypoallergenic
                                    </span>
                                    <span>
                                        <?php echo !empty($gato['hypoallergenic']) ? $gato['hypoallergenic'] : '0'      ; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-more-info col-12">
                                <p class="d-block">
                                    <?php echo substr($gato['description'], 0, 59) . '...'; ?>
                                </p>
                                <p class="d-none">
                                    <?php echo $gato['description']; ?>
                                </p>
                                <button class="" onclick="moreInfo(event)">
                                    More Info
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            <?php 
                endif;
            endforeach; 
            ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Nenhum gato encontrado.</p>
            </div>
        <?php endif; ?>
    </div>
</div>