<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function my_cool_shortcode_manage_page() {
    $shortcodes = get_option( 'my_cool_shortcodes_list', array() );

    // Initialize empty shortcode data
    $editing_shortcode = array(
        'label' => '',
        'name' => '',
        'description' => '',
        'content' => ''
    );

    $edit_index = -1;

    // If editing, get the existing data
    if ( isset( $_GET['edit'] ) && is_numeric( $_GET['edit'] ) ) {
        $edit_index = intval( $_GET['edit'] );
        if ( isset( $shortcodes[ $edit_index ] ) ) {
            $editing_shortcode = $shortcodes[ $edit_index ];
        }
    }

    // Handle form submission
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['my_cool_shortcode_label'], $_POST['my_cool_shortcode_name'], $_POST['my_cool_shortcode_content'] ) ) {
        $new_shortcode = array(
            'label'       => sanitize_text_field( $_POST['my_cool_shortcode_label'] ),
            'name'        => sanitize_text_field( $_POST['my_cool_shortcode_name'] ),
            'description' => isset( $_POST['my_cool_shortcode_description'] ) ? sanitize_text_field( $_POST['my_cool_shortcode_description'] ) : '',
            'content'     => wp_kses_post( $_POST['my_cool_shortcode_content'] ),
        );

        if ( $edit_index >= 0 ) {
            $shortcodes[ $edit_index ] = $new_shortcode;
        } else {
            $shortcodes[] = $new_shortcode;
        }

        update_option( 'my_cool_shortcodes_list', $shortcodes );

        // Redirect to the settings page after adding/editing
        wp_redirect( admin_url( 'admin.php?page=my-cool-shortcodes-settings' ) );
        exit;
    }

    // Now start the HTML output
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Manage Shortcode', 'my-cool-shortcodes' ); ?></h1>

        <a href="<?php echo esc_url( admin_url( 'admin.php?page=my-cool-shortcodes-settings' ) ); ?>" class="button-secondary"><?php esc_html_e( 'Manage Shortcodes', 'my-cool-shortcodes' ); ?></a>

        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="my_cool_shortcode_label"><?php esc_html_e( 'Shortcode Label', 'my-cool-shortcodes' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="my_cool_shortcode_label" name="my_cool_shortcode_label" class="regular-text" value="<?php echo esc_attr( $editing_shortcode['label'] ); ?>" required />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="my_cool_shortcode_name"><?php esc_html_e( 'Shortcode Name', 'my-cool-shortcodes' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="my_cool_shortcode_name" name="my_cool_shortcode_name" class="regular-text" value="<?php echo esc_attr( $editing_shortcode['name'] ); ?>" required />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="my_cool_shortcode_description"><?php esc_html_e( 'Shortcode Description', 'my-cool-shortcodes' ); ?></label>
                    </th>
                    <td>
                        <textarea id="my_cool_shortcode_description" name="my_cool_shortcode_description" class="large-text"><?php echo esc_textarea( $editing_shortcode['description'] ); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="my_cool_shortcode_content"><?php esc_html_e( 'Shortcode Content', 'my-cool-shortcodes' ); ?></label>
                    </th>
                    <td>
                        <?php
                        $content = $editing_shortcode['content'];
                        wp_editor( $content, 'my_cool_shortcode_content' );
                        ?>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php esc_attr_e( $edit_index >= 0 ? 'Update Shortcode' : 'Create Shortcode', 'my-cool-shortcodes' ); ?>" />
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=my-cool-shortcodes-settings' ) ); ?>" class="button-secondary"><?php esc_html_e( 'Cancel', 'my-cool-shortcodes' ); ?></a>
            </p>
        </form>
    </div>
    <?php
}
