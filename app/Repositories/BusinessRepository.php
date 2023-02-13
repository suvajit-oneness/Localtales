<?php
namespace App\Repositories;

use App\Models\Business;
use App\Models\Userbusiness;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\UserCollection;
use App\Contracts\BusinessContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class BusinessRepository
 *
 * @package \App\Repositories
 */
class BusinessRepository extends BaseRepository implements BusinessContract
{
    use UploadAble;

    /**
     * BusinessRepository constructor.
     * @param Business $model
     */
    public function __construct(Business $model)
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
    public function listBusinesss(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findBusinessById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Business|mixed
     */
    public function createBusiness(array $params)
    {
        try {

            $collection = collect($params);

            $business = new Business;
            $business->name = $collection['name'];
            $business->business_name = $collection['business_name'];
            $business->category_id = $collection['category_id'];
            $business->email = $collection['email'];
            $business->password = bcrypt($collection['password']);
            $business->mobile = $collection['mobile'];
            $business->address = $collection['address'];
            $business->pin = $collection['pin'];
            $business->lat = $collection['lat'];
            $business->lon = $collection['lon'];
            $business->description = $collection['description'];
            $business->service_description = $collection['service_description'];
            $business->opening_hour = $collection['opening_hour'];
            $business->website = $collection['website'];
            $business->facebook_link = $collection['facebook_link'];
            $business->twitter_link = $collection['twitter_link'];
            $business->instagram_link = $collection['instagram_link'];
            $business->remember_token = '';
            $business->status = 1;

            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("businesses/",$imageName);
            $uploadedImage = $imageName;
            $business->image = $uploadedImage;

            $business->save();

            return $business;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBusiness(array $params)
    {
        $business = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $business->name = $collection['name'];
        $business->business_name = $collection['business_name'];
        $business->category_id = $collection['category_id'];
        $business->mobile = $collection['mobile'];
        $business->address = $collection['address'];
        $business->pin = $collection['pin'];
        $business->lat = $collection['lat'];
        $business->lon = $collection['lon'];
        $business->description = $collection['description'];
        $business->service_description = $collection['service_description'];
        $business->opening_hour = $collection['opening_hour'];
        $business->website = $collection['website'];
        $business->facebook_link = $collection['facebook_link'];
        $business->twitter_link = $collection['twitter_link'];
        $business->instagram_link = $collection['instagram_link'];

        $business->save();

        return $business;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteBusiness($id)
    {
        $business = $this->findOneOrFail($id);
        $business->delete();
        return $business;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBusinessStatus(array $params){
        $business = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $business->status = $collection['check_status'];
        $business->save();

        return $business;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsBusiness($id)
    {
        $businesses = Business::with('deals')->with('properties')->with('events')->where('id',$id)->get();

        return $businesses;
    }

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getBusinessByPinCode($pinCode){
        $businesses = Business::with('category')->where('pin',$pinCode)->get();

        return $businesses;
    }

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getTrendingBusinessByPinCode($pinCode){
        $businesses = Business::with('category')->where('pin',$pinCode)->take(3)->get();

        return $businesses;
    }

    /**
     * @param $pinCode
     * @param $categoryId
     * @return mixed
     */
    public function getBusinessByCategory($pinCode,$categoryId){
        $businesses = Business::with('category')->where('pin',$pinCode)->where('category_id',$categoryId)->get();

        return $businesses;
    }

    /**
     * @param business_id
     * @param user_id
     * @return Userbusiness|mixed
     */
    public function saveUserBusiness($directory_id,$user_id,$ip){
        $userBusiness = new Userbusiness;
        $userBusiness->directory_id = $directory_id;
        $userBusiness->ip = $_SERVER['REMOTE_ADDR'];
         $userBusiness->user_id = $user_id;

        $userBusiness->save();
//dd($userBusiness);
        return $userBusiness;
    }

    /**
     * @param business_id
     * @param user_id
     * @return bool
     */
    public function deleteUserBusiness($directory_id,$user_id,$ip){
        Userbusiness::where("directory_id",$directory_id)->where("user_id",$user_id)->where("ip",$ip)->delete();

        return true;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function UserBusinesses($user_id){
        $UserBusinesses = Userbusiness::with('directory')->where("user_id",$user_id)->get();

        return $UserBusinesses;
    }

    /**
     * @param business_id
     * @param $user_id
     * @return mixed
     */
    public function checkUserBusinesses($directory_id,$user_id,$ip){
        $userBusinesses = Userbusiness::where('directory_id',$directory_id)->where("user_id",$user_id)->where('ip',$ip)->get();

        return $userBusinesses;
    }




    /**
     * @param business_id
     * @param user_id
     * @return Userbusiness|mixed
     */
    public function saveUserCollection($collection_id,$user_id,$ip){
        $userBusiness = new UserCollection;
        $userBusiness->collection_id = $collection_id;
        $userBusiness->ip = $_SERVER['REMOTE_ADDR'];
         $userBusiness->user_id = $user_id;

        $userBusiness->save();
//dd($userBusiness);
        return $userBusiness;

    }

    /**
     * @param business_id
     * @param user_id
     * @return bool
     */
    public function deleteUserCollection($collection_id,$user_id,$ip){
        UserCollection::where("collection_id",$collection_id)->where("user_id",$user_id)->where("ip",$ip)->delete();

        return true;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function UserCollection($user_id){
        $UserBusinesses = UserCollection::where('user_id',$user_id)->get();
        return $UserBusinesses;
    }

    /**
     * @param business_id
     * @param $user_id
     * @return mixed
     */
    public function checkUserCollection($collection_id,$user_id,$ip){
        $userBusinesses = UserCollection::where('collection_id',$collection_id)->where("user_id",$user_id)->where('ip',$ip)->get();

        return $userBusinesses;
    }


    public function claim(array $params)
     {
        try {

            $collection = collect($params);
            $item = new ClaimBusiness;
            $item->user_id = Auth::guard('user')->user()->id ?? '';
            $item->directory_id = $collection['directory_id'];
            $item->user_name = $collection['user_name'];
            $item->user_email = $collection['user_email'];
            $item->comment = $collection['comment'] ?? '';
            $item->save();
            return $item;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}
