<?php
// Cria papéis ao ativar o plugin
function gp_add_roles() {
    add_role('aluno', 'Aluno', [
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => false, // não pode publicar direto
    ]);

    add_role('professor', 'Professor', [
        'read' => true,
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_others_posts' => true,
        'delete_posts' => true,
        'delete_others_posts' => true,
        'edit_published_posts' => true,
        'delete_published_posts' => true,
    ]);
}
add_action('init', 'gp_add_roles');
// register_activation_hook(__FILE__, 'gp_add_roles');
