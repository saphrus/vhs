<?php
namespace FluidTYPO3\Vhs\Tests\Unit\ViewHelpers\Iterator;

/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Vhs\Tests\Unit\ViewHelpers\AbstractViewHelperTest;

/**
 * @protection on
 * @author Claus Due <claus@namelesscoder.net>
 * @package Vhs
 */
class LastViewHelperTest extends AbstractViewHelperTest {

	/**
	 * @test
	 */
	public function returnsLastElement() {
		$array = array('a', 'b', 'c');
		$arguments = array(
			'haystack' => $array
		);
		$output = $this->executeViewHelper($arguments);
		$this->assertEquals('c', $output);
	}

	/**
	 * @test
	 */
	public function supportsIterators() {
		$array = new \ArrayIterator(array('a', 'b', 'c'));
		$arguments = array(
			'haystack' => $array
		);
		$output = $this->executeViewHelper($arguments);
		$this->assertEquals('c', $output);
	}

	/**
	 * @test
	 */
	public function supportsTagContent() {
		$array = array('a', 'b', 'c');
		$arguments = array(
			'haystack' => NULL
		);
		$output = $this->executeViewHelperUsingTagContent('Array', $array, $arguments);
		$this->assertEquals('c', $output);
	}

	/**
	 * @test
	 */
	public function returnsNullIfHaystackIsNull() {
		$arguments = array(
			'haystack' => NULL
		);
		$output = $this->executeViewHelper($arguments);
		$this->assertEquals(NULL, $output);
	}

	/**
	 * @test
	 */
	public function returnsNullIfHaystackIsEmptyArray() {
		$arguments = array(
			'haystack' => array()
		);
		$output = $this->executeViewHelper($arguments);
		$this->assertEquals(NULL, $output);
	}

	/**
	 * @test
	 */
	public function throwsExceptionOnUnsupportedHaystacks() {
		$arguments = array(
			'haystack' => new \DateTime('now')
		);
		$output = $this->executeViewHelper($arguments);
		$this->assertStringStartsWith('Invalid argument supplied to Iterator/LastViewHelper - expected array, Iterator or NULL but got', $output);
	}

}
