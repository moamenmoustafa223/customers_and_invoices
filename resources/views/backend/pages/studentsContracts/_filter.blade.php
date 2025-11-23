<div class="row mb-0">
    <div class="col-md-12 mb-0">
        <div class="card-box mb-1 pt-1 pb-1" style="background-color: #cde1ef">
            <form action="{{route('contracts_filter')}}" method="GET">
                @csrf
                <div class="row">

                    <div class="col-md-3">
                        <select class="form-control select2" name="pilgrim" >
                            <option selected value="0">   اختر حاج </option>
                            @foreach(App\Models\Pilgrim::all() as $pilgrim)
                                <option value="{{$pilgrim->id}}" @if($pilgrim->id == request()->pilgrim) selected @endif>{{$pilgrim->name}} / {{ $pilgrim->phone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control select2" name="campaign" >
                            <option selected value="0">  اختر حملة حج أو عمرة </option>
                            @foreach(App\Models\Campaign::all() as $campaign)
                                <option value="{{$campaign->id}}" @if($campaign->id == request()->campaign) selected @endif>{{$campaign->campaign_name}} / {{ $campaign->campaign_date }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-secondary " type="submit" > <i class="fas fa-search"></i> </button>
                        <a href="{{route('studentsContracts.index')}}" class="btn btn-secondary " type="submit"> <i class="fas fa-sync-alt"></i> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
