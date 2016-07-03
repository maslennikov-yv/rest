<?php
namespace Rest;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Action
{
    const PK = 'id';

    /** @var Resource */
    protected $resource;

    /**
     * Action constructor.
     * @param Resource $resource
     */
    public function __construct($resource = null)
    {
        if (null !== $resource) {
            $this->setResource($resource);
        }
    }

    /**
     * @return Resource
     * @throws \Exception
     */
    public function getResource()
    {
        if (null === $this->resource) {
            throw new \Exception('Resource instance not set');
        }
        return $this->resource;
    }

    /**
     * @param mixed $resource
     */
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     * @throws ApiException
     */
    public function run(Request $request, Response $response)
    {

        try {

            if ($result = $this->dispatch($request)) {

                $code = 200;

            } else {

                $result = [
                    'message' => 'Empty result',
                ];
                $code = 404;

            }

        } catch (\Exception $e) {

            if ($e instanceof ApiException) {

                $result['message'] = $e->getMessage();

                if ($e->getData()) {
                    $result['data'] = $e->getData();
                }
                $code = $e->getCode();

            } else {

                $result['message'] = 'Internal Server Error';
                $code = 500;

            }

        }

        return $this->serialize($response, $result, $code);

    }

    protected function dispatch(Request $request)
    {

        $method = $request->getMethod();
        if (!is_string($method)) {
            throw new ApiException(405, 'Unsupported HTTP method; must be a string, received ' . (is_object($method) ? get_class($method) : gettype($method)));
        }
        $method = strtoupper($method);

        /** @var Resource $resource */
        $resource = $this->getResource();

        if ('GET' === $method) {

            if ($id = $request->getAttribute(static::PK)) {
                $result = $resource->fetch($id, $request->getQueryParams();
            } else {
                $result = $resource->fetchAll($request->getQueryParams());
            }

        } elseif ('POST' === $method) {

            $result = $resource->create($request->getParsedBody());

        } elseif ('PUT' === $method) {

            $result = $resource->update($id, $request->getParsedBody());

        } elseif ('PATCH' === $method) {

            $result = $resource->patch($id, $request->getParsedBody());

        } elseif ('DELETE' === $method) {

            $result = $resource->delete($id);

        } else {

            throw new ApiException(405, 'The ' . $method . ' method has not been defined');
        }

        return $result;

    }

    protected function serialize(Response $response, $data, $status)
    {
        $body = $response->getBody();
        $body->rewind();
        $body->write($json = json_encode($data));

        // Ensure that the json encoding passed successfully
        if ($json === false) {
            throw new \RuntimeException(json_last_error_msg(), json_last_error());
        }

        $responseWithJson = $response->withHeader('Content-Type', 'application/json;charset=utf-8');

        return $responseWithJson->withStatus($status);
    }

}
