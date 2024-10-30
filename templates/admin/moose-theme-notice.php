<?php

$active_theme = wp_get_theme()->get( 'TextDomain' );

if ( $active_theme === 'wp-moose' || $active_theme === 'wp-moose-premium' ) {
	return;
}

$wp_moose         = mek_get_theme( 'wp-moose' );
$wp_moose_premium = mek_get_theme( 'wp-moose-premium' );
$installed_theme  = $wp_moose_premium ?: $wp_moose;

if ( $installed_theme !== null ) {
	if ( ! current_user_can( 'switch_themes' ) ) {
		return;
	}

	$activation_url = wp_nonce_url(
		'themes.php?action=activate&stylesheet=' . urlencode( $installed_theme->get_stylesheet() ),
		'switch-theme_' . $installed_theme->get_stylesheet()
	);

	$theme_uri   = $installed_theme->get( 'ThemeURI' );
	$theme_name  = $installed_theme->get( 'Name' ) . ' ' . __( 'Theme', 'moose-elementor-kit' );
	$action_name = __( 'Activate', 'moose-elementor-kit' ) . ' ' . $theme_name;

} else {
	if ( ! current_user_can( 'install_themes' ) ) {
		return;
	}

	$activation_url = wp_nonce_url(
		'update.php?action=install-theme&theme=wp-moose',
		'install-theme_wp-moose'
	);

	$theme_uri   = 'https://www.wpmoose.com/themes/wp-moose-theme/';
	$theme_name  = __( 'WP Moose Theme', 'moose-elementor-kit' );
	$action_name = __( 'Install', 'moose-elementor-kit' ) . ' ' . $theme_name;
}

?>

<div class="wrap mek-bg-base mek-shadow-sm mek-rounded mek-px-8 mek-py-4">
    <div class="mek-flex">
        <div>
            <img class="mek-border mek-border-solid mek-border-gray-200" width="360"
                 src="<?php echo esc_url( MEK_ASSETS_URL . 'images/wp-moose-screenshot.png' ) ?>" alt="">
        </div>
        <div class="mek-pl-6 mek-max-w-prose mek-flex mek-flex-col mek-justify-between">
            <div>
                <h2 class="mek-mt-0 mek-text-2xl"><?php esc_html_e( 'Do you know ?', 'moose-elementor-kit' ) ?></h2>
                <p class="mek-leading-6">
					<?php
					printf(
						__( '%1$s can works with any theme as long as Elementor is activated, but we strongly recommend you to try our %2$s, It has a unified ui styles and works better with %1$s.', 'moose-elementor-kit' ),
						'<strong>Moose Elementor Kit</strong>',
						'<a target="_blank" href="' . esc_url( $theme_uri ) . '">' . esc_html( $theme_name ) . '</a>'
					);
					?>
                </p>
				<?php if ( $installed_theme !== null ): ?>
                    <p class="mek-leading-6">
						<?php
						printf(
							__( 'We detected that you have installed %s, you can activate it by simply clicking the button below.', 'moose-elementor-kit' ),
							'<a target="_blank" href="' . esc_url( $theme_uri ) . '">' . esc_html( $theme_name ) . '</a>'
						);
						?>
                    </p>
				<?php endif; ?>
            </div>
            <div>
				<?php
				printf( '<a href="%s" class="mek-btn mek-btn-info">%s</a>', $activation_url, esc_html( $action_name ) )
				?>
            </div>
        </div>
    </div>
</div>
