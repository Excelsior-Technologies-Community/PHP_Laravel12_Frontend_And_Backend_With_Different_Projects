<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@inquirypro.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '+91 98765 43210',
            ]
        );

        $customers = [];
        for ($i = 1; $i <= 5; $i++) {
            $customers[] = User::updateOrCreate(
                ['email' => "customer$i@example.com"],
                [
                    'name' => "Customer $i",
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                    'phone' => '+91 98765 4321' . $i,
                ]
            );
        }

        $categories = [
            ['name' => 'Technical Support', 'slug' => 'technical-support', 'description' => 'Help with technical issues and bugs', 'icon' => 'fa-tools'],
            ['name' => 'Sales Inquiry', 'slug' => 'sales-inquiry', 'description' => 'Questions about pricing and services', 'icon' => 'fa-shopping-cart'],
            ['name' => 'Feedback', 'slug' => 'feedback', 'description' => 'Share your feedback and suggestions', 'icon' => 'fa-comment-dots'],
            ['name' => 'Complaint', 'slug' => 'complaint', 'description' => 'Report an issue or complaint', 'icon' => 'fa-exclamation-circle'],
            ['name' => 'Partnership', 'slug' => 'partnership', 'description' => 'Business partnership opportunities', 'icon' => 'fa-handshake'],
            ['name' => 'General Inquiry', 'slug' => 'general-inquiry', 'description' => 'Any other general questions', 'icon' => 'fa-question-circle'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $subjects = [
            'Login issue on mobile app',
            'Pricing for enterprise plan',
            'Great service experience',
            'Payment gateway error',
            'API integration help needed',
            'Account activation problem',
            'Feature request for dashboard',
            'Billing discrepancy',
            'Security concern report',
            'Reseller program inquiry',
        ];

        $messages = [
            'I am unable to login to the mobile app since yesterday. It keeps showing invalid credentials error.',
            'Could you please share the pricing details for the enterprise plan? We are a team of 50+ users.',
            'I wanted to express my gratitude for the excellent support team. They resolved my issue within hours.',
            'I was charged twice for my last subscription. Please check and refund the extra amount.',
            'I need help integrating your API with my Laravel application. Can you provide documentation?',
            'My account is not activated yet even after clicking the verification link multiple times.',
            'It would be great if you could add a dark mode option to the dashboard. Many users would appreciate it.',
            'My invoice shows a different amount than what was discussed during the sales call. Please clarify.',
            'I noticed a potential security issue where user data is exposed in the API response without authentication.',
            'I am interested in becoming a reseller for your product. Please share the partnership details.',
        ];

        $statuses = ['pending', 'in_progress', 'resolved', 'closed'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        for ($i = 0; $i < 10; $i++) {
            Inquiry::updateOrCreate(
                ['reference_number' => 'INQ-' . strtoupper(Str::random(8))],
                [
                    'name' => "Customer " . ($i + 1),
                    'email' => "customer" . ($i + 1) . "@example.com",
                    'phone' => '+91 98765 4321' . ($i + 1),
                    'subject' => $subjects[$i],
                    'message' => $messages[$i],
                    'category_id' => Category::inRandomOrder()->first()->id,
                    'tracking_token' => Str::random(32),
                    'status' => $statuses[array_rand($statuses)],
                    'priority' => $priorities[array_rand($priorities)],
                    'is_read' => $i < 7,
                    'user_id' => $customers[array_rand($customers)]->id,
                ]
            );
        }

        $blogs = [
            [
                'title' => 'How to Submit an Effective Inquiry',
                'excerpt' => 'Learn the best practices for submitting inquiries that get quick responses from our support team.',
                'content' => 'When submitting an inquiry, make sure to provide as much detail as possible. Include relevant screenshots, error messages, and steps to reproduce the issue. This helps our team understand your problem quickly and provide an accurate solution.',
                'author' => 'Admin User',
                'is_published' => true,
            ],
            [
                'title' => 'Understanding Inquiry Statuses',
                'excerpt' => 'A comprehensive guide to understanding the different statuses of your inquiries.',
                'content' => 'Your inquiry can have several statuses: Pending, In Progress, Resolved, and Closed. Each status indicates the current state of your request and helps you track progress.',
                'author' => 'Admin User',
                'is_published' => true,
            ],
            [
                'title' => 'Tips for Better Communication',
                'excerpt' => 'Improve your communication with our support team using these simple tips.',
                'content' => 'Clear communication is key to resolving issues quickly. Be specific about your problem, provide context, and respond promptly to follow-up questions from our team.',
                'author' => 'Admin User',
                'is_published' => true,
            ],
            [
                'title' => 'New Features Coming Soon',
                'excerpt' => 'Exciting new features are on the way! Here is what you can expect in the next update.',
                'content' => 'We are working on several exciting features including advanced analytics, team collaboration tools, and mobile app improvements. Stay tuned for the upcoming release.',
                'author' => 'Admin User',
                'is_published' => true,
            ],
            [
                'title' => 'Customer Success Stories',
                'excerpt' => 'Read how our customers are achieving success with InquiryPro.',
                'content' => 'Our customers have been achieving remarkable results using InquiryPro. From reducing response times to improving customer satisfaction, discover how InquiryPro is making a difference.',
                'author' => 'Admin User',
                'is_published' => false,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['title' => $blog['title']],
                [
                    'slug' => Str::slug($blog['title']) . '-' . time() . '-' . rand(100, 999),
                    'excerpt' => $blog['excerpt'],
                    'content' => $blog['content'],
                    'author' => $blog['author'],
                    'is_published' => $blog['is_published'],
                ]
            );
        }

        $testimonials = [
            ['name' => 'Rajesh Kumar', 'position' => 'CTO', 'company' => 'TechSolutions', 'message' => 'InquiryPro transformed how we handle customer support. Response times reduced by 60%.', 'rating' => 5],
            ['name' => 'Priya Sharma', 'position' => 'Manager', 'company' => 'Global Services', 'message' => 'The best inquiry management system we have used. Highly recommended!', 'rating' => 5],
            ['name' => 'Amit Patel', 'position' => 'Director', 'company' => 'StartupHub', 'message' => 'Easy to use and very efficient. Our team loves the dashboard features.', 'rating' => 4],
            ['name' => 'Sneha Joshi', 'position' => 'CEO', 'company' => 'InnovateCo', 'message' => 'Customer support has never been this organized. InquiryPro is a game changer.', 'rating' => 5],
            ['name' => 'Vikram Singh', 'position' => 'Head of Ops', 'company' => 'ScaleUp Inc', 'message' => 'The analytics and reporting features give us great insights into our support performance.', 'rating' => 4],
            ['name' => 'Meera Reddy', 'position' => 'VP Sales', 'company' => 'GrowthLabs', 'message' => 'Our sales team uses InquiryPro to track leads. It has improved our conversion rates significantly.', 'rating' => 5],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name'], 'company' => $testimonial['company']],
                $testimonial
            );
        }

        $faqs = [
            ['question' => 'How do I submit an inquiry?', 'answer' => 'You can submit an inquiry by filling out the contact form on our homepage. Simply enter your name, email, subject, and message, and our team will get back to you within 24-48 hours.', 'category' => 'General', 'sort_order' => 1],
            ['question' => 'How can I track my inquiry status?', 'answer' => 'Use the reference number sent to your email after submission. Enter it on the Track Inquiry page along with your email to see the current status.', 'category' => 'General', 'sort_order' => 2],
            ['question' => 'What is the response time?', 'answer' => 'We aim to respond to all inquiries within 24-48 business hours. Urgent issues are prioritized and may receive faster responses.', 'category' => 'Support', 'sort_order' => 3],
            ['question' => 'Can I update my inquiry after submission?', 'answer' => 'Yes, you can add additional details by replying to the confirmation email or contacting our support team with your reference number.', 'category' => 'Support', 'sort_order' => 4],
            ['question' => 'What file types are supported for attachments?', 'answer' => 'We support PDF, DOC, DOCX, JPG, JPEG, and PNG files. Maximum file size is 2MB per attachment.', 'category' => 'Technical', 'sort_order' => 5],
            ['question' => 'Is my data secure?', 'answer' => 'Yes, we use industry-standard encryption and security practices to protect your data. All communications are encrypted and stored securely.', 'category' => 'Technical', 'sort_order' => 6],
            ['question' => 'How do I create an account?', 'answer' => 'Click on the Register button in the top navigation, fill in your details, and verify your email address to create an account.', 'category' => 'Account', 'sort_order' => 7],
            ['question' => 'Can I delete my inquiry?', 'answer' => 'Yes, you can request deletion of your inquiry by contacting our support team. Please note that some data may be retained for legal compliance.', 'category' => 'Privacy', 'sort_order' => 8],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
