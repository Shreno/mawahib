<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    // السماح للإداريين بعرض جميع المقالات
    public function viewAny(User $user)
    {
        return $user->hasRole('superadmin')|| $user->hasRole('admin') || $user->hasRole('customer_support');
    }

    // السماح للمستخدم بعرض المقال الخاص به فقط
    public function view(User $user, Article $article)
    {
        return $user->hasRole('superadmin')|| $user->hasRole('admin') || $user->hasRole('customer_support') || $user->id === $article->user_id;
    }
}
