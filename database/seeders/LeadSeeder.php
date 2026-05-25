<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\User;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : null;

        $interiorType = \App\Models\LeadType::create([
            'name' => 'Interior Design',
            'slug' => 'interior_design',
            'form_schema' => [
                ['name' => 'residential_type', 'label' => 'Residential Type', 'type' => 'select', 'options' => ['Independent house', 'Renovation', 'G+1+2'], 'required' => false],
                ['name' => 'unit_configuration', 'label' => 'Unit Configuration', 'type' => 'select', 'options' => ['1BHK', '2BHK', '3BHK', 'Villa', 'Duplex'], 'required' => false],
                ['name' => 'budget', 'label' => 'Budget / Price Range', 'type' => 'text', 'required' => false],
            ]
        ]);

        $itProjectsType = \App\Models\LeadType::create([
            'name' => 'IT Projects',
            'slug' => 'it_projects',
            'form_schema' => [
                ['name' => 'linkedin_profile', 'label' => 'LinkedIn Profile', 'type' => 'text', 'required' => false],
                ['name' => 'skill_set', 'label' => 'Skill Set', 'type' => 'textarea', 'required' => false],
                ['name' => 'technology', 'label' => 'Technology', 'type' => 'select', 'options' => ['PHP', 'Laravel', 'React', 'Node.js', 'Vue.js'], 'required' => false],
                ['name' => 'budget', 'label' => 'Budget', 'type' => 'text', 'required' => false],
                ['name' => 'project_duration', 'label' => 'Project Duration', 'type' => 'text', 'required' => false],
            ]
        ]);

        $leads = [
            [
                'name' => 'Karan Singh',
                'email' => 'karan.s@example.com',
                'phone' => '9876543111',
                'city' => 'Hyderabad',
                'state' => 'Telangana',
                'lead_type_id' => $interiorType->id,
                'source' => 'google',
                'status' => 'new',
                'custom_data' => [
                    'residential_type' => 'Independent house',
                    'unit_configuration' => '3BHK',
                    'budget' => '30 Lakhs',
                ]
            ],
            [
                'name' => 'Riya Desai',
                'email' => 'riya.desai@example.com',
                'phone' => '9988776655',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'lead_type_id' => $interiorType->id,
                'source' => 'facebook',
                'status' => 'interested',
                'custom_data' => [
                    'residential_type' => 'Renovation',
                    'unit_configuration' => '2BHK',
                    'budget' => '15 Lakhs',
                ]
            ],
            [
                'name' => 'Rahul Verma',
                'email' => 'rahul.v@techstartup.com',
                'phone' => '9123456789',
                'city' => 'Bengaluru',
                'state' => 'Karnataka',
                'lead_type_id' => $itProjectsType->id,
                'source' => 'linkedin',
                'status' => 'new',
                'custom_data' => [
                    'linkedin_profile' => 'linkedin.com/in/rahulverma',
                    'skill_set' => 'Frontend development, API integration',
                    'technology' => 'React',
                    'budget' => '$5,000',
                    'project_duration' => '3 Months',
                ]
            ],
            [
                'name' => 'Sonia Kapoor',
                'email' => 'sonia.kapoor@agency.com',
                'phone' => '9090908888',
                'city' => 'Delhi',
                'state' => 'Delhi',
                'lead_type_id' => $itProjectsType->id,
                'source' => 'direct',
                'status' => 'demo_scheduled',
                'custom_data' => [
                    'linkedin_profile' => 'linkedin.com/in/soniakapoor',
                    'skill_set' => 'Full stack development, e-commerce',
                    'technology' => 'Laravel',
                    'budget' => '$10,000',
                    'project_duration' => '6 Months',
                ]
            ]
        ];

        foreach ($leads as $leadData) {
            $leadData['created_by'] = $adminId;
            Lead::create($leadData);
        }
    }
}
