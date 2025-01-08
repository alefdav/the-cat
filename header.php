<!doctype html>
<html lang="pt">

<head>

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="manifest" href="<?php bloginfo('template_url') ?>/manifest.json">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header>

    <div class="container h-100 d-flex">
      <div class="col-12">
        <div class="breadcrumb-container">
          <a href="<?php echo home_url(); ?>">Home</a>
          <?php 
          if (is_page('favoritos')) {
            echo '<a href='.home_url().'>Search</a>';
            echo '<span class="selected">My Favorites</span>';
          }else{
            echo '<span class="selected">Search</span>';
          }
          ?>
        </div>
      </div>
      
    </div>
  </header>