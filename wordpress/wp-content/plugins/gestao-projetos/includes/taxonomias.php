<?php
// Taxonomia: Instituições
function gp_register_tax_instituicao() {
    register_taxonomy('instituicao', 'projeto', [
        'labels' => [
            'name' => 'Instituições',
            'singular_name' => 'Instituição'
        ],
        'hierarchical' => true, // como categorias
        'public' => true,
        'rewrite' => ['slug' => 'instituicao'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'gp_register_tax_instituicao');

// Taxonomia: Grupos
function gp_register_tax_grupo() {
    register_taxonomy('grupo', 'projeto', [
        'labels' => [
            'name' => 'Grupos',
            'singular_name' => 'Grupo'
        ],
        'hierarchical' => true,
        'public' => true,
        'rewrite' => ['slug' => 'grupo'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'gp_register_tax_grupo');

// Taxonomia: Semestres
function gp_register_tax_semestre() {
    register_taxonomy('semestre', 'projeto', [
        'labels' => [
            'name' => 'Semestres',
            'singular_name' => 'Semestre'
        ],
        'hierarchical' => false, // como tags
        'public' => true,
        'rewrite' => ['slug' => 'semestre'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'gp_register_tax_semestre');
