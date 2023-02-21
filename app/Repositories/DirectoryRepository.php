<?php
namespace App\Repositories;

use App\Models\Directory;
use App\Models\Review;
use App\Models\CollectionDirectory;
use App\Models\Suburb;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Contracts\DirectoryContract;
use App\Models\DirectoryCategory;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
/**
 * Class DirectoryRepository
 *
 * @package \App\Repositories
 */
class DirectoryRepository extends BaseRepository implements DirectoryContract
{
    use UploadAble;

    /**
     * BlogCategoryRepository constructor.
     * @param Directory $model
     */
    public function __construct(Directory $model)
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
    public function listDirectory(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findDirectoryById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return State|mixed
     */
    public function createDirectory(array $params)
    {
        try {
            $collection = collect($params);
            $dir = new Directory;
            $dir->name = $collection['name'];
            $dir->email = $collection['email'];
            $dir->password = $collection['password'];
            $dir->mobile = $collection['mobile'];
            $dir->category_id = $collection['category_id'];
            $dir->address = $collection['address'];
            $dir->pin = $collection['pin'];
            $dir->lat = $collection['lat'];
            $dir->lon = $collection['lon'];
            $dir->description = $collection['description'];
            $dir->service_description = $collection['service_description'];
            $dir->opening_hour = $collection['opening_hour'];
            $dir->website = $collection['website'];
            $dir->facebook_link = $collection['facebook_link'];
            $dir->twitter_link = $collection['twitter_link'];
            $dir->instagram_link = $collection['instagram_link'];
            $dir->establish_year = $collection['establish_year'];
            $dir->ABN = $collection['ABN'];
            $dir->monday = $collection['monday'];
            $dir->tuesday = $collection['tuesday'];
            $dir->wednesday = $collection['wednesday'];
            $dir->thursday = $collection['thursday'];
            $dir->friday = $collection['friday'];
            $dir->saturday = $collection['saturday'];
            $dir->sunday = $collection['sunday'];
            $dir->public_holiday = $collection['public_holiday	'];
            $dir->category_tree = $collection['category_tree'];

                $slug = Str::slug($collection['name'], '-');
                $slugExistCount = Directory::where('slug', $slug)->count();
                if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
                $dir->slug = $slug;


            $profile_image = $collection['image'];
            $imageName = time().".".$profile_image->getClientOriginalName();
            $profile_image->move("Directory/",$imageName);
            $uploadedImage = $imageName;
            $dir->image = $uploadedImage;
            $dir->save();
            return $dir;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDirectory(array $params)
    {
            $dir = $this->findOneOrFail($params['id']);
            $collection = collect($params)->except('_token');
            $dir->name = $collection['name'];
            $dir->email = $collection['email'];
            // $dir->password = $collection['password'];
            $dir->mobile = $collection['mobile'];
            // $dir->category_id = $collection['category_id'];
            $dir->address = $collection['address'];
            $dir->pin = $collection['pin'];
            $dir->lat = $collection['lat'];
            $dir->lon = $collection['lon'];
            $dir->description = $collection['description'];
            $dir->service_description = $collection['service_description'];
            $dir->opening_hour = $collection['opening_hour'];
            $dir->website = $collection['website'];
            $dir->facebook_link = $collection['facebook_link'];
            $dir->twitter_link = $collection['twitter_link'];
            $dir->instagram_link = $collection['instagram_link'];
            $dir->establish_year = $collection['establish_year'];
            $dir->ABN = $collection['ABN'];
            $dir->monday = $collection['monday'];
            $dir->tuesday = $collection['tuesday'];
            $dir->wednesday = $collection['wednesday'];
            $dir->thursday = $collection['thursday'];
            $dir->friday = $collection['friday'];
            $dir->saturday = $collection['saturday'];
            $dir->sunday = $collection['sunday'];
            //$dir->public_holiday = $collection['public_holiday	'];
            $dir->category_tree = $collection['category_tree'];
            if($dir->name != $collection['name']) {
                $slug = Str::slug($collection['name'], '-');
                $slugExistCount = Directory::where('slug', $slug)->count();
                if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
                $dir->slug = $slug;
            }

            if (!empty($collection['image'])) {
                $profile_image = $collection['image'];
                $imageName = time().".".$profile_image->getClientOriginalName();
                $profile_image->move("Directory/",$imageName);
                $uploadedImage = $imageName;
                $dir->image = $uploadedImage;
            }

            $dir->save();
            return $dir;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteDirectory($id)
    {
        $state = $this->findOneOrFail($id);
        $state->delete();
        return $state;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateDirectoryStatus(array $params){
        $state = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $state->status = $collection['check_status'];
        $state->save();

        return $state;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsDirectory($id)
    {
        $categories = Directory::where('id',$id)->get();

        return $categories;
    }



       /**
     * @return mixed
     */
    public function getDirectorycategories(){
          $categories = DB::select("SELECT * from directory_categories
          WHERE `type` = 0 AND
          child_category IS NOT NULL
          GROUP BY child_category
          ORDER BY child_category");
        //$categories = DirectoryCategory::where('type',0)->where('child_category','!=','NULL')->orderBy('child_category')->groupBy('child_category')->get();
        // dd($categories[1]);

        return $categories;
    }
        public function latestdirectory(){
            $blogs = Directory::orderBy('created_at','asc')->take(4)->get();

            return $blogs;
        }


    /**
     *
     * @param $categoryId
     * @param $keyword
     * @return mixed
     */
    public function searchDirectoryData($categoryId,$name,$keyword,$establish_year,$opening_hour, $sort){
        // dd($sort);
        if($sort=="time_asc") {$filterName = "id";$sortOrder = "asc";}
        elseif($sort=="time_desc") {$filterName = "id";$sortOrder = "desc";}
        else {$filterName = "id";$sortOrder = "asc";}

        $blogs = Directory::
        when($categoryId!='', function($query) use ($categoryId){
            $query->where('category_id', 'like',  $categoryId .',%');
        })
        ->when($name, function($query) use ($name){
            $query->where('name', 'like', '%' . $name .'%');
        })
        ->when($keyword, function($query) use ($keyword){
            $query->where('address', 'LIKE', '%' . $keyword . '%');
        })
        ->when($establish_year, function($query) use ($establish_year){
            $query->where('establish_year', 'like', '%' . $establish_year .'%');
        })
        ->when($opening_hour, function($query) use ($opening_hour){
            $query
            ->where('monday', 'like', '%' . $opening_hour .'%')
            ->orWhere('tuesday', 'like', '%' . $opening_hour .'%')
          ->orWhere('wednesday', 'like', '%' . $opening_hour .'%')
            ->orWhere('thursday', 'like', '%' . $opening_hour .'%')
          ->orWhere('friday', 'like', '%' . $opening_hour .'%')
            ->orWhere('saturday', 'like', '%' . $opening_hour .'%')
            ->orWhere('sunday', 'like', '%' . $opening_hour .'%')
            ->orWhere('public_holiday', 'like', '%' . $opening_hour .'%');
        })
        ->orderBy($filterName, $sortOrder)
        ->paginate(15)
        ->appends(request()->query());
         //dd($blogs);
        return $blogs;
    }



        public function searchDirectorybyData($categoryId,$keyword,$name,$establish_year,$opening_hour, $sort){
        // dd($sort);
        if($sort=="time_asc") {$filterName = "id";$sortOrder = "asc";}
        elseif($sort=="time_desc") {$filterName = "id";$sortOrder = "desc";}
        else {$filterName = "id";$sortOrder = "asc";}

        $blogs = Directory::
        when($categoryId, function($query) use ($categoryId){
            $query->where('category_tree', 'LIKE',  $categoryId .'%');
        })
        ->when($name, function($query) use ($name){
            $query->where('name', 'LIKE', '%' . $name .'%');
        })
        ->when($keyword, function($query) use ($keyword){
            $query->where('address', 'LIKE', '%' . $keyword);
        })

        ->when($establish_year, function($query) use ($establish_year){
            $query->where('establish_year', 'LIKE', '%' . $establish_year .'%');
        })
        ->when($opening_hour, function($query) use ($opening_hour){
            $query
            ->where('monday', 'like', '%' . $opening_hour .'%')
            ->orWhere('tuesday', 'like', '%' . $opening_hour .'%')
          ->orWhere('wednesday', 'like', '%' . $opening_hour .'%')
            ->orWhere('thursday', 'like', '%' . $opening_hour .'%')
          ->orWhere('friday', 'like', '%' . $opening_hour .'%')
            ->orWhere('saturday', 'like', '%' . $opening_hour .'%')
            ->orWhere('sunday', 'like', '%' . $opening_hour .'%')
            ->orWhere('public_holiday', 'like', '%' . $opening_hour .'%');
        })
        ->orderBy($filterName, $sortOrder)
        ->paginate(15)
        ->appends(request()->query());
         //dd($blogs);
        return $blogs;
    }



    /**
     *
     * @param $categoryId
     * @param $keyword
     * @return mixed
     */
    public function searchDirectoryDatabyPostcode($categoryId,$keyword,$suburb){
        // dd($sort);

        $blogs = Directory::
        when($categoryId!='', function($query) use ($categoryId){
            $query->where('category_id', 'like',  $categoryId .',%');
        })
        ->when($keyword, function($query) use ($keyword){
            $query->where('name', 'like', '%' . $keyword .'%');
        })
         ->when($suburb, function($query) use ($suburb){
            $query->where('address', 'like', '%'  . $suburb .'%');
        })
        ->paginate(9)
        ->appends(request()->query());
         //dd($blogs);
        return $blogs;
    }

    /**
     *
     * @param $categoryId
     * @param $keyword
     * @return mixed
     */
    public function searchDirectoryDatabyPostcodeData($categoryId,$keyword){
        // dd($sort);

        $blogs = Directory::
        when($categoryId!='', function($query) use ($categoryId){
            $query->where('category_id', 'like','%' . $categoryId .'%');
        })
        ->when($keyword, function($query) use ($keyword){
            $query->where('name', 'like', '%' . $keyword .'%');
        })
        ->paginate(9)
        ->appends(request()->query());
         //dd($blogs);
        return $blogs;
    }
    public function searchDirectorybypincode(Request $request){
       $blogs=Directory::where('address', 'LIKE', $request->address);
        return $blogs;
    }
     /**
     * @param $pinCode
     * @return mixed
     */
    public function getDirectoryByPinCode($pinCode){
        $dir=Directory::where('address', 'LIKE', '%' . $pinCode . '%')->paginate(30);
        return $dir;
        //dd($dir);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsBusiness($id)
    {
        $businesses = Directory::where('id',$id)->get();

        return $businesses;
    }
     /**
     * @param $collectionId
     * @return mixed
     */
    public function directorywisecollection($collectionId){

        $blogs = CollectionDirectory::where('collection_id',$collectionId)->with('directory')->paginate(15);


        return $blogs;
    }

     /**
     * This method is for search directory
     * @param
     *
     */
    public function Directorysearch(array $data)
    {
        $collectedData = collect($data);

        $resp = Directory::where('pin', 'like', '%'.$collectedData['query'].'%')->get();

        return $resp;
    }



    /**
     * @return mixed
     */
    public function getSearchDirectory(string $term)
    {
        return Directory::where([['name', 'LIKE', '%' . $term . '%']])
        ->orWhere('category_id', 'LIKE', '%' . $term . '%')
        ->orWhere('address', 'LIKE', '%' . $term . '%')
        ->orWhere('email', 'LIKE', '%' . $term . '%')
        ->paginate(20);
    }


    public function addReview(array $data){
        $collectedData = collect($data);

        $wishlistExists = Review::where('directory_id', $collectedData['directory_id'])->first();

        if ($wishlistExists) {
            $newEntry = Review::destroy($wishlistExists->id);
            return "removed";
        } else {
            $newEntry = new Review;

            $newEntry->name = $collectedData['name'];
            $newEntry->directory_id = $collectedData['directory_id'];
            $newEntry->email = $collectedData['email'];
            $newEntry->rating = $collectedData['rating'];
            $newEntry->comment = $collectedData['comment'];

            $newEntry->save();
            return "ReviewAdded";
        }

    }


    public function showreview($id){
        return Review::where('directory_id', $id)->get();
      }


         //directory review add
    public function directoryReview(array $params)
    {
        try {

            $collection = collect($params);

            $item = new Review;
            $item->user_id = !empty(Auth::guard('user')->user()->id) ? Auth::guard('user')->user()->id : '';
            $item->author_name = $collection['author_name'];
            $item->directory_id = $collection['directory_id'];
            $item->rating = $collection['rating'];
            $item->text = $collection['text'];
            $item->save();

            return $item;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    }



