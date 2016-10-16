# Framework Agnostic Results Object

[![Author](http://img.shields.io/badge/author-@mikebarlow-red.svg?style=flat-square)](https://twitter.com/mikebarlow)
[![Source Code](http://img.shields.io/badge/source-snscripts/result-brightgreen.svg?style=flat-square)](https://github.com/snscripts/result)
[![Latest Version](https://img.shields.io/github/release/snscripts/result.svg?style=flat-square)](https://github.com/snscripts/result/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/snscripts/result/blob/master/LICENSE)
[![Build Status](https://img.shields.io/travis/snscripts/result/master.svg?style=flat-square)](https://travis-ci.org/snscripts/result)

## Introduction

This Result Object is a PSR-2 Compliant Framework Agnostic helper designed for returning data in an object orientated way. It allows you do easily define the success or failure of the recent action as well as set easily checkable status strings, fuller messages, error strings and any extra data.

## Requirements

### Composer

Snscripts\Result requires the following:

* "php": ">=5.5.0"

And the following if you wish to run in dev mode and run tests.

* "phpunit/phpunit": "~4.0"
* "squizlabs/php_codesniffer": "~2.0"

## Installation

### Composer

Simplest installation is via composer.

    composer require snscripts/result 1.*

or adding to your projects `composer.json` file.

    {
        "require": {
            "snscripts/result": "1.*"
        }
    }

## Usage

In it's simplest form the package can be used in the following ways

	// A successful result
	$Result = \Snscripts\Result\Result::success();
	
	// A failure result
	$Result = \Snscripts\Result\Result::fail();
	
You would then need to return `$Result` from your function or library, within the code that called your library you can then check whether the result was a success or a fail depending on your needs

	$Result = $MyLibrary->someAction(); // this returns Result::success();
	
	// check for a success
	var_dump($Result->isSuccess());
	
	// check for a fail
	var_dump($Result->isFail());
	
### Status Codes

Sometimes you may wish to define a status code to go with the result, this can further describe the result. This can also be useful in multi-lingual situations where your code requires a fixed string / code to define exactly what happened.

You can set a code using `$Result->setCode('myCode');` and retrieve the code from the result using `$Result->getCode();`.

As default the object comes with some defined constants for common results.

	CREATED    = 'created',
	UPDATED    = 'updated',
	SAVED      = 'saved',
	DELETED    = 'deleted',
	VALIDATION = 'validation',
	AUTH       = 'authorised',
	NOT_AUTH   = 'not_authorised',
	FOUND      = 'found',
	NOT_FOUND  = 'not_found',
	ERROR      = 'error',
	FAILED     = 'failed',
	PROCESSING = 'processing'
  
These are object constants so would be accessed in the following way.

	use Snscripts\Result\Result;
	
	var_dump(Result::CREATED);
	var_dump(Result::AUTH);
	var_dump(Result::NOT_FOUND);
	
This means you can use them in the following way in combination with `setCode` method above.
	
	$Result->setCode(Result::ERROR);
	
	echo $Result->getCode(); // 'error'
	
The error code can also be passed as the first parameter of the static `success` and `fail` methods.

	Result::success(Result::CREATED);
	Result::fail(Result::VALIDATION);
	
## Message

Along with the status code you can also define a message to pass along. This could be the actual message that is displayed to the user, a language string for translation, etc...

This is set and retrieved in the following way.

	$Result->setMessage('Your item was added successfully');
	$Result->getMessage();
	
For convience, a message can also be passed as the second parameter of the static `success` and `fail` methods.

	Result::success(
		Result::CREATED, 
		'Your item was created successfully'
	);
	Result::fail(
		Result::VALIDATION, 
		'There was a validation error, please try again'
	);
	
## Errors

If the result is a fail result, you may need to pass an array of errors. This will generally be from your systems validation methods.

You can set a full array of errors in one go by using the `setErrors` command.

	$Result->setErrors([
		'field' => [
			'is required,
			'must be unique'
		],
		'another_field' => 'is required'
	]);
	
You can then retrieve the error list very simply by calling

	var_dump($Result->getErrors());
	
In some cases you may be looping through your data and need to set error messages one at a time.

You can do this by using `setError`

	$Result->setError('Field is required');
	$Result->setError(['field' => 'is required']);
	
The `setError` method has been written so any strings set will be pushed onto the array as normal.

	$Result->setError('Field is required');
	$Result->setError('Another error occurred');
	
	// var_dump($Result->getErrors()); Will result in
	[
		'Field is required',
		'Another error occurred'
	]

In the event of an array being passed, the method will try and merge the array in. This helps prevent an extra array level being created and also helps merge data if multiple errors occurred on the same key.

	$Result->setError('Field is required');
	$Result->setError(['field' => 'is required']);
	// var_dump($Result->getErrors()); Will result in
	[
		'Field is required',
		'field' => 'is required'
	]
	
For convience, you can pass an array of errors into the third parameter of the `success` and `fail` static methods, this will perform the equivilant of the `setErrors` command and will set the complete array of errors.

	Result::fail(
		Result::VALIDATION, 
		'There was a validation error, please try again',
		[
			'field1' => 'is required',
			'field2' => [
				'is required',
				'should be unique'
			]
		]
	);
		
## Extras

With any result you may wish to passed some extra data back with the result, this could be a copy of the data just manipulated or a copy of the form array that just failed validation, with Result you can pass this simply with the following commands.

You can set a full array of extra data in one go by using the `setExtras` command.

	$Result->setExtras([
		'foo' => 'bar',
		'bar' => 'foo',
		[
			'fizzbuzz',
			'buzzfizz'
		]
	]);
	
You can then retrieve the extra data list very simply by calling

	var_dump($Result->getExtras());
	
In some cases you may be looping through your data and need to set data one piece at a time.

You can do this by using `setExtra`

	$Result->setExtra('foobar');
	$Result->setExtra(['foo' => 'bar']);
	
The `setExtra` method has been written so any strings set will be pushed onto the array as normal.

	$Result->setExtra('foobar');
	$Result->setExtra('barfoo');
	
	// var_dump($Result->getExtras()); Will result in
	[
		'foobar',
		'barfoo'
	]

In the event of an array being passed, the method will try and merge the array in. This helps prevent an extra array level being created and also helps merge data if multiple items occurred on the same key.

	$Result->setExtra('foobar');
	$Result->setExtra(['foo' => 'bar']);
	// var_dump($Result->getExtras()); Will result in
	[
		'Foobar',
		'foo' => 'bar'
	]
	
For convience, you can pass an array of extra data into the fourth parameter of the `success` and `fail` static methods, this will perform the equivilant of the `setExtras` command and will set the complete array of data.

	Result::success(
		Result::CREATED, 
		'Your item was successfully created',
		[],
		[
			'id' => 1,
			'name' => 'Foo Bar',
			'address' => 'fizzbuzz street'
		]
	);
	
## Contributing

Please see [CONTRIBUTING](https://github.com/snscripts/result/blob/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/snscripts/result/blob/master/LICENSE) for more information.
