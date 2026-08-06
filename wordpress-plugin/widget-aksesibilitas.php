<?php
/**
 * Plugin Name:       Widget Aksesibilitas Indonesia
 * Plugin URI:        https://github.com/godzam/widget-aksesibilitas
 * Description:       Widget aksesibilitas lengkap untuk website WordPress. Mendukung 20+ fitur aksesibilitas: perbesar teks, font disleksia, filter buta warna, mode gelap, mode fokus, dan banyak lagi.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * Author:            godzam
 * Author URI:        https://github.com/godzam
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       widget-aksesibilitas
 */

defined('ABSPATH') || exit;

define('WAK_VERSION',  '1.0.0');
define('WAK_FILE',     __FILE__);
define('WAK_DIR',      plugin_dir_path(__FILE__));
define('WAK_URL',      plugin_dir_url(__FILE__));
define('WAK_OPTION',   'wak_settings');

// ── Default settings ──────────────────────────────────────────────────────────
function wak_defaults() {
    return [
        'color'    => '#1a6fb5',
        'vside'    => 'bottom',
        'hside'    => 'left',
        'vval'     => '24',
        'hval'     => '24',
        'cols'     => '3',
        'disabled' => [],
    ];
}

function wak_get_settings() {
    return wp_parse_args(get_option(WAK_OPTION, []), wak_defaults());
}

// ── Daftar semua fitur ────────────────────────────────────────────────────────
function wak_all_features() {
    return [
        'fontUp'   => ['label' => 'Perbesar teks',      'group' => 'Teks'],
        'fontDn'   => ['label' => 'Perkecil teks',      'group' => 'Teks'],
        'spasi'    => ['label' => 'Spasi teks',         'group' => 'Teks'],
        'lineH'    => ['label' => 'Jarak baris',        'group' => 'Teks'],
        'dyslexia' => ['label' => 'Font disleksia',     'group' => 'Teks'],
        'invert'   => ['label' => 'Inversi warna',      'group' => 'Warna'],
        'dark'     => ['label' => 'Latar gelap',        'group' => 'Warna'],
        'gray'     => ['label' => 'Abu-abu',            'group' => 'Warna'],
        'deuter'   => ['label' => 'Buta warna (Deuteranopia)', 'group' => 'Warna'],
        'protan'   => ['label' => 'Buta warna (Protanopia)',   'group' => 'Warna'],
        'tritan'   => ['label' => 'Buta warna (Tritanopia)',   'group' => 'Warna'],
        'bigclick' => ['label' => 'Area klik besar',    'group' => 'Navigasi'],
        'cursor'   => ['label' => 'Kursor besar',       'group' => 'Navigasi'],
        'ulink'    => ['label' => 'Garis bawah link',   'group' => 'Navigasi'],
        'guide'    => ['label' => 'Panduan baca',       'group' => 'Navigasi'],
        'hideimg'  => ['label' => 'Sembunyikan gambar', 'group' => 'Konten'],
        'stopgif'  => ['label' => 'Stop GIF / video',  'group' => 'Konten'],
        'focus'    => ['label' => 'Mode fokus',         'group' => 'Konten'],
        'anim'     => ['label' => 'Stop animasi',       'group' => 'Konten'],
        'cc'       => ['label' => 'Aktifkan CC video',  'group' => 'Konten'],
        'reset'    => ['label' => 'Reset semua',        'group' => 'Lainnya'],
    ];
}

// ── Enqueue widget di frontend ─────────────────────────────────────────────────
add_action('wp_enqueue_scripts', 'wak_enqueue');
function wak_enqueue() {
    $s = wak_get_settings();

    wp_enqueue_script(
        'widget-aksesibilitas',
        WAK_URL . 'assets/widget-aksesibilitas.min.js',
        [],
        WAK_VERSION,
        true
    );

    // Bangun config dari settings
    $disabled = array_values(array_filter((array) $s['disabled']));
    $config = [
        'color' => sanitize_hex_color($s['color']) ?: '#1a6fb5',
        'vside' => in_array($s['vside'], ['bottom','top']) ? $s['vside'] : 'bottom',
        'hside' => in_array($s['hside'], ['left','right']) ? $s['hside'] : 'left',
        'vval'  => absint($s['vval']) . 'px',
        'hval'  => absint($s['hval']) . 'px',
        'cols'  => in_array((int)$s['cols'], [2,3,4]) ? (int)$s['cols'] : 3,
    ];
    if (!empty($disabled)) {
        $config['disabled'] = $disabled;
    }

    // Inject WAKConfig sebelum script widget
    $json = wp_json_encode($config);
    wp_add_inline_script('widget-aksesibilitas', "window.WAKConfig = {$json};", 'before');
}

// ── Admin menu ─────────────────────────────────────────────────────────────────
add_action('admin_menu', 'wak_admin_menu');
function wak_admin_menu() {
    add_options_page(
        'Widget Aksesibilitas',
        'Aksesibilitas',
        'manage_options',
        'widget-aksesibilitas',
        'wak_settings_page'
    );
}

// ── Register settings ──────────────────────────────────────────────────────────
add_action('admin_init', 'wak_register_settings');
function wak_register_settings() {
    register_setting(WAK_OPTION, WAK_OPTION, 'wak_sanitize');
}

function wak_sanitize($input) {
    $out = wak_defaults();
    if (isset($input['color']))    $out['color'] = sanitize_hex_color($input['color']) ?: '#1a6fb5';
    if (isset($input['vside']))    $out['vside'] = in_array($input['vside'], ['bottom','top']) ? $input['vside'] : 'bottom';
    if (isset($input['hside']))    $out['hside'] = in_array($input['hside'], ['left','right']) ? $input['hside'] : 'left';
    if (isset($input['vval']))     $out['vval']  = (string) absint($input['vval']);
    if (isset($input['hval']))     $out['hval']  = (string) absint($input['hval']);
    if (isset($input['cols']))     $out['cols']  = in_array((int)$input['cols'], [2,3,4]) ? (string)(int)$input['cols'] : '3';

    $features = array_keys(wak_all_features());
    $disabled = [];
    foreach ($features as $id) {
        if (empty($input['feature_' . $id])) {
            $disabled[] = $id;
        }
    }
    $out['disabled'] = $disabled;

    return $out;
}

// ── Admin styles ───────────────────────────────────────────────────────────────
add_action('admin_enqueue_scripts', 'wak_admin_enqueue');
function wak_admin_enqueue($hook) {
    if ($hook !== 'settings_page_widget-aksesibilitas') return;
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    // Inline admin CSS & JS
    wp_add_inline_style('wp-color-picker', wak_admin_css());
    wp_add_inline_script('wp-color-picker', wak_admin_js());
}

function wak_admin_css() {
    return '
.wak-wrap{max-width:900px;margin-top:1.5rem}
.wak-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem}
@media(max-width:700px){.wak-grid{grid-template-columns:1fr}}
.wak-card{background:#fff;border:1px solid #dde3ec;border-radius:10px;padding:1.5rem}
.wak-card h3{margin:0 0 1.2rem;font-size:14px;font-weight:600;color:#1e40af;
  text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;padding-bottom:.75rem}
.wak-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:.9rem}
.wak-row label{font-size:14px;color:#374151;font-weight:500}
.wak-row select,.wak-row input[type=number]{
  border:1px solid #d1d5db;border-radius:6px;padding:5px 10px;
  font-size:14px;color:#111;background:#f9fafb;width:130px}
.wak-row input[type=number]{width:80px}
.wak-feature-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:0}
.wak-feature-item{display:flex;align-items:center;gap:8px;padding:7px 4px;
  border-bottom:1px solid #f1f5f9;font-size:13px;color:#374151}
.wak-feature-item:nth-last-child(-n+2){border-bottom:0}
.wak-group-label{grid-column:1/-1;font-size:11px;font-weight:700;color:#6b7280;
  text-transform:uppercase;letter-spacing:.07em;padding:10px 4px 4px;
  border-bottom:1px solid #e2e8f0;margin-top:.5rem}
.wak-group-label:first-child{margin-top:0}
.wak-preview-wrap{position:relative;background:#f0f4f8;border-radius:8px;
  height:160px;overflow:hidden;margin-top:1rem;border:1px solid #e2e8f0}
.wak-preview-btn{position:absolute;width:48px;height:48px;border-radius:50%;
  border:none;font-size:24px;cursor:default;display:flex;align-items:center;
  justify-content:center;box-shadow:0 3px 10px rgba(0,0,0,.2);transition:.2s}
.wak-preview-label{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
  font-size:12px;color:#94a3b8;text-align:center}
.wak-save-bar{display:flex;align-items:center;gap:1rem;margin-top:1.5rem}
.wak-badge{display:inline-flex;align-items:center;gap:5px;font-size:12px;
  padding:4px 10px;border-radius:20px;background:#dcfce7;color:#166534}
.wak-note{background:#eff6ff;border-left:3px solid #1a6fb5;padding:.75rem 1rem;
  border-radius:0 6px 6px 0;font-size:13px;color:#374151;margin-bottom:1.5rem}
.wak-note code{background:#dbeafe;padding:1px 5px;border-radius:3px;font-size:12px}
.wak-toggle{position:relative;display:inline-block;width:38px;height:22px}
.wak-toggle input{opacity:0;width:0;height:0;position:absolute}
.wak-toggle-slider{position:absolute;inset:0;background:#d1d5db;border-radius:22px;
  cursor:pointer;transition:.2s}
.wak-toggle-slider:before{content:"";position:absolute;width:16px;height:16px;
  left:3px;top:3px;background:#fff;border-radius:50%;transition:.2s}
.wak-toggle input:checked+.wak-toggle-slider{background:#1a6fb5}
.wak-toggle input:checked+.wak-toggle-slider:before{transform:translateX(16px)}
';
}

function wak_admin_js() {
    return "
jQuery(function($){
    // Color picker
    $('#wak-color').wpColorPicker({
        change: function(e, ui){
            $('#wak-preview-btn').css('background', ui.color.toString());
        }
    });

    // Preview update
    function updatePreview(){
        var vside = $('#wak-vside').val();
        var hside = $('#wak-hside').val();
        var vval  = parseInt($('#wak-vval').val())||24;
        var hval  = parseInt($('#wak-hval').val())||24;
        var color = $('#wak-color').val();
        var btn   = $('#wak-preview-btn');
        btn.css({
            top:'', bottom:'', left:'', right:'',
            background: color
        });
        btn.css(vside, Math.min(vval, 60)+'px');
        btn.css(hside, Math.min(hval, 60)+'px');
    }

    $('#wak-vside,#wak-hside,#wak-vval,#wak-hval').on('change input', updatePreview);
    updatePreview();

    // Select all / none
    $('#wak-all').on('click', function(){ $('.wak-feat-cb').prop('checked', true); });
    $('#wak-none').on('click', function(){ $('.wak-feat-cb').prop('checked', false); });
});
";
}

// ── Halaman settings ───────────────────────────────────────────────────────────
function wak_settings_page() {
    if (!current_user_can('manage_options')) return;
    $s        = wak_get_settings();
    $features = wak_all_features();
    $disabled = (array) $s['disabled'];

    // Kelompokkan fitur per group
    $groups = [];
    foreach ($features as $id => $f) {
        $groups[$f['group']][$id] = $f['label'];
    }
    ?>
    <div class="wrap wak-wrap">
        <h1>
            <span style="font-size:24px">♿</span>
            Widget Aksesibilitas Indonesia
            <span class="wak-badge" style="margin-left:8px;vertical-align:middle">v<?php echo WAK_VERSION ?></span>
        </h1>

        <div class="wak-note">
            Plugin ini secara otomatis menyuntikkan widget ke semua halaman website Anda.
            Anda juga tetap bisa menggunakan <code>window.WAKConfig</code> via script manual
            — settings dari plugin ini hanya berlaku jika tidak ada konfigurasi manual.
            <a href="https://github.com/godzam/widget-aksesibilitas" target="_blank" style="margin-left:8px">📖 Dokumentasi</a>
        </div>

        <form method="post" action="options.php">
            <?php settings_fields(WAK_OPTION); ?>

            <div class="wak-grid">

                <!-- Kolom kiri: Tampilan & Posisi -->
                <div>
                    <div class="wak-card">
                        <h3>🎨 Tampilan Tombol</h3>

                        <div class="wak-row">
                            <label>Warna tombol</label>
                            <input type="text" id="wak-color"
                                name="<?php echo WAK_OPTION ?>[color]"
                                value="<?php echo esc_attr($s['color']) ?>"
                                class="wak-color-field">
                        </div>

                        <div class="wak-row">
                            <label>Posisi vertikal</label>
                            <select id="wak-vside" name="<?php echo WAK_OPTION ?>[vside]">
                                <option value="bottom" <?php selected($s['vside'],'bottom') ?>>Bawah</option>
                                <option value="top"    <?php selected($s['vside'],'top') ?>>Atas</option>
                            </select>
                        </div>

                        <div class="wak-row">
                            <label>Posisi horizontal</label>
                            <select id="wak-hside" name="<?php echo WAK_OPTION ?>[hside]">
                                <option value="left"  <?php selected($s['hside'],'left') ?>>Kiri</option>
                                <option value="right" <?php selected($s['hside'],'right') ?>>Kanan</option>
                            </select>
                        </div>

                        <div class="wak-row">
                            <label>Jarak vertikal (px)</label>
                            <input type="number" id="wak-vval"
                                name="<?php echo WAK_OPTION ?>[vval]"
                                value="<?php echo esc_attr($s['vval']) ?>"
                                min="0" max="200">
                        </div>

                        <div class="wak-row">
                            <label>Jarak horizontal (px)</label>
                            <input type="number" id="wak-hval"
                                name="<?php echo WAK_OPTION ?>[hval]"
                                value="<?php echo esc_attr($s['hval']) ?>"
                                min="0" max="200">
                        </div>

                        <div class="wak-row">
                            <label>Kolom grid menu</label>
                            <select name="<?php echo WAK_OPTION ?>[cols]">
                                <option value="2" <?php selected($s['cols'],'2') ?>>2 kolom</option>
                                <option value="3" <?php selected($s['cols'],'3') ?>>3 kolom</option>
                                <option value="4" <?php selected($s['cols'],'4') ?>>4 kolom</option>
                            </select>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="wak-card" style="margin-top:1.5rem">
                        <h3>👁 Preview Tombol</h3>
                        <div class="wak-preview-wrap">
                            <div class="wak-preview-label">Area halaman website</div>
                            <button type="button" id="wak-preview-btn" class="wak-preview-btn"
                                style="background:<?php echo esc_attr($s['color']) ?>;
                                       <?php echo esc_attr($s['vside']) ?>:<?php echo esc_attr($s['vval']) ?>px;
                                       <?php echo esc_attr($s['hside']) ?>:<?php echo esc_attr($s['hval']) ?>px;
                                       color:<?php echo (wak_lum($s['color']) > 0.179 ? '#111' : '#fff') ?>">
                                &#9855;
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Kolom kanan: Fitur -->
                <div class="wak-card">
                    <h3>
                        ⚙️ Fitur yang Ditampilkan
                        <span style="float:right;font-weight:400;font-size:12px;margin-top:2px">
                            <a href="#" id="wak-all" style="color:#1a6fb5">Pilih semua</a> |
                            <a href="#" id="wak-none" style="color:#6b7280">Hapus semua</a>
                        </span>
                    </h3>

                    <div class="wak-feature-grid">
                        <?php foreach ($groups as $group => $items) : ?>
                            <div class="wak-group-label"><?php echo esc_html($group) ?></div>
                            <?php foreach ($items as $id => $label) :
                                $checked = !in_array($id, $disabled); ?>
                                <div class="wak-feature-item">
                                    <label class="wak-toggle">
                                        <input type="checkbox"
                                            class="wak-feat-cb"
                                            name="<?php echo WAK_OPTION ?>[feature_<?php echo esc_attr($id) ?>]"
                                            value="1"
                                            <?php checked($checked) ?>>
                                        <span class="wak-toggle-slider"></span>
                                    </label>
                                    <?php echo esc_html($label) ?>
                                </div>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </div>
                </div>

            </div><!-- .wak-grid -->

            <div class="wak-save-bar">
                <?php submit_button('Simpan Pengaturan', 'primary', 'submit', false) ?>
                <?php if (isset($_GET['settings-updated'])) : ?>
                    <span class="wak-badge">✓ Tersimpan</span>
                <?php endif ?>
            </div>

            <!-- Kode embed manual -->
            <div class="wak-card" style="margin-top:1.5rem">
                <h3>📋 Kode Embed Manual (opsional)</h3>
                <p style="font-size:13px;color:#6b7280;margin-bottom:.75rem">
                    Jika Anda ingin menggunakan script manual tanpa plugin ini aktif,
                    salin kode berikut dan tempel sebelum tag <code>&lt;/body&gt;</code>:
                </p>
                <textarea readonly rows="8" onclick="this.select()"
                    style="width:100%;font-family:monospace;font-size:12px;
                           padding:.75rem;border:1px solid #e2e8f0;border-radius:6px;
                           background:#f8fafc;color:#1e293b;resize:vertical"
                ><?php echo esc_textarea(wak_generate_embed($s)) ?></textarea>
            </div>

        </form>
    </div>
    <?php
}

// Helper: hitung luminance untuk warna tombol
function wak_lum($hex) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    $r = hexdec(substr($hex,0,2))/255;
    $g = hexdec(substr($hex,2,2))/255;
    $b = hexdec(substr($hex,4,2))/255;
    $f = function($v) { return $v <= 0.03928 ? $v/12.92 : pow(($v+0.055)/1.055, 2.4); };
    return 0.2126*$f($r) + 0.7152*$f($g) + 0.0722*$f($b);
}

// Helper: generate kode embed
function wak_generate_embed($s) {
    $disabled = array_values(array_filter((array)$s['disabled']));
    $lines   = ["<script>"];
    $lines[] = "window.WAKConfig = {";
    $lines[] = "  color: \"{$s['color']}\",";
    $lines[] = "  vside: \"{$s['vside']}\",";
    $lines[] = "  hside: \"{$s['hside']}\",";
    $lines[] = "  vval:  \"{$s['vval']}px\",";
    $lines[] = "  hval:  \"{$s['hval']}px\",";
    $lines[] = "  cols:  {$s['cols']},";
    if (!empty($disabled)) {
        $ids     = array_map(fn($d) => "'{$d}'", $disabled);
        $lines[] = "  disabled: [" . implode(', ', $ids) . "],";
    }
    $lines[] = "};";
    $lines[] = "</script>";
    $lines[] = "<script src=\"https://cdn.jsdelivr.net/gh/godzam/widget-aksesibilitas@latest/widget-aksesibilitas.min.js\" defer></script>";
    return implode("\n", $lines);
}

// ── Activation / Deactivation ─────────────────────────────────────────────────
register_activation_hook(__FILE__, function() {
    if (!get_option(WAK_OPTION)) {
        add_option(WAK_OPTION, wak_defaults());
    }
});

register_deactivation_hook(__FILE__, function() {
    // Tidak hapus settings saat deaktivasi, hanya saat uninstall
});

// ── Uninstall: hapus settings ─────────────────────────────────────────────────
// Ditangani oleh uninstall.php
