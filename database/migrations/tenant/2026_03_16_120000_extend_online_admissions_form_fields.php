<?php

use App\Models\WebsiteSetup\OnlineAdmissionSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('online_admissions', function (Blueprint $table) {
            if (! Schema::hasColumn('online_admissions', 'blood_group_id')) {
                $table->foreignId('blood_group_id')->nullable()->after('gender_id')->constrained('blood_groups')->nullOnDelete();
            }
            if (! Schema::hasColumn('online_admissions', 'age')) {
                $table->string('age')->nullable()->after('dob');
            }
            if (! Schema::hasColumn('online_admissions', 'qualification')) {
                $table->string('qualification')->nullable()->after('age');
            }
            if (! Schema::hasColumn('online_admissions', 'phone_secondary')) {
                $table->string('phone_secondary')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('online_admissions', 'school_workplace')) {
                $table->string('school_workplace')->nullable()->after('email');
            }
            if (! Schema::hasColumn('online_admissions', 'father_cnic')) {
                $table->string('father_cnic')->nullable()->after('father_profession');
            }
            if (! Schema::hasColumn('online_admissions', 'guardian_cnic')) {
                $table->string('guardian_cnic')->nullable()->after('guardian_profession');
            }
            if (! Schema::hasColumn('online_admissions', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable()->after('guardian_cnic');
            }
            if (! Schema::hasColumn('online_admissions', 'selected_courses')) {
                $table->json('selected_courses')->nullable()->after('emergency_contact');
            }
        });

        $newFields = [
            'blood_group',
            'age',
            'qualification',
            'phone_secondary',
            'school_workplace',
            'father_cnic',
            'guardian_cnic',
            'emergency_contact',
            'course_selection',
        ];

        foreach ($newFields as $field) {
            if (! OnlineAdmissionSetting::where('field', $field)->where('type', 'online_admission')->exists()) {
                $setting = new OnlineAdmissionSetting();
                $setting->field = $field;
                $setting->type = 'online_admission';
                $setting->is_show = 1;
                $setting->is_required = 0;
                $setting->is_system_required = 0;
                $setting->save();
            }
        }

        // Ensure CNIC field is available in settings (legacy field name: cpr_no)
        if (! OnlineAdmissionSetting::where('field', 'cpr_no')->where('type', 'online_admission')->exists()) {
            $setting = new OnlineAdmissionSetting();
            $setting->field = 'cpr_no';
            $setting->type = 'online_admission';
            $setting->is_show = 1;
            $setting->is_required = 0;
            $setting->is_system_required = 0;
            $setting->save();
        }
    }

    public function down(): void
    {
        Schema::table('online_admissions', function (Blueprint $table) {
            if (Schema::hasColumn('online_admissions', 'blood_group_id')) {
                $table->dropForeign(['blood_group_id']);
                $table->dropColumn('blood_group_id');
            }
            foreach (['age', 'qualification', 'phone_secondary', 'school_workplace', 'father_cnic', 'guardian_cnic', 'emergency_contact', 'selected_courses'] as $col) {
                if (Schema::hasColumn('online_admissions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        OnlineAdmissionSetting::where('type', 'online_admission')
            ->whereIn('field', ['blood_group', 'age', 'qualification', 'phone_secondary', 'school_workplace', 'father_cnic', 'guardian_cnic', 'emergency_contact', 'course_selection'])
            ->delete();
    }
};
