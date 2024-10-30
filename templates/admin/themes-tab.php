<?php
/**
 * Themes tab content in admin page
 */

use MEK\Core\Option as MEKOption;

$default = get_option( 'mek-default-theme', 0 );
$themes  = \MEK\Core\Option::themes();
?>

<script type="text/javascript">
    var MEKThemes = <?php echo wp_json_encode( [
		'themes'  => $themes,
		'palette' => mek_array_pluck( 'default', MEKOption::colors() ),
	] ); ?>;
</script>

<script type="text/html" id="tmpl-mek-theme-template">
    <div data-mek-theme-index="{{ data.index }}"
         class="mek-bg-base mek-shadow-sm mek-rounded mek-p-4">
        <div class="mek-flex mek-items-center mek-justify-between">
            <input type="text" name="mek-themes[{{ data.index }}][label]" value="{{ data.label }}"/>

            <div class="mek-space-x-2">
                <button type="button"
                        class="dashicons mek-delete-theme mek-cursor-pointer mek-border-none mek-badge mek-badge-error mek-badge-circle">
                    <span class="dashicons-trash"></span>
                </button>

                <button type="button"
                        class="dashicons mek-toggle-theme-palette mek-cursor-pointer mek-border-none mek-badge mek-badge-circle">
                    <span class="dashicons-arrow-left-alt2"></span>
                </button>
            </div>
        </div>

        <div class="mek-theme-palette mek-hidden">
            <div class="mek-grid mek-grid-cols-2 lg:mek-grid-cols-4">
				<?php foreach ( MEKOption::colors() as $id => $color ): ?>
                    <div>
                        <h4><?php echo esc_html( $color['label'] ) ?></h4>
                        <input type="text"
                               class="mek-color-field"
                               data-default-color="<?php echo esc_attr( $color['default'] ) ?>"
                               name="mek-themes[{{ data.index }}][palette][<?php echo esc_attr( $id ) ?>]"
                               id="'<?php echo esc_attr( $id ) ?>_{{ data.index }}'"
                               value="{{ data.palette['<?php echo esc_attr( $id ) ?>'] }}">
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
    </div>
</script>

<form data-mek-change-monitor="true" action="options.php" method="post"
      class="mek-space-y-4  mek-form-controls mek-form-default mek-form-primary">
    <div class="mek-bg-base mek-shadow-sm mek-rounded mek-p-4 mek-flex mek-items-center mek-justify-between">
        <input type="submit" name="submit"
               class="mek-btn mek-btn-primary"
               value="<?php esc_html_e( 'Save Changes', 'moose-elementor-kit' ); ?>">

        <label>
            <span><?php esc_html_e( 'Default Theme', 'moose-elementor-kit' ); ?></span>
            <select name="mek-default-theme" id="mek-default-theme">
				<?php foreach ( $themes as $id => $theme ): ?>
                    <option value="<?php echo esc_attr( $id ) ?>" <?php selected( $default, $id ) ?>>
						<?php echo esc_html( $theme['label'] ) ?>
                    </option>
				<?php endforeach; ?>
            </select>
        </label>

        <div class="mek-flex mek-items-center mek-space-x-2">
            <input type="text" id="mek-new-theme-label" placeholder="Theme Name" class="mek-inline-block">
            <button type="button" id="mek-create-new-theme"
                    class="mek-btn mek-btn-primary">
				<?php esc_html_e( 'Create New', 'moose-elementor-kit' ); ?>
            </button>
        </div>
    </div>

	<?php
	// output security fields for the registered setting "mek-themes"
	settings_fields( 'mek-themes' );
	// output setting sections and their fields
	do_settings_sections( 'mek-themes' );
	?>

	<?php if ( mek_fs()->is_not_paying() ): ?>
        <div class="mek-bg-base mek-shadow-sm mek-rounded mek-p-4">
			<?php
			printf(
				wp_kses(
					'Want More Color Options? Meet <a class="mek-link mek-link-hover-primary" target="_blank" href="%1$s">%2$s</a>',
					[ 'a' => [ 'class' => [], 'href' => [], 'target' => [] ] ]
				),
				esc_url( \MEK\Utils\Upsell::url( 'admin-themes' ) ),
				__( 'Pro version', 'moose-elementor-kit' )
			);
			?>
        </div>
	<?php endif; ?>

    <div class="mek-themes-container mek-space-y-4"></div>
</form>

