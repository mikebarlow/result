<?php
namespace Snscripts\Result\Tests;

use Snscripts\Result\Result;

class ResultTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $this->assertInstanceOf(
            'Snscripts\Result\Result',
            new Result(Result::SUCCESS)
        );

        $this->assertInstanceOf(
            'Snscripts\Result\Result',
            new Result(Result::FAIL)
        );
    }

    public function testIsSuccessReturnsCorrectBool()
    {
        $Result = new Result(Result::SUCCESS);
        $this->assertTrue(
            $Result->isSuccess()
        );

        $Result = new Result(Result::FAIL);
        $this->assertFalse(
            $Result->isSuccess()
        );
    }

    public function testIsFailReturnsCorrectBool()
    {
        $Result = new Result(Result::FAIL);
        $this->assertTrue(
            $Result->isFail()
        );

        $Result = new Result(Result::SUCCESS);
        $this->assertFalse(
            $Result->isFail()
        );
    }

    public function testSetMessageSetsWithoutError()
    {
        $Result = new Result(Result::SUCCESS);

        $this->assertInstanceOf(
            'Snscripts\Result\Result',
            $Result->setMessage('Test validation message')
        );
    }

    public function testGetMessageReturnsTheSetMessage()
    {
        $Result = new Result(Result::SUCCESS);
        $Result->setMessage('Test validation message');

        $this->assertSame(
            'Test validation message',
            $Result->getMessage()
        );
    }

    public function testSetErrorsCorrectlySetsErrors()
    {
        $Result = new Result(Result::SUCCESS);

        $this->assertInstanceOf(
            'Snscripts\Result\Result',
            $Result->setErrors([
                'foo' => 'bar',
                'bar' => 'foo',
                'foobar' => 'barfoo'
            ])
        );
    }

    public function testGetErrorsCorrectReturnsTheGetErrors()
    {
        $Result = new Result(Result::SUCCESS);
        $Result->setErrors([
            'foo' => 'bar',
            'bar' => 'foo',
            'foobar' => 'barfoo'
        ]);

        $this->assertSame(
            [
                'foo' => 'bar',
                'bar' => 'foo',
                'foobar' => 'barfoo'
            ],
            $Result->getErrors()
        );
    }

    public function testAddErrorAddsSingleError()
    {
        $Result = new Result(Result::SUCCESS);

        $this->assertSame(
            [],
            $Result->getErrors()
        );

        $Result->addError('foobar');

        $this->assertSame(
            ['foobar'],
            $Result->getErrors()
        );

        $Result->addError(['field' => ['Required Field']]);

        $this->assertSame(
            ['foobar', 'field' => ['Required Field']],
            $Result->getErrors()
        );
    }

    public function testSetErrorsThrowsExceptionWhenStringPassed()
    {
        $this->setExpectedException('InvalidArgumentException');

        $Result = new Result(Result::SUCCESS);

        $Result->setErrors('string should fail');
    }

    public function testSetErrorsThrowsExceptionWhenObjectPassed()
    {
        $this->setExpectedException('InvalidArgumentException');

        $Result = new Result(Result::SUCCESS);

        $Result->setErrors(
            new \StdClass
        );
    }

    public function testSetExtraCorrectly()
    {
        $Result = new Result(Result::SUCCESS);

        $this->assertInstanceOf(
            'Snscripts\Result\Result',
            $Result->setExtra('foo', 'bar')
        );
    }

    public function testGetExtrasRetrievesTheExtraDataCorrectly()
    {
        $Result = new Result(Result::SUCCESS);

        $Result->setExtra('foo', 'bar');
        $this->assertSame(
            ['foo' => 'bar'],
            $Result->getExtras()
        );

        $Result->setExtra('bar', 'foo');
        $this->assertSame(
            ['foo' => 'bar', 'bar' => 'foo'],
            $Result->getExtras()
        );

        $Result->setExtra('foo', ['one' => 'two']);
        $this->assertSame(
            ['foo' => ['one' => 'two'], 'bar' => 'foo'],
            $Result->getExtras()
        );
    }

    public function testSetExtrasCorrectlySetsExtras()
    {
        $Result = new Result(Result::SUCCESS);

        $this->assertInstanceOf(
            'Snscripts\Result\Result',
            $Result->setExtras([
                'foo' => 'bar',
                'bar' => 'foo',
                'foobar' => 'barfoo'
            ])
        );
    }

    public function testSetExtrasThrowsExceptionWhenStringPassed()
    {
        $this->setExpectedException('InvalidArgumentException');

        $Result = new Result(Result::SUCCESS);

        $Result->setExtras('key', 'string should fail');
    }

    public function testSetExtrasThrowsExceptionWhenObjectPassed()
    {
        $this->setExpectedException('InvalidArgumentException');

        $Result = new Result(Result::SUCCESS);

        $Result->setExtras(
            new \StdClass
        );
    }

    public function testSetCodeSetsCorrectly()
    {
        $Result = new Result(Result::SUCCESS);

        $this->assertInstanceOf(
            'Snscripts\Result\Result',
            $Result->setCode(Result::CREATED)
        );
    }

    public function testGetCodeReturnsTheCorrectCode()
    {
        $Result = new Result(Result::SUCCESS);

        $Result->setCode(Result::CREATED);
        $this->assertSame(
            Result::CREATED,
            $Result->getCode()
        );

        $Result->setCode(Result::NOT_FOUND);
        $this->assertSame(
            Result::NOT_FOUND,
            $Result->getCode()
        );
    }

    public function testStaticSuccessReturnsObjectAndStatusEqualsTrue()
    {
        $Result = Result::success();

        $this->assertInstanceOf(
            'Snscripts\Result\Result',
            $Result
        );

        $this->assertTrue(
            $Result->isSuccess()
        );

        $this->assertFalse(
            $Result->isFail()
        );
    }

    public function testStaticFailReturnsObjectAndStatusEqualsFalse()
    {
        $Result = Result::fail();

        $this->assertInstanceOf(
            'Snscripts\Result\Result',
            $Result
        );

        $this->assertTrue(
            $Result->isFail()
        );

        $this->assertFalse(
            $Result->isSuccess()
        );
    }

    public function testStaticCreateSetsDataCorrectly()
    {
        $Result = Result::success(
            Result::UPDATED,
            'lorem ipsum',
            ['foo' => 'bar'],
            ['bar' => 'foo']
        );

        $this->assertTrue(
            $Result->isSuccess()
        );

        $this->assertSame(
            Result::UPDATED,
            $Result->getCode()
        );

        $this->assertSame(
            'lorem ipsum',
            $Result->getMessage()
        );

        $this->assertSame(
            ['foo' => 'bar'],
            $Result->getErrors()
        );

        $this->assertSame(
            ['bar' => 'foo'],
            $Result->getExtras()
        );
    }
}
