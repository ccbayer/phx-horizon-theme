<footer class="content-info">
  <div class="footer-primary">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-4">
          <nav>
            <?php
              if (has_nav_menu('footer_navigation')) :
                wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'nav']);
              endif;
            ?>
          </nav>
        </div>
        <?php
          $contact = get_field('footer_contact_info', 'options');
          if($contact):
        ?>
        <div class="col-xs-12 col-md-4">
          <h4 class="h3"><?= $contact['footer_contact_headline'] ?: 'Contact Us' ?></h4>
          <p><a class="fancyHover" href="mailto:<?= $contact['footer_email_address']; ?>"><?= $contact['footer_email_address']; ?></a></p>
          <p><a href="tel:+<?= $contact['footer_phone_number']; ?>"><?= $contact['footer_phone_number']; ?></a></p>
        </div>
        <?php
          endif;
        ?>
        <?php
          $locations = get_field('footer_locations_group', 'options');
          if($locations):
        ?>
        <div class="col-xs-12 col-md-4">
          <h4 class="h3"><?= $locations['footer_locations_headline'] ?: 'Locations' ?></h4>
          <ul>
            <?php foreach($locations['footer_locations'] as $loc): ?>
            <li><?= $loc['location']; ?></li>
          <?php endforeach; ?>
          </ul>
        </div>
        <?php
          endif;
        ?>
      </div>
      <?php
        $branding = get_field('footer_branding', 'options');
        if($branding):
      ?>
      <div class="row">
        <div class="col text-center footer-logo">
          <?php if($branding['link']): ?>
          <a href="<?= $branding['link']['url'] ?>" target="<?= $branding['link']['target'] ?>">
          <?php endif; ?>
            <?php if($branding['image']): ?>
            <img src="<?= $branding['image']['url'] ?>" alt="<?= $branding['image']['alt'] ?>"/>
          <?php elseif($branding['link']): ?>
            <?= $branding['link']['title']; ?>
          <?php endif; ?>
          <?php if($branding['link']): ?>
          </a>
          <?php endif ?>
        </div>
      </div>
      <?php endif; ?>
      <div class="row">
        <div class="col text-center">
          <?php
          $copyright = get_field('footer_copyright', 'options');
          if($copyright):
            foreach($copyright as $copy):
          ?>
          <small>
            <?php
              if($copy['copyright_info_type'] === 'link' && $copy['copyright_link']):
                echo '<a href="'.$copy['copyright_link']['url'].'" target="'.$copy['copyright_link']['target'].'">'.$copy['copyright_link']['title'].'</a>';
              elseif($copy['copyright_info_type'] === 'text' && $copy['copyright_text']):
                echo '&copy;'.date('Y').' '.$copy['copyright_text'];
              endif;
            ?>
          </small>
        <?php endforeach; ?>
      <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php
    $footer_logos = get_field('footer_logos', 'options');
    if($footer_logos):
  ?>
  <div class="footer-secondary">
    <div class="container">
      <div class="row">
        <div class="col text-center">
          <?php if($footer_logos['footer_headline']): ?>
          <small><?= $footer_logos['footer_headline'] ?></small>
        <?php endif; ?>
      </div>
    </div>
    <div class="row justify-content-center align-items-center">
        <?php foreach($footer_logos['logos'] as $logo): ?>
          <div class="col-md-2 align-self-center text-center">
          <?php
            $link = $logo['link'] ?? false;
            if($link):
          ?>
            <a href="<?= $logo['link']['url'] ?>" target="<?= $logo['link']['target'] ?>"><img src="<?= $logo['image']['url'] ?>" alt="<?= $logo['image']['alt'] ?>" class="logo"></a>
          <?php else: ?>
            <img src="<?= $logo['image']['url'] ?>" alt="<?= $logo['image']['alt'] ?>" class="logo">
          <?php endif; ?>
        </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</footer>
