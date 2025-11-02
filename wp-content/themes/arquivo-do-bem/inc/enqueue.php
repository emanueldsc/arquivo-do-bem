<?php

namespace ArquivoDoBem;

function is_vite_dev(): bool
{
  return defined('VITE_DEV') && VITE_DEV === true;
}

function theme_scripts()
{
  $handle_client   = 'vite-client';
  $handle_preamble = 'adb-react-preamble';
  $handle_app      = 'adb-app';

  if (is_vite_dev()) {
    // Browser acessa localhost:5173
    $viteOrigin = 'http://localhost:5173';

    // 1) Preamble do React Refresh
    wp_enqueue_script('adb-react-preamble', $viteOrigin . '/preamble.js', [], null, true);

    // 2) Cliente do Vite (HMR), depende do preamble
    wp_enqueue_script('vite-client', $viteOrigin . '/@vite/client', ['adb-react-preamble'], null, true);

    // 3) Entrada principal (depende do cliente)
    wp_enqueue_script('adb-app', $viteOrigin . '/main.jsx', ['vite-client'], null, true);
  } else {
    // Produção: manifest do Vite
    $manifest_path = get_stylesheet_directory() . '/dist/manifest.json';
    if (!file_exists($manifest_path)) return;

    $manifest = json_decode(file_get_contents($manifest_path), true);

    // 🔴 AJUSTE ESTA CHAVE CASO SEU ENTRY NÃO SEJA 'src/react/main.jsx'
    $entryKey = 'src/react/main.jsx';

    if (!isset($manifest[$entryKey])) return;
    $entry = $manifest[$entryKey];

    // CSS
    if (!empty($entry['css'])) {
      foreach ($entry['css'] as $css) {
        wp_enqueue_style('adb-style-' . md5($css), get_stylesheet_directory_uri() . '/dist/' . ltrim($css, '/'), [], null);
      }
    }

    // JS
    wp_enqueue_script($handle_app, get_stylesheet_directory_uri() . '/dist/' . ltrim($entry['file'], '/'), [], null, true);
  }

  // Dados expostos ao front (sempre)
  $expose_handle = $handle_app;
  wp_localize_script($expose_handle, '__WP_DATA__', [
    'restUrl'     => esc_url_raw(rest_url('arquivo/v1/')),
    'nonce'       => wp_create_nonce('wp_rest'),
    'currentUser' => is_user_logged_in() ? wp_get_current_user() : null,
    'siteUrl'     => get_site_url(),
    'assetsUrl'   => get_stylesheet_directory_uri() . '/assets',
  ]);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\theme_scripts');
