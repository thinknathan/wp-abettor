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

use DOMDocument;
use DOMNodeList;
use DOMXPath;

class DOM
{
	/**
	 * The root document.
	 *
	 * @var DOMDocument
	 */
	protected $doc;

	/**
	 * Create a new DOM instance.
	 *
	 * @param string $html
	 * @return void
	 */
	public function __construct($html)
	{
			$this->doc = new DOMDocument();

			// use LibXML internal error handler to prevent errors from bubbling to PHP
			libxml_use_internal_errors(true);
			$this->doc->loadHTML('<?xml encoding="UTF-8">' . $html, \LIBXML_HTML_NOIMPLIED | \LIBXML_HTML_NODEFDTD);
			libxml_clear_errors(); // clear all libxml errors
	}

	/**
	 * Executes callback on each DOMElement.
	 *
	 * @param callable $callback
	 * @return DOM
	 */
	public function each($callback)
	{
		foreach ($this->xpath('//*') as $node) {
				$callback($node);
		}

			return $this;
	}

	/**
	 * Evaluates the given XPath expression
	 *
	 * @param string $expression The XPath expression to execute.
	 * @return DOMNodeList
	 */
	public function xpath($expression)
	{
			return (new DOMXPath($this->doc))->query($expression);
	}

	/**
	 * Save the document HTML.
	 *
	 * @return string
	 */
	public function html()
	{
			// Note: 23 = strlen('<?xml encoding="UTF-8">')
			return trim(substr($this->doc->saveHTML(), 23));
	}

	/** {@inheritdoc} */
	public function __call($name, $arguments)
	{
			return $this->doc->{$name}(...$arguments);
	}

	/** {@inheritdoc} */
	public function __get($name)
	{
			return $this->doc->{$name};
	}
}
