<?php

/*
Copyright (c) Roots Software LLC

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

namespace Think_Nathan\Abettor;

use ReflectionClass;
use Think_Nathan\Abettor\Modules\AbstractModule;

use function apply_filters;
use function do_action;

class Abettor
{
		/**
		 * List of module classes.
		 *
		 * @var string[]|object[]
		 */
		protected $modules;

		/**
		 * List of supported modules and options.
		 *
		 * @var array[]
		 */
		protected $features;

		/**
		 * Create an instance of Soil.
		 *
		 * @param string[]|object[]
		 * @return void
		 */
		public function __construct($modules = [], $features = [])
		{
				$this->modules = $modules;
				$this->features = $this->features($features);
		}

		/**
		 * Add a module to the list of modules.
		 *
		 * @param string|object $module
		 * @return void
		 */
		public function addModule($module)
		{
				$this->modules[] = $module;
		}

		/**
		 * Remove a module from the list of modules.
		 *
		 * @param string|object $module
		 * @return bool True on success, false on failure
		 */
		public function removeModule($module)
		{
				if (($index = array_search($module, $this->modules, true)) === false) {
						return false;
				}
				unset($this->modules[$index]);
				return true;
		}

		/**
		 * Retrieve list of modules.
		 *
		 * @return string[]|object[]
		 */
		public function getModules()
		{
				return $this->modules;
		}

		/**
		 * Invokes Soil.
		 *
		 * @internal Used by `after_setup_theme`
		 *
		 * @return void
		 */
		public function __invoke()
		{
				$modules = array_unique(array_filter(
						apply_filters('abettor/modules', (array) $this->modules)
				));

				if (!$this->features) {
						$this->features = isset($GLOBALS['_wp_theme_features']['abettor'][0])
								? $this->features($GLOBALS['_wp_theme_features']['abettor'][0])
								: null;
				}

				if (!$this->features) {
						return;
				}

				foreach ($modules as $module) {
						if (is_string($module)) {
								/** @var \Think_Nathan\Abettor\Modules\AbstractModule */
								$module = new $module();
						}

						if (!$this->features) {
								$module->register(['enabled' => true]);
								continue;
						}

						if (isset($this->features[$module->provides()]) && $this->features[$module->provides()]) {
								$module->register($this->features[$module->provides()]);
						}
				}

				do_action('abettor/init');
		}

		protected function features($features = [])
		{
				$modules = [];

				foreach ((array) $features as $module => $options) {
						// add_theme_support('abettor', ['module'])
						if (is_int($module)) {
								$module = $options;
								$options = ['enabled' => true];
						}

						// add_theme_support('abettor', ['module' => true])
						if (is_bool($options)) {
								$options = ['enabled' => $options];
						}

						// add_theme_support('abettor', ['module' => 'some-option'])
						if (!is_array($options)) {
								$options = ['options' => $options];
						}

						// if an option is specified,
						// let's assume the module should be enabled
						// add_theme_support('abettor', ['module' => ['option' => 'value']])
						if (!isset($options['enabled'])) {
								$options['enabled'] = true;
						}

						$modules[$module] = (array) $options;
				}

				return $modules;
		}

		public static function discoverModules($glob = __DIR__ . '/Modules/*Module.php', $namespace = __NAMESPACE__ . '\\Modules')
		{
				$namespace = rtrim($namespace, '\\');

				return array_map(static function ($file) use ($namespace) {
						$className = basename($file, '.php');

						$module =  "{$namespace}\\{$className}";

						if (is_subclass_of($module, AbstractModule::class) && !(new ReflectionClass($module))->isAbstract()) {
								return $module;
						}
				}, glob($glob));
		}
}
