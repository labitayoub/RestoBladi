<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    /**
     * Get all resources
     * 
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']);
    
    /**
     * Find resource by id
     * 
     * @param int $id
     * @return mixed
     */
    public function find($id);
    
    /**
     * Find resource by field
     * 
     * @param string $field
     * @param mixed $value
     * @return mixed
     */
    public function findBy($field, $value);
    
    /**
     * Create new resource
     * 
     * @param array $data
     * @return mixed
     */
    public function create(array $data);
    
    /**
     * Update resource
     * 
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, $id);
    
    /**
     * Delete resource
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id);
}