<?php get_header(); ?>

<main>
    <button type="button" class="btn btn-secondary btn-floating btn-lg text-dark btn-opacity-50 fs-3" id="btn-back-to-top">
        <i class="bi bi-chevron-up"></i>
    </button>
    <section class="p-2 px-md-5">
        <div class="container-fluid">
            <div class="row py-3">
                <?php
                    if ( have_posts() ) {
	                    while ( have_posts() ) {
		                    the_post(); 
		                    the_content();
	                    }
                    }
                ?>
            </div>
        </div>
    </section> 
</main>

<?php get_footer(); ?>