<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2018 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Element;

/**
 * Test class for PhpOffice\PhpWord\Element\AbstractElement
 */
class AbstractElementTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test set/get element index
     */
    public function testElementIndex()
    {
        $stub = $this->getMockForAbstractClass('\PhpOffice\PhpWord\Element\AbstractElement');
        $ival = rand(0, 100);
        $stub->setElementIndex($ival);
        $this->assertEquals($ival, $stub->getElementIndex());
    }

    /**
     * Test set/get element unique Id
     */
    public function testElementId()
    {
        $stub = $this->getMockForAbstractClass('\PhpOffice\PhpWord\Element\AbstractElement');
        $stub->setElementId();
        $this->assertEquals(6, strlen($stub->getElementId()));
    }

    public function testSetNewStyleReturnsStyleObjectIfReturnObjectIsTrue()
    {
        $styleObject = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');
        $styleObject->expects(static::never())
            ->method('setStyleByArray');

        $style = $this->invokeSetNewStyle($styleObject, null, true);

        static::assertSame($styleObject, $style);
    }

    public function testSetNewStyleReturnsStyleValueIfReturnObjectIsFalse()
    {
        $styleObject = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');
        $styleObject->expects(static::never())
            ->method('setStyleByArray');

        $styleValue = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');

        $style = $this->invokeSetNewStyle($styleObject, $styleValue, false);

        static::assertSame($styleValue, $style);
    }

    public function testSetNewStyleCallsSetStyleByArrayIfArrayGiven()
    {
        $styleValue = array(
            'coolStyle' => true,
        );

        $styleObject = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');
        $styleObject->expects(static::once())
            ->method('setStyleByArray')
            ->with($styleValue);

        $style = $this->invokeSetNewStyle($styleObject, $styleValue);

        static::assertSame($styleObject, $style);
    }

    public function testSetNewStyleReturnsNullWhenDefaultParamsGiven()
    {
        $styleObject = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');

        $style = $this->invokeSetNewStyle($styleObject);

        static::assertNull($style);
    }

    private function invokeSetNewStyle($styleObject, $styleValue = null, $returnObject = false)
    {
        $stub = $this->getMockForAbstractClass('\PhpOffice\PhpWord\Element\AbstractElement');

        $reflection = new \ReflectionClass($stub);
        $method = $reflection->getMethod('setNewStyle');
        $method->setAccessible(true);

        return $method->invoke($stub, $styleObject, $styleValue, $returnObject);
    }
}
