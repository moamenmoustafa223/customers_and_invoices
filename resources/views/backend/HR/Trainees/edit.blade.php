@extends('backend.layouts.master')

@section('page_title')
   {{trans('trainees.edit_trainee')}}
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
                <h4>{{$trainee->nam_ar}}</h4>

                <form action="{{route('Trainees.update',$trainee->id )}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="form-group col-md-3">
                            <label for="name_ar">{{trans('trainees.trainee_name_ar')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.trainee_name_ar')}}" name="name_ar" value="{{$trainee->name_ar}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="name_en">{{trans('trainees.trainee_name_en')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.trainee_name_en')}}" name="name_en" value="{{$trainee->name_en}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="email">{{trans('trainees.email')}}</label>
                            <input type="email" class="form-control" placeholder="{{trans('trainees.email')}} " name="email" value="{{$trainee->email}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="phone">{{trans('trainees.phone')}}</label>
                            <input type="number" class="form-control" placeholder="{{trans('trainees.phone')}} " name="phone" value="{{$trainee->phone}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="id_number">{{trans('trainees.id_number')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.id_number')}} " name="id_number" value="{{$trainee->id_number}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="jop_ar">{{trans('trainees.jop_ar')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.jop_ar')}} " name="jop_ar" value="{{$trainee->jop_ar}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="jop_en">{{trans('trainees.jop_en')}} </label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.jop_en')}} " name="jop_en" value="{{$trainee->jop_en}}" required>
                        </div>


                        <div class="col-md-3">
                            <label for="gender">{{trans('trainees.gender')}}</label>
                            <select name="gender" class="form-control">
                                <option value="0" {{ old('gender', $trainee->gender) == 0 ? 'selected' : null }}>{{trans('trainees.Male')}}</option>
                                <option value="1" {{ old('gender', $trainee->gender) == 1 ? 'selected' : null }}>{{trans('trainees.female')}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="Nationality">{{trans('trainees.Nationality')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.Nationality')}} " name="Nationality" value="{{$trainee->Nationality}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="religion">{{trans('trainees.religion')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.religion')}} " name="religion" value="{{$trainee->religion}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="social_status">{{trans('trainees.social_status')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.social_status')}} " name="social_status" value="{{$trainee->social_status}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="address">{{trans('trainees.address')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.address')}} " name="address" value="{{$trainee->address}}" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="academic">{{trans('trainees.academic')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.academic')}} " name="academic" value="{{$trainee->academic}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="type_academic">{{trans('trainees.type_academic')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.type_academic')}}" name="type_academic" value="{{$trainee->type_academic}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="date_academic">{{trans('trainees.date_academic')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('trainees.date_academic')}}" name="date_academic" value="{{$trainee->date_academic}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="place_academic">{{trans('trainees.place_academic')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.place_academic')}} " name="place_academic" value="{{$trainee->place_academic}}" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="training_department">{{trans('trainees.training_department')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.training_department')}} " name="training_department" value="{{$trainee->training_department}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="training_duration">{{trans('trainees.training_duration')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.training_duration')}} " name="training_duration" value="{{$trainee->training_duration}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="training_salary">{{trans('trainees.training_salary')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.training_salary')}} " name="training_salary" value="{{$trainee->training_salary}}" >
                        </div>


                        <div class="form-group col-md-3">
                            <label for="start_training_date">{{trans('trainees.start_training_date')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('trainees.start_training_date')}}" name="start_training_date" value="{{$trainee->start_training_date}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="end_training_date">{{trans('trainees.end_training_date')}}</label>
                            <input type="date" class="form-control" placeholder="{{trans('trainees.end_training_date')}} " name="end_training_date" value="{{$trainee->end_training_date}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="training_place">{{trans('trainees.training_place')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.training_place')}} " name="training_place" value="{{$trainee->training_place}}" >
                        </div>


                        <div class="col-md-3">
                            <label for="attend_training">{{trans('trainees.attend_training')}}</label>
                            <select name="attend_training" class="form-control">
                                <option value="0" {{ old('attend_training', $trainee->attend_training) == 0 ? 'selected' : null }}>{{trans('trainees.Yes')}}</option>
                                <option value="1" {{ old('attend_training', $trainee->attend_training) == 1 ? 'selected' : null }}>{{trans('trainees.No')}}</option>
                            </select>
                        </div>


                        <div class="form-group col-md-3">
                            <label for="management_skills">{{trans('trainees.management_skills')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.management_skills')}} " name="management_skills" value="{{$trainee->management_skills}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="technical_skills">{{trans('trainees.technical_skills')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.technical_skills')}} " name="technical_skills" value="{{$trainee->technical_skills}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="evaluation">{{trans('trainees.evaluation')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('trainees.evaluation')}} " name="evaluation" value="{{$trainee->evaluation}}" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="image">{{trans('trainees.image')}}</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>


                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('trainees.notes')}}</label>
                            <textarea class="form-control" name="notes"  rows="4">{{$trainee->notes}}</textarea>
                        </div>

                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success"> {{trans('trainees.Save')}} </button>
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


