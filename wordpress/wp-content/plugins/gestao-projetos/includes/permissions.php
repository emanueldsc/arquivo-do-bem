<?php
// Força posts de alunos como "pendente" até revisão do professor
function gp_force_pending($post_data) {
    if (current_user_can('aluno') && $post_data['post_type'] === 'projeto') {
        $post_data['post_status'] = 'pending';
    }
    return $post_data;
}
add_filter('wp_insert_post_data', 'gp_force_pending');
