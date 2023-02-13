<?php
namespace App\Repositories;

use App\Models\Event;
use App\Models\Userevent;
use App\Models\DirectoryCategory;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\EventContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Auth;
/**
 * Class EventRepository
 *
 * @package \App\Repositories
 */
class EventRepository extends BaseRepository implements EventContract
{
    use UploadAble;

    /**
     * EventRepository constructor.
     * @param Event $model
     */
    public function __construct(Event $model)
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
    public function listEvents(string $order = 'id', string $sort = 'asc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findEventById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Event|mixed
     */
    public function createEvent(array $params)
    {
        try {
            $collection = collect($params);
            $event = new Event;
            $event->created_by = Auth::guard('eventorganiser')->user()->id;
            $event->category_id = implode(',',$collection['category_id'])?? '';
            $event->directory_id = implode(',',$collection['directory_id']) ?? '';
            $event->title = $collection['title']?? '';
            $event->slug = slugGenerate($collection['title'], 'events');
            $event->description = $collection['description']?? '';
            $event->short_description = $collection['short_description']?? '';
            if($params['host'] == 'Other'){
                $event->host = $collection['other_host_name'] ?? '';
            }
            else{
                $event->host = $collection['host'] ?? '';
            }
            $event->type = $collection['type'] ?? '';
            $event->link = $collection['link'] ?? '';
            $event->address = $collection['address']?? '';
            if(!empty($params['pin'])) {
            $event->pin = $collection['pin']?? '';
            }
            if(!empty($params['suburb'])) {
            $event->suburb = $collection['suburb']?? '';
            }
            if(!empty($params['state'])) {
            $event->state = $collection['state']?? '';
            }
            if(!empty($params['address'])||!empty($params['pin'])||!empty($params['suburb'])||!empty($params['state'])) {
            $event->full_address = ($collection['address'].', '.$collection['suburb'].', '.$collection['state'].', ' .$collection['pin']) ?? '';
            }
            $event->lat = $collection['lat']?? '';
            $event->lon = $collection['lon']?? '';
            $event->start_date = $collection['start_date']?? '';
            $event->end_date = $collection['end_date']?? '';
            $event->start_time = $collection['start_time']?? '';
            $event->end_time = $collection['end_time']?? '';
            $event->contact_email = $collection['contact_email']?? '';
            $event->contact_phone = $collection['contact_phone']?? '';
            $event->website = $collection['website']?? '';
            $event->is_paid = $collection['is_paid']?? '';
            $event->price = $collection['price']?? '';
            $event->is_recurring = $collection['is_recurring']?? '';
            $event->recurring = $collection['recurring'] ?? '';
            $event->no_of_followers = 0;
            if(!empty($params['image'])) {
                $profile_image = $collection['image'] ?? '';
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("uploads/events/",$imageName);
                $uploadedImage = $imageName;
                $event->image = $uploadedImage;
            }
            if(!empty($params['image1'])) {
                $profile_image = $collection['image1'] ?? '';
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("uploads/events/",$imageName);
                $uploadedImage = $imageName;
                $event->image1 = $uploadedImage;
            }
            if(!empty($params['image2'])) {
                $profile_image = $collection['image2'] ?? '';
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("uploads/events/",$imageName);
                $uploadedImage = $imageName;
                $event->image2 = $uploadedImage;
            }
            if(!empty($params['image3'])) {
                $profile_image = $collection['image3'] ?? '';
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("uploads/events/",$imageName);
                $uploadedImage = $imageName;
                $event->image3 = $uploadedImage;
            }
            $event->save();
            //dd($event);
           
            return $event;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
    //create event for business
    /**
     * @param array $params
     * @return Event|mixed
     */
    public function createBusinessEvent(array $params)
    {
        try {
            $collection = collect($params);
            $event = new Event;
            $event->created_by = Auth::guard('business')->user()->id;
            $event->category_id = implode(',',$collection['category_id'])?? '';
            $event->directory_id = Auth::guard('business')->user()->id ?? '';
            $event->title = $collection['title']?? '';
            $event->slug = slugGenerate($collection['title'], 'events');
            $event->description = $collection['description']?? '';
            $event->short_description = $collection['short_description']?? '';
            if($params['host'] == 'Other'){
                $event->host = $collection['other_host_name'] ?? '';
            }
            else{
                $event->host = $collection['host'] ?? '';
            }
            $event->type = $collection['type'] ?? '';
            $event->link = $collection['link'] ?? '';
            $event->address = $collection['address']?? '';
            if(!empty($params['pin'])) {
            $event->pin = $collection['pin']?? '';
            }
            if(!empty($params['suburb'])) {
            $event->suburb = $collection['suburb']?? '';
            }
            if(!empty($params['state'])) {
            $event->state = $collection['state']?? '';
            }
            if(!empty($params['address'])||!empty($params['pin'])||!empty($params['suburb'])||!empty($params['state'])) {
            $event->full_address = ($collection['address'].', '.$collection['suburb'].', '.$collection['state'].', ' .$collection['pin']) ?? '';
            }
            $event->lat = $collection['lat']?? '';
            $event->lon = $collection['lon']?? '';
            $event->start_date = $collection['start_date']?? '';
            $event->end_date = $collection['end_date']?? '';
            $event->start_time = $collection['start_time']?? '';
            $event->end_time = $collection['end_time']?? '';
            $event->contact_email = $collection['contact_email']?? '';
            $event->contact_phone = $collection['contact_phone']?? '';
            $event->website = $collection['website']?? '';
            $event->is_paid = $collection['is_paid']?? '';
            $event->price = $collection['price']?? '';
            $event->is_recurring = $collection['is_recurring']?? '';
            $event->recurring = $collection['recurring'] ?? '';
            $event->no_of_followers = 0;
            if(!empty($params['image'])) {
                $profile_image = $collection['image'] ?? '';
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("uploads/events/",$imageName);
                $uploadedImage = $imageName;
                $event->image = $uploadedImage;
            }
            if(!empty($params['image1'])) {
                $profile_image = $collection['image1'] ?? '';
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("uploads/events/",$imageName);
                $uploadedImage = $imageName;
                $event->image1 = $uploadedImage;
            }
            if(!empty($params['image2'])) {
                $profile_image = $collection['image2'] ?? '';
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("uploads/events/",$imageName);
                $uploadedImage = $imageName;
                $event->image2 = $uploadedImage;
            }
            if(!empty($params['image3'])) {
                $profile_image = $collection['image3'] ?? '';
                $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
                $profile_image->move("uploads/events/",$imageName);
                $uploadedImage = $imageName;
                $event->image3 = $uploadedImage;
            }
            $event->save();
            //dd($event);
           
            return $event;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
    /**
     * @param array $params
     * @return mixed
     */
    public function updateEvent(array $params)
    {
        $event = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 
        $event->created_by = Auth::guard('eventorganiser')->user()->id;
        if(!empty($params['category_id'])) {
            $event->category_id = implode(',',$collection['category_id'])?? '';
        }
        if(!empty($params['directory_id'])) {
            $event->directory_id = implode(',',$collection['directory_id']) ?? '';
        }
        $event->title = $collection['title']?? '';
        if($event->title != $collection['title']) {
        $event->slug = slugGenerate($collection['title'], 'events');
        }
        $event->description = $collection['description']?? '';
        $event->short_description = $collection['short_description']?? '';
        if($params['host'] == 'Other'){
            $event->host = $collection['other_host_name'] ?? '';
        }
        else{
            $event->host = $collection['host'] ?? '';
        }
        $event->type = $collection['type'] ?? '';
        if($params['type'] == 'online'){
            $event->link = $collection['link'] ?? '';
        }
        else{
            $event->address = $collection['address']?? '';
            if(!empty($params['pin'])) {
                $event->pin = $collection['pin']?? '';
            }
            if(!empty($params['suburb'])) {
            $event->suburb = $collection['suburb']?? '';
            }
            $event->state = $collection['state']?? '';
            if(!empty($params['suburb'])) {
                $event->full_address = ($collection['address'].', '.$collection['suburb'].', '.$collection['state'].', ' .$collection['pin']) ?? '';
            }
           
        }
        $event->lat = $collection['lat']?? '';
        $event->lon = $collection['lon']?? '';
        $event->start_date = $collection['start_date']?? '';
        $event->end_date = $collection['end_date']?? '';
        $event->start_time = $collection['start_time']?? '';
        $event->end_time = $collection['end_time']?? '';
        $event->contact_email = $collection['contact_email']?? '';
        $event->contact_phone = $collection['contact_phone']?? '';
        $event->website = $collection['website']?? '';
        $event->is_paid = $collection['is_paid']?? '';
        if($params['is_paid'] == 0){
            $event->price = '';
        }
        else{
            $event->price = $collection['price'] ?? '';
        }
        $event->is_recurring = $collection['is_recurring']?? '';
        if($params['is_recurring'] == 0){
            $event->recurring = '';
        }
        else{
            $event->recurring = $collection['price'] ?? '';
        }
        $event->no_of_followers = 0;
        if(!empty($params['image'])) {
            $profile_image = $collection['image'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/events/",$imageName);
            $uploadedImage = $imageName;
            $event->image = $uploadedImage;
        }
        if(!empty($params['image1'])) {
            $profile_image = $collection['image1'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/events/",$imageName);
            $uploadedImage = $imageName;
            $event->image1 = $uploadedImage;
        }
        if(!empty($params['image2'])) {
            $profile_image = $collection['image2'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/events/",$imageName);
            $uploadedImage = $imageName;
            $event->image2 = $uploadedImage;
        }
        if(!empty($params['image3'])) {
            $profile_image = $collection['image3'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/events/",$imageName);
            $uploadedImage = $imageName;
            $event->image3 = $uploadedImage;
        }
        $event->save();
        return $event;
    }
    //update event for business
     /**
     * @param array $params
     * @return mixed
     */
    public function updateBusinessEvent(array $params)
    {
        $event = $this->findOneOrFail($params['id']); 
        $collection = collect($params)->except('_token'); 
        $event->created_by = Auth::guard('business')->user()->id;
        if(!empty($params['category_id'])) {
            $event->category_id = implode(',',$collection['category_id'])?? '';
        }
        if(!empty($params['directory_id'])) {
            $event->directory_id = Auth::guard('business')->user()->id ?? '';
        }
        $event->title = $collection['title']?? '';
        if($event->title != $collection['title']) {
        $event->slug = slugGenerate($collection['title'], 'events');
        }
        $event->description = $collection['description']?? '';
        $event->short_description = $collection['short_description']?? '';
        if($params['host'] == 'Other'){
            $event->host = $collection['other_host_name'] ?? '';
        }
        else{
            $event->host = $collection['host'] ?? '';
        }
        $event->type = $collection['type'] ?? '';
        if($params['type'] == 'online'){
            $event->link = $collection['link'] ?? '';
        }
        else{
            $event->address = $collection['address']?? '';
            if(!empty($params['pin'])) {
                $event->pin = $collection['pin']?? '';
            }
            if(!empty($params['suburb'])) {
            $event->suburb = $collection['suburb']?? '';
            }
            $event->state = $collection['state']?? '';
            if(!empty($params['suburb'])) {
                $event->full_address = ($collection['address'].', '.$collection['suburb'].', '.$collection['state'].', ' .$collection['pin']) ?? '';
            }
           
        }
        $event->lat = $collection['lat']?? '';
        $event->lon = $collection['lon']?? '';
        $event->start_date = $collection['start_date']?? '';
        $event->end_date = $collection['end_date']?? '';
        $event->start_time = $collection['start_time']?? '';
        $event->end_time = $collection['end_time']?? '';
        $event->contact_email = $collection['contact_email']?? '';
        $event->contact_phone = $collection['contact_phone']?? '';
        $event->website = $collection['website']?? '';
        $event->is_paid = $collection['is_paid']?? '';
        if($params['is_paid'] == 0){
            $event->price = '';
        }
        else{
            $event->price = $collection['price'] ?? '';
        }
        $event->is_recurring = $collection['is_recurring']?? '';
        if($params['is_recurring'] == 0){
            $event->recurring = '';
        }
        else{
            $event->recurring = $collection['price'] ?? '';
        }
        $event->no_of_followers = 0;
        if(!empty($params['image'])) {
            $profile_image = $collection['image'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/events/",$imageName);
            $uploadedImage = $imageName;
            $event->image = $uploadedImage;
        }
        if(!empty($params['image1'])) {
            $profile_image = $collection['image1'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/events/",$imageName);
            $uploadedImage = $imageName;
            $event->image1 = $uploadedImage;
        }
        if(!empty($params['image2'])) {
            $profile_image = $collection['image2'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/events/",$imageName);
            $uploadedImage = $imageName;
            $event->image2 = $uploadedImage;
        }
        if(!empty($params['image3'])) {
            $profile_image = $collection['image3'] ?? '';
            $imageName = mt_rand().'-'.time().".".$profile_image->getClientOriginalExtension();
            $profile_image->move("uploads/events/",$imageName);
            $uploadedImage = $imageName;
            $event->image3 = $uploadedImage;
        }
        $event->save();
        return $event;
    }
    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteEvent($id)
    {
        $event = $this->findOneOrFail($id);
        $event->delete();
        return $event;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateEventStatus(array $params){
        $event = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $event->status = $collection['check_status'];
        $event->save();

        return $event;
    }

     /**
     * @param $id
     * @return mixed
     */
    public function detailsEvent($id)
    {
        $events = Event::with('category')->where('id',$id)->get();
        
        return $events;
    }
    /* event category */
     /* @param $id
      * @return mixed
      */
    public function listCategories()
    {
        $cat = DirectoryCategory::where('status',1)->where('type',1)->orderby('parent_category')->get();
        
        return $cat;
    }
    /**
     * @param $businessId
     * @return mixed
     */
    public function getEventsByBusiness($businessId){
        $events = Event::with('category')->where('business_id',$businessId)->get();
        
        return $events;
    }

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getEventsByPinCode($pinCode){
        $events = Event::with('category')->where('pin',$pinCode)->get();
        
        return $events;
    }

    /**
     * @param $pinCode
     * @return mixed
     */
    public function getTrendingEventsByPinCode($pinCode){
        $events = Event::with('category')->where('pin',$pinCode)->take(3)->get();
        
        return $events;
    }

    /**
     * @param $pinCode
     * @param $categoryId
     * @param $keyword
     * @return mixed
     */
    public function searchEventsData($category,$from,$to,$keyword){
        $event = Event::with('category')->where('created_by',Auth::guard('eventorganiser')->user()->id)->where('status','=',1)
                        
                        ->when($category, function($query) use ($category){
                            $query->where('category_id', '=', $category);
                        })
                        ->when($from, function($query) use ($from){
                            $query->where('start_date', 'like', '%' . $from .'%');
                        })
                        ->when($to, function($query) use ($to){
                            $query->where('end_date', 'like', '%' . $to .'%');
                        })
                        ->when($keyword, function($query) use ($keyword){
                            $query->where('title', 'like', '%' . $keyword .'%')->orWhere('pin', 'like', '%' . $keyword .'%')->orWhere('suburb', 'like', '%' . $keyword .'%');
                        })
                        ->paginate(15);
        //dd($event);
        return $event;
    }

    /**
     * @param $pinCode
     * @param $categoryId
     * @return mixed
     */
    public function getEventsByCategory($pinCode,$categoryId){
        $events = Event::with('category')->where('pin',$pinCode)->where('category_id',$categoryId)->get();
        
        return $events;
    }

    /**
     * @param $pinCode
     * @param $id
     * @return mixed
     */
    public function getRelatedEvents($pinCode,$id){
        $events = Event::with('category')->where('pin',$pinCode)->where('id','!=',$id)->get();
        
        return $events;
    }

    /**
     * @param event_id
     * @param user_id
     * @return Userevent|mixed
     */
    public function saveUserEvent($event_id,$user_id){
        $userEvent = new Userevent;
        $userEvent->event_id = $event_id;
        $userEvent->user_id = $user_id;
            
        $userEvent->save();

        Event::where('id', $event_id)->increment('no_of_followers', 1);

        return $userEvent;
    }

    /**
     * @param event_id
     * @param user_id
     * @return bool
     */
    public function deleteUserEvent($event_id,$user_id){
        Userevent::where("event_id",$event_id)->where("user_id",$user_id)->delete();

        Event::where('id', $event_id)->decrement('no_of_followers', 1);
        
        return true;   
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function userEvents($user_id){
        $userEvents = Userevent::with('event')->where('user_id',$user_id)->get();

        return $userEvents;
    }

    /**
     * @param event_id
     * @param $user_id
     * @return mixed
     */
    public function checkUserEvents($event_id, $user_id){
        $userEvents = Userevent::where('event_id',$event_id)->where('user_id',$user_id)->get();

        return $userEvents;
    }

    /**
     * @param $pinCode
     * @param $eventDate
     * @param $keyword
     * @param $categoryId
     * @param $eventformatId
     * @param $languageId
     * @param $isPaid
     * @param $isRecurring
     * @return mixed
     */
    public function filterEventsData($pinCode,$eventDate,$keyword,$categoryId,$eventformatId,$languageId,$isPaid,$isRecurring){
        $deals = Event::with('category')->where('status','=',1)
                        ->when($pinCode, function($query) use ($pinCode){
                            $query->where('pin', '=', $pinCode);
                        })
                        ->when($eventDate, function($query) use ($eventDate){
                            $query->where('start_date', '<=', $eventDate)->where('end_date', '>=', $eventDate);
                        })
                        ->when($keyword, function($query) use ($keyword){
                            $query->where('title', 'like', '%' . $keyword .'%');
                        })
                        ->when($categoryId, function($query) use ($categoryId){
                            $query->where('category_id', '=', $categoryId);
                        })
                        ->when($eventformatId, function($query) use ($eventformatId){
                            $query->where('format_id', '=', $eventformatId);
                        })
                        ->when($languageId, function($query) use ($languageId){
                            $query->where('language_id', '=', $languageId);
                        })
                        ->when($isPaid, function($query) use ($isPaid){
                            $query->where('is_paid', '=', $isPaid);
                        })
                        ->when($isRecurring, function($query) use ($isRecurring){
                            $query->where('is_recurring', '=', $isRecurring);
                        })
                        ->paginate(15);
        
        return $deals;
    }
}