<section class="hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col align-items-center text-center">
        <h1>
          <div class="h3 color-light slide-up-animate delay-2-point-5"><?= $hero_content['subheadline']; ?></div>
          <span class="slide-up-animate delay-2-point-75"><?= $hero_content['headline']; ?></span>
        </h1>
        <a href="<?= $hero_content['cta']['url'] ?>" class="btn btn-primary btn-light fancyHover slide-up-animate delay-3"><?= $hero_content['cta']['title']; ?></a>
      </div>
    </div>
  </div>
  <a href="<?= $hero_content['cta']['url'] ?>" class="arrow slide-up-30-animate delay-3-point-5"><img src="<?= get_stylesheet_directory_uri(); ?>/dist/images/arrow.png" alt="Learn More"/></a>
</section>
