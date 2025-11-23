<!-- Modal -->
<div class="modal fade" id="edit_EmployeesCourses{{$employeesCourse->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('courses.edit_Course')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-left">

                <form action=" {{ route('EmployeesCourses.update', $employeesCourse->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="" class="font-weight-bold">
                                {{trans('courses.Select_Employee')}}
                            </label>
                            <select class="form-control select2" name="employee_id" required>
                                <option selected disabled value=""> {{trans('courses.Select_Employee')}}</option>
                                @foreach(App\Models\HR\Employee::all() as $employee)
                                    <option value="{{$employee->id}}" @if($employee->id == $employeesCourse->employee_id) selected @endif>{{ $employee->name_en }} / {{ $employee->phone }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="name">{{trans('courses.Course_name')}} </label>
                            <input type="text" class="form-control" id="name"  name="name" value="{{ $employeesCourse->name }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('courses.Course_Start')}}  </label>
                            <input type="date" class="form-control" id="name_en"  name="start" value="{{ $employeesCourse->start }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('courses.Course_End')}}</label>
                            <input type="date" class="form-control" id="name_en"  name="end" value="{{ $employeesCourse->end }}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">  {{trans('courses.notes')}} </label>
                            <textarea class="form-control" name="notes" rows="4"> {{ $employeesCourse->notes }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('back.Save')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
