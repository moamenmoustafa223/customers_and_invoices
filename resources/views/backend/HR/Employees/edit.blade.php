@extends('backend.layouts.master')

@section('page_title')
    {{trans('employees.edit_employee')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Employees.index')}}">
                <i class="fas fa-arrow-circle-right pr-1"></i>
                {{trans('employees.Back')}}
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mb-3"> {{trans('employees.edit_employee')}}</h4>

                    <form action="{{route('Employees.update',$employee->id )}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="form-group col-md-3">
                                <label for="" class="font-weight-bold">
                                    {{trans('employees.select_Category')}}
                                </label>
                                <select class="form-control select2" name="category_employees_id" required>
                                    <option selected disabled value=""> {{trans('employees.select_Category')}}</option>
                                    @foreach(App\Models\HR\CategoryEmployees::all() as $categoryEmployees)
                                        <option value="{{ $categoryEmployees->id }}" {{ old('category_employees_id', $employee->category_employees_id) == $categoryEmployees->id ? 'selected' : null }} >
                                            @if (app()->getLocale() == 'ar')
                                                {{ $categoryEmployees->name }}
                                            @else
                                                {{ $categoryEmployees->name_en }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-3">
                                <label for="status">{{trans('back.Status')}}</label>
                                <select name="status" class="form-control">
                                    <option value="0" {{ old('active', $employee->status) == 0 ? 'selected' : null }}>{{trans('back.active')}}</option>
                                    <option value="1" {{ old('inactive', $employee->status) == 1 ? 'selected' : null }}>{{trans('back.inactive')}}</option>
                                </select>
                            </div>


                            <hr class="col-md-12">


                            <div class="form-group col-md-3">
                                <label for="employee_no">{{trans('employees.employee_no')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.employee_no')}}" name="employee_no" value="{{$employee->employee_no}}" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="Join_date">{{trans('employees.Join_date')}}</label>
                                <input type="date" class="form-control" placeholder="{{trans('employees.Join_date')}}" name="Join_date" value="{{$employee->Join_date}}" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="name_ar">{{trans('employees.employee_name_ar')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.employee_name_ar')}}" name="name_ar" value="{{$employee->name_ar}}" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="name_en">{{trans('employees.employee_name_en')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.employee_name_en')}}" name="name_en" value="{{$employee->name_en}}" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="email">{{trans('employees.email')}}</label>
                                <input type="email" class="form-control" placeholder="{{trans('employees.email')}} " name="email" value="{{$employee->email}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="phone">{{trans('employees.phone')}} (UserName)</label>
                                <input type="number" class="form-control" placeholder="{{trans('employees.phone')}} " name="phone" value="{{$employee->phone}}" required>
                                <small id="emailHelp" class="form-text text-muted">{{trans('back.notes_username_employee')}}</small>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="password">{{trans('employees.password')}}</label>
                                <input type="password" class="form-control" placeholder="{{trans('employees.password')}}" name="password" value="{{$employee->password}}" required>
                            </div>

                            <hr class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="jop_ar">{{trans('employees.jop_ar')}} </label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.jop_ar')}} " name="jop_ar" value="{{$employee->jop_ar}}" required>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="jop_en">{{trans('employees.jop_en')}} </label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.jop_en')}} " name="jop_en" value="{{$employee->jop_en}}" required>
                            </div>

                        </div>
                        <div class="row">


                            <div class="form-group col-md-3">
                                <label for="birth_date">{{trans('employees.birth_date')}}</label>
                                <input type="date" class="form-control" placeholder="{{trans('employees.birth_date')}} " name="birth_date" value="{{$employee->birth_date}}" >
                            </div>

                            <div class="col-md-3">
                                <label for="gender">{{trans('employees.gender')}}</label>
                                <select name="gender" class="form-control">
                                    <option value="0" {{ old('gender', $employee->gender) == 0 ? 'selected' : null }}>{{trans('employees.Male')}}</option>
                                    <option value="1" {{ old('gender', $employee->gender) == 1 ? 'selected' : null }}>{{trans('employees.female')}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="Nationality">{{trans('employees.Nationality')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.Nationality')}}" name="Nationality" value="{{$employee->Nationality}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="religion">{{trans('employees.religion')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.religion')}}" name="religion" value="{{$employee->religion}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="social_status">{{trans('employees.social_status')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.social_status')}}ة" name="social_status" value="{{$employee->social_status}}" >
                            </div>

                            <hr class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="id_number">{{trans('employees.id_number')}} </label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.id_number')}}" name="id_number" value="{{$employee->id_number}}" required >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="start_date_id"> {{trans('employees.date_of_issue')}}</label>
                                <input type="date" class="form-control" placeholder="{{trans('employees.date_of_issue')}}" name="start_date_id" value="{{$employee->start_date_id}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="end_date_id">{{trans('employees.Expiry_date')}}</label>
                                <input type="date" class="form-control" placeholder="{{trans('employees.Expiry_date')}} " name="end_date_id" value="{{$employee->end_date_id}}" >
                            </div>

                            <hr class="col-md-12">

                            <div class="form-group col-md-3">
                                <label for="passport_number">{{trans('employees.passport_number')}} </label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.passport_number')}} " name="passport_number" value="{{$employee->passport_number}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="start_date_passport">{{trans('employees.date_of_issue')}}</label>
                                <input type="date" class="form-control" placeholder="{{trans('employees.date_of_issue')}} " name="start_date_passport" value="{{$employee->start_date_passport}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="end_date_passport">{{trans('employees.Expiry_date')}}</label>
                                <input type="date" class="form-control" placeholder="{{trans('employees.Expiry_date')}} " name="end_date_passport" value="{{$employee->end_date_passport}}" >
                            </div>


                            <div class="form-group col-md-3">
                                <label for="Place">{{trans('employees.place_of_issue')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.place_of_issue')}} " name="Place" value="{{$employee->Place}}" >
                            </div>


                            <hr class="col-md-12">


                        </div>
                        <div class="row">

                            <div class="form-group col-md-3">
                                <label for="academic">{{trans('employees.academic')}}  </label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.academic')}}  " name="academic" value="{{$employee->academic}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="type_academic">{{trans('employees.type_academic')}} </label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.type_academic')}} " name="type_academic" value="{{$employee->type_academic}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="date_academic">{{trans('employees.date_academic')}}</label>
                                <input type="date" class="form-control" placeholder="{{trans('employees.date_academic')}} " name="date_academic" value="{{$employee->date_academic}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="place_academic">{{trans('employees.place_academic')}} </label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.place_academic')}}" name="place_academic" value="{{$employee->place_academic}}" >
                            </div>

                            <hr class="col-md-12">


                            <div class="form-group col-md-3">
                                <label for="address">{{trans('employees.address')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('employees.address')}} " name="address" value="{{$employee->address}}" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="image">{{trans('employees.image')}}</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="image">{{trans('employees.image')}}</label>
                                <img src="{{asset($employee->image)}}" alt="{{$employee->name_ar}}" width="100">
                            </div>

                            <hr class="col-md-12">
                            <div class="form-group col-md-12">
                                <label for="notes">{{trans('employees.notes')}}</label>
                                <textarea class="form-control" name="notes"  rows="6">{{$employee->notes}}</textarea>
                            </div>

                        </div>

                        <hr class="col-md-12">
                        <div class=" col-md-12 text-center">
                            <button type="submit" class="btn btn-success"> {{trans('employees.Save')}} </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
    <!-- end row -->


@endsection


@section('js')
    <script>

    </script>
@endsection


