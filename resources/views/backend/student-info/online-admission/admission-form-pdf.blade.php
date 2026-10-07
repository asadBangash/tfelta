<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ___('student_info.official_admission_form') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #111; margin: 12px; }
        .header-table { width: 100%; border-bottom: 2px solid #c00; margin-bottom: 8px; }
        .title { color: #c00; font-size: 16px; font-weight: bold; text-align: right; }
        .photo-box { border: 1px dashed #666; width: 90px; height: 110px; text-align: center; font-size: 8px; padding-top: 40px; }
        .photo-box img { width: 88px; height: 108px; object-fit: cover; }
        h4 { font-size: 11px; margin: 10px 0 4px; text-transform: uppercase; border-bottom: 1px solid #333; }
        table.fields { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
        table.fields td { padding: 3px 4px; vertical-align: top; }
        .label { font-weight: bold; width: 28%; }
        .value { border-bottom: 1px dotted #999; }
        .rules ol { margin: 4px 0 0 16px; padding: 0; }
        .sign-row { margin-top: 28px; width: 100%; }
        .sign-row td { text-align: center; padding-top: 24px; border-top: 1px solid #333; width: 33%; }
        .checkbox { display: inline-block; width: 10px; height: 10px; border: 1px solid #333; margin-right: 4px; text-align: center; font-size: 8px; line-height: 10px; }
        .checked { background: #333; color: #fff; }
    </style>
</head>
<body>
@php
    $photoPath = null;
    if ($admission->student_img && !empty($admission->student_img->path) && file_exists(public_path($admission->student_img->path))) {
        $photoPath = public_path($admission->student_img->path);
    }
    $courses = $admission->selected_courses ?? [];
    $courseLabels = function ($group, $keys) use ($courseOptions) {
        if (!is_array($keys)) {
            return '';
        }
        $map = $courseOptions[$group] ?? [];
        return collect($keys)->map(fn ($k) => $map[$k] ?? $k)->implode(', ');
    };
@endphp

<table class="header-table">
    <tr>
        <td style="width: 70%;">
            <strong style="font-size: 12px;">{{ strtoupper(setting('application_name')) }}</strong><br>
            @if(setting('address')){{ setting('address') }}<br>@endif
            @if(setting('phone')){{ ___('common.phone') }}: {{ setting('phone') }}@endif
            @if(setting('email')) | {{ setting('email') }}@endif
        </td>
        <td style="width: 30%; vertical-align: top;">
            <div class="title">{{ ___('student_info.official_admission_form') }}</div>
            <div class="photo-box" style="float: right; margin-top: 4px;">
                @if($photoPath)
                    <img src="{{ $photoPath }}" alt="">
                @else
                    {{ ___('student_info.affix_photo') }}
                @endif
            </div>
        </td>
    </tr>
</table>

<table class="fields">
    <tr>
        <td class="label">{{ ___('student_info.date_of_admission') }}</td>
        <td class="value">{{ dateFormat($admission->created_at) }}</td>
        <td class="label">{{ ___('student_info.admission_no') }}</td>
        <td class="value">{{ $admission->reference_no }}</td>
    </tr>
</table>

<h4>{{ ___('student_info.section_a_student_information') }}</h4>
<table class="fields">
    <tr>
        <td class="label">{{ ___('student_info.student_name') }}</td>
        <td class="value" colspan="3">{{ strtoupper(trim($admission->first_name.' '.$admission->last_name)) }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('student_info.date_of_birth') }}</td>
        <td class="value">{{ dateFormat($admission->dob) }}</td>
        <td class="label">{{ ___('frontend.age') }}</td>
        <td class="value">{{ $admission->age }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.Gender') }}</td>
        <td class="value">{{ @$admission->gender->name }}</td>
        <td class="label">{{ ___('frontend.student_cnic_form_b') }}</td>
        <td class="value">{{ $admission->cpr_no }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.blood_group') }}</td>
        <td class="value">{{ @$admission->blood->name }}</td>
        <td class="label">{{ ___('frontend.qualification') }}</td>
        <td class="value">{{ $admission->qualification }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.Residance_Address') }}</td>
        <td class="value" colspan="3">{{ $admission->residance_address }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.email_address') }}</td>
        <td class="value">{{ $admission->email }}</td>
        <td class="label">{{ ___('frontend.phone_no') }}</td>
        <td class="value">{{ $admission->phone }} @if($admission->phone_secondary)/ {{ $admission->phone_secondary }}@endif</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.school_workplace') }}</td>
        <td class="value" colspan="3">{{ $admission->school_workplace ?: $admission->previous_school_info }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('academic.class') }} / {{ ___('academic.section') }}</td>
        <td class="value">{{ @$admission->class->name }} ({{ @$admission->section->name }})</td>
        <td class="label">{{ ___('frontend.Shift') }}</td>
        <td class="value">{{ @$admission->shift->defaultTranslate->name ?? '' }}</td>
    </tr>
</table>

<h4>{{ ___('student_info.section_b_guardian_information') }}</h4>
<table class="fields">
    <tr>
        <td class="label">{{ ___('frontend.father_name') }}</td>
        <td class="value">{{ $admission->father_name }}</td>
        <td class="label">{{ ___('frontend.father_cnic') }}</td>
        <td class="value">{{ $admission->father_cnic }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.father_phone') }}</td>
        <td class="value">{{ $admission->father_phone }}</td>
        <td class="label">{{ ___('frontend.father_profession') }}</td>
        <td class="value">{{ $admission->father_profession }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.guardian_name') }}</td>
        <td class="value">{{ $admission->guardian_name }}</td>
        <td class="label">{{ ___('frontend.guardian_cnic') }}</td>
        <td class="value">{{ $admission->guardian_cnic }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.guardian_phone') }}</td>
        <td class="value">{{ $admission->guardian_phone }}</td>
        <td class="label">{{ ___('frontend.Guardian_Profession') }}</td>
        <td class="value">{{ $admission->guardian_profession }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.emergency_contact') }}</td>
        <td class="value" colspan="3">{{ $admission->emergency_contact }}</td>
    </tr>
</table>

@if(!empty($courses))
<h4>{{ ___('frontend.course_selection') }}</h4>
<table class="fields">
    <tr>
        <td class="label">{{ ___('frontend.computer_it_courses') }}</td>
        <td class="value" colspan="3">
            {{ $courseLabels('computer', $courses['computer'] ?? []) }}
            @if(!empty($courses['computer_other'])) | {{ ___('frontend.other') }}: {{ $courses['computer_other'] }} @endif
        </td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.english_language_courses') }}</td>
        <td class="value" colspan="3">{{ $courseLabels('english', $courses['english'] ?? []) }}</td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.tuition_classes') }}</td>
        <td class="value" colspan="3">
            @if(!empty($courses['tuition']['enabled']))
                {{ ___('frontend.grade') }}: {{ $courses['tuition']['grade'] ?? '' }},
                {{ ___('frontend.subjects') }}: {{ $courses['tuition']['subjects'] ?? '' }}
            @endif
        </td>
    </tr>
    <tr>
        <td class="label">{{ ___('frontend.special_programs') }}</td>
        <td class="value" colspan="3">{{ $courseLabels('special', $courses['special'] ?? []) }}</td>
    </tr>
</table>
@endif

<h4>{{ ___('frontend.admission_rules_heading') }}</h4>
<div class="rules">
    <ol>
        <li>{{ ___('frontend.admission_rule_1') }}</li>
        <li>{{ ___('frontend.admission_rule_2') }}</li>
        <li>{{ ___('frontend.admission_rule_3') }}</li>
    </ol>
</div>

<p style="margin-top: 10px; font-size: 9px;">
    {{ ___('student_info.admission_declaration') }}
    @if($admission->declaration_acknowledged) (✓) @endif
</p>
@if($admission->rules_acknowledged)
<p style="font-size: 9px;">{{ ___('frontend.admission_rules_ack_label') }} (✓)</p>
@endif

<table class="sign-row">
    <tr>
        <td>{{ ___('student_info.signature_applicant') }}</td>
        <td>{{ ___('student_info.signature_guardian') }}</td>
        <td>{{ ___('student_info.signature_director') }}</td>
    </tr>
</table>

</body>
</html>
