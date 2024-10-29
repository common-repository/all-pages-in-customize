<?php
defined( 'EOS_APIC_PLUGIN_DIR' ) || exit; // Exit if not accessed by the plugin

if( !function_exists( 'eos_apic_customize_register' ) ){
 add_action( 'customize_register', 'eos_apic_customize_register',100 );
 function eos_apic_customize_register( $wp_customize ) {
   $post_types = get_post_types( array( 'publicly_queryable' => true,'public' => true ),'names','and' );
   $post_types = is_array( $post_types ) ? array_unique( array_merge( array( 'page' ),$post_types ) ) : array( 'page','post' );
   $excludes = array( 'attachment' );
   foreach( $excludes as $exclude ){
     if( isset( $post_types[$exclude] ) ){
       unset( $post_types[$exclude] );
     }
   }
   $wp_customize->add_section(
     'eos_apic',
     array(
       'title' => esc_html__( 'All Pages','eos-apic' ),
       'priority' => 10,
     )
   );
   $n = 10;
   foreach( $post_types as $post_type ){
     $wp_customize->add_setting(
       'eos_apic_'.esc_attr( $post_type ),
       array( 'sanitize_callback' => 'sanitize_text_field','transport' => 'postMessage','default' => '0' )
     );
     $values = array( 0 => esc_html__( '-- Select --','eos-apic' ) );
     $posts = get_posts( array( 'posts_per_page' => -1,'orderby' => 'title','order' => 'ASC','post_type' => $post_type,'field' => array( 'ids','post_title' ) ) );
     $post_type_obj = get_post_type_object( $post_type );
     $mobile_ids = false;
     if( function_exists( 'eos_scfm_get_main_options_array' ) ){
       $mobile_ids = eos_scfm_get_main_options_array();
       $mobile_ids = isset( $mobile_ids['mobile_ids'] ) && !empty( $mobile_ids['mobile_ids'] ) ? $mobile_ids['mobile_ids'] : false;
     }
     foreach( $posts as $post ){
       $after_title = $mobile_ids && is_array( $mobile_ids ) && in_array( $post->ID,$mobile_ids ) ? ' &#128241;' : '';
       $values[absint( $post->ID )] = esc_html( $post->post_title ).$after_title;
     }
     if( !empty( $values ) ){
       $wp_customize->add_control(
         'eos_apic_'.$post_type,
         array(
           'type' => 'select',
           'label' => esc_html( $post_type_obj->labels->name ),
           'section' => 'eos_apic',
           'class' => 'eos-apic-control',
           'priority' => $n,
           'choices' => $values
       ) );
     }
     $n = $n + 10;
   }
 }
}

 add_action( 'customize_preview_init', 'eos_apic_enqueue_assets' );
 //Prepare the customize preview loading all the needed scripts and styles
 function eos_apic_enqueue_assets(){
   wp_enqueue_script( 'eos-apic-customizer',EOS_APIC_PLUGIN_URL.'/assets/apic-customizer.js',array( 'jquery','customize-preview' ),EOS_APIC_VERSION,true );
   wp_localize_script( 'eos-apic-customizer','eos_apic',array(
       'home_url' => get_home_url(),
       'post_types' => esc_js( sanitize_text_field( implode( ',',array_keys( get_post_types() ) ) ) )
     )
   );
 }
