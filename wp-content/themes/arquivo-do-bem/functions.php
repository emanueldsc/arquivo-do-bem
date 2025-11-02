<?php
// 1) Detecta DEV checando o @vite/client no container
function adb_is_dev(): bool
{
  $ch = curl_init('http://vite:5173/@vite/client');
  curl_setopt_array($ch, [
    CURLOPT_NOBODY => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 1,
  ]);
  $ok = curl_exec($ch) !== false;
  curl_close($ch);
  return $ok;
}

// 2) Define constante lida pelo enqueue.php
if (!defined('VITE_DEV')) {
  define('VITE_DEV', adb_is_dev());
}

// 3) Inclui o enqueue
// require_once __DIR__ . '/enqueue.php';

$enqueue_candidates = [
  __DIR__ . '/inc/enqueue.php',
  __DIR__ . '/enqueue.php'
];

$found = false;
foreach ($enqueue_candidates as $file) {
  if (file_exists($file)) {
    require_once $file;
    $found = true;
    break;
  }
}

if (!$found) {
  // Loga e evita fatal (mostra mensagem clara)
  error_log('[arquivo-do-bem] enqueue.php não encontrado em inc/ nem na raiz do tema.');
  // Opcional: exiba aviso amigável no front (em dev)
  if (defined('WP_DEBUG') && WP_DEBUG) {
    echo '<pre style="color:red">[arquivo-do-bem] Falta o arquivo inc/enqueue.php (ou enqueue.php na raiz).</pre>';
  }
  return; // evita continuar e dar fatal
}

// 4) Força type="module" em DEV nos *handles* que usamos
add_filter('script_loader_tag', function ($tag, $handle, $src) {
  $asModules = ['vite-client', 'adb-react-preamble', 'adb-app']; // <<< mantenha esses nomes
  if (in_array($handle, $asModules, true)) {
    return '<script type="module" src="' . esc_url($src) . '"></script>' . "\n";
  }
  return $tag;
}, 999, 3);
