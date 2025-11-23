<?php

namespace App\Models\HR;
use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    public function status()
    {
        return $this->status ? trans("back.Complete")  : trans("back.New") ;
    }



}
