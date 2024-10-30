<?php
/**
 * Widgets tab content in admin page
 */

$extensions = \MEK\Core\ElementsManager::all_extensions();
$links      = [
	'video' => __( 'Video', 'moose-elementor-kit' ),
	'doc'   => __( 'View Docs', 'moose-elementor-kit' ),
	'demo'  => __( 'View Demos', 'moose-elementor-kit' ),
];
?>

<form data-mek-change-monitor="true" action="options.php" method="post">
    <div class="mek-bg-base mek-shadow-sm mek-rounded mek-p-4">
        <input type="submit"
               name="submit"
               class="mek-btn mek-btn-primary mek-my-4"
               value="<?php esc_html_e( 'Save Settings', 'moose-elementor-kit' ); ?>">
    </div>

	<?php
	// output security fields for the registered setting "mek-extensions-settings"
	settings_fields( 'mek-extensions-settings' );
	// output setting sections and their fields
	do_settings_sections( 'mek-extensions-settings' );
	?>

    <div class="mek-grid mek-grid-cols-2 lg:mek-grid-cols-4 mek-gap-4 mek-py-4">
		<?php foreach ( $extensions as $slug => $extension ): ?>
            <div class="mek-element-box">
				<?php if ( isset( $extension['pro'] ) && $extension['pro'] ): ?>
                    <span class="mek-pro-badge"></span>
				<?php endif; ?>
                <div class="mek-flex mek-flex-col mek-justify-between mek-space-y-4">
                    <div class="mek-flex mek-items-center mek-justify-between">
                        <h4 class="mek-font-bold mek-text-[1rem] mek-m-0">
							<?php echo esc_html( $extension['label'] ); ?>
                        </h4>
                        <label>
                            <input type="checkbox"
                                   id="<?php echo esc_attr( 'mek-extension-' . $slug ) ?>"
                                   name="<?php echo esc_attr( 'mek-extension-' . $slug ) ?>"
                                   class="mek-switch mek-switch-solid mek-switch-primary"
								<?php checked( 'on', get_option( 'mek-extension-' . $slug, 'on' ) ) ?>
                            >
                        </label>
                    </div>

					<?php if ( isset( $extension['description'] ) ): ?>
                        <p class="mek-opacity-70">
							<?php echo esc_html( $extension['description'] ); ?>
                        </p>
					<?php endif; ?>


					<?php if ( count( array_intersect_key( $extension, $links ) ) > 0 ): ?>
                        <div class="mek-flex mek-justify-between">
							<?php foreach ( $links as $key => $label ): ?>
								<?php if ( isset( $extension[ $key ] ) ): ?>
                                    <a class="mek-link mek-link-hover-primary"
                                       target="_blank"
                                       href="<?php echo esc_url( $extension[ $key ] ) ?>">
										<?php echo esc_html( $label ); ?>
                                    </a>
								<?php endif; ?>
							<?php endforeach; ?>
                        </div>
					<?php endif; ?>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
</form>
