<?php
function adb_is_dev() {
  if (isset($_GET['adb_dev']) && $_GET['adb_dev'] === '1') return true;

  $host = 'http://vite:5173';
  $ch = curl_init("$host/@vite/client");
  curl_setopt_array($ch, [
    CURLOPT_NOBODY => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 1,
  ]);
  $ok = curl_exec($ch) !== false;
  curl_close($ch);
  return $ok;
}

add_action('wp_enqueue_scripts', function () {
  $theme_uri  = get_stylesheet_directory_uri();
  $theme_path = get_stylesheet_directory();

  if (adb_is_dev()) {
    // Enfileira os scripts normalmente (sem type por enquanto)
    wp_enqueue_script('vite-client', 'http://localhost:5173/@vite/client', [], null, false);
    wp_enqueue_script('adb-react-preamble', 'http://localhost:5173/src/preamble.js', ['vite-client'], null, false);
    wp_enqueue_script('adb-app', 'http://localhost:5173/src/main.jsx', ['adb-react-preamble'], null, false);
  } else {
    $manifest_path = $theme_path . '/dist/.vite/manifest.json';
    if (file_exists($manifest_path)) {
      $manifest = json_decode(file_get_contents($manifest_path), true);
      $entry = $manifest['src/main.jsx'] ?? $manifest['src/main.tsx'] ?? null;
      if ($entry) {
        if (!empty($entry['css'])) {
          foreach ($entry['css'] as $css) {
            wp_enqueue_style('adb-style', $theme_uri . '/dist/' . $css, [], null);
          }
        }
        wp_enqueue_script('adb-app', $theme_uri . '/dist/' . $entry['file'], [], null, true);
      }
    }
  }
}, 10);

/**
 * FORÇA type="module" de forma absoluta,
 * reescrevendo as tags <script> no HTML final.
 */
add_filter('script_loader_tag', function ($tag, $handle, $src) {
  $modules = ['vite-client', 'adb-react-preamble', 'adb-app'];
  if (in_array($handle, $modules, true)) {
    return '<script type="module" src="' . esc_url($src) . '"></script>' . "\n";
  }
  return $tag;
}, 999, 3);
