<!-- Modal -->
<div class="modal fade" id="add_CategoryAllowances" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('courses.Employees_Courses')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('EmployeesCourses.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="" class="font-weight-bold">
                                {{trans('courses.Select_Employee')}}
                            </label>
                            <select class="form-control select2" name="employee_id" required>
                                <option selected disabled value=""> {{trans('courses.Select_Employee')}}</option>
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


                        <div class="form-group col-md-6">
                            <label for="name">{{trans('courses.Course_name')}} </label>
                            <input type="text" class="form-control" id="name"  name="name" placeholder="{{trans('courses.Course_name')}}" value="{{ old('name') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="start">{{trans('courses.Course_Start')}}  </label>
                            <input type="date" class="form-control" id="name"  name="start" placeholder="{{trans('courses.Course_Start')}}" value="{{ old('start') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="start">C{{trans('courses.Course_End')}} </label>
                            <input type="date" class="form-control" id="name"  name="end" placeholder="{{trans('courses.Course_End')}}" value="{{ old('end') }}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">  {{trans('courses.notes')}} </label>
                            <textarea class="form-control" name="notes" rows="6">{{ old('notes') }}</textarea>
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
