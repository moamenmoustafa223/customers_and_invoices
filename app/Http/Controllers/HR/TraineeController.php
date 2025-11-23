<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Trainee;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TraineeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('query');
        $trainees = Trainee::query()
            ->where('name_ar', 'LIKE', "%{$search}%")
            ->orWhere('name_en', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')->paginate(10);

        return view('backend.HR.Trainees.index', compact('trainees'));
    }


    public function create()
    {
        return view('backend.HR.Trainees.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'id_number' => 'required',
            'jop_ar' => 'required',
            'jop_en' => 'required',
            'phone' =>  'required', 'string', 'phone', 'max:255', 'unique:trainees',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:trainees',
            'image' => 'nullable|image|mimes:jpg,jpeg,gif,png|max:20000',
        ]);

        if ($image = $request->file('image')){
            $filename = time().$image->getClientOriginalName();
            $image->move('images/Trainees/', $filename);
            $data['image'] = 'images/Trainees/'.$filename;
        }

        $data['user_id'] = Auth::id();
        $data['name_ar'] = $request->name_ar;
        $data['name_en'] = $request->name_en;

        $data['phone'] = normalizePhoneNumber($request->phone, Setting::first()->phone_code ?? '968');
        $data['email'] = $request->email;

        $data['id_number'] = $request->id_number;

        $data['jop_ar'] = $request->jop_ar;
        $data['jop_en'] = $request->jop_en;

        $data['gender'] = $request->gender;
        $data['Nationality'] = $request->Nationality;
        $data['religion'] = $request->religion;
        $data['social_status'] = $request->social_status;
        $data['address'] = $request->address;

        $data['academic'] = $request->academic;
        $data['type_academic'] = $request->type_academic;
        $data['date_academic'] = $request->date_academic;
        $data['place_academic'] = $request->place_academic;

        $data['training_department'] = $request->training_department;
        $data['training_duration'] = $request->training_duration;
        $data['training_salary'] = $request->training_salary;

        $data['start_training_date'] = $request->start_training_date;
        $data['end_training_date'] = $request->end_training_date;
        $data['training_place'] = $request->training_place;

        $data['attend_training'] = $request->attend_training;
        $data['management_skills'] = $request->management_skills;
        $data['technical_skills'] = $request->technical_skills;
        $data['evaluation'] = $request->evaluation;

        $data['notes'] = $request->notes;

        Trainee::create($data);
        toast('تم الإضافة بنجاح','success');
        return redirect()->route('Trainees.index');
    }

    public function show($id)
    {
        $trainee = Trainee::find($id);
        return view('backend.HR.Trainees.show', compact('trainee'));
    }



    public function edit($id)
    {
        $trainee = Trainee::find($id);
        return view('backend.HR.Trainees.edit', compact('trainee'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'id_number' => 'required',
            'jop_ar' => 'required',
            'jop_en' => 'required',
            'phone' => 'required', 'string', 'phone', 'max:255', 'unique:employees,phone,' .$id,
            'email' => 'required', 'string', 'email', 'max:255', 'unique:employees,email,' .$id,
            'Nationality' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,gif,png|max:20000',
        ]);

        $trainee = Trainee::find($id);

        if ($image = $request->file('image')){
            $filename = time().$image->getClientOriginalName();
            $image->move('images/Trainees/', $filename);
            $data['image'] = 'images/Trainees/'.$filename;
        }

        $data['user_id'] = Auth::id();
        $data['name_ar'] = $request->name_ar;
        $data['name_en'] = $request->name_en;

        $data['phone'] = normalizePhoneNumber($request->phone, Setting::first()->phone_code ?? '968');
        $data['email'] = $request->email;

        $data['id_number'] = $request->id_number;

        $data['jop_ar'] = $request->jop_ar;
        $data['jop_en'] = $request->jop_en;

        $data['gender'] = $request->gender;
        $data['Nationality'] = $request->Nationality;
        $data['religion'] = $request->religion;
        $data['social_status'] = $request->social_status;
        $data['address'] = $request->address;

        $data['academic'] = $request->academic;
        $data['type_academic'] = $request->type_academic;
        $data['date_academic'] = $request->date_academic;
        $data['place_academic'] = $request->place_academic;

        $data['training_department'] = $request->training_department;
        $data['training_duration'] = $request->training_duration;
        $data['training_salary'] = $request->training_salary;

        $data['start_training_date'] = $request->start_training_date;
        $data['end_training_date'] = $request->end_training_date;
        $data['training_place'] = $request->training_place;

        $data['attend_training'] = $request->attend_training;
        $data['management_skills'] = $request->management_skills;
        $data['technical_skills'] = $request->technical_skills;
        $data['evaluation'] = $request->evaluation;

        $data['notes'] = $request->notes;

        $trainee->update($data);

        toast('تم التعديل بنجاح','success');
        return redirect()->route('Trainees.index');
    }



    public function destroy($id)
    {
        $trainee = Trainee::find($id);
        $trainee->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }


}
