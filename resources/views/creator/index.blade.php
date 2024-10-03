@extends('layouts.creator')
@section('content')
<style type="text/css">
	.footer-cta{
		display:none;
	}
</style>
<div class="col-12" style="min-height:100vh;background:#f4f4f4">
	<div class="col-12 p-0" style="background:#fff">
		        @php $wallet=\App\Models\Wallet::where('user_id',Auth()->user()->id)->first(); @endphp

	
	<div class="container">
		<div class="col-12 p-0 d-flex align-items-center justify-content-center" style="min-height:40vh;">
			<div style="width:800px" class="mx-auto py-8 d-flex align-items-center justify-content-center">
				<div class="text-center">
                
					<div class="col-12 px-0 pb-8 row d-flex justify-content-between">
                    <div class="col-4" style="line-height:1">
                   
                    
						<div class="font-3">إجمالى ارباحك</div>
						<div class="font-10" style="font-weight:bold;color:#1abc9c">
							{{ $totalEarnings }}
						</div>
						
					</div>
                    
					<div class="col-4" style="line-height:1">
                   
                    
						<div class="font-3">أنفقت معنا</div>
						<div class="font-10" style="font-weight:bold;color:#1abc9c">
							{{ isset($wallet) ? $wallet->withdrawn_balance : 0 }}
						</div>
						
					</div>
					<div class="col-4" style="line-height:1">
						<div class="font-3">رصيدك الآن</div>
						<div class="font-10" style="font-weight:bold;color:#1abc9c">
                        {{ isset($wallet) ? $wallet->balance : 0 }}
							
						</div>
					</div>
					</div>
				<a href="{{ route('user.withdrawal_requests.create') }}" class="btn btn-outline-success rounded-pill font-3 px-8" ><span class="fal fa-shop"></span> <i class="fal fa-sack-dollar mx-2 "></i> طلب سحب رصيد الآن</a>
				</div>
				
			</div>
			
		</div>
		
	</div>

	

	</div>
	<div class="col-12">
			<div class="container py-5">
				<div class="col-12 p-0 row d-flex">
					
				
				@if(0)
				<div class="col-12 p-4 mb-3 d-flex align-items-center justify-content-center" style="background: #fff;border-radius: 8px;min-height: 40vh;">
					<div class="col-12 text-center">
						<span class="fal fa-shopping-cart mx-2 font-12 " style="opacity:0.3"></span>
						<div class="col-12 text-center py-3">
							لا توجد طلبات بعد في حسابك
						</div>
						<div class="col-12 p-2 text-center">
							<a href="#" class="btn btn-success rounded-pill font-2 px-8"><span class="fal fa-shop"></span> <i class="fal fa-box-open mx-2 "></i> عرض الخدمات</a>
						</div>
					</div>
						
				</div>
				@else
				
				<div style="background:#ddeaea" class="col-12 col-lg-6 p-2 mb-0">
				<div class="col-12 p-3  row d-flex " style="background: #ddeaea;border-radius: 8px;">
					
					<div class="col font-1">
						<div class="col-12 p-0 row d-flex">
							<div class="col-12 col-lg-12">
								<h5 class="font-1"> إجمالى أرباحك </h5>
								
								
							</div>
							<div class="col-12 col-lg-6">
                            					<p>	<h1>{{ $totalEarnings }}</h1>  دولار أمريكى	</p>

							</div>

						</div>
						
						
					</div>
					
					
				</div>
				</div>
                {{--  --}}

                <div class="col-12 col-lg-6 p-2 mb-0">
				<div class="col-12 p-3  row d-flex " style="background: #fff;border-radius: 8px;">
					<div style="width:70px;" class="p-0">
						<img src="https://bit.ly/3X2ccBf" style="width:100%" class="rounded">
					</div>
					<div class="col font-1">
						<div class="col-12 p-0 row d-flex">
							<div class="col-12 col-lg-12">
								<h5 class="font-1">زيادة متابعين صفحة فيسبوك عدد 12.000 متابع</h5>
								<div class="progress col-12 col-lg-6" style="height:8px">
								  <div class="progress-bar bg-success" role="progressbar" style="width: 75%" ></div>
								</div>
								<div class="font-1 mt-1">
									الحالة : <span class="bg bg-success text-light font-small" style="padding: 0px 8px 4px;border-radius: 6px;">مكتمل جزئياً</span>
								</div>
							</div>
							<div class="col-12 col-lg-6">
							</div>

						</div>
						
						
					</div>
					<div class="col-12 py-2 px-0 row">
						<div class="col-12 col-lg-6 p-0 font-1">
							<span class="fal fa-bars" style="width:18px"></span> <span class="mx-2">70012</span>
						</div>
						<div class="col-12 col-lg-6 p-0 font-1">
							<span class="fal fa-sack-dollar" style="width:18px"></span> <span class="mx-2">التكلفة 6.00$</span>
						</div>
						<div class="col-12 col-lg-6 p-0 font-1">
							<span class="fal fa-link" style="width:18px"></span> <span class="mx-2"><a href="#">الرابط</a></span>
						</div>
						<div class="col-12 col-lg-6 p-0 font-1">
							<span class="fal fa-tally" style="width:18px"></span> <span class="mx-2">العدد قبل البدء 610</span>
						</div>
						<div class="col-12 col-lg-6 p-0 font-1">
							<span class="fal fa-tally" style="width:18px"></span> <span class="mx-2">العدد المتبقي 2100</span>
						</div>
						<div class="col-12 col-lg-6 p-0 font-1">
							<span class="fal fa-clock" style="width:18px"></span> <span class="mx-2">منذ 3 دقائق</span>
						</div>
						
					</div>
					<div class="col-12 py-2 px-0 row">
						<button class="btn btn-warning font-1 mx-1" style="padding: 0px 5px 5px;width: 60px;box-shadow: 0 0.25rem 0.75rem rgb(30 34 40 / 15%);">تعويض</button>
						<button class="btn btn-outline-warning font-1 mx-1" style="padding: 0px 5px 5px;width: 60px;">تقييم</button>
					</div>
					
				</div>
				</div>

				
				@endif



				</div>
			</div>
		</div>
</div>
{{-- <x-start />
<x-numbers />
<x-faqs />
<x-blog />
<x-about />
<x-call-to-action /> --}}
@endsection