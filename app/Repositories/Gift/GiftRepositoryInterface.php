<?php

namespace App\Repositories\Gift;

/**
 * Interface GiftRepositoryInterface
 * @package App\Repositories\Gift
 */
interface GiftRepositoryInterface
{

    /**
     * @param $data
     * @return mixed
     */
    public function create($data);

    /**
     * @param $gift
     * @return mixed
     */
    public function resolve($gift);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);
}