<?php
/**
 * Force the visual editor to strip extra formatting when pasting
 * Credit: https://jonathannicol.com/blog/2015/02/19/clean-pasted-text-in-wordpress/
 */
 
namespace Think_Nathan\Abettor\TinyMCECleanPaste;
 
function tinymce_clean_paste( $in ) {
  $in['paste_preprocess'] = "function(plugin, args){
    // Strip all HTML tags except those we have whitelisted
    var whitelist = 'br,p,span,b,strong,i,em,a,h1,h2,h3,h4,h5,h6,ul,li,ol,abbr,address,cite,dfn,del,ins,q,time';
    var stripped = jQuery('<div>' + args.content + '</div>');
    var els = stripped.find('*').not(whitelist);
    for (var i = els.length - 1; i >= 0; i--) {
      var e = els[i];
      jQuery(e).replaceWith(e.innerHTML);
    }
    // Strip all class and id attributes
    stripped.find('*').removeAttr('id').removeAttr('class').removeAttr('style');
    // Return the clean HTML
    args.content = stripped.html();
  }";
  return $in;
}
add_filter('tiny_mce_before_init', __NAMESPACE__ . '\\tinymce_clean_paste');
