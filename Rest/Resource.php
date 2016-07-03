<?php
namespace Rest;

class Resource
{

    /**
     * Create a resource
     *
     * @param $data
     * @throws ApiException
     */
    public function create($data)
    {
        throw new ApiException(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param $id
     * @throws ApiException
     * @return mixed
     */
    public function delete($id)
    {
        throw new ApiException(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Fetch a resource
     *
     * @param $id
     * @param array $params
     * @throws ApiException
     */
    public function fetch($id, $params = array())
    {
        throw new ApiException(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @throws ApiException
     * @return mixed
     */
    public function fetchAll($params = array())
    {
        throw new ApiException(405, 'The GET method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @throws ApiException
     * @return mixed
     */
    public function update($id, $data)
    {
        throw new ApiException(405, 'The PUT method has not been defined for individual resources');
    }

    /**
     * Patch a resource
     *
     * @param $id
     * @param $data
     * @throws ApiException
     */
    public function patch($id, $data)
    {
        throw new ApiException(405, 'The PATCH method has not been defined for individual resources');
    }

}