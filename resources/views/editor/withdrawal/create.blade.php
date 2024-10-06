@extends('layouts.editor')

@section('content')
<div class="col-12 p-3">
    <div class="col-12 col-lg-12 p-0 ">
    <form method="POST" class="row" action="{{ route('editor.withdrawal_requests.store') }}">
    @csrf
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
                            المبلغ 
                        </div>
                        <div class="col-12 pt-3">
<input class="form-control" type="text" name="amount" pattern="^\d+(\.\d+)?$" step="0.01" min="0.01" required>
        </div>
    </div>

     <div class="col-12 p-3 row">
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                            طريقة السحب 
                        </div>
                        <div class="col-12 pt-3">
        <select name="payment_method" class="form-control select2-select" required>
            <option value="Zain Cash">زين كاش</option>
            <option value="USDT Binance">USDT Binance</option>
            <option value="Payoneer">بيونير</option>
        </select>
        </div>
    </div>

   <div class="col-12 p-3 row">
                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                             تفاصيل السحب 
                        </div>
                        <div class="col-12 pt-3">
        <input class="form-control" type="text" name="payment_details">
        </div>
    </div>

        <div class="col-12 p-3">
                <button class="btn btn-success" type="submit">حفظ</button>
            </div>
        </div>

</form>



    </div>
 </div>



@endsection