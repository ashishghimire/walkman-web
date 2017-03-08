<?php

namespace App\Repositories\Gift;

use App\Gift;

/**
 * Class GiftRepository
 * @package App\Repositories\Gift
 */
class GiftRepository implements GiftRepositoryInterface
{
    /**
     * @var Gift
     */
    protected $gift;

    /**
     * GiftRepository constructor.
     * @param Gift $gift
     */
    public function __construct(Gift $gift)
    {
        $this->gift = $gift;
    }

    /**
     * @param $data
     * @return bool
     */
    public function create($data)
    {
        if (!$this->gift->create($data)) {
            return false;
        }

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function find($id)
    {
        try {
            $gift = $this->gift->findOrFail($id);
        } catch (\Exception $exception) {
            return false;
        }

        return $gift;
    }

    /**
     * @param $gift
     * @return bool
     */
    public function resolve($gift)
    {
        $gift->resolved = true;

        if (!$gift->save()) {
            return false;
        }

        return true;
    }
}
