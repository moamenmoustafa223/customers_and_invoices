@extends('backend.layouts.master')

@section('page_title')
    {{trans('trainees.add_new_trainee')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-primary btn-sm" href="{{route('Trainees.index')}}">
                <i class="fas fa-arrow-right me-1"></i>
                {{trans('trainees.Back')}}
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('Trainees.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="name_ar">{{trans('trainees.trainee_name_ar')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.trainee_name_ar')}}" name="name_ar" value="{{old('name_ar')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="name_en">{{trans('trainees.trainee_name_en')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.trainee_name_en')}}" name="name_en" value="{{old('name_en')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="email">{{trans('trainees.email')}}</label>
                            <input type="email" class="form-control" placeholder="{{trans('trainees.email')}} " name="email" value="{{old('email')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="phone">{{trans('trainees.phone')}}</label>
                            <input type="number" class="form-control" placeholder="{{trans('trainees.phone')}} " name="phone" value="{{old('phone')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="id_number">{{trans('trainees.id_number')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.id_number')}} " name="id_number" value="{{old('id_number')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="jop_ar">{{trans('trainees.jop_ar')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.jop_ar')}} " name="jop_ar" value="{{old('jop_ar')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="jop_en">{{trans('trainees.jop_en')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.jop_en')}} " name="jop_en" value="{{old('jop_en')}}" required>
                        </div>


                        <div class="col-md-3">
                            <label for="gender">{{trans('trainees.gender')}}</label>
                            <select name="gender" class="form-control">
                                <option value="0" {{ old('gender') == 0 ? 'selected' : null }}>{{trans('trainees.Male')}}</option>
                                <option value="1" {{ old('gender') == 1 ? 'selected' : null }}>{{trans('trainees.female')}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="Nationality">{{trans('trainees.Nationality')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.Nationality')}} " name="Nationality" value="{{old('Nationality')}}" required >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="religion">{{trans('trainees.religion')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.religion')}} " name="religion" value="{{old('religion')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="social_status">{{trans('trainees.social_status')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.social_status')}} " name="social_status" value="{{old('social_status')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="address">{{trans('trainees.address')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.address')}} " name="address" value="{{old('address')}}" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="academic">{{trans('trainees.academic')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.academic')}} " name="academic" value="{{old('academic')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="type_academic">{{trans('trainees.type_academic')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.type_academic')}}" name="type_academic" value="{{old('type_academic')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="date_academic">{{trans('trainees.date_academic')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('trainees.date_academic')}}" name="date_academic" value="{{old('date_academic')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="place_academic"> {{trans('trainees.place_academic')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.place_academic')}} " name="place_academic" value="{{old('place_academic')}}" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="training_department">{{trans('trainees.training_department')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.training_department')}} " name="training_department" value="{{old('training_department')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="training_duration">{{trans('trainees.training_duration')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.training_duration')}}" name="training_duration" value="{{old('training_duration')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="training_salary">{{trans('trainees.training_salary')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.training_salary')}} " name="training_salary" value="{{old('training_salary')}}" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="start_training_date">{{trans('trainees.start_training_date')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('trainees.start_training_date')}} " name="start_training_date" value="{{old('start_training_date')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="end_training_date">{{trans('trainees.end_training_date')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('trainees.end_training_date')}} " name="end_training_date" value="{{old('end_training_date')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="training_place">{{trans('trainees.training_place')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.training_place')}} " name="training_place" value="{{old('training_place')}}" >
                        </div>



                        <div class="col-md-3">
                            <label for="attend_training">{{trans('trainees.attend_training')}}</label>
                            <select name="attend_training" class="form-control">
                                <option value="0" {{ old('attend_training') == 0 ? 'selected' : null }}>{{trans('trainees.Yes')}}</option>
                                <option value="1" {{ old('attend_training') == 1 ? 'selected' : null }}>{{trans('trainees.No')}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="management_skills">{{trans('trainees.management_skills')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.management_skills')}} " name="management_skills" value="{{old('management_skills')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="technical_skills">{{trans('trainees.technical_skills')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.technical_skills')}} " name="technical_skills" value="{{old('technical_skills')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="evaluation">{{trans('trainees.evaluation')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.evaluation')}} " name="evaluation" value="{{old('evaluation')}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="image">{{trans('trainees.image')}}</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>


                       <div class="form-group col-md-12">
                            <label for="notes">{{trans('trainees.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="4">{{old('notes')}}</textarea>
                        </div>

                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success"> {{trans('trainees.Add')}} </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


@section('js')
    <script>

    </script>
@endsection


