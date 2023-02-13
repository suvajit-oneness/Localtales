<?php
namespace App\Repositories;

use App\Models\BusinessLead;
use App\Models\Userbusiness;
use App\Models\BusinessSignupPage;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\BussinessLeadContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class BusinessRepository
 *
 * @package \App\Repositories
 */
class BussinessLeadRepository extends BaseRepository implements BussinessLeadContract
{
    use UploadAble;

    /**
     * BusinessRepository constructor.
     * @param BusinessLead $model
     */
    public function __construct(BusinessLead $model)
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
    public function listBusinesssLead(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findBusinessLeadById(int $id)
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
    public function createLeadBusiness(array $params)
    {
        try {

            $collection = collect($params);

            $business = new BusinessLead;
            $business->bussiness_name = $collection['bussiness_name'] ? $collection['bussiness_name'] : '';
            $business->category = $collection['category'] ? $collection['category'] : '';
            $business->service_description = $collection['service_description'] ? $collection['service_description'] : '';
            $business->description = $collection['description'] ? $collection['description'] : '';
            $business->email = $collection['email'] ? $collection['email'] : '';
            $business->mobile_no = $collection['mobile_no'] ? $collection['mobile_no'] : '';
            $business->alt_mobile_no = $collection['alt_mobile_no'] ? $collection['alt_mobile_no'] : '';
            $business->facebook_link = $collection['facebook_link'] ? $collection['facebook_link'] : '';
            $business->twitter_link = $collection['twitter_link'] ? $collection['twitter_link'] : '';
            $business->instagram_link = $collection['instagram_link'] ? $collection['instagram_link'] : '';
            $business->linkedin_link = $collection['linkedin_link'] ? $collection['linkedin_link'] : '';
            $business->youtube_link = $collection['youtube_link'] ? $collection['youtube_link'] : '';
            $business->bussiness_address = $collection['bussiness_address'] ? $collection['bussiness_address'] : '';
            $business->monday_opening_hour = $collection['monday_opening_hour'] ? $collection['monday_opening_hour'] : '';
            $business->tuesday_opening_hour = $collection['tuesday_opening_hour'] ? $collection['tuesday_opening_hour'] : '';
            $business->wednesday_opening_hour = $collection['wednesday_opening_hour'] ? $collection['wednesday_opening_hour'] : '';
            $business->thursday_opening_hour = $collection['thursday_opening_hour'] ? $collection['thursday_opening_hour'] : '';
            $business->friday_opening_hour = $collection['friday_opening_hour'] ? $collection['friday_opening_hour'] : '';
            $business->saturday_opening_hour = $collection['saturday_opening_hour'] ? $collection['saturday_opening_hour'] : '';
            $business->sunday_opening_hour = $collection['sunday_opening_hour'] ? $collection['sunday_opening_hour'] : '';
            $business->type = $collection['type'] ? $collection['type'] : '';

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
    public function updateLeadBusiness(array $params)
    {
        $business = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $business->bussiness_name = $collection['bussiness_name'] ? $collection['bussiness_name'] : '';
        $business->category = $collection['category'] ? $collection['category'] : '';
        $business->service_description = $collection['service_description'] ? $collection['service_description'] : '';
        $business->description = $collection['description'] ? $collection['description'] : '';
        $business->email = $collection['email'] ? $collection['email'] : '';
        $business->mobile_no = $collection['mobile_no'] ? $collection['mobile_no'] : '';
        $business->alt_mobile_no = $collection['alt_mobile_no'] ? $collection['alt_mobile_no'] : '';
        $business->facebook_link = $collection['facebook_link'] ? $collection['facebook_link'] : '';
        $business->twitter_link = $collection['twitter_link'] ? $collection['twitter_link'] : '';
        $business->instagram_link = $collection['instagram_link'] ? $collection['instagram_link'] : '';
        $business->linkedin_link = $collection['linkedin_link'] ? $collection['linkedin_link'] : '';
        $business->youtube_link = $collection['youtube_link'] ? $collection['youtube_link'] : '';
        $business->bussiness_address = $collection['bussiness_address'] ? $collection['bussiness_address'] : '';
        $business->monday_opening_hour = $collection['monday_opening_hour'] ? $collection['monday_opening_hour'] : '';
        $business->tuesday_opening_hour = $collection['tuesday_opening_hour'] ? $collection['tuesday_opening_hour'] : '';
        $business->wednesday_opening_hour = $collection['wednesday_opening_hour'] ? $collection['wednesday_opening_hour'] : '';
        $business->thursday_opening_hour = $collection['thursday_opening_hour'] ? $collection['thursday_opening_hour'] : '';
        $business->friday_opening_hour = $collection['friday_opening_hour'] ? $collection['friday_opening_hour'] : '';
        $business->saturday_opening_hour = $collection['saturday_opening_hour'] ? $collection['saturday_opening_hour'] : '';
        $business->sunday_opening_hour = $collection['sunday_opening_hour'] ? $collection['sunday_opening_hour'] : '';
        $business->type = $collection['type'] ? $collection['type'] : '';

        $business->save();

        return $business;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteLeadBusiness($id)
    {
        $business = $this->findOneOrFail($id);
        $business->delete();
        return $business;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateBusinessLeadStatus(array $params){
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
    public function detailsBusinessLead($id)
    {
        $businesses = BusinessLead::where('id',$id)->get();

        return $businesses;
    }


    /**
     * @return mixed
     */
    public function getSearchBussiness(string $term)
    {
        return BusinessLead::where([['bussiness_name', 'LIKE', '%' . $term . '%']])
        ->orWhere('mobile_no', 'LIKE', '%' . $term . '%')
        ->orWhere('email', 'LIKE', '%' . $term . '%')
        ->orWhere('bussiness_address', 'LIKE', '%' . $term . '%')
        ->get();
    }
    // /**
    //  * @param $pinCode
    //  * @return mixed
    //  */
    // public function getBusinessByPinCode($pinCode){
    //     $businesses = Business::with('category')->where('pin',$pinCode)->get();

    //     return $businesses;
    // }

    // /**
    //  * @param $pinCode
    //  * @return mixed
    //  */
    // public function getTrendingBusinessByPinCode($pinCode){
    //     $businesses = Business::with('category')->where('pin',$pinCode)->take(3)->get();

    //     return $businesses;
    // }

    // /**
    //  * @param $pinCode
    //  * @param $categoryId
    //  * @return mixed
    //  */
    // public function getBusinessByCategory($pinCode,$categoryId){
    //     $businesses = Business::with('category')->where('pin',$pinCode)->where('category_id',$categoryId)->get();

    //     return $businesses;
    // }

    // /**
    //  * @param business_id
    //  * @param user_id
    //  * @return Userbusiness|mixed
    //  */
    // public function saveUserBusiness($business_id,$user_id){
    //     $userBusiness = new Userbusiness;
    //     $userBusiness->business_id = $business_id;
    //     $userBusiness->user_id = $user_id;

    //     $userBusiness->save();

    //     return $userBusiness;
    // }

    // /**
    //  * @param business_id
    //  * @param user_id
    //  * @return bool
    //  */
    // public function deleteUserBusiness($business_id,$user_id){
    //     Userbusiness::where("business_id",$business_id)->where("user_id",$user_id)->delete();

    //     return true;
    // }

    // /**
    //  * @param $user_id
    //  * @return mixed
    //  */
    // public function UserBusinesses($user_id){
    //     $UserBusinesses = Userbusiness::with('business')->where('user_id',$user_id)->get();

    //     return $UserBusinesses;
    // }

    // /**
    //  * @param business_id
    //  * @param $user_id
    //  * @return mixed
    //  */
    // public function checkUserBusinesses($business_id, $user_id){
    //     $userBusinesses = Userbusiness::where('business_id',$business_id)->where('user_id',$user_id)->get();

    //     return $userBusinesses;
    // }
    
    
      /**
     * @return mixed
     */
    public function getSearchBussinesscouncil(string $term)
    {
        return BusinessSignupPage::where([['council_name', 'LIKE', '%' . $term . '%']])
        ->orWhere('email', 'LIKE', '%' . $term . '%')
        ->orWhere('contact_no', 'LIKE', '%' . $term . '%')
        ->paginate(25);
    }
}
