<?php

namespace App\Repositories;

use App\Contracts\SettingsContract;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use App\Traits\UploadAble;
class SettingsRepository extends BaseRepository implements SettingsContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Setting $model
     */
    public function __construct(Setting $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    /**
     * This method is for show settings
     *
     */

    public function listAll(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        // return $this->all($columns, $order, $sort);
        return $this->model->select($columns)->where('key', '!=', 'Splash Screen')->where('key', '!=', 'CONTACT_US')->where('key', '!=', 'ABOUT_US')->where('key', '!=', 'FAQ')->where('key', '!=', 'Collection')->orderBy($order, $sort)->get();
    }
    /**
     * This method is for show settings details
     * @param  $id
     *
     */
    public function listById($id)
    {
        return Setting::where('id',$id)->get();
    }
    /**
     * This method is for settings update
     *
     *
     */
    public function updateSettings(array $params)
    {
        $updatedEntry = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        //$updatedEntry->key = $collection['key'];

        $updatedEntry->content = $collection['content'];

        $updatedEntry->save();

        return $updatedEntry;
    }
    /**
     * @param array $params
     * @return mixed
     */
    public function updateStatus(array $params){
        $state = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $state->status = $collection['check_status'];
        $state->save();

        return $state;
    }
}
