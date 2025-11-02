<?php
/**
 * Tema: arquivo-do-bem
 * Arquivo: inc/enqueue.php (recomendado)
 *
 * Requisitos:
 * - Vite configurado com root = 'src'
 * - Entry principal em src/main.jsx  → URL pública:  /main.jsx
 * - Preamble em src/preamble.js      → URL pública:  /preamble.js
 *
 * Observação:
 * - O filtro que força <script type="module"> para os handles
 *   ['vite-client','adb-react-preamble','adb-app'] deve estar no functions.php
 */

namespace ArquivoDoBem;

if (!function_exists(__NAMESPACE__ . '\\is_vite_dev')) {
  function is_vite_dev(): bool {
    // A constante VITE_DEV deve ser definida no functions.php (detecção por curl).
    return defined('VITE_DEV') && VITE_DEV === true;
  }
}

if (!function_exists(__NAMESPACE__ . '\\theme_scripts')) {
  function theme_scripts() {
    // Handles consistentes com o filtro em functions.php
    $handle_preamble = 'adb-react-preamble';
    $handle_client   = 'vite-client';
    $handle_app      = 'adb-app';

    if (is_vite_dev()) {
      /**
       * DEV (HMR):
       * Com root='src', os caminhos públicos **não** têm /src no começo.
       * Ex.: src/preamble.js → /preamble.js
       *      src/main.jsx    → /main.jsx
       */
      $viteOrigin = 'http://localhost:5173';

      // 1) Preamble do React Refresh (só carrega se existir no disco, evita 404 no console)
      $preamble_disk = get_stylesheet_directory() . '/src/preamble.js';
      if (file_exists($preamble_disk)) {
        wp_enqueue_script($handle_preamble, $viteOrigin . '/preamble.js', [], null, true);
      }

      // 2) Cliente HMR do Vite (depende do preamble se ele existir)
      $deps_client = file_exists($preamble_disk) ? [$handle_preamble] : [];
      wp_enqueue_script($handle_client, $viteOrigin . '/@vite/client', $deps_client, null, true);

      // 3) Entry principal (depende do cliente HMR)
      wp_enqueue_script($handle_app, $viteOrigin . '/main.jsx', [$handle_client], null, true);

    } else {
      /**
       * PROD:
       * Lê dist/manifest.json gerado pelo Vite
       * Atenção ao entryKey (com root='src' e input='/main.jsx', a chave usual é 'main.jsx')
       */
      $manifest_path = get_stylesheet_directory() . '/dist/manifest.json';
      if (!file_exists($manifest_path)) {
        // Evita tela branca se esquecer de buildar
        error_log('[arquivo-do-bem] dist/manifest.json não encontrado. Rode "npm run build".');
        return;
      }

      $manifest = json_decode(file_get_contents($manifest_path), true);
      $entryKey = 'main.jsx'; // 🔴 ajuste aqui caso seu input seja outro

      if (!isset($manifest[$entryKey])) {
        // Fallback inteligente: pega a primeira entrada com 'file'
        foreach ($manifest as $k => $v) {
          if (!empty($v['file'])) { $entryKey = $k; break; }
        }
      }

      if (!isset($manifest[$entryKey])) {
        error_log('[arquivo-do-bem] Entrada do manifest não encontrada.');
        return;
      }

      $entry = $manifest[$entryKey];

      // CSS(s) do entry
      if (!empty($entry['css'])) {
        foreach ($entry['css'] as $css) {
          wp_enqueue_style(
            'adb-style-' . md5($css),
            get_stylesheet_directory_uri() . '/dist/' . ltrim($css, '/'),
            [],
            null
          );
        }
      }

      // JS do entry
      wp_enqueue_script(
        $handle_app,
        get_stylesheet_directory_uri() . '/dist/' . ltrim($entry['file'], '/'),
        [],
        null,
        true
      );
    }

    // Expõe dados úteis ao front (sempre, dev/prod)
    // Use o mesmo handle do app para garantir que __WP_DATA__ exista quando seu bundle rodar.
    wp_localize_script($handle_app, '__WP_DATA__', [
      'restUrl'     => esc_url_raw(rest_url('arquivo/v1/')),
      'nonce'       => wp_create_nonce('wp_rest'),
      'currentUser' => is_user_logged_in() ? wp_get_current_user() : null,
      'siteUrl'     => get_site_url(),
      'assetsUrl'   => get_stylesheet_directory_uri() . '/assets',
    ]);
  }

  add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\theme_scripts');
}
