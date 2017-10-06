<?php
/**
 * Provides visual differentiators for development sites. 
 */

namespace Think_Nathan\Abettor\DemarcateDevelopment;

/**
 * Custom development message on dev environment
 * Adds a red box to the top-left of all pages with the word "DEV"
 */
function add_development_styles() {
  if (WP_ENV === 'development') {
    $output = "<style>html::before { content: 'DEV'; font-weight: 700; letter-spacing: 1px; line-height: 3; text-align: center; width: 3rem; height: 3rem; background: red; display: block; position: fixed; top: 0; left: 0; z-index: 999999; pointer-events: none; opacity: .5; }</style>";
    echo $output;
  }
}
add_action( 'wp_head',    __NAMESPACE__ . '\\add_development_styles', 5 );
add_action( 'admin_head', __NAMESPACE__ . '\\add_development_styles', 5 );


/**
 * Custom development favicon
 * Adds the letter D on top of the existing favicon
 * Credit: http://www.totallycommunications.com/latest/dynamic-favicons-step-by-step-guide/
 */
function add_development_favicon() {
  if (WP_ENV === 'development') {
    $output = '<script>(function(c){';
    $output .= 'var b=c.createElement("canvas"),d=c.createElement("img"),e=c.querySelector("link[rel=icon]");';
    $output .= 'if (!e) {return};';
    $output .= 'var f=e.cloneNode(!0);';
    $output .= 'if("function"==typeof b.getContext){b.width=16;b.height=16;';
    $output .= 'var a=b.getContext("2d");';
    $output .= 'd.onload=function(){';
    $output .= 'a.drawImage(this,0,0,16,16);';
    $output .= 'a.font="bold 12px Arial";';
    $output .= 'a.fillStyle="red";';
    $output .= 'a.strokeStyle="white";';
    $output .= 'a.lineWidth=2;';
    $output .= 'a.textAlign="center";';
    $output .= 'a.strokeText("D",8,13);';
    $output .= 'a.fillText("D",8,13);';
    $output .= 'f.href=b.toDataURL("image/png");';
    $output .= 'c.head.appendChild(f)';
    $output .= '};';
    $output .= 'd.src=e.href';
    $output .= '}})(document);';
    $output .= '</script>';
    echo $output;
  }
}
add_action( 'wp_footer',    __NAMESPACE__ . '\\add_development_favicon', 5 );
add_action( 'admin_footer', __NAMESPACE__ . '\\add_development_favicon', 5 );
