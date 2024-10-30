<?php
/**
 * Widgets tab content in admin page
 */

$elementGroups = mek_array_group( 'category', \MEK\Core\ElementsManager::all_elements() );
$categories    = mek_config( 'element-categories' );
$links         = [
	'video' => __( 'Video', 'moose-elementor-kit' ),
	'doc'   => __( 'Read Doc', 'moose-elementor-kit' ),
	'demo'  => __( 'View Demo', 'moose-elementor-kit' ),
];
?>

<form data-mek-change-monitor="true" action="options.php" method="post">
    <div class="mek-bg-base mek-shadow-sm mek-rounded mek-p-4 mek-flex mek-items-center mek-justify-between">
        <input type="submit" name="submit"
               class="mek-btn mek-btn-primary mek-my-4"
               value="<?php esc_html_e( 'Save Settings', 'moose-elementor-kit' ); ?>">

        <label>
            <h4 class="mek-m-0 mek-inline-block mek-mr-2"><?php esc_html_e( 'Toggle All' ); ?></h4>
            <input type="checkbox"
                   id="mek-element-toggle-all"
                   name="mek-element-toggle-all"
                   class="mek-switch mek-switch-solid mek-switch-primary"
				<?php checked( 'on', get_option( 'mek-element-toggle-all', 'on' ) ) ?>
            >
        </label>
    </div>

	<?php
	// output security fields for the registered setting "mek-elements-settings"
	settings_fields( 'mek-elements-settings' );
	// output setting sections and their fields
	do_settings_sections( 'mek-elements-settings' );
	?>

    <div class="mek-elements mek-mb-6">
		<?php foreach ( $elementGroups as $category => $elements ): ?>
			<?php if ( isset( $categories[ $category ] ) ): ?>
                <h3 class="mek-font-normal mek-mt-8">
					<?php echo esc_html( $categories[ $category ] ); ?>
                </h3>
                <div class="mek-grid mek-grid-cols-2 lg:mek-grid-cols-4 mek-gap-4">
					<?php foreach ( $elements as $slug => $element ): ?>
                        <div class="mek-element-box">
							<?php if ( isset( $element['pro'] ) && $element['pro'] ): ?>
                                <span class="mek-pro-badge"></span>
							<?php endif; ?>
                            <div class="mek-flex mek-flex-col mek-justify-between mek-space-y-4">
                                <div class="mek-flex mek-items-center mek-justify-between">
                                    <h4 class="mek-font-bold mek-text-[1rem] mek-m-0">
										<?php echo esc_html( $element['label'] ); ?>
                                    </h4>
                                    <label>
                                        <input type="checkbox"
                                               id="<?php echo esc_attr( 'mek-element-' . $slug ) ?>"
                                               name="<?php echo esc_attr( 'mek-element-' . $slug ) ?>"
                                               class="mek-switch mek-switch-solid mek-switch-primary"
											<?php checked( 'on', get_option( 'mek-element-' . $slug, 'on' ) ) ?>
                                        />
                                    </label>
                                </div>

								<?php if ( isset( $element['description'] ) ): ?>
                                    <p class="mek-opacity-70">
										<?php echo esc_html( $element['description'] ); ?>
                                    </p>
								<?php endif; ?>

								<?php if ( count( array_intersect_key( $element, $links ) ) > 0 ): ?>
                                    <div class="mek-flex mek-justify-between">
										<?php foreach ( $links as $key => $label ): ?>
											<?php if ( isset( $element[ $key ] ) ): ?>
                                                <a class="mek-link mek-link-hover-primary"
                                                   target="_blank"
                                                   href="<?php echo esc_url( $element[ $key ] ) ?>">
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
			<?php endif; ?>

		<?php endforeach; ?>
    </div>

    <hr>

    <input type="submit" name="submit"
           class="mek-btn mek-btn-primary mek-my-4"
           value="<?php esc_html_e( 'Save Settings', 'moose-elementor-kit' ); ?>">
</form>