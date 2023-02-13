<?php
namespace App\Repositories;

use App\Models\Deal;
use App\Models\Userdeal;
use App\Models\DealReview;
use App\Traits\UploadAble;
use App\Models\State;
use App\Models\DirectoryCategory;
use Illuminate\Http\UploadedFile;
use App\Contracts\DealContract;
use Illuminate\Database\QueryException;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class DealRepository
 *
 * @package \App\Repositories
 */
class DealRepository extends BaseRepository implements DealContract
{
    use UploadAble;

    /**
     * DealRepository constructor.
     * @param Deal $model
     */
    public function __construct(Deal $model)
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
    public function listDeals(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findDealById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Deal|mixed
     */
    public function createDeal(array $params)
    {
        try {

            $collection = collect($params);

            $deal = new Deal;
            $deal->title = $collection['title'] ?? '';
            $deal->slug = slugGenerate($collection['title'], 'deals');
            $deal->created_by = Auth::guard('business')->user()->id;
            $deal->address = $collection['address'] ?? '';
            $deal->state = $collection['state'] ?? '';
            $deal->suburb = $collection['suburb'] ?? '';
            $deal->pin = $collection['pin'] ?? '';
            if(!empty($params['address'])||!empty($params['pin'])||!empty($params['suburb'])||!empty($params['state'])) {
                $deal->full_address = ($collection['address'].', '.$collection['suburb'].', '.$collection['state'].', ' .$collection['pin']) ?? '';
            }
            $deal->expiry_date = $collection['expiry_date'] ?? '';
            $deal->short_description = $collection['short_description'] ?? '';
            $deal->description = $collection['description'] ?? '';
            $deal->category_id = implode(',',$collection['category_id'])?? '';
            //$deal->business_id = $collection['business_id'];
            $deal->price = $collection['price'] ?? '';
            $deal->promo_code = $collection['promo_code'] ?? '';
            $deal->discount_type = $collection['discount_type']?? '';
            $deal->discount_amount = $collection['discount_amount']?? '';
            $deal->how_to_redeem = $collection['how_to_redeem'] ?? '';
            if(!empty($params['image'])){
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $deal->image = $uploadedImage;
            }
            if(!empty($params['image1'])){
                $profile_image = $collection['image1'];
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("uploads/deals/",$imageName);
                $uploadedImage = $imageName;
                $deal->image1 = $uploadedImage;
            }
            if(!empty($params['image2'])){
                $profile_image = $collection['image2'];
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("uploads/deals/",$imageName);
                $uploadedImage = $imageName;
                $deal->image2 = $uploadedImage;
            }
            if(!empty($params['image3'])){
                $profile_image = $collection['image3'];
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("uploads/deals/",$imageName);
                $uploadedImage = $imageName;
                $deal->image3 = $uploadedImage;
            }
            $deal->save();

            return $deal;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
    /** for admin
     * @param array $params
     * @return Deal|mixed
     */
    public function createDealAdmin(array $params)
    {
        try {

            $collection = collect($params);

            $deal = new Deal;
            $deal->title = $collection['title'] ?? '';
            $deal->slug = slugGenerate($collection['title'], 'deals');
            
            $deal->address = $collection['address'] ?? '';
            $deal->state = $collection['state'] ?? '';
            $deal->suburb = $collection['suburb'] ?? '';
            $deal->pin = $collection['pin'] ?? '';
            if(!empty($params['address'])||!empty($params['pin'])||!empty($params['suburb'])||!empty($params['state'])) {
                $deal->full_address = ($collection['address'].', '.$collection['suburb'].', '.$collection['state'].', ' .$collection['pin']) ?? '';
            }
            $deal->expiry_date = $collection['expiry_date'] ?? '';
            $deal->short_description = $collection['short_description'] ?? '';
            $deal->description = $collection['description'] ?? '';
            $deal->category_id = implode(',',$collection['category_id'])?? '';
            $deal->directory_id = implode(',',$collection['directory_id'])?? '';
            //$deal->business_id = $collection['business_id'];
            $deal->price = $collection['price'] ?? '';
            $deal->promo_code = $collection['promo_code'] ?? '';
            $deal->discount_type = $collection['discount_type']?? '';
            $deal->discount_amount = $collection['discount_amount']?? '';
            $deal->how_to_redeem = $collection['how_to_redeem'] ?? '';
            if(!empty($params['image'])){
            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $deal->image = $uploadedImage;
            }
            if(!empty($params['image1'])){
                $profile_image = $collection['image1'];
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("uploads/deals/",$imageName);
                $uploadedImage = $imageName;
                $deal->image1 = $uploadedImage;
            }
            if(!empty($params['image2'])){
                $profile_image = $collection['image2'];
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("uploads/deals/",$imageName);
                $uploadedImage = $imageName;
                $deal->image2 = $uploadedImage;
            }
            if(!empty($params['image3'])){
                $profile_image = $collection['image3'];
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("uploads/deals/",$imageName);
                $uploadedImage = $imageName;
                $deal->image3 = $uploadedImage;
            }
            $deal->save();

            return $deal;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDeal(array $params)
    {
        $deal = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $deal->title = $collection['title']?? '';
        if($deal->title != $collection['title']) {
            $deal->slug = slugGenerate($collection['title'], 'deals');
            }
        $deal->created_by = Auth::guard('business')->user()->id;
        $deal->address = $collection['address']?? '';
        $deal->state = $collection['state'] ?? '';
        $deal->suburb = $collection['suburb'] ?? '' ;
        $deal->pin = $collection['pin'] ?? '';
        if(!empty($collection['suburb'])) {
            $deal->full_address = ($collection['address'].', '.$collection['suburb'].', '.$collection['state'].', ' .$collection['pin']) ?? '';
        }
        else{
            $deal->full_address = $deal->full_address; 
        }
        $deal->expiry_date = $collection['expiry_date'] ?? '';
        $deal->short_description = $collection['short_description'] ?? '';
        $deal->description = $collection['description']?? '';
        if(!empty($params['category_id'])) {
            $deal->category_id = implode(',',$collection['category_id'])?? '';
        }
        //$deal->business_id = $collection['business_id']?? '';
        $deal->price = $collection['price']?? '';
        $deal->promo_code = $collection['promo_code']?? '';
        $deal->discount_type = $collection['discount_type']?? '';
        $deal->discount_amount = $collection['discount_amount']?? '';
        $deal->how_to_redeem = $collection['how_to_redeem']?? '';
        if(!empty($params['image'])) {
            $profile_image = $collection['image'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $event->image = $uploadedImage;
        }
        if(!empty($params['image1'])){
            $profile_image = $collection['image1'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $deal->image1 = $uploadedImage;
        }
        if(!empty($params['image2'])){
            $profile_image = $collection['image2'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $deal->image2 = $uploadedImage;
        }
        if(!empty($params['image3'])){
            $profile_image = $collection['image3'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $deal->image3 = $uploadedImage;
        }
        $deal->save();

        return $deal;
    }

    /** for admin
     * @param array $params
     * @return mixed
     */
    public function updateDealAdmin(array $params)
    {
        $deal = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $deal->title = $collection['title']?? '';
        if($deal->title != $collection['title']) {
            $deal->slug = slugGenerate($collection['title'], 'deals');
            }
       
        $deal->address = $collection['address']?? '';
        $deal->state = $collection['state'] ?? '';
        $deal->suburb =  $collection['suburb'] ?? '' ;
        $deal->pin = $collection['pin'] ?? '';
        if(!empty($collection['suburb'])) {
            $deal->full_address = ($collection['address'].', '.$collection['suburb'].', '.$collection['state'].', ' .$collection['pin']) ?? '';
        }
        else{
            $deal->full_address = $deal->full_address; 
        }
        $deal->expiry_date = $collection['expiry_date'] ?? '';
        $deal->short_description = $collection['short_description'] ?? '';
        $deal->description = $collection['description']?? '';
        if(!empty($params['category_id'])) {
            $deal->category_id = implode(',',$collection['category_id'])?? '';
        }
        if(!empty($params['directory_id'])) {
        $deal->directory_id = implode(',',$collection['directory_id'])?? '';
        }
        //$deal->business_id = $collection['business_id']?? '';
        $deal->price = $collection['price']?? '';
        $deal->promo_code = $collection['promo_code']?? '';
        $deal->discount_type = $collection['discount_type']?? '';
        $deal->discount_amount = $collection['discount_amount']?? '';
        $deal->how_to_redeem = $collection['how_to_redeem']?? '';
        if(!empty($params['image'])) {
            $profile_image = $collection['image'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $event->image = $uploadedImage;
        }
        if(!empty($params['image1'])){
            $profile_image = $collection['image1'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $deal->image1 = $uploadedImage;
        }
        if(!empty($params['image2'])){
            $profile_image = $collection['image2'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $deal->image2 = $uploadedImage;
        }
        if(!empty($params['image3'])){
            $profile_image = $collection['image3'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("uploads/deals/",$imageName);
            $uploadedImage = $imageName;
            $deal->image3 = $uploadedImage;
        }
        $deal->save();

        return $deal;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteDeal($id)
    {
        $deal = $this->findOneOrFail($id);
        $deal->delete();
        return $deal;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDealStatus(array $params){
        $deal = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $deal->status = $collection['check_status'];
        $deal->save();

        return $deal;
    }

     /**
     * @param $id
     * @return mixed
     */
    public function detailsDeal($id)
    {
        $deals = Deal::with('category','business')->where('id',$id)->get();

        return $deals;
    }

    /**
     * @param $businessId
     * @return mixed
     */
    public function getDealsByBusiness($businessId){
        $events = Deal::with('category')->where('business_id',$businessId)->get();

        return $events;
    }

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getDealsByPinCode($pinCode){
        $deals = Deal::with('category')->where('pin',$pinCode)->get();

        return $deals;
    }

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getTrendingDealsByPinCode($pinCode){
        $deals = Deal::with('category')->where('pin',$pinCode)->take(5)->get();

        return $deals;
    }

    /**
     * @param $pinCode
     * @param $categoryId
     * @param $keyword
     * @return mixed
     */
    public function searchDealsData($pinCode,$categoryId,$keyword){
        $deals = Deal::with('category')->where('status','=',1)
                        ->when($pinCode, function($query) use ($pinCode){
                            $query->where('pin', '=', $pinCode);
                        })
                        ->when($categoryId!='', function($query) use ($categoryId){
                            $query->where('category_id', '=', $categoryId);
                        })
                        ->when($keyword, function($query) use ($keyword){
                            $query->where('title', 'like', '%' . $keyword .'%');
                        })
                        ->paginate(25);

        return $deals;
    }

    /**
     * @param $pinCode
     * @param $categoryId
     * @return mixed
     */
    public function getDealsByCategory($pinCode,$categoryId){
        $deals = Deal::with('category')->where('pin',$pinCode)->where('category_id',$categoryId)->get();

        return $deals;
    }

    /**
     * @param $pinCode
     * @param $id
     * @return mixed
     */
    public function getRelatedDeals($pinCode,$id){
        $deals = Deal::with('category')->where('pin',$pinCode)->where('id','!=',$id)->get();

        return $deals;
    }

    /**
     * @param deal_id
     * @param user_id
     * @return Userdeal|mixed
     */
    public function saveUserDeal($deal_id,$user_id){
        $userDeal = new Userdeal;
        $userDeal->deal_id = $deal_id;
        $userDeal->user_id = $user_id;

        $userDeal->save();

        return $userDeal;
    }

    /**
     * @param deal_id
     * @param user_id
     * @return bool
     */
    public function deleteUserDeal($deal_id,$user_id){
        Userdeal::where("deal_id",$deal_id)->where("user_id",$user_id)->delete();

        return true;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function userDeals($user_id){
        $userDeals = Userdeal::with('deal')->where('user_id',$user_id)->get();

        return $userDeals;
    }

    /**
     * @param deal_id
     * @param $user_id
     * @return mixed
     */
    public function checkUserDeals($deal_id, $user_id){
        $userDeals = Userdeal::where('deal_id',$deal_id)->where('user_id',$user_id)->get();

        return $userDeals;
    }

    /**
     * @param $pinCode
     * @param $categoryId
     * @param $keyword
     * @param $expiryDate
     * @param $minPrice
     * @param $maxPrice
     * @return mixed
     */
    public function filterDealsData($pinCode,$categoryId,$keyword,$expiryDate,$minPrice,$maxPrice){
        $deals = Deal::with('category')->where('status','=',1)
                        ->when($pinCode, function($query) use ($pinCode){
                            $query->where('pin', '=', $pinCode);
                        })
                        ->when($categoryId!='', function($query) use ($categoryId){
                            $query->where('category_id', '=', $categoryId);
                        })
                        ->when($keyword, function($query) use ($keyword){
                            $query->where('title', 'like', '%' . $keyword .'%');
                        })
                        ->when($expiryDate!='', function($query) use ($expiryDate){
                            $query->where('expiry_date', '>=', $expiryDate);
                        })
                        ->when($minPrice!='', function($query) use ($minPrice){
                            $query->where('price', '>=', $minPrice);
                        })
                        ->when($maxPrice!='', function($query) use ($maxPrice){
                            $query->where('price', '<=', $maxPrice);
                        })
                        ->get();

        return $deals;
    }
    public function listCategories()
    {
        $cat = DirectoryCategory::where('status',1)->where('type',1)->orderby('parent_category')->get();
        
        return $cat;
    }
    //deal review add 
    public function dealReview(array $params)
    {
        try {

            $collection = collect($params);

            $item = new DealReview;
            $item->user_id = Auth::guard('user')->user()->id ?? '';
            $item->name = $collection['name'];
            $item->deal_id = $collection['deal_id'];
            $item->email = $collection['email'];
            $item->rating = $collection['rating'];
            $item->comment = $collection['comment'];
            $item->save();

            return $item;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

     /**
     * @return mixed
     */
    public function getSearchDeal(string $term)
    {
        return Deal::where([['title', 'LIKE', '%' . $term . '%']])
            ->orWhere('full_address', 'LIKE', '%' . $term . '%')
            ->orWhere('pin', 'LIKE', '%' . $term . '%')
            ->orWhere('suburb', 'LIKE', '%' . $term . '%')
            ->paginate(25);
    }
}
