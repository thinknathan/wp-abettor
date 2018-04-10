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
  if (defined('WP_ENV') && WP_ENV === 'development'):
  ?>
    <style>
      /**
      * wp-abettor plugin
      * Adds a red box to the top-left of all pages with the word "DEV" 
      */
      html::before {
        content: 'DEV';
        font-weight: 700;
        letter-spacing: 1px;
        line-height: 3;
        text-align: center;
        width: 3rem;
        height: 3rem;
        background: red;
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999999;
        pointer-events: none;
        opacity: .5;
      }
    </style>
  <?php
  endif;
}
add_action( 'wp_head',    __NAMESPACE__ . '\\add_development_styles', 5 );
add_action( 'admin_head', __NAMESPACE__ . '\\add_development_styles', 5 );


/**
 * Custom development favicon
 * Adds the letter D on top of the existing favicon
 * Credit: http://www.totallycommunications.com/latest/dynamic-favicons-step-by-step-guide/
 */
function add_development_favicon() {
  if (defined('WP_ENV') && WP_ENV === 'development'):
  ?>
    <script>
      /**
      * wp-abettor plugin
      * Adds the letter D on top of the existing favicon 
      */
      (function (c) {
        var b = c.createElement("canvas"),
          d = c.createElement("img"),
          e = c.querySelector("link[rel=icon]");
        if (!e) {
          return;
        };
        var f = e.cloneNode(!0);
        if ("function" == typeof b.getContext) {
          b.width = 16;
          b.height = 16;
          var a = b.getContext("2d");
          d.onload = function () {
            a.drawImage(this, 0, 0, 16, 16);
            a.font = "bold 12px Arial";
            a.fillStyle = "red";
            a.strokeStyle = "white";
            a.lineWidth = 2;
            a.textAlign = "center";
            a.strokeText("D", 8, 13);
            a.fillText("D", 8, 13);
            f.href = b.toDataURL("image/png");
            c.head.appendChild(f);
          };
          d.src = e.href;
        };
      })(document);
    </script>
  <?php
  endif;
}
add_action( 'wp_footer',    __NAMESPACE__ . '\\add_development_favicon', 5 );
add_action( 'admin_footer', __NAMESPACE__ . '\\add_development_favicon', 5 );
