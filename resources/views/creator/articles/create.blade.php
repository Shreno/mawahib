@extends('layouts.creator')
@section('content')
<div class="col-12 p-3">
    <div class="col-12 col-lg-12 p-0 ">
        <form id="validate-form" class="row" enctype="multipart/form-data" method="POST" action="{{route('user.articles.store')}}">
            @csrf
            <input type="hidden" name="temp_file_selector" id="temp_file_selector" value="{{uniqid()}}">
            <div class="col-12 col-lg-8 p-0 main-box">
                <div class="col-12 px-0">
                    <div class="col-12 px-3 py-3">
                        <span class="fas fa-info-circle"></span> إضافة جديد
                    </div>
                    <div class="col-12 divider" style="min-height: 2px;"></div>
                </div>
                <div class="col-12 p-3 row">
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                            القسم 
                        </div>
                        <div class="col-12 pt-3">
                            <select class="form-control select2-select" name="category_id[]" required multiple size="1" style="height:30px;opacity: 0;">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if(old('category_id')==$category->id) selected @endif>{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                            الوسوم
                        </div>
                        <div class="col-12 pt-3">
                            <select class="form-control select2-select" name="tag_id[]"  multiple size="1" style="height:30px;opacity: 0;">
                                @foreach($tags as $tag)
                                <option value="{{$tag->id}}">{{$tag->tag_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{--  --}}
                  



                    {{--  --}}
                    <div class="col-12">
                    </div>
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                            الرابط (slug)
                        </div>
                        <div class="col-12 pt-3">
                            <input type="text" name="slug" required maxlength="190" class="form-control" value="{{old('slug')}}">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                            العنوان
                        </div>
                        <div class="col-12 pt-3">
                            <input type="text" name="title" required maxlength="190" class="form-control" value="{{old('title')}}">
                        </div>
                    </div>
                    <div class="col-12 p-2">
                        <div class="col-12">
                            الصورة الرئيسية
                        </div>
                        <div class="col-12 pt-3">
                            <input type="file" name="main_image" class="filepond" accept="image/*">
                        </div>
                        <div class="col-12 pt-3">
                        </div>
                    </div>
                    <div class="col-12  p-2">
                        <div class="col-12">
                            الوصف
                        </div>
                        <div class="col-12 pt-3">
                            <textarea name="description" class="editor with-file-explorer">{{old('description')}}</textarea>
                        </div>
                    </div>
                    <div class="col-12 p-2">
                        <div class="col-12">
                            ميتا الوصف
                        </div>
                        <div class="col-12 pt-3">
                            <textarea name="meta_description" class="form-control" style="min-height:150px">{{old('meta_description')}}</textarea>
                        </div>
                    </div>
                    <div class="col-12 p-2">
                        <div class="col-12">
                            مميز
                        </div>
                        <div class="col-12 pt-3">
                            <select class="form-control" name="is_featured">
                                <option @if(old('is_featured')=="0" ) selected @endif value="0">لا</option>
                                <option @if(old('is_featured')=="1" ) selected @endif value="1">نعم</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h4>المعلومات</h4>
                    <div class="card-header text-center">
                        <h6>أدخل رابط التطبيق</h6>
                        <input type="text" name="app_link" class="form-control" placeholder="أدخل رابط التحميل من Google Play" value="{{ old('app_link') }}" required>
                    </div>
                
                    <div class="card-body">
                        <div class="form-group">
                            <label>اسم التطبيق</label>
                            <input type="text" name="app_name" class="form-control" value="{{ old('app_name') }}" required>
                        </div>
                
                        <div class="form-group">
                            <label>وصف التطبيق</label>
                            <textarea name="app_description" class="form-control" rows="3">{{ old('app_description') }}</textarea>
                        </div>
                
                        <div class="form-group">
                            <label>عدد مرات التحميل</label>
                            <input type="number" name="download_count" class="form-control" value="{{ old('download_count') }}">
                        </div>
                
                        <div class="form-group">
                            <label>سعر التطبيق</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}" step="0.01">
                        </div>
                
                        <div class="form-group">
                            <label>تقييم التطبيق</label>
                            <input type="number" name="rating" class="form-control" min="0" max="5" step="0.1" value="{{ old('rating') }}">
                        </div>
                
                        <div class="form-group">
                            <label>المطور</label>
                            <input type="text" name="developer" class="form-control" value="{{ old('developer') }}">
                        </div>
                
                        <div class="form-group">
                            <label>التصنيف</label>
                            <input type="text" name="category" class="form-control" value="{{ old('category') }}">
                        </div>
                
                        <div class="form-group">
                            <label>آخر إصدار</label>
                            <input type="text" name="version" class="form-control" value="{{ old('version') }}">
                        </div>
  
                </div>
            </div>
            <div class="col-12 p-3">
                <button class="btn btn-success" id="submitEvaluation">حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection
