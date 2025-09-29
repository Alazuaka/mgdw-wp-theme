<?php
/*
Template Name: Главная
*/
get_header();
?>
<section class="container">
    <?php $rows = get_field('main_slider'); ?>
    <?php if (have_rows('main_slider')): ?>
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php $i = 0;
                while (have_rows('main_slider')): the_row(); ?>
                    <div class="carousel-item <?php echo $i++ == 0 ? 'active' : ''; ?>">
                        <picture>
                            <source media="(min-width: 768px)" srcset="<?php echo get_sub_field('image_xl')['url'] ?? ''; ?>">
                            <img src="<?php echo get_sub_field('image_xs')['url'] ?? get_sub_field('image_xl')['url'] ?? ''; ?>" alt="<?php echo get_sub_field('alt') || get_sub_field('image_xs')['alt'] ?? 'Описание слайда'; ?>" class="d-block w-100 hero-img">
                        </picture>
                        <div class="carousel-caption">
                            <h2><?php the_sub_field('title'); ?></h2>
                            <p><?php the_sub_field('descr'); ?></p>
                            <?php $button = get_sub_field('link');
                            if ($button): ?>
                                <a href="<?php echo get_permalink($button); ?>" class="btn btn-primary">Подробнее</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <a class="carousel-control-prev" href="#carousel" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></a>
            <a class="carousel-control-next" href="#carousel" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></a>
        </div>
    <?php else: ?>
        <p>Debug: Repeater пустой или имя поля кривое</p>
    <?php endif; ?>
</section>
<?php get_footer(); ?>