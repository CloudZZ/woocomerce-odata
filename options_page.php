<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





?>
<style>
    .one_c_options input[type=text]{
        width:400px;
    }
</style>
<div class="wrap">
    <h1><?php _e('1C Sync Settings') ?></h1>
    <form class="one_c_options" method="post" action="options.php">
        <?php settings_fields( '1c-option-group' ); ?>
        <?php do_settings_sections( '1c-option-group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('1C Url'); ?></th>
                <td><input type="text" name="1c_url" value="<?php echo esc_attr( get_option('1c_url') ); ?>" /></td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e('1C Login'); ?></th>
                <td><input type="text" name="1c_login" value="<?php echo esc_attr( get_option('1c_login') ); ?>" /></td>
            </tr>

            <tr valign="top">
                <th scope="row"><?php _e('1C Pass'); ?></th>
                <td><input type="text" name="1c_pass" value="<?php echo esc_attr( get_option('1c_pass') ); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
<?php
//require_once('cron.php');
?>