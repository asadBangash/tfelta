<?php

namespace Database\Seeders\StudentInfo;

use App\Models\BloodGroup;
use App\Models\Gender;
use App\Models\Religion;
use App\Models\Session;
use App\Models\Academic\Classes;
use App\Models\Academic\ClassSetup;
use App\Models\Academic\ClassSetupChildren;
use App\Models\Academic\Section;
use App\Models\WebsiteSetup\OnlineAdmission;
use Illuminate\Database\Seeder;

class OnlineAdmissionSampleSeeder extends Seeder
{
    public function run(): void
    {
        if (OnlineAdmission::where('reference_no', 'DEMO01')->exists()) {
            $this->command?->info('Sample online admission already exists (DEMO01).');

            return;
        }

        [$sessionId, $classId, $sectionId] = $this->resolveAcademicIds();

        if (! $sessionId || ! $classId || ! $sectionId) {
            $this->command?->warn('OnlineAdmissionSampleSeeder: could not resolve session/class/section.');

            return;
        }

        $genderId = Gender::query()->value('id');
        $religionId = Religion::query()->value('id');
        $bloodId = BloodGroup::query()->value('id');

        OnlineAdmission::create([
            'first_name' => 'Atif',
            'last_name' => 'Rehman',
            'phone' => '+923331746105',
            'phone_secondary' => '03331234567',
            'email' => 'atif.demo@example.com',
            'reference_no' => 'DEMO01',
            'payment_status' => 0,
            'session_id' => $sessionId,
            'classes_id' => $classId,
            'section_id' => $sectionId,
            'shift_id' => null,
            'religion_id' => $religionId,
            'gender_id' => $genderId,
            'blood_group_id' => $bloodId,
            'dob' => '2007-04-01',
            'age' => '18',
            'qualification' => 'Matric',
            'cpr_no' => '17301-1234567-1',
            'school_workplace' => 'Fazal Model School Peshawar',
            'residance_address' => 'Momin Town, Sector 2, Peshawar',
            'spoken_lang_at_home' => 'Urdu',
            'nationality' => 'Pakistani',
            'place_of_birth' => 'Peshawar',
            'guardian_name' => 'Asad Rehman',
            'guardian_phone' => '03339966130',
            'guardian_profession' => 'Business',
            'guardian_cnic' => '17301-9876543-2',
            'father_name' => 'Asad Rehman',
            'father_phone' => '03339966130',
            'father_profession' => 'Business',
            'father_cnic' => '17301-9876543-2',
            'mother_name' => 'Sample Mother',
            'mother_phone' => '03330001122',
            'emergency_contact' => 'Uncle Ali — 03335556677',
            'declaration_acknowledged' => true,
            'rules_acknowledged' => true,
            'selected_courses' => [
                'computer' => ['basic_computer', 'web_development'],
                'english' => ['english_speaking_3m'],
                'computer_other' => null,
                'tuition' => [
                    'enabled' => false,
                    'grade' => null,
                    'subjects' => null,
                ],
                'special' => ['calligraphy'],
            ],
            'previous_school' => 0,
        ]);

        $this->command?->info('Sample online admission created (reference: DEMO01). Check Admin → Online Admission.');
    }

    /**
     * @return array{0: ?int, 1: ?int, 2: ?int}
     */
    private function resolveAcademicIds(): array
    {
        $sessionId = setting('session') ?: Session::query()->orderBy('id')->value('id');

        $classId = Classes::query()->value('id');
        $sectionId = null;

        if ($classId && $sessionId) {
            $setup = ClassSetup::query()
                ->where('session_id', $sessionId)
                ->where('classes_id', $classId)
                ->first();

            if ($setup) {
                $sectionId = ClassSetupChildren::query()
                    ->where('class_setup_id', $setup->id)
                    ->value('section_id');
            }
        }

        if (! $classId || ! $sectionId) {
            $class = Classes::firstOrCreate(['name' => 'English Language']);
            $section = Section::firstOrCreate(['name' => 'A']);
            $classId = $class->id;
            $sectionId = $section->id;

            if ($sessionId) {
                $setup = ClassSetup::firstOrCreate([
                    'session_id' => $sessionId,
                    'classes_id' => $classId,
                ]);

                ClassSetupChildren::firstOrCreate([
                    'class_setup_id' => $setup->id,
                    'section_id' => $sectionId,
                ]);
            }
        }

        return [$sessionId, $classId, $sectionId];
    }
}
