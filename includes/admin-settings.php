<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function my_cool_shortcodes_add_admin_menu() {
    add_menu_page(
        __( 'My Cool Shortcodes Settings', 'my-cool-shortcodes' ),
        __( 'Shortcodes', 'my-cool-shortcodes' ),
        'manage_options',
        'my-cool-shortcodes-settings',
        'my_cool_shortcodes_settings_page',
        'dashicons-shortcode',
        20
    );

    // Submenu for adding/editing shortcodes
    add_submenu_page(
        null,
        __( 'Manage Shortcode', 'my-cool-shortcodes' ),
        __( 'Manage Shortcode', 'my-cool-shortcodes' ),
        'manage_options',
        'my-cool-shortcode-manage',
        'my_cool_shortcode_manage_page'
    );
}
add_action( 'admin_menu', 'my_cool_shortcodes_add_admin_menu' );

function my_cool_shortcodes_settings_page() {
    // Handle deleting shortcodes at the very beginning, before any output
    if ( isset( $_POST['delete_shortcode'] ) ) {
        $shortcodes = get_option( 'my_cool_shortcodes_list', array() );
        $index_to_delete = intval( $_POST['delete_shortcode'] );
        unset( $shortcodes[ $index_to_delete ] );
        $shortcodes = array_values( $shortcodes );
        update_option( 'my_cool_shortcodes_list', $shortcodes );

        // Redirect to the settings page after deletion
        wp_redirect( admin_url( 'admin.php?page=my-cool-shortcodes-settings' ) );
        exit;
    }

    // Retrieve shortcodes after handling any deletions
    $shortcodes = get_option( 'my_cool_shortcodes_list', array() );

    // Now begin HTML output
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Shortcodes', 'my-cool-shortcodes' ); ?></h1>

        <a href="<?php echo esc_url( admin_url( 'admin.php?page=my-cool-shortcode-manage' ) ); ?>" class="button-primary"><?php esc_html_e( 'Add Shortcode', 'my-cool-shortcodes' ); ?></a>

        <h2><?php esc_html_e( 'Existing Shortcodes', 'my-cool-shortcodes' ); ?></h2>

        <?php if ( ! empty( $shortcodes ) ) : ?>
            <table class="widefat">
                <thead>
                    <tr>
                        <th><?php esc_html_e( 'Label', 'my-cool-shortcodes' ); ?></th>
                        <th><?php esc_html_e( 'Shortcode Name', 'my-cool-shortcodes' ); ?></th>
                        <th><?php esc_html_e( 'Shortcode', 'my-cool-shortcodes' ); ?></th>
                        <th><?php esc_html_e( 'Description', 'my-cool-shortcodes' ); ?></th>
                        <th><?php esc_html_e( 'Actions', 'my-cool-shortcodes' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $shortcodes as $index => $shortcode ) : ?>
                        <tr>
                            <td><?php echo esc_html( $shortcode['label'] ); ?></td>
                            <td><?php echo esc_html( $shortcode['name'] ); ?></td>
                            <td>[<?php echo esc_html( $shortcode['name'] ); ?>]</td>
                            <td><?php echo esc_html( $shortcode['description'] ); ?></td>
                            <td>
                                <a href="<?php echo esc_url( admin_url( 'admin.php?page=my-cool-shortcode-manage&edit=' . $index ) ); ?>" class="button-primary"><?php esc_html_e( 'Edit', 'my-cool-shortcodes' ); ?></a>
                                <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="delete_shortcode" value="<?php echo esc_attr( $index ); ?>" />
                                    <input type="submit" class="button-secondary" value="<?php esc_attr_e( 'Delete', 'my-cool-shortcodes' ); ?>" onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to delete this shortcode?', 'my-cool-shortcodes' ); ?>');" />
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p><?php esc_html_e( 'No shortcodes found.', 'my-cool-shortcodes' ); ?></p>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=my-cool-shortcode-manage' ) ); ?>" class="button-primary"><?php esc_html_e( 'Add your first shortcode', 'my-cool-shortcodes' ); ?></a>
        <?php endif; ?>
    </div>
    <?php
}
