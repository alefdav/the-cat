<?php /*  Template Name: categoria */
global $paged;
$category = get_queried_object();
get_header();
wp_custom_breadcrumbs();

if (have_posts()) {
    while (have_posts()) {
        the_post();
    ?>

        <h1><a href="<?php echo esc_url(get_category_link(get_the_category()[0]->term_id)) ?>"><?php echo get_the_category()[0]->name; ?></a></h1>

        <h1 class="titulo-post">
            <a href="<?php the_permalink() ?>">
                <?php the_title(); ?>
                <?php the_content(); ?>
            </a>
        </h1>

<?php } ?>


<nav class="paginacao">
    <ul class="pagination justify-content-center">
        <?php
            if (get_previous_posts_link()) {
        ?>
        <li class="btn btn-primary">
            <?php previous_posts_link('Anterior'); ?>
        </li>
        <?php
            }
            if (get_previous_posts_link() || get_next_posts_link()) {
        ?>
            <li class="page-item active">
                <a class="" href="#">
                    <?php echo ($paged) ? $paged : '1' ?>
                </a>
            </li>
        <?php
            } if (get_next_posts_link()) {
        ?>
                <li class="btn btn-primary">
                    <?php next_posts_link('Próxima'); ?>
                </li>
        <?php
            }
        ?>
    </ul>
</nav>
<?php } else { ?>
    <p>Nada encontrado.</p>
<?php } ?>
<div id="sidebar-cat" class="col-12 col-lg-4 col-xl-3 ml-auto">
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
