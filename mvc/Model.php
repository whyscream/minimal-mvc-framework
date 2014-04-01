<?php

	namespace Mvc;

	/**
	 * Describes the basic functionality of all Model implementations.
	 *
	 * All models should implement a few basics:
	 * - the Countable interface
	 * - the Iterator interface
	 * 
	 * Some examples of what this gives you:
	 *   @code
	 *     // Countable
	 *     $num_results = count($model);
	 * 
	 *     // Iterator
	 *     foreach ($model as $item) {
	 *         print($item->name);
	 *     }
	 *   @endcode
	 */
	interface Model extends \Countable, \Iterator {}
