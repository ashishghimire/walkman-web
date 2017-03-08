<?php

namespace App\Repositories\Incentive;

use App\Incentive;
use File;
use Storage;

/**
 * Class IncentiveRepository
 * @package App\Repositories\Incentive
 */
class IncentiveRepository implements IncentiveRepositoryInterface
{
    /**
     * @var Incentive
     */
    protected $incentive;
    /**
     * @var array
     */
    protected $days = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');

    /**
     * IncentiveRepository constructor.
     * @param Incentive $incentive
     */
    public function __construct(Incentive $incentive)
    {
        $this->incentive = $incentive;
    }

    /**
     * @param $userId
     * @param $data
     * @return bool
     */
    public function save($userId, $data)
    {
        $data['user_id'] = $userId;

        if (!empty($data['photo'])) {
            $fileName = Storage::putFile('incentive_pictures', $data['photo']);
            $data['photo'] = $fileName;
        }

        if ($this->incentive->create($data)) {
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->incentive->findOrFail($id);
    }

    /**
     * @param $incentive
     * @param $data
     * @return bool
     */
    public function update($incentive, $data)
    {
        $incentive->description = $data['description'];
        $incentive->day = $data['day'];
        $incentive->gold_value = $data['gold_value'];

        if (!empty($data['photo'])) {

            $fileName = Storage::putFile('incentive_pictures', $data['photo']);

            if (!empty($incentive->photo)) {
                if (File::exists(storage_path("app/{$incentive->photo}"))) {
                    Storage::delete($incentive->photo);
                }
            }
            $incentive->photo = $fileName;
        } else {
            if (isset($data['image-deleted'])) {
                Storage::delete($incentive->photo);
                $incentive->photo = null;
            }
        }
        if ($incentive->save()) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getTodaysIncentives()
    {

        $today = date('w');

        return $this->incentive
            ->where('day', $this->days[$today])
            ->where('available', true)
            ->with('sponsor')->get();
    }
}
