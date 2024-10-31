<?php

class PrivacyPolicyMessageAdmin {
    
    public function __construct() {
        add_action( 'admin_init', array($this, 'settings_init'));
        add_action( 'admin_menu', array($this, 'options_page'));
    }
    
    public function options_page(){
        add_options_page('Privacy Policy Message', 'Privacy Policy Message','manage_options','prvpmsg',array($this, 'options_page_html'));   
    }
    
    public function options_page_html(){
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        } 
        settings_errors( 'prvpmsg_messages' );
        echo '<div class="wrap">';
        echo '<h1>'.esc_html( get_admin_page_title() ).'</h1>';
        echo '<form action="options.php" method="post">';
        settings_fields( 'prvpmsg' );
        do_settings_sections( 'prvpmsg' );
        submit_button( 'Save Settings' );
        echo '</form></div>';
    }
    
    public function settings_init(){
        $plg_options_name = 'prvpmsg_options';
        register_setting( 'prvpmsg', $plg_options_name );
         
        /* 
         * Content Section : section 
         */
        add_settings_section('prvpmsg_section_content', __('Content Section', 'prvpmsg'), array($this, 'section_content_callback'), 'prvpmsg');
         
        /* 
         * Message : textarea 
         */
        add_settings_field('prvpmsg_field_message', 
            __('Message', 'prvpmsg'), array($this, 'field_message_callback'), 'prvpmsg', 'prvpmsg_section_content', [
                'label_for' => 'prvpmsg_field_message',
                'class' => 'prvpmsg_row',
                'plg_options_name' => $plg_options_name,
            ]
        );
         
        /* 
         * Message position : select option (left, right, top, bottom)
         */
        add_settings_field('prvpmsg_field_message_position', 
            __('Message position', 'prvpmsg'), array($this, 'field_message_position_callback'), 'prvpmsg', 'prvpmsg_section_content', [
                'label_for' => 'prvpmsg_field_message_position',
                'class' => 'prvpmsg_row',
                'plg_options_name' => $plg_options_name,
            ]
        );
        
        /* 
         * Link type : select / 1. custom link;  2. privacy policy page;
         */
        add_settings_field('prvpmsg_field_link_type', 
            __('Link type', 'prvpmsg'), array($this, 'field_link_type_callback'), 'prvpmsg', 'prvpmsg_section_content', [
                'label_for' => 'prvpmsg_field_link_type',
                'class' => 'prvpmsg_row',
                'plg_options_name' => $plg_options_name,
            ]
        );
         
        /* 
         * Link label : input/text 
         */
        add_settings_field('prvpmsg_field_link_label', 
            __('Link label', 'prvpmsg'), array($this, 'field_link_label_callback'), 'prvpmsg', 'prvpmsg_section_content', [
                'label_for' => 'prvpmsg_field_link_label',
                'class' => 'prvpmsg_row',
                'plg_options_name' => $plg_options_name,
            ]
        );
         
        /* 
         * Link target : select 
         */
        add_settings_field('prvpmsg_field_link_target', 
            __('Link target', 'prvpmsg'), array($this, 'field_link_target_callback'), 'prvpmsg', 'prvpmsg_section_content', [
                'label_for' => 'prvpmsg_field_link_target',
                'class' => 'prvpmsg_row',
                'plg_options_name' => $plg_options_name,
            ]
        );
        
        /* 
         * Custom link URI : input/text
         */
        add_settings_field('prvpmsg_field_custom_link_uri', 
            __('Custom link URI', 'prvpmsg'), array($this, 'field_custom_link_uri_callback'), 'prvpmsg', 'prvpmsg_section_content', [
                'label_for' => 'prvpmsg_field_custom_link_uri',
                'class' => 'prvpmsg_row',
                'plg_options_name' => $plg_options_name,
            ]
        );
         
        /* 
         * Button label : input/text 
         */
        add_settings_field('prvpmsg_field_button_label', 
            __('Button label', 'prvpmsg'), array($this, 'field_button_label_callback'), 'prvpmsg', 'prvpmsg_section_content', [
                'label_for' => 'prvpmsg_field_button_label',
                'class' => 'prvpmsg_row',
                'plg_options_name' => $plg_options_name,
            ]
        );
        
        /* 
         * Cookie expire days: input/text
         */
        add_settings_field('prvpmsg_field_cookie_expire_days', 
            __('Cookie expire days', 'prvpmsg'), array($this, 'field_cookie_expire_days_callback'), 'prvpmsg', 'prvpmsg_section_content', [
                'label_for' => 'prvpmsg_field_cookie_expire_days',
                'class' => 'prvpmsg_row',
                'plg_options_name' => $plg_options_name,
            ]
        );
        
    }
    
    function field_custom_link_uri_callback($args) {
        $options = get_option($args['plg_options_name']);
        echo '<input id="'.esc_attr( $args['label_for'] ).'" name="prvpmsg_options['.esc_attr( $args['label_for'] ).']" size="40" type="text" value="'.$options[ $args['label_for'] ].'" />';
    }
    
    function field_cookie_expire_days_callback($args) {
        $options = get_option($args['plg_options_name']);
        echo '<input id="'.esc_attr( $args['label_for'] ).'" name="prvpmsg_options['.esc_attr( $args['label_for'] ).']" size="40" type="text" value="'.$options[ $args['label_for'] ].'" />';
    }

    public function field_message_position_callback($args){
        $options = get_option($args['plg_options_name']);
        echo '<select id="'.esc_attr( $args['label_for'] ).'" data-custom="'.esc_attr( $args['plg_options_name'] ).'" name="prvpmsg_options['.esc_attr( $args['label_for'] ).']"
        >';
        echo '<option value="left" '.(isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'left', false ) ) : ( '' ) ).'>'.__( 'Left', 'prvpmsg' ).'</option>';
        echo '<option value="right" '.(isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'right', false ) ) : ( '' )).'>'.__( 'Right', 'prvpmsg' ).'</option>';
        echo '<option value="top" '.(isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'top', false ) ) : ( '' ) ).'>'.__( 'Top', 'prvpmsg' ).'</option>';
        echo '<option value="bottom" '.(isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'bottom', false ) ) : ( '' )).'>'.__( 'Bottom', 'prvpmsg' ).'</option>';
        echo '</select>';
    }
    
    public function field_link_target_callback($args){
        $options = get_option($args['plg_options_name']);
        echo '<select id="'.esc_attr( $args['label_for'] ).'" data-custom="'.esc_attr( $args['plg_options_name'] ).'" name="prvpmsg_options['.esc_attr( $args['label_for'] ).']"
        >';
        echo '<option value="_self" '.(isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], '_self', false ) ) : ( '' ) ).'>'.__( 'Same window', 'prvpmsg' ).'</option>';
        echo '<option value="_blank" '.(isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], '_blank', false ) ) : ( '' )).'>'.__( 'Open in new window', 'prvpmsg' ).'</option>';
        echo '</select>';
    }
    
    public function field_link_type_callback($args){
        $options = get_option($args['plg_options_name']);
        echo '<select id="'.esc_attr( $args['label_for'] ).'" data-custom="'.esc_attr( $args['plg_options_name'] ).'" name="prvpmsg_options['.esc_attr( $args['label_for'] ).']"
        >';
        echo '<option value="custom_link" '.(isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'custom_link', false ) ) : ( '' ) ).'>'.__( 'Custom link', 'prvpmsg' ).'</option>';
        echo '<option value="privacy_page" '.(isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'privacy_page', false ) ) : ( '' )).'>'.__( 'Privacy policy page', 'prvpmsg' ).'</option>';
        echo '</select>';
    }
    
    public function section_content_callback($args){
        echo '<p id="'.esc_attr( $args['id'] ).'">'.esc_html_e( 'Set Content Options', 'prvpmsg' ).'</p>';
    }
    
    function field_message_callback($args) {
        $options = get_option($args['plg_options_name']);
        echo '<textarea id="'.esc_attr( $args['label_for'] ).'" style="width:100%;" name="prvpmsg_options['.esc_attr( $args['label_for'] ).']" rows="5">'.$options[ $args['label_for'] ].'</textarea>';
    }
    
    function field_button_label_callback($args) {
        $options = get_option($args['plg_options_name']);
        echo '<input id="'.esc_attr( $args['label_for'] ).'" name="prvpmsg_options['.esc_attr( $args['label_for'] ).']" size="40" type="text" value="'.$options[ $args['label_for'] ].'" />';
    }
    
    function field_link_label_callback($args) {
        $options = get_option($args['plg_options_name']);
        echo '<p>'.__('Insert text %link% in message text to view link.', 'prvpmsg').'</p>';
        echo '<input id="'.esc_attr( $args['label_for'] ).'" name="prvpmsg_options['.esc_attr( $args['label_for'] ).']" size="40" type="text" value="'.$options[ $args['label_for'] ].'" />';
    }

}