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
}
