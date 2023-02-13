@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="app-title">
        <div class="row w-100">
            <div class="col-md-6">
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
                <p></p>
            </div>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="row mx-0">
                <div class="col-md-8">
                    <p class="small text-muted">Displaying {{ $data->firstItem() }} - {{ $data->lastItem() }} out of {{ $data->total() }} records</p>
                </div>
                <div class="col-md-4">
                    <form action="" class="d-flex">
                        <input type="search" name="keyword" id="keyword" class="form-control form-control-sm" placeholder="Search here.." value="{{app('request')->input('keyword')}}" autocomplete="off">
                        <button type="submit" class="btn btn-outline-danger btn-sm ml-3">Search</button>
                        {{-- <a href="{{ route('admin.directory.verify.export') }}">Export</a> --}}
                    </form>
                </div>
            </div>

            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped">
                        <thead>
                            <tr style="position: sticky;top: 49px;">
                                <th>ID</th>
                                <th>Name</th>
                                <th>CSV cat</th>
                                <th width="300">LT cat</th>
                                <th>Google cat</th>
                                <th style="background: #ffc107;">Match</th>
                                <th>Verify</th>
                                <th>Address</th>
                                {{-- <th>Place ID</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key => $directory)
                                <tr id="#row_{{$directory->id}}">
                                    <td class="small text-muted">
                                        {{ $directory->id }}
                                    </td>
                                    <td class="small text-muted">
                                        <a href="{{ url('/directory/'.$directory->slug) }}" target="_blank">{{ $directory->name }}</a>
                                        <br>
                                        <a href="#detailModal{{$key}}" data-toggle="modal">Details</a>
                                    </td>
                                    <td class="small text-dark">
                                        {{ csvdirectoryCategoryStr($directory->category_id) }}
                                    </td>
                                    <td class="small text-dark">
                                        {!! directoryParentChildCategoryStr($directory->category_id) !!}
                                    </td>
                                    <td class="small text-dark">
                                        {{ $directory->google_category_display }}
                                    </td>
                                    <td>
                                        @php
                                            if (!empty($directory->place_id) && !empty($directory->google_category_display)) {
                                                // 1 explode google category
                                                $googleCategoryExplode = explode(', ', $directory->google_category_display);

                                                // 2 directory category into string
                                                $cat = substr($directory->category_id, 0, -1);
                                                $displayCategoryName = '';
                                                foreach(explode(',', $cat) as $catKey => $catVal) {
                                                    $catDetails = \App\Models\DirectoryCategory::where('id', $catVal)->where('status', 1)->first();

                                                    if(!empty($catDetails->child_category)) {
                                                        $displayCategoryName .= $catDetails->parent_category.', '.$catDetails->child_category.', ';
                                                    }
                                                }
                                                $displayCategoryName = substr($displayCategoryName, 0, -2);

                                                // 3 if any one of the google category matches string with directory category
                                                $gMatch = 0;
                                                foreach ($googleCategoryExplode as $gCat) {
                                                    if($gMatch == 1) break;

                                                    if(preg_match("/{$gCat}/i", $displayCategoryName)) {
                                                        $gMatch = 1;
                                                    } else {
                                                        $gMatch = 0;
                                                    }
                                                }

                                                if ($gMatch == 1) {
                                                    // UPDATE STATUS IN DB
                                                    DB::table('directories')->where('id', $directory->id)->update(['match_status' => 1]);
                                                    echo '<span class="badge badge-success rounded-0">Match</span>';
                                                } else {
                                                    // 4 check for synonyms here
                                                    foreach ($googleCategoryExplode as $gCat) {
                                                        if($gMatch == 1) break;

                                                        // synonym for 'beauty_salon'
                                                        elseif(preg_match("/beauty_salon/i", $gCat)) {
                                                            if(
                                                                preg_match("/beauty/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'cemetery'
                                                        elseif(preg_match("/cemetery/i", $gCat)) {
                                                            if(
                                                                preg_match("/funeral/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'embassy'
                                                        elseif(preg_match("/embassy/i", $gCat)) {
                                                            if(
                                                                preg_match("/Government/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'funeral_home'
                                                        elseif(preg_match("/funeral_home/i", $gCat)) {
                                                            if(
                                                                preg_match("/funeral/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'library'
                                                        elseif(preg_match("/library/i", $gCat)) {
                                                            if(
                                                                preg_match("/Libraries/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'local_government_office'
                                                        elseif(preg_match("/local_government_office/i", $gCat)) {
                                                            if(
                                                                preg_match("/government/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'hair_care'
                                                        elseif(preg_match("/hair_care/i", $gCat)) {
                                                            if(
                                                                preg_match("/hair/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'lawyer'
                                                        elseif(preg_match("/lawyer/i", $gCat)) {
                                                            if(
                                                                preg_match("/Legal/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'lodging'
                                                        elseif(preg_match("/lodging/i", $gCat)) {
                                                            if(
                                                                preg_match("/Accommodation/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'pet_store'
                                                        elseif(preg_match("/pet_store/i", $gCat)) {
                                                            if(
                                                                preg_match("/pet/i", $displayCategoryName) || 
                                                                preg_match("/pets/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'pet_store'
                                                        elseif(preg_match("/place_of_worship/i", $gCat)) {
                                                            if(
                                                                preg_match("/churches/i", $displayCategoryName) || 
                                                                preg_match("/church/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'police'
                                                        elseif(preg_match("/police/i", $gCat)) {
                                                            if(
                                                                preg_match("/Federal/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'post_office'
                                                        elseif(preg_match("/post_office/i", $gCat)) {
                                                            if(
                                                                preg_match("/post office/i", $displayCategoryName) ||
                                                                preg_match("/courier Services/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'real_estate_agency'
                                                        elseif(preg_match("/real_estate_agency/i", $gCat)) {
                                                            if(
                                                                preg_match("/real estate agents/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'store'
                                                        elseif(preg_match("/store/i", $gCat)) {
                                                            if(
                                                                preg_match("/shop/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'travel'
                                                        if(preg_match("/travel/i", $gCat)) {
                                                            if(
                                                                preg_match("/travel/i", $displayCategoryName) ||
                                                                preg_match("/tour/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                        // synonym for 'veterinary_care'
                                                        elseif(preg_match("/veterinary_care/i", $gCat)) {
                                                            if(
                                                                preg_match("/pet/i", $displayCategoryName) || 
                                                                preg_match("/pets/i", $displayCategoryName) || 
                                                                preg_match("/vet/i", $displayCategoryName)
                                                            ) {
                                                                $gMatch = 1;
                                                            } else {
                                                                $gMatch = 0;
                                                            }
                                                        }
                                                    }

                                                    if ($gMatch == 1) {
                                                        // UPDATE STATUS IN DB
                                                        DB::table('directories')->where('id', $directory->id)->update(['match_status' => 1]);
                                                        echo '<span class="badge badge-success rounded-0">Match</span>';
                                                    } else {
                                                        // UPDATE STATUS IN DB
                                                        DB::table('directories')->where('id', $directory->id)->update(['match_status' => 0, 'match_status_detail' => 'failure']);
                                                        echo '<span class="badge badge-danger rounded-0">Failure</span>';
                                                    }
                                                }
                                            } else {
                                                // UPDATE STATUS IN DB
                                                DB::table('directories')->where('id', $directory->id)->update(['match_not_found' => 1]);
                                                echo '<span class="badge badge-warning rounded-0">Not found</span>';
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        <a href="javascript: void(0)" onclick="verifyFunc({{$directory->id}}, {{$directory->is_verified}})" class="verify_{{$directory->id}}">
                                            {!! ($directory->is_verified == 0) ? '<span class="badge badge-danger rounded-0">False</span>' : '<span class="badge badge-success rounded-0">Success</span>' !!}
                                        </a>
                                    </td>
                                    <td class="small text-muted">
                                        {{ $directory->address }}
                                    </td>
                                    {{-- <td class="small text-muted">
                                        {{ $directory->place_id }}
                                    </td> --}}
                                </tr>

                                <div class="modal fade" id="detailModal{{$key}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-title">
                                                <h5>{{ $directory->name }}</h5>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                    $array = json_decode($directory->google_api_detail_fetch, true);
                                                    print '<pre>';
                                                    print_r($array);
                                                    print '</pre>';
                                                @endphp
                                            </div>
                                            <div class="modal-footer"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>

                    {!! $data->appends($_GET)->links() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function verifyFunc(id, verify) {
            $.ajax({
                url: "{{route('admin.directory.verify')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    id: id,
                    type: verify,
                },
                type: 'POST',
                success: function(result) {
                    if (result.status == 200) {
                        var content = '';

                        if (result.type == 0) {
                            content = '<span class="badge badge-danger rounded-0">False</span>';
                        } else {
                            content = '<span class="badge badge-success rounded-0">Success</span>';
                        }

                        $('.verify_'+id).html(content);
                    }
                },
            })
        }
    </script>
@endpush

