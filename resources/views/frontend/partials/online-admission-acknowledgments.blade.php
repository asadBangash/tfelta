@if (is_show('admission_rules_ack') || is_show('admission_declaration_ack'))
    <div class="col-xl-12 mb_24">
        <h6>{{ ___('frontend.admission_rules_heading') }}</h6>
        <ol class="small">
            <li>{{ ___('frontend.admission_rule_1') }}</li>
            <li>{{ ___('frontend.admission_rule_2') }}</li>
            <li>{{ ___('frontend.admission_rule_3') }}</li>
        </ol>
    </div>
@endif

@if (is_show('admission_declaration_ack'))
    <div class="col-xl-12 mb_24">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="admission_declaration_ack" value="1"
                id="admission_declaration_ack"
                @if (is_required('admission_declaration_ack')) required @endif
                @if (old('admission_declaration_ack')) checked @endif>
            <label class="form-check-label" for="admission_declaration_ack">
                {{ ___('student_info.admission_declaration') }}
                @if (is_required('admission_declaration_ack'))
                    <span class="text-danger">*</span>
                @endif
            </label>
        </div>
        @error('admission_declaration_ack')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>
@endif

@if (is_show('admission_rules_ack'))
    <div class="col-xl-12 mb_24">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="admission_rules_ack" value="1"
                id="admission_rules_ack"
                @if (is_required('admission_rules_ack')) required @endif
                @if (old('admission_rules_ack')) checked @endif>
            <label class="form-check-label" for="admission_rules_ack">
                {{ ___('frontend.admission_rules_ack_label') }}
                @if (is_required('admission_rules_ack'))
                    <span class="text-danger">*</span>
                @endif
            </label>
        </div>
        @error('admission_rules_ack')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>
@endif
