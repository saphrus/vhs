<?php
namespace FluidTYPO3\Vhs\Tests\Unit\ViewHelpers\Condition\Iterator;

/*
 * This file is part of the FluidTYPO3/Vhs project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Vhs\Tests\Fixtures\Domain\Model\Bar;
use FluidTYPO3\Vhs\Tests\Fixtures\Domain\Model\Foo;
use FluidTYPO3\Vhs\Tests\Unit\ViewHelpers\AbstractViewHelperTest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

/**
 * @protection off
 * @author Claus Due <claus@namelesscoder.net>
 * @package Vhs
 */
class ContainsViewHelperTest extends AbstractViewHelperTest {

	/**
	 * @dataProvider getPositiveTestValues
	 * @param mixed $haystack
	 * @param mixed $needle
	 */
	public function testRendersThen($haystack, $needle) {
		$result = $this->executeViewHelper(array('haystack' => $haystack, 'needle' => $needle, 'then' => 'then'));
		$this->assertEquals('then', $result);
	}

	/**
	 * @return array
	 */
	public function getPositiveTestValues() {
		$bar = new Bar();
		ObjectAccess::setProperty($bar, 'uid', 1, TRUE);
		$foo = new Foo();
		ObjectAccess::setProperty($foo, 'uid', 2, TRUE);
		$objectStorage = new ObjectStorage();
		$objectStorage->attach($bar);
		/** @var LazyObjectStorage $lazyObjectStorage */
		$lazyObjectStorage = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')
			->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\LazyObjectStorage', $bar, 'foo', 0);
		ObjectAccess::setProperty($lazyObjectStorage, 'isInitialized', TRUE, TRUE);
		$lazyObjectStorage->attach($foo);
		return array(
			array(array('foo'), 'foo'),
			array('foo,bar', 'foo'),
			array(array($foo), $foo),
			array($objectStorage, $bar),
			array($lazyObjectStorage, $foo)
		);
	}

	/**
	 * @dataProvider getNegativeTestValues
	 * @param mixed $haystack
	 * @param mixed $needle
	 */
	public function testRendersElse($haystack, $needle) {
		$result = $this->executeViewHelper(array('haystack' => $haystack, 'needle' => $needle, 'else' => 'else'));
		$this->assertEquals('else', $result);
	}

	/**
	 * @return array
	 */
	public function getNegativeTestValues() {
		$bar = new Bar();
		ObjectAccess::setProperty($bar, 'uid', 1, TRUE);
		$foo = new Foo();
		ObjectAccess::setProperty($foo, 'uid', 2, TRUE);
		$objectStorage = new ObjectStorage();
		$objectStorage->attach($bar);
		/** @var LazyObjectStorage $lazyObjectStorage */
		$lazyObjectStorage = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')
			->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\LazyObjectStorage', $bar, 'foo', 0);
		ObjectAccess::setProperty($lazyObjectStorage, 'isInitialized', TRUE, TRUE);
		$lazyObjectStorage->attach($foo);
		return array(
			array(array('foo'), 'bar'),
			array('foo,baz', 'bar'),
			array($objectStorage, $foo),
			array($lazyObjectStorage, $bar)
		);
	}

}
