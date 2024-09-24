@extends('layouts.editor')
@section('content')
<div class="col-12 p-3">
    <div class="col-12 col-lg-12 p-0 ">
         
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
                      <div class="col-12 col-lg-6  p-2">
                        <div class="col-12">
                            تفاصيل السحب
                   
                        </div>
                        <div class="col-12 pt-3">
                            <textarea disabled  name="" class=" with-file-explorer">{{$WithdrawalRequest->payment_details}}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                            طريقة السحب 
                        </div>
                        <div class="col-12 pt-3">
        <select name="payment_method" class="form-control select2-select" required>
        <option value="Zain Cash" {{ $WithdrawalRequest->payment_method == 'Zain Cash' ? 'selected' : '' }}>زين كاش</option>
    <option value="USDT Binance" {{ $WithdrawalRequest->payment_method == 'USDT Binance' ? 'selected' : '' }}>USDT Binance</option>
    <option value="Payoneer" {{ $WithdrawalRequest->payment_method == 'Payoneer' ? 'selected' : '' }}>بيونير</option>
        </select>
        </div>
    </div>               
                
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

                            <input disabled type="text" name="" disabled required maxlength="190" class="form-control" value="{{ $statusTranslations[$WithdrawalRequest->status] ?? 'غير معروف' }}" placeholder="مثال: التصميم الجرافيكي">
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

                    
                  
                   
                  
                  
                </div>
                    
              
            </div>
            <div class="col-12 p-3">
            
            </div>
    </div>
</div>
@endsection
