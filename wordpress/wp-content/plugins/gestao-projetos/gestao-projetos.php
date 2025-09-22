<?php
/*
Plugin Name: Gestão de Projetos Acadêmicos
Description: Plugin para gerenciar instituições, grupos, alunos e professores com revisão de postagens.
Version: 1.0
Author: Emanuel Douglas
*/

// Bloqueia acesso direto
if (!defined('ABSPATH')) exit;

// Inclui módulos
require_once plugin_dir_path(__FILE__) . 'includes/cpt-projetos.php';
require_once plugin_dir_path(__FILE__) . 'includes/taxonomias.php';
