<?php
/**
 * Admin home page for MEK.
 */

$tabs = [
	'widgets'    => __( 'Widgets', 'moose-elementor-kit' ),
	'extensions' => __( 'Extensions', 'moose-elementor-kit' ),
	'themes'     => __( 'Themes', 'moose-elementor-kit' ),
];

$active_tab = isset( $_GET['tab'] ) && in_array( $_GET['tab'], array_keys( $tabs ) ) ? $_GET['tab'] : 'widgets';

?>

<?php mek_get_template_part( 'admin/moose-theme-notice' ); ?>
<div class="wrap mek-settings-page mek-bg-base-100 mek-rounded mek-px-8 mek-py-4">
    <!-- Menus -->
    <ul class="mek-menu mek-menu-lg mek-p-4 mek-menu-horizontal mek-menu-primary mek-menu-pills mek-bg-base mek-shadow-sm mek-rounded">
		<?php foreach ( $tabs as $slug => $label ): ?>
            <li class="<?php mek_clsx_echo( [
				'mek-menu-item',
				'mek-current-menu-item' => $active_tab === $slug
			] ); ?>">
                <a href="?page=moose-elementor-kit&tab=<?php echo esc_attr( $slug ) ?>">
					<?php echo esc_html( $label ); ?>
                </a>
            </li>
		<?php endforeach; ?>
        <li class="mek-menu-item">
            <a target="_blank" href="<?php echo esc_url( \MEK\Utils\Upsell::url( 'admin-tab' ) ) ?>">
				<?php esc_html_e( 'Upgrade', 'moose-elementor-kit' ) ?>
            </a>
        </li>
    </ul>

    <!-- Content -->
	<?php
	mek_get_template_part( 'admin/' . $active_tab . '-tab' );
	?>
</div>
