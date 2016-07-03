<?php
namespace Rest;

use Exception;

class ApiException extends Exception
{

    /**
     * Status titles for common problems
     *
     * @var array
     */
    protected $problemStatusTitles = [
        // CLIENT ERROR
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        // SERVER ERROR
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];

    private $data;

    /**
     * @return null|array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * ApiException constructor.
     *
     * @param string $code
     * @param null $details
     * @param null $data
     * @param Exception|null $previous
     */
    public function __construct($code, $details = null, $data = null, Exception $previous = null)
    {
        $this->data = $data;

        if (!isset($this->problemStatusTitles[$code])) {
            $code = 500;
        }

        parent::__construct($details ? $details : $this->problemStatusTitles[$code], $code, $previous);
    }

}