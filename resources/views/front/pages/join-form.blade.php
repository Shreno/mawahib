@extends('layouts.app',['page_title'=>"تواصل معنا"])
@section('content')

<div class="container">
    <h2>الانضمام إلى الموقع</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('join.submit') }}" method="POST">
        @csrf
        <div class="row">

        <div class="form-group col-md-6">
            <label for="name">الاسم بالكامل *</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="email">البريد *</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="phone">رقم الهاتف *</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="followers">عدد المتابعين الإجمالي في كل المنصات *</label>
            <input type="number" name="followers" id="followers" class="form-control" value="{{ old('followers') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="platform_link">رابط حسابك على أكبر منصة لديك متابعين بها *</label>
            <input type="url" name="platform_link" id="platform_link" class="form-control" value="{{ old('platform_link') }}" required>
        </div>

        <div class="form-group col-md-6">
            <label for="youtube_link">رابط قناتك على يوتيوب (اختياري)</label>
            <input type="url" name="youtube_link" id="youtube_link" class="form-control" value="{{ old('youtube_link') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="facebook_link">رابط حسابك على فيسبوك (اختياري)</label>
            <input type="url" name="facebook_link" id="facebook_link" class="form-control" value="{{ old('facebook_link') }}">
        </div>

        <div class="form-group col-md-6">
            <label for="tiktok_link">رابط حسابك على تيك توك (اختياري)</label>
            <input type="url" name="tiktok_link" id="tiktok_link" class="form-control" value="{{ old('tiktok_link') }}">
        </div>

        <div class="form-group col-md-12">
            <label for="notes">ملاحظاتك (اختياري)</label>
            <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>
    </div>
    <br>

        <button type="submit" class="btn btn-primary">إرسال طلب الانضمام</button>
    </form>
</div>









@endsection