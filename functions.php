<?php

function theme_add_thumbnail_support(){
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme','theme_add_thumbnail_support');

function wp_style_theme(){
  wp_enqueue_style('style', get_stylesheet_uri());
  wp_enqueue_script('script-js', get_template_directory_uri() . '/assets/js/script.js', array(),'1.0.0', true);
}
add_action('wp_enqueue_scripts','wp_style_theme');

// bootstrap 5 wp_nav_menu walker
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
{
  private $current_item;
  private $dropdown_menu_alignment_values = [
    'dropdown-menu-start',
    'dropdown-menu-end',
    'dropdown-menu-sm-start',
    'dropdown-menu-sm-end',
    'dropdown-menu-md-start',
    'dropdown-menu-md-end',
    'dropdown-menu-lg-start',
    'dropdown-menu-lg-end',
    'dropdown-menu-xl-start',
    'dropdown-menu-xl-end',
    'dropdown-menu-xxl-start',
    'dropdown-menu-xxl-end'
  ];

  function start_lvl(&$output, $depth = 0, $args = null)
  {
    $dropdown_menu_class[] = '';
    foreach($this->current_item->classes as $class) {
      if(in_array($class, $this->dropdown_menu_alignment_values)) {
        $dropdown_menu_class[] = $class;
      }
    }
    $indent = str_repeat("\t", $depth);
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $this->current_item = $item;

    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array) $item->classes;

    $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
    $classes[] = 'nav-item';
    $classes[] = 'nav-item-' . $item->ID;
    if ($depth && $args->walker->has_children) {
      $classes[] = 'dropdown-menu dropdown-menu-end';
    }

    $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = ' class="' . esc_attr($class_names) . '"';

    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
    $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
    $nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
    $attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}
//nouveau menu
function aregister_nav_menu(){
    register_nav_menu( 'principal-menu', __('Menu Principal'));
}

add_action('init', 'aregister_nav_menu');

// Sidebar*
function wpdocs_theme_widgets_init(){
  register_sidebar( array(
    'id' => 'page-sidebar',
    'name' => 'Footer',
    'before_widget'  => '<div class="col-xs-12 col-sm-12 col-md-4 style="list-style-type=none">',
    'after_widget'  => '</div>',
  ) );
}
add_action('widgets_init','wpdocs_theme_widgets_init');

// Page programmation des films
function wpm_custom_post_type(){
  
  // Custom Post Type Film
  $labels = array(
		// Le nom au pluriel
		'name'                => _x( 'Films', 'Post Type General Name'),
		// Le nom au singulier
		'singular_name'       => _x( 'Film', 'Post Type Singular Name'),
		// Le libellé affiché dans le menu
		'menu_name'           => __( 'Films'),
		// Les différents libellés de l'administration
		'all_items'           => __( 'Tous les films'),
		'view_item'           => __( 'Voir les films'),
		'add_new_item'        => __( 'Ajouter un nouveau film'),
		'add_new'             => __( 'Ajouter'),
		'edit_item'           => __( 'Editer le film'),
		'update_item'         => __( 'Modifier le film'),
		'search_items'        => __( 'Rechercher un film'),
		'not_found'           => __( 'Non trouvé'),
		'not_found_in_trash'  => __( 'Non trouvé dans la corbeille'),
	);

  $args = array(
		'label'               => __( 'Films'),
		'description'         => __( 'Tout sur les Films'),
		'labels'              => $labels,
		// On définit les options disponibles dans l'éditeur de notre custom post type ( un titre, un auteur...)
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		/* 
		* Différentes options supplémentaires
		*/
		'show_in_rest'        => true,
		'hierarchical'        => false,
		'public'              => true,
		'has_archive'         => true,
		'rewrite'			        => array( 'slug' => 'films'),

	);

  register_post_type( 'films', $args );

  // Déclaration Taxonomie Réalisateur
  $label = array(
    'name' => 'Réalisateur',
    'new_item_name' => 'Nom du nouveau réalisateur',
    'parent_item' => 'Type de réalisateur'
  );

  $arg = array(
    'label' => 'Réalisateur',
    'labels' => $label,
    'public' => true,
    'show_in_rest' => true,
    'hierarchical' => true
  );

  register_taxonomy( 'realisateur', 'films', $arg );

};

add_action( 'init', 'wpm_custom_post_type' );