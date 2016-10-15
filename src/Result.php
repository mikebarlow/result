<?php
namespace Snscripts\Result;

class Result
{
    protected $success = false;
    protected $code = '';
    protected $message = '';
    protected $errors = [];

    const
        SUCCESS = true,
        FAIL = false;

    /**
     * initiate a success result
     *
     * @param string $code
     * @param string $message
     * @param array $errors
     * @return Result $Result
     */
    public static function success($code = '', $message = '', $errors = [])
    {
        $Result = new static(self::SUCCESS);

        if (! empty($code)) {
            $Result->setCode($code);
        }

        if (! empty($message)) {
            $Result->setMessage($message);
        }

        if (! empty($errors)) {
            $Result->setErrors($errors);
        }

        return $Result;
    }

    /**
     * initiate a fail result
     *
     * @param string $code
     * @param string $message
     * @param array $errors
     * @return Result $Result
     */
    public static function fail($code = '', $message = '', $errors = [])
    {
        $Result = new static(self::FAIL);

        if (! empty($code)) {
            $Result->setCode($code);
        }

        if (! empty($message)) {
            $Result->setMessage($message);
        }

        if (! empty($errors)) {
            $Result->setErrors($errors);
        }

        return $Result;
    }

    /**
     * construct the Result object with a true / false denoting successful or not
     *
     * @param $success bool
     */
    public function __construct($success)
    {
        $this->success = $success;
    }

    /**
     * was the result successful
     *
     * @return bool
     */
    public function isSuccess()
    {
        return ($this->success === self::SUCCESS);
    }

    /**
     * did the result fail
     *
     * @return bool
     */
    public function isFail()
    {
        return ($this->success === self::FAIL);
    }

    /**
     * set the code
     *
     * @param string $code
     * @return Result $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * get the code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * set a more elaborate message
     *
     * @param string $message
     * @return Result $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * get the message
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * get the error messages
     *
     * @return array $errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * set all the error messages
     *
     * @param array $errors
     * @return Result $this
     */
    public function setErrors($errors)
    {
        if (! is_array($errors)) {
            throw new \InvalidArgumentException('Result->setErrors() must be passed an array');
        }

        $this->errors = $errors;
        return $this;
    }

    /**
     * add an error message to the list
     *
     * @param mixed $error
     * @return Result $this
     */
    public function addError($error)
    {
        if (is_array($error)) {
            $this->errors += $error;
        } else {
            $this->errors[] = $error;
        }
        
        return $this;
    }
}
