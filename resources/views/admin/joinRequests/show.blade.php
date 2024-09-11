@extends('layouts.admin')
@section('content')
<div class="col-12 py-0 px-3 row">
    <div class="col-12  pt-4" style="background: #fff;min-height: 80vh">
        <div class="col-9 px-3">
            <h5>عرض طلب الإنضمام رقم {{$joinRequest->id}} القادمة من {{$joinRequest->name}}</h5>
        </div>
		<div class="col-3 px-3">
            <h5> حالة الطلب :
				@if($joinRequest->status=='pending')
				قيد التنفيذ
				@can('join-requests-update')
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
					تغير حالة الطلب
				  </button>
				@endcan
				

				@elseif($joinRequest->status=='approved')
				تم الموافقة

				@elseif($joinRequest->status=="rejected")
				تم الرفض
				@can('join-requests-update')
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
					تغير حالة الطلب
				  </button>
				@endcan

				@endif
			</h5>
        </div>

		<div class="row">

			<div class="form-group col-md-6">
				<label for="name">الاسم بالكامل *</label>
				<input type="text" name="name" id="name" class="form-control" disabled value="{{ $joinRequest->name }}" required>
			</div>
	
			<div class="form-group col-md-6">
				<label for="email">البريد *</label>
				<input type="email" name="email" id="email" class="form-control" disabled value="{{ $joinRequest->email }}" required>
			</div>
	
			<div class="form-group col-md-6">
				<label for="phone">رقم الهاتف *</label>
				<input type="text" name="phone" id="phone" class="form-control" disabled value="{{ $joinRequest->phone }}" required>
			</div>
	
			<div class="form-group col-md-6">
				<label for="followers">عدد المتابعين الإجمالي في كل المنصات *</label>
				<input type="number" name="followers" id="followers"disabled class="form-control" value="{{ $joinRequest->followers }}" required>
			</div>
	
			<div class="form-group col-md-6">
				<label for="platform_link">رابط حسابك على أكبر منصة لديك متابعين بها *</label>
				<input type="url" name="platform_link" id="platform_link"disabled class="form-control" value="{{$joinRequest->platform_link }}" required>
			</div>
	
			<div class="form-group col-md-6">
				<label for="youtube_link">رابط قناتك على يوتيوب (اختياري)</label>
				<input type="url" name="youtube_link" id="youtube_link"disabled class="form-control" value="{{ $joinRequest->youtube_link }}">
			</div>
	
			<div class="form-group col-md-6">
				<label for="facebook_link">رابط حسابك على فيسبوك (اختياري)</label>
				<input type="url" name="facebook_link" id="facebook_link"disabled class="form-control" value="{{ $joinRequest->facebook_link }}">
			</div>
	
			<div class="form-group col-md-6">
				<label for="tiktok_link">رابط حسابك على تيك توك (اختياري)</label>
				<input type="url" name="tiktok_link" id="tiktok_link" class="form-control" value="{{ $joinRequest->tiktok_link }}">
			</div>
	
			<div class="form-group col-md-12">
				<label for="notes">ملاحظاتك (اختياري)</label>
				<textarea name="notes" id="notes" disabled class="form-control">{{ $joinRequest->notes }}</textarea>
			</div>
		</div>
      
       
     
     
    </div>
</div>
{{--  --}}
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">تغير حالة طلب الإنضمام</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form  method="POST" action="{{route('admin.join-requests.update',$joinRequest->id)}}" >
			@csrf
            @method("PUT")
		<div class="modal-body">
			<select name="status" class="form-control" id="">
				<option value="pending">قيد التنفيذ</option>
				<option value="approved">موافقة</option>
				<option value="rejected">رفض</option>

			</select>
			
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">غلق</button>
		  <button type="submit" class="btn btn-primary">تغير</button>
		</div>
	  </div>
	</div>
  </div>




{{--  --}}
@endsection
