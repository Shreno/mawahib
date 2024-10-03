<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                "tag_name" => "إدارة البريد الإلكتروني",
                "arabic_name" => "إدارة البريد الإلكتروني",
                "english_name" => "Email Handling",
                "slug" => "email-handling",
            ],
            [
                "tag_name" => "الفوتوشوب",
                "arabic_name" => "الفوتوشوب",
                "english_name" => "Photoshop",
                "slug" => "photoshop",
            ],
            [
                "tag_name" => "العربية",
                "arabic_name" => "العربية",
                "english_name" => "Arabic",
                "slug" => "arabic",
            ],
            [
                "tag_name" => "الإنجليزية",
                "arabic_name" => "الإنجليزية",
                "english_name" => "English",
                "slug" => "english",
            ],
            [
                "tag_name" => "تصميم الفوتوشوب",
                "arabic_name" => "تصميم الفوتوشوب",
                "english_name" => "Photoshop Design",
                "slug" => "photoshop-design",
            ],
          
            [
                "tag_name" => "تصميم الشعارات",
                "arabic_name" => "تصميم الشعارات",
                "english_name" => "Logo Design",
                "slug" => "logo-design",
            ],
            [
                "tag_name" => "تصميم الجرافيك",
                "arabic_name" => "تصميم الجرافيك",
                "english_name" => "Graphic Design",
                "slug" => "graphic-design",
            ],
            [
                "tag_name" => "إعادة كتابة المقالات",
                "arabic_name" => "إعادة كتابة المقالات",
                "english_name" => "Article Rewriting",
                "slug" => "article-rewriting",
            ],
            [
                "tag_name" => "التصميم الإبداعي",
                "arabic_name" => "التصميم الإبداعي",
                "english_name" => "Creative Design",
                "slug" => "creative-design",
            ],
            [
                "tag_name" => "الترجمة",
                "arabic_name" => "الترجمة",
                "english_name" => "Translation",
                "slug" => "translation",
            ],
            [
                "tag_name" => "تصميم الإعلانات",
                "arabic_name" => "تصميم الإعلانات",
                "english_name" => "Advertisement Design",
                "slug" => "advertisement-design",
            ],
            [
                "tag_name" => "إدخال البيانات ",
                "arabic_name" => "إدخال البيانات ",
                "english_name" => "Data Entry",
                "slug" => "data-entry",
            ],
           
            [
                "tag_name" => "تعديل الصور",
                "arabic_name" => "تعديل الصور",
                "english_name" => "Photo Editing",
                "slug" => "photo-editing",
            ],
            [
                "tag_name" => "البحث في الويب",
                "arabic_name" => "البحث في الويب",
                "english_name" => "Web Search",
                "slug" => "web-search",
            ],
            [
                "tag_name" => "البحث على الإنترنت",
                "arabic_name" => "البحث على الإنترنت",
                "english_name" => "Internet Research",
                "slug" => "internet-research",
            ],
            [
                "tag_name" => "Microsoft Excel",
                "arabic_name" => "",
                "english_name" => "Microsoft Excel",
                "slug" => "excel",
            ],
            [
                "tag_name" => "تصميم البوسترات",
                "arabic_name" => "تصميم البوسترات",
                "english_name" => "Poster Design",
                "slug" => "poster-design",
            ],
           
            [
                "tag_name" => "كتابة المحتوى",
                "arabic_name" => "كتابة المحتوى",
                "english_name" => "Content Writing",
                "slug" => "content-writing",
            ],
            [
                "tag_name" => "أندرويد",
                "arabic_name" => "أندرويد",
                "english_name" => "Android",
                "slug" => "android",
            ],
          
            [
                "tag_name" => "تصميم البنرات",
                "arabic_name" => "تصميم البنرات",
                "english_name" => "Banner Design",
                "slug" => "banner-design",
            ],
            [
                "tag_name" => "PDF",
                "arabic_name" => "",
                "english_name" => "PDF",
                "slug" => "pdf",
            ],
            [
                "tag_name" => "المقالات",
                "arabic_name" => "المقالات",
                "english_name" => "Articles",
                "slug" => "articles",
            ],
            [
                "tag_name" => "التسويق عبر الإنترنت",
                "arabic_name" => "التسويق عبر الإنترنت",
                "english_name" => "Internet Marketing",
                "slug" => "internet-marketing",
            ],
            [
                "tag_name" => "تصميم الأفكار",
                "arabic_name" => "تصميم الأفكار",
                "english_name" => "Concept Design",
                "slug" => "concept-design",
            ],
            [
                "tag_name" => "الكتابة على الإنترنت",
                "arabic_name" => "الكتابة على الإنترنت",
                "english_name" => "Online Writing",
                "slug" => "online-writing",
            ],
            [
                "tag_name" => "التدقيق اللغوي",
                "arabic_name" => "التدقيق اللغوي",
                "english_name" => "Proofreading",
                "slug" => "proofreading",
            ],
            [
                "tag_name" => "تصميم المواقع الإلكترونية",
                "arabic_name" => "تصميم المواقع الإلكترونية",
                "english_name" => "Website Design",
                "slug" => "website-design",
            ],
            [
                "tag_name" => "إنتاج الفيديو",
                "arabic_name" => "إنتاج الفيديو",
                "english_name" => "Video Production",
                "slug" => "video-production",
            ],
            [
                "tag_name" => "تصميم الدعوات",
                "arabic_name" => "تصميم الدعوات",
                "english_name" => "Invitation Design",
                "slug" => "invitation-design",
            ],
            [
                "tag_name" => "تسويق الفيسبوك",
                "arabic_name" => "تسويق الفيسبوك",
                "english_name" => "Facebook Marketing",
                "slug" => "facebook-marketing",
            ],
            [
                "tag_name" => "البحث",
                "arabic_name" => "البحث",
                "english_name" => "Research",
                "slug" => "research",
            ],
            [
                "tag_name" => "التسويق",
                "arabic_name" => "التسويق",
                "english_name" => "Marketing",
                "slug" => "marketing",
            ],
            [
                "tag_name" => "الفرنسية",
                "arabic_name" => "الفرنسية",
                "english_name" => "French",
                "slug" => "french",
            ],
            [
                "tag_name" => "التحرير",
                "arabic_name" => "التحرير",
                "english_name" => "Editing",
                "slug" => "editing",
            ],
            [
                "tag_name" => "جافاسكربت",
                "arabic_name" => "جافاسكربت",
                "english_name" => "Javascript",
                "slug" => "javascript",
            ],
            [
                "tag_name" => "Powerpoint",
                "arabic_name" => "",
                "english_name" => "Powerpoint",
                "slug" => "powerpoint",
            ],
            [
                "tag_name" => "كتابة التقارير",
                "arabic_name" => "كتابة التقارير",
                "english_name" => "Report Writing",
                "slug" => "report-writing",
            ],
            [
                "tag_name" => "After Effects",
                "arabic_name" => "",
                "english_name" => "After Effects",
                "slug" => "after-effects",
            ],
        
        ];
        //\App\Models\Tag::truncate();
        \App\Models\Tag::insert( collect($tags)->unique('slug')->all() );

    }
}
