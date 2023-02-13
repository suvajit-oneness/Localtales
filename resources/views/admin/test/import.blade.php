<form action="{{url('/')}}/admin/cat/match/post" method="post" enctype="multipart/form-data">@csrf
    <input type="file" name="file" id="">
    <button type="submit">Submit</button>
</form>