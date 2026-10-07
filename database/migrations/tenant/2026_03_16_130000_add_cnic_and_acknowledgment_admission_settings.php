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
            if (! Schema::hasColumn('online_admissions', 'declaration_acknowledged')) {
                $table->boolean('declaration_acknowledged')->default(false)->after('selected_courses');
            }
            if (! Schema::hasColumn('online_admissions', 'rules_acknowledged')) {
                $table->boolean('rules_acknowledged')->default(false)->after('declaration_acknowledged');
            }
        });

        $legacyCnic = OnlineAdmissionSetting::where('type', 'online_admission')->where('field', 'cpr_no')->first();

        if (! OnlineAdmissionSetting::where('type', 'online_admission')->where('field', 'student_cnic_form_b')->exists()) {
            $setting = new OnlineAdmissionSetting();
            $setting->field = 'student_cnic_form_b';
            $setting->type = 'online_admission';
            $setting->is_show = $legacyCnic ? (bool) $legacyCnic->is_show : 1;
            $setting->is_required = $legacyCnic ? (bool) $legacyCnic->is_required : 0;
            $setting->is_system_required = 0;
            $setting->save();
        }

        // Single CNIC/Form B toggle in admin (replaces legacy cpr_no setting row).
        OnlineAdmissionSetting::where('type', 'online_admission')->where('field', 'cpr_no')->delete();

        foreach ([
            'admission_declaration_ack' => ['show' => 1, 'required' => 1],
            'admission_rules_ack' => ['show' => 1, 'required' => 1],
        ] as $field => $defaults) {
            if (! OnlineAdmissionSetting::where('type', 'online_admission')->where('field', $field)->exists()) {
                $setting = new OnlineAdmissionSetting();
                $setting->field = $field;
                $setting->type = 'online_admission';
                $setting->is_show = $defaults['show'];
                $setting->is_required = $defaults['required'];
                $setting->is_system_required = 0;
                $setting->save();
            }
        }
    }

    public function down(): void
    {
        Schema::table('online_admissions', function (Blueprint $table) {
            foreach (['declaration_acknowledged', 'rules_acknowledged'] as $col) {
                if (Schema::hasColumn('online_admissions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        OnlineAdmissionSetting::where('type', 'online_admission')
            ->whereIn('field', ['student_cnic_form_b', 'admission_declaration_ack', 'admission_rules_ack'])
            ->delete();
    }
};
