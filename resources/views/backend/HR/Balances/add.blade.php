<!-- Modal -->
<div class="modal fade" id="add_balance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.add_new_balance')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('Balances.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="" class="font-weight-bold">
                                {{trans('back.select_Employee ')}}
                            </label>
                            <select class="form-control select2" name="employee_id" required>
                                <option selected disabled value=""> {{trans('back.select_Employee ')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    <option value="{{ $employee->id }}">
                                        @if (app()->getLocale() == 'ar')
                                            {{ $employee->name_ar }} / {{ $employee->phone }}
                                        @else
                                            {{ $employee->name_en }} / {{ $employee->phone }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="name">{{trans('back.balance_name')}}</label>
                            <input type="text" class="form-control" id="name"   name="name" placeholder="{{trans('back.balance_name')}}" value="{{old('name')}}">
                        </div>


                        <div class="form-group col-md-4">
                            <label for="number">{{trans('back.number_of_days')}}</label>
                            <input type="number" class="form-control" id="number" step="any"   name="number"  value="{{ 0, old('number') }}">
                        </div>


                        <div class="form-group col-md-12">
                            <label for="notes">  {{trans('back.notes')}}</label>
                            <textarea class="form-control" name="notes" rows="4"> {{ old('notes') }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('back.Add')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
