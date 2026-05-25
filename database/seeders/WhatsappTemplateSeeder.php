<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WhatsappTemplate;

class WhatsappTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => '👋 Initial Greeting',
                'body' => "Hi {name}! 👋 I'm {bde} from Elements HR. I noticed your interest in {category}. Would you like to know more about the program?",
            ],
            [
                'name' => '🔄 Follow-Up Reminder',
                'body' => "Hi {name}, hope you're doing well! Just following up on our previous conversation about {category}. Do you have any questions I can help with?",
            ],
            [
                'name' => '🎓 Demo Invitation',
                'body' => "Hi {name}! 🎓 We'd love to invite you for a free demo session of our {category} program. Would you be available this week? Let me know your preferred date and time.",
            ],
            [
                'name' => '📚 Course Details',
                'body' => "Hi {name}, here are the details for {category}:\n\n📚 Program designed for career growth\n💰 Affordable fee structure\n📅 Next batch starting soon!\n\nShall I reserve a seat for you?",
            ],
            [
                'name' => '💬 Quick Check-In',
                'body' => "Hi {name}, quick check-in! 😊 Have you had a chance to think about the {category} program? Happy to answer any questions.",
            ],
        ];

        foreach ($templates as $template) {
            WhatsappTemplate::create([
                'name' => $template['name'],
                'body' => $template['body'],
                'is_active' => true,
            ]);
        }
    }
}
