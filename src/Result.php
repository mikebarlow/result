<?php
namespace Snscripts\Result;

class Result
{
    protected $success = false;
    protected $code = '';
    protected $message = '';
    protected $errors = [];
    protected $extra = [];

    const
        SUCCESS = true,
        FAIL = false,

        // readable string codes to describe the result in multi lang situations
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
        PROCESSING = 'processing';

    /**
     * initiate a success result
     *
     * @param string $code
     * @param string $message
     * @param array $errors
     * @param array $extras
     * @return Result $Result
     */
    public static function success($code = '', $message = '', $errors = [], $extras = [])
    {
        return self::loadResult(self::SUCCESS, $code, $message, $errors, $extras);
    }

    /**
     * initiate a fail result
     *
     * @param string $code
     * @param string $message
     * @param array $errors
     * @param array $extras
     * @return Result $Result
     */
    public static function fail($code = '', $message = '', $errors = [], $extras = [])
    {
        return self::loadResult(self::FAIL, $code, $message, $errors, $extras);
    }

    /**
     * load up the result object
     *
     * @param bool $status
     * @param string $code
     * @param string $message
     * @param array $errors
     * @param array $extras
     * @return Result $Result
     */
    protected static function loadResult($status, $code, $message, $errors, $extras)
    {
        $Result = new static($status);

        if (! empty($code)) {
            $Result->setCode($code);
        }

        if (! empty($message)) {
            $Result->setMessage($message);
        }

        if (! empty($errors)) {
            $Result->setErrors($errors);
        }

        if (! empty($extras)) {
            $Result->setExtras($extras);
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

    /**
     * get the extra data
     *
     * @return array $extras
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * get individual extra items
     *
     * @param string $key
     * @return mixed
     */
    public function getExtra($key)
    {
        if (array_key_exists($key, $this->extras)) {
            return $this->extras[$key];
        }

        return false;
    }

    /**
     * set extra data
     *
     * @param string $key
     * @param mixed $data
     * @return Result $this
     */
    public function setExtra($key, $data)
    {
        $this->extras[$key] = $data;
        return $this;
    }

    /**
     * set all extra data
     *
     * @param string $extras
     * @return Result $this
     */
    public function setExtras($extras)
    {
        if (! is_array($extras)) {
            throw new \InvalidArgumentException('Result->setExtras() must be passed an array');
        }

        $this->extras = $extras;
        return $this;
    }
}
