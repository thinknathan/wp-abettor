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

use ArrayAccess;
use Countable;
use IteratorAggregate;

class Options implements ArrayAccess, IteratorAggregate, Countable
{
	/**
	 * Options.
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * Create Options instance.
	 *
	 * @param array $options
	 * @return void
	 */
	public function __construct($options)
	{
			$this->merge($options);
	}

	/**
	 * Get option value.
	 *
	 * @param  string  $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		if ($this->offsetExists($key)) {
				return $this->options[$key];
		}

			return $default;
	}

	/**
	 * Merge passed options.
	 *
	 * @param array|Options $options
	 * @return Options
	 */
	public function merge($options)
	{
		foreach ((array) $options as $option => $value) {
			if (isset($this->options[$option])) {
					continue;
			}

				$this->offsetSet($option, $value);
		}

			return $this;
	}

	/**
	 * Forcefully merge passed options.
	 *
	 * This will overwrite options that already exist.
	 *
	 * @param array|Options $options
	 * @return Options
	 */
	public function forceMerge($options)
	{
		foreach ((array) $options as $option => $value) {
				$this->offsetSet($option, $value);
		}

			return $this;
	}

	/**
	 * Get the internal array of options.
	 *
	 * @return array
	 */
	public function all()
	{
			return $this->options;
	}

	/**
	 * Get all options.
	 *
	 * @return Traversable
	 */
	#[\ReturnTypeWillChange]
	public function getIterator()
	{
			return $this->options;
	}

	/**
	 * Get number of options.
	 *
	 * @return int
	 */
	#[\ReturnTypeWillChange]
	public function count()
	{
			return count($this->options);
	}

	/**
	 * Get option value.
	 *
	 * @param string $key
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet($key)
	{
			return $this->get($key);
	}

	/**
	 * Set option value.
	 *
	 * @param string $key
	 * @param mixed  $value
	 * @return void
	 */
	#[\ReturnTypeWillChange]
	public function offsetSet($key, $value)
	{
			/**
			 * The following:
			 *     $options[] = 'foobar'
			 *     $options[1] = 'foobar'
			 *
			 * Will resolve as:
			 *     $options['foobar'] = true
			 */
		if (!is_string($key)) {
				$key = $value;
				$value = true;
		}

			$this->options[$key] = $value;
	}

	/**
	 * Checks whether option exists.
	 *
	 * @param string $key
	 * @return bool
	 */
	#[\ReturnTypeWillChange]
	public function offsetExists($key)
	{
			return array_key_exists($key, $this->options);
	}

	/**
	 * Delete an option.
	 *
	 * @param string $key
	 * @return void
	 */
	#[\ReturnTypeWillChange]
	public function offsetUnset($key)
	{
			unset($this->options[$key]);
	}

	/**
	 * Get option value.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
			return $this->get($key);
	}

	/**
	 * Set option value.
	 *
	 * @param string $key
	 * @param mixed  $value
	 * @return void
	 */
	public function __set($key, $value)
	{
			$this->offsetSet($key, $value);
	}

	/**
	 * Checks whether option exists.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function __isset($key)
	{
			return $this->offsetExists($key);
	}

	/**
	 * Delete an option.
	 *
	 * @param string $key
	 * @return void
	 */
	public function __unset($key)
	{
			$this->offsetUnset($key);
	}
}
