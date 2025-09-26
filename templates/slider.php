<?php if (is_front_page()) {  // Только на главной
 $slides = get_posts(['post_type' => 'slider_slide', 'numberposts' => -1, 'post_status' => 'publish']);
 if ($slides) { ?>
  <div id="main-carousel" class="carousel slide" data-ride="carousel">
   <div class="carousel-inner">
    <?php $i = 0;
    foreach ($slides as $slide) {
     $active = $i++ == 0 ? ' active' : ''; ?>
     <div class="item<?php echo $active; ?>">
      <img src="<?php echo wp_get_attachment_url(get_post_meta($slide->ID, 'slide_image', true)); ?>" alt="<?php echo $slide->post_title; ?>">
      <div class="carousel-caption">
       <h3><?php echo $slide->post_title; ?></h3>
       <?php if ($link = get_post_meta($slide->ID, 'slide_link', true)) { ?>
        <a href="<?php echo $link; ?>" class="btn btn-primary">Подробнее</a>
       <?php } ?>
      </div>
     </div>
    <?php } ?>
   </div>
   <a class="left carousel-control" href="#main-carousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
   <a class="right carousel-control" href="#main-carousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
  </div>
 <?php } ?>
<?php } ?>