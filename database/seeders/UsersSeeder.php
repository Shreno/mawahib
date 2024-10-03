<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wallet;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::count();
        if($users==0)
           $admin= \App\Models\User::create([
                'name'=>"مسؤول",
                'email'=>"admin@admin.com",
                'email_verified_at'=>date("Y-m-d h:i:s"), 
                'password'=>bcrypt('password')
            ]);
            // 
            $main_image = $admin->addMediaFromUrl("https://loremflickr.com/700/500/nature")->toMediaCollection('avatar');
            $admin->update(['avatar'=>$main_image->id.'/'.$main_image->file_name]);

            // 
            for($i =0 ; $i<5 ;$i++){

            $user=\App\Models\User::create([
                'name' => "صانع محتوى",
                'email' => "creator_".$i."@gmail.com", // تأكد من استخدام بريد إلكتروني فريد
                'user_type'=>'creator',
                'email_verified_at' => date("Y-m-d h:i:s"), 
                'password'=>bcrypt('password'),
                'bio'=>'صانع محتوى متخصص في مراجعات الكتب. أهدف إلى تسليط الضوء على الأعمال الأدبية المميزة.',
                'followers'=>'1000',
                "platform_link"=>'https://www.youtube.com/',
                "youtube_link"=>'https://www.youtube.com/',
                "facebook_link"=>'https://www.facebook.com/',
                
                "tiktok_link"=>'https://www.tiktok.com/en/',
            ]);
            // 
            $main_image = $user->addMediaFromUrl("https://loremflickr.com/700/500/nature")->toMediaCollection('avatar');
            $user->update(['avatar'=>$main_image->id.'/'.$main_image->file_name]);

            // 
            Wallet::create([
                'user_id' => $user->id, // ربط المحفظة بالمستخدم
                'balance' => 0, // يمكنك ضبط الرصيد الابتدائي كما تريد
            ]);
        }
    }

}
