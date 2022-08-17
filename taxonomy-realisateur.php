<?php get_header(); ?>

<main>
    <button type="button" class="btn btn-secondary btn-floating btn-lg text-dark btn-opacity-50 fs-3" id="btn-back-to-top">
        <i class="bi bi-chevron-up"></i>
    </button>
    <section class="p-2 px-md-5">
        <div class="container-fluid">
            <div class="row py-3">
                <div class="text-center">
                    <h1>La programmation</h1>
                    <h1 class="pb-3">Des pépites à (re)découvrir...</h1>
                </div>
                <?php
                    if ( have_posts() ) {
	                    while ( have_posts() ) {
                            the_post(); ?>
                            <div class="col-xs-12 col-sm-6 col-lg-4 col-xl-3 d-flex justify-content-center">
                                <div class="card" style="width: 18rem;">
                                    <img src="<?php the_post_thumbnail_url(); ?>" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php the_title(); ?></h5>
                                        <span class="card-text"><?php the_excerpt(); ?></span>
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">En savoir +</a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                ?>
            </div>
        </div>
    </section> 
</main>

<?php get_footer(); ?>