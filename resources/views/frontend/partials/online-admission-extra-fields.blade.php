@if (is_show('age'))
    <div class="col-xl-6">
        <label class="primary_label2">{{ ___('frontend.age') }} @if (is_required('age'))<span class="text-danger">*</span>@endif</label>
        <input name="age" placeholder="{{ ___('frontend.age') }}" class="form-control ot-input mb_30" type="text"
            @if (is_required('age')) required @endif>
    </div>
@endif

@if (is_show('blood_group'))
    <div class="col-xl-6 mb_24">
        <label class="primary_label2">{{ ___('frontend.blood_group') }} @if (is_required('blood_group'))<span class="text-danger">*</span>@endif</label>
        <select class="theme_select wide" name="blood_group" @if (is_required('blood_group')) required @endif>
            <option value="">{{ ___('frontend.Select') }}</option>
            @foreach ($data['bloods'] ?? [] as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
@endif

@if (is_show('qualification'))
    <div class="col-xl-6">
        <label class="primary_label2">{{ ___('frontend.qualification') }} @if (is_required('qualification'))<span class="text-danger">*</span>@endif</label>
        <input name="qualification" placeholder="{{ ___('frontend.qualification') }}" class="form-control ot-input mb_30" type="text"
            @if (is_required('qualification')) required @endif>
    </div>
@endif

@if (is_show('phone_secondary'))
    <div class="col-xl-6">
        <label class="primary_label2">{{ ___('frontend.phone_secondary') }} @if (is_required('phone_secondary'))<span class="text-danger">*</span>@endif</label>
        <input name="phone_secondary" placeholder="{{ ___('frontend.phone_secondary') }}" class="form-control ot-input mb_30" type="text"
            @if (is_required('phone_secondary')) required @endif>
    </div>
@endif

@if (is_show('school_workplace'))
    <div class="col-xl-6">
        <label class="primary_label2">{{ ___('frontend.school_workplace') }} @if (is_required('school_workplace'))<span class="text-danger">*</span>@endif</label>
        <input name="school_workplace" placeholder="{{ ___('frontend.school_workplace') }}" class="form-control ot-input mb_30" type="text"
            @if (is_required('school_workplace')) required @endif>
    </div>
@endif

@if (is_show('father_cnic'))
    <div class="col-xl-6">
        <label class="primary_label2">{{ ___('frontend.father_cnic') }} @if (is_required('father_cnic'))<span class="text-danger">*</span>@endif</label>
        <input name="father_cnic" placeholder="{{ ___('frontend.father_cnic') }}" class="form-control ot-input mb_30" type="text"
            @if (is_required('father_cnic')) required @endif>
    </div>
@endif

@if (is_show('guardian_cnic'))
    <div class="col-xl-6">
        <label class="primary_label2">{{ ___('frontend.guardian_cnic') }} @if (is_required('guardian_cnic'))<span class="text-danger">*</span>@endif</label>
        <input name="guardian_cnic" placeholder="{{ ___('frontend.guardian_cnic') }}" class="form-control ot-input mb_30" type="text"
            @if (is_required('guardian_cnic')) required @endif>
    </div>
@endif

@if (is_show('emergency_contact'))
    <div class="col-xl-6">
        <label class="primary_label2">{{ ___('frontend.emergency_contact') }} @if (is_required('emergency_contact'))<span class="text-danger">*</span>@endif</label>
        <input name="emergency_contact" placeholder="{{ ___('frontend.emergency_contact') }}" class="form-control ot-input mb_30" type="text"
            @if (is_required('emergency_contact')) required @endif>
    </div>
@endif

@if (is_show('course_selection'))
    @php $courseOptions = config('admission_courses', []); @endphp
    <div class="col-xl-12 mb_24">
        <h6 class="mb-3">{{ ___('frontend.course_selection') }}</h6>
        <p class="small text-muted mb-2">{{ ___('frontend.tick_appropriate_program') }}</p>

        @if (!empty($courseOptions['computer']))
            <p class="fw-bold mb-1">{{ ___('frontend.computer_it_courses') }}</p>
            <div class="row mb-3">
                @foreach ($courseOptions['computer'] as $key => $label)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="courses_computer[]" value="{{ $key }}" id="cc_{{ $key }}">
                            <label class="form-check-label" for="cc_{{ $key }}">{{ $label }}</label>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-6">
                    <input name="courses_computer_other" placeholder="{{ ___('frontend.other') }}" class="form-control ot-input mt-1" type="text">
                </div>
            </div>
        @endif

        @if (!empty($courseOptions['english']))
            <p class="fw-bold mb-1">{{ ___('frontend.english_language_courses') }}</p>
            <div class="row mb-3">
                @foreach ($courseOptions['english'] as $key => $label)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="courses_english[]" value="{{ $key }}" id="ce_{{ $key }}">
                            <label class="form-check-label" for="ce_{{ $key }}">{{ $label }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <p class="fw-bold mb-1">{{ ___('frontend.tuition_classes') }}</p>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="courses_tuition_enabled" value="1" id="tuition_enabled">
                    <label class="form-check-label" for="tuition_enabled">{{ ___('frontend.tuition_classes') }}</label>
                </div>
            </div>
            <div class="col-md-4">
                <input name="tuition_grade" placeholder="{{ ___('frontend.grade') }}" class="form-control ot-input" type="text">
            </div>
            <div class="col-md-4">
                <input name="tuition_subjects" placeholder="{{ ___('frontend.subjects') }}" class="form-control ot-input" type="text">
            </div>
        </div>

        @if (!empty($courseOptions['special']))
            <p class="fw-bold mb-1">{{ ___('frontend.special_programs') }}</p>
            <div class="row mb-3">
                @foreach ($courseOptions['special'] as $key => $label)
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="courses_special[]" value="{{ $key }}" id="cs_{{ $key }}">
                            <label class="form-check-label" for="cs_{{ $key }}">{{ $label }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endif
