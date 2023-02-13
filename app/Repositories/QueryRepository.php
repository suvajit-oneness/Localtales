<?php



namespace App\Repositories;



use App\Contracts\QueryContract;

use App\Models\Query;



class QueryRepository implements QueryContract

{

    public function listAllQuery()

    {

        return Query::all();
    }

    public function createQuery($collection)

    {

        $tickedId = 'tck_' . mt_rand();

        $query = new Query();

        $query->ticked_id = $tickedId;

        $query->name = $collection['name'];

        $query->email = $collection['email'];

        $query->query_catagory = $collection['query_catagory'];
        if(!empty($collection['other'])){
        $query->other = $collection['other'] ?? '';
        }
        $query->query = $collection['query'];

        $c = 1;

        $imar = [];

        if (array_key_exists('related_images', $collection)) {

            foreach ($collection['related_images'] as $images) {

                $images_name = $tickedId . '_image' . $c . $images->getClientOriginalExtension();

                $images->move(public_path('/query-screenshots'), $images_name);

                array_push($imar, '/query-screenshots/' . $images_name);

                $c++;
            }
        }

        $query->related_images = implode(',', $imar);

        $saved = $query->save();

        if ($saved)

            return $query->ticked_id;

        else

            return 'error';
    }

    public function viewQuery($id)

    {

        return Query::findOrFail($id);
    }



    public function updateQueryStatus($collection)

    {

        $update = Query::where('id', $collection['id'])->update(['status' => $collection['check_status']]);

        return $update;
    }



    public function deleteQuery($id)

    {
        return Query::where('id', $id)->delete();
    }
}
