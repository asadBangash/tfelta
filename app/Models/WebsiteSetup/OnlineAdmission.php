<?php

namespace App\Models\WebsiteSetup;

use App\Models\Upload;
use App\Models\Session;
use App\Models\BloodGroup;
use App\Models\Academic\Shift;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Gender;
use App\Models\Religion;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentInfo\OnlineAdmissionFeesAssign;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnlineAdmission extends Model
{
    use HasFactory;

    protected $casts = [
        'upload_documents' => 'array',
        'selected_courses' => 'array',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'id');
    }

    public function blood()
    {
        return $this->belongsTo(BloodGroup::class, 'blood_group_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function fees()
    {
        return $this->hasOne(OnlineAdmissionFeesAssign::class, 'id', 'fees_assign_id');
    }

    public function payslip_img()
    {
        return $this->belongsTo(Upload::class, 'payslip_image_id', 'id');
    }

    public function student_img()
    {
        return $this->belongsTo(Upload::class, 'student_image_id', 'id');
    }

    public function gurdian_img()
    {
        return $this->belongsTo(Upload::class, 'gurdian_image_id', 'id');
    }

    public function father_img()
    {
        return $this->belongsTo(Upload::class, 'father_image_id', 'id');
    }

    public function mother_img()
    {
        return $this->belongsTo(Upload::class, 'mother_image_id', 'id');
    }


    public function previous_img()
    {
        return $this->belongsTo(Upload::class, 'previous_school_image_id', 'id');
    }
}
