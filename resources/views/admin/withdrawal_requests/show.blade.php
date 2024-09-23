@extends('layouts.admin')
@section('content')
<div class="col-12 p-3">
    <div class="col-12 col-lg-12 p-0 ">
        <form id="validate-form" class="row" enctype="multipart/form-data" method="POST" action="{{route('admin.withdrawal_requests.update',$WithdrawalRequest)}}">
            @csrf
            @method("PUT")
            <div class="col-12 col-lg-8 p-0 main-box">
                <div class="col-12 px-0">
                    <div class="col-12 px-3 py-3">
                        <span class="fas fa-info-circle"></span> معاينة طلب السحب
                    </div>
                    <div class="col-12 divider" style="min-height: 2px;"></div>
                </div>
             
                
                <div class="col-12 p-3 row">
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                             المستخدم 
                        </div>
                        <div class="col-12 pt-3">
                            <input type="text" disabled name="" required maxlength="190" class="form-control" value="{{$WithdrawalRequest->user->name}}" placeholder="مثال: تصميم الجرافيك">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                        المبلغ
                        </div>
                        <div class="col-12 pt-3">
                            <input type="text" name="" disabled required maxlength="190" class="form-control" value="{{$WithdrawalRequest->amount}}" placeholder="مثال: التصميم الجرافيكي">
                        </div>
                    </div>
                      <div class="col-12  p-2">
                        <div class="col-12">
                            تفاصيل السحب
                   
                        </div>
                        <div class="col-12 pt-3">
                            <textarea disabled  name="" class=" with-file-explorer">{{$WithdrawalRequest->payment_details}}</textarea>
                        </div>
                    </div>
                                @if($WithdrawalRequest->status=='pending')


                     <div class="col-12 pt-3">
                     <div class="col-12">
                             موافقة أو رفض طلب السحب
                   
                        </div>
                            <select class="form-control select2-select" name="status" required  size="1" style="height:30px;opacity: 0;">
                              <option {{$WithdrawalRequest->status=='pending' ? 'selected':''}} value="pending">قيد الإنتظار</option>
                               <option {{$WithdrawalRequest->status=='approved' ? 'selected':''}} value="approved">موافقة</option>
				               <option {{$WithdrawalRequest->status=='rejected' ? 'selected':''}} value="rejected">رفض</option>
                            </select>
                        </div>
                      <div class="col-12 p-2">
                        <div class="col-12">
رفع صورة تأكيد السحب                        </div>
                        <div class="col-12 pt-3">
                            <input type="file" name="image_confirm" class="filepond" accept="image/*">
                        </div>
                        <div class="col-12 pt-3">
                        </div>
                    </div>
                    @else
                      <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                        حالة الطلب
                        </div>
                        <div class="col-12 pt-3">
                        @php
    $statusTranslations = [
        'approved' => 'موافقة',
        'rejected' => 'مرفوض',
        'pending' => 'قيد الانتظار'
    ];
@endphp

                            <input type="text" name="" disabled required maxlength="190" class="form-control" value="{{ $statusTranslations[$WithdrawalRequest->status] ?? 'غير معروف' }}" placeholder="مثال: التصميم الجرافيكي">
                        </div>
                    </div>

                     <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                         صورة تاكيد الطلب 
                        </div>
                        <div class="col-12 pt-3">
                        <img width="100px" height="100px" src={{asset('storage/'.$WithdrawalRequest->image_confirm)}}>
                        </div>
                    </div>

                    @endif
                  
                   
                  
                  
                </div>
                    
              
            </div>
            <div class="col-12 p-3">
            @if($WithdrawalRequest->status=='pending')
                <button class="btn btn-success" id="submitEvaluation">حفظ</button>
            @endif
            </div>
        </form>
    </div>
</div>
@endsection
