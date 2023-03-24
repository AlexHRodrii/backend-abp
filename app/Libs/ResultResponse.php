<?php

namespace App\Libs;

class ResultResponse
{
    const SUCCESS_CODE = 200;
    const CREATED_CODE = 201;
    const NO_CONTENT_CODE = 204;
    const ERROR_CODE = 400;
    const ERROR_ELEMENT_NOT_FOUND_CODE = 404;
    const INTERNAL_SERVER_ERROR_CODE = 500;

    const TXT_CREATED_CODE = 'Recurso creado';
    const TXT_NO_CONTENT_CODE = 'Recurso borrado';
    const TXT_SUCCESS_CODE = 'Success';
    const TXT_ERROR_CODE = 'Error';
    const TXT_ERROR_ELEMENT_NOT_FOUND_CODE = 'Element not found';
    const TXT_INTERNAL_SERVER_ERROR_CODE = 'Internal Server Error';

    public $statusCode;
    public $message;
    public $data;

    function __construct() {
        $this->statusCode = self::ERROR_CODE;
        $this->message = 'Error';
        $this->data = '';
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $message
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

}
