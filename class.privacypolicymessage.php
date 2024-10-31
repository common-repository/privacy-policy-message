<?php

class PrivacyPolicyMessage {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
    }
    
    public function init() {
        load_plugin_textdomain( 'prvpmsg' );
        // add translation
//        add_action( 'plugins_loaded', array($this, 'loadPluginTextdomain')); 
        
        // add assets
        wp_register_script( 'jquery.cookie-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.cookie.js', array('jquery'), PRVPMSG_VERSION );
        wp_enqueue_script( 'jquery.cookie-js' );
        wp_register_style( 'privacy-policy-message-css', plugin_dir_url( __FILE__ ) . 'assets/css/privacy-policy-message.css', array(), PRVPMSG_VERSION );
        wp_enqueue_style( 'privacy-policy-message-css');
        wp_register_script( 'privacy-policy-message-js', plugin_dir_url( __FILE__ ) . 'assets/js/privacy-policy-message.js', array('jquery'), PRVPMSG_VERSION );
        wp_enqueue_script( 'privacy-policy-message-js' );
        
        // add html
        add_action('wp_footer', array($this, 'generateHtml') );
        
    }
    
    public function loadPluginTextdomain(){
        load_plugin_textdomain( 'prvpmsg', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }
    
    public function generateHtml(){
        $options = get_option( 'prvpmsg_options' );
        $link = (!empty( esc_url($options['prvpmsg_field_custom_link_uri']) )  && esc_url($options['prvpmsg_field_link_type'] === 'custom_link') ) ? esc_url($options['prvpmsg_field_custom_link_uri']) : get_privacy_policy_url();
        $link_label = esc_attr($options['prvpmsg_field_link_label']);
        $link_html = ' <a class="prvpmsg__link" href="'.$link.'" target="'.esc_attr($options['prvpmsg_field_link_target']).'">'.$link_label.'</a>';
        $message = str_replace('%link%', $link_html, esc_html($options['prvpmsg_field_message']) );
        echo '<div class="prvpmsg prvpmsg__style-default prvpmsg__position-'.esc_attr($options['prvpmsg_field_message_position']).'" data-expire="'.esc_attr($options['prvpmsg_field_cookie_expire_days']).'">';
        echo '<span class="prvpmsg__message">'.$message.'<span class="prvpmsg__btn-accept prvpmsg__btn-close">'.esc_attr($options['prvpmsg_field_button_label']).'</span></span>';
        echo '<a class="prvpmsg__btn-close prvpmsg__close-x" title="'.__('Close', 'prvpmsg').'"></a>';
        echo '</div>';
            
    }

    public function activation() {
        if( get_option( 'prvpmsg_options' ) ){
            return ;
        }
        $default = array();
        update_option('prvpmsg_options', $default);        
    }
    
    public function deactivation() {
    }
    
    public function unintall() {
    }
}