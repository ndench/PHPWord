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
        $stub = $this->getElementStub();

        $styleObject = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');
        $styleObject->expects(static::never())
            ->method('setStyleByArray');

        $style = $stub->callSetNewStyle($styleObject, null, true);

        static::assertSame($styleObject, $style);
    }

    public function testSetNewStyleReturnsStyleValueIfReturnObjectIsFalse()
    {
        $stub = $this->getElementStub();

        $styleObject = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');
        $styleObject->expects(static::never())
            ->method('setStyleByArray');

        $styleValue = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');

        $style = $stub->callSetNewStyle($styleObject, $styleValue, false);

        static::assertSame($styleValue, $style);
    }

    public function testSetNewStyleCallsSetStyleByArrayIfArrayGiven()
    {
        $stub = $this->getElementStub();

        $styleValue = array(
            'coolStyle' => true,
        );

        $styleObject = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');
        $styleObject->expects(static::once())
            ->method('setStyleByArray')
            ->with($styleValue);

        $style = $stub->callSetNewStyle($styleObject, $styleValue);

        static::assertSame($styleObject, $style);
    }

    public function testSetNewStyleReturnsNullWhenDefaultParamsGiven()
    {
        $stub = $this->getElementStub();

        $styleObject = $this->createMock('\PhpOffice\PhpWord\Style\AbstractStyle');

        $style = $stub->callSetNewStyle($styleObject);

        static::assertNull($style);
    }

    private function getElementStub()
    {
        return new class() extends AbstractElement {
            public function callSetNewStyle($styleObject, $styleValue = null, $returnObject = false)
            {
                return $this->setNewStyle($styleObject, $styleValue, $returnObject);
            }
        };
    }
}
