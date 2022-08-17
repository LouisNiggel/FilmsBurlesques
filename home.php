<?php get_header(); ?>

<main>
    <button type="button" class="btn btn-secondary btn-floating btn-lg text-dark btn-opacity-50 fs-3" id="btn-back-to-top">
        <i class="bi bi-chevron-up"></i>
    </button>
    <section class="p-2 px-md-5">
        <div class="container-fluid">
            <div class="row py-3 actus">
                <div class="text-center">
                    <h1>Actualités</h1>
                    <h1 class="pb-3">Retrouvez toute l'actualité du festival...</h1>
                </div>
                <?php
                    if ( have_posts() ) {
	                    while ( have_posts() ) {
		                    the_post(); 
		                    the_content();?>
                            <div class="col-md-4"></div>
                            <button type="button" class="btn btn-light mb-3 ms-5" style="width:auto">
                                <a style="text-decoration:none;color:black" href="<?php the_permalink() ?>">
                                    Lire la suite
                                </a>
                            </button>
                            <?php
	                    }
                    }
                ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <span>&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section> 
</main>

<?php get_footer(); ?>