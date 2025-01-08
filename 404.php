<?php get_header() ?>

<div id="notfound">
    <div class="notfound">
        <div
            class="notfound-404"
            style="background-image: url(<?php echo get_template_directory_uri() . '/assets/img/emoji.png' ?>);"
        ></div>
        <h1>404</h1>
        <h2>Oops! A página não pode ser encontrada</h2>
        <p>
            Sentimos muito, mas a página que você procura não existe ou foi apagada.
            O nome pode ter mudado ou está temporariamente indisponível.
        </p>
        <a href="<?php echo site_url() ?>">Voltar para a Home</a>
    </div>
</div>

<?php get_sidebar() ?>
<?php get_footer() ?>
