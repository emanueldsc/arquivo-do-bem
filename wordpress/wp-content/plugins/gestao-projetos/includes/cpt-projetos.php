<?php
function gp_register_projetos() {
    register_post_type('projeto', [
        'labels' => [
            'name' => 'Projetos',
            'singular_name' => 'Projeto'
        ],
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'rewrite' => ['slug' => 'projetos'],
        'supports' => ['title', 'editor', 'author'],
        'show_in_rest' => true, // ativa Gutenberg/REST API
    ]);
}
add_action('init', 'gp_register_projetos');
