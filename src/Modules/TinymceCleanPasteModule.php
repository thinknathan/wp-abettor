<?php

namespace Think_Nathan\Abettor\Modules;

use function is_admin;

/**
 * Force the visual editor to strip extra formatting when pasting
 * Credit: https://jonathannicol.com/blog/2015/02/19/clean-pasted-text-in-wordpress/
 */
class TinymceCleanPasteModule extends AbstractModule
{
	/**
	 * Name of the module.
	 *
	 * @var string
	 */
	protected $name = 'tinymce-clean-paste';

	/**
	 * Condition under which the module is loaded.
	 *
	 * @return bool
	 */
	protected function condition()
	{
			return apply_filters(
				'abettor/load-module/' . $this->provides(),
				$this->options->enabled && is_admin()
			);
	}

	/**
	 * Module handle.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->filter('tiny_mce_before_init', 'tinymceCleanPaste');
	}

	/**
	 * Strip all HTML tags except those we have allowlisted
	 *
	 * @internal Used by `tiny_mce_before_init`
	 *
	 * @param array $in
	 * @return array
	 */
	public function tinymceCleanPaste($in)
	{
		$in['paste_preprocess'] = "function(plugin, args){
			const allowed = 'br,p,span,b,strong,i,em,a,h1,h2,h3,h4,h5,h6,ul,li,ol,abbr,address,cite,dfn,del,ins,q,time';
			const stripped = jQuery('<div>' + args.content + '</div>');
			const els = stripped.find('*').not(allowed);
			for (let i = els.length - 1; i >= 0; i--) {
				const e = els[i];
				jQuery(e).replaceWith(e.innerHTML);
			}
			// Strip all class and id attributes
			stripped.find('*').removeAttr('id').removeAttr('class').removeAttr('style');
			args.content = stripped.html();
		}";
		return $in;
	}
}
