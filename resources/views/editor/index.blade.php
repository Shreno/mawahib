@extends('layouts.editor')
@section('content')
    {{--  --}}
    <div class="col-12 px-0  " style="margin-top: 55px;position: relative;">
        <div style="position: fixed; display: none; align-items: center; justify-content: center; height: 100vh; background: var(--background-1); z-index: 10; margin-top: -15px;"
            id="loading-image-container">
            <img src="/images/loading.gif" style="position:fixed;width: 120px;max-width: 80%;margin-top: -60px;"
                id="loading-image">
        </div>
        <div class="col-12 p-0 row">
            <div class="col-12 py-5 rounded-2" style="text-align: center;background: var(--background-1);margin-top: -5px;">
                <div class="col-12" style="display:flex;justify-content: center;">
                    <img src="{{ asset('storage/' . auth()->user()->getUserAvatar()) }}"
                        style="width:130px;height: 130px;border-radius: 50%;">
                </div>
<div class="col-12 p-2 d-flex flex-column align-items-center justify-content-center" style=" text-align: center;">
    <div style=" text-align: center;">
        {{ auth()->user()->id }} <br>
        {{ auth()->user()->name }} <br>
        {{ auth()->user()->email }}<br>
        رابط الحساب <a href="{{ route('creators.show', auth()->user()->id) }}"
            target="_blank">{{ route('creators.show', auth()->user()->id) }}</a><br>
        رابط الاحالة <a href="{{ route('join.form') }}" target="_blank">{{ route('join.form') }}</a><br>
        <br>
    </div>
    <div style=" text-align: center;">
        <a href="{{ route('user.articles.create') }}" class="btn btn-success my-1"><span
                class="fal fa-paper-plane"></span> طلب كتابة محتوى</a>
        <a href="{{ route('user.withdrawal_requests.create') }}" class="btn btn-outline-primary ms-2 my-1"><span
                class="fal fa-money-check"></span> سحب الأرباح</a>
    </div>
</div>
            </div>
            <style type="text/css">
                .mobile-menu-link {
                    padding: 10px 0px !important;
                }
            </style>
            {{-- <div class="col-12 container" style="background:var(--background-0)">
                <div style="width:800px;max-width:100%;margin:0px auto;">
                    <div class="d-flex align-items-center justify-content-center row text-center p-0"
                        style="font-size:13px">
                        <div class="col p-0 text-center">
                            <a href="https://creators.nafezly.com/admin"
                                style="color: inherit; padding: 5px 1px 10px; margin: 0px 2px; position: relative; border-bottom: 6px solid rgb(1, 148, 254);"
                                class="mobile-menu-link d-block font-1 font-lg-2 active">
                                <div class="p-0 text-center"><span class="fal fa-home  p-0 font-1 font-lg-2"></span></div>
                                <div class="p-0 text-center font-1">الرئيسية</div>
                            </a>
                        </div>
                        <div class="col p-0 text-center">
                            <a href="https://creators.nafezly.com/admin?tab=balances"
                                style="color:inherit;padding: 5px 1px 10px;margin: 0px 2px;"
                                class="mobile-menu-link d-block font-1 font-lg-2">
                                <div class="p-0 text-center"><span class="fal fa-sack-dollar  p-0 font-1 font-lg-2"></span>
                                </div>
                                <div class="p-0 text-center font-1">أرصدتي</div>
                            </a>
                        </div>
                        <div class="col p-0 text-center">
                            <a href="https://creators.nafezly.com/admin?tab=analytics"
                                style="color:inherit;padding: 5px 1px 10px;margin: 0px 2px;"
                                class="mobile-menu-link d-block font-1 font-lg-2">
                                <div class="p-0 text-center"><span class="fal fa-chart-line  p-0 font-1 font-lg-2"></span>
                                </div>
                                <div class="p-0 text-center font-1">احصائياتي</div>
                            </a>
                        </div>
                        <div class="col p-0 text-center">
                            <a href="https://creators.nafezly.com/admin?tab=events"
                                style="color:inherit;padding: 5px 1px 10px;margin: 0px 2px;color: #ff9800;position: relative;"
                                class="mobile-menu-link d-block font-1 font-lg-2">
                                <div class="p-0 text-center"><span class="fas fa-bullhorn  p-0 font-1 font-lg-2"></span>
                                </div>
                                <div class="p-0 text-center font-1">الأحداث</div>
                            </a>
                        </div>
                        <div class="col p-0 text-center">
                            <a href="https://creators.nafezly.com/admin?tab=referral"
                                style="color:inherit;padding: 5px 1px 10px;margin: 0px 2px;"
                                class="mobile-menu-link d-block font-1 font-lg-2">
                                <div class="p-0 text-center"><span class="fas fa-stars  p-0 font-1 font-lg-2"></span></div>
                                <div class="p-0 text-center font-1">احالاتي</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-12 py-0 px-3 row">
                <div class="col-12  pt-2" style="min-height: 80vh">
                    <div class="col-12 col-lg-9 px-3 py-5 d-flex mx-auto justify-content-center align-items-center">
                        <style type="text/css">
                            #new_revenue,
                            #traffics-chart {
                                width: 100% !important;
                                height: auto !important;
                            }
                        </style>
                        <div class="col-12 p-0 row justify-content-center">
                            <div class="col-12 row p-0">
                                <div class="col-12 p-2">
                                </div>
                                <div class="col-12 col-lg-6 row p-0 d-flex pb-3">
                                    <div class="col-12 col-lg-12 p-2">
                                        <div class="col-12 p-4 rounded-3" style="color: #fff;background: #1abc9c">
                                            <div class="col-12 p-0">
                                                اجمالي أرباحك
                                            </div>
                                            <span class="font-2 font-lg-6 text-success"
                                                style="font-weight:bold;color:#fff!important">{{ $totalEarnings }}</span>
                                            <div class="font-small">دولار أمريكي</div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 p-2">
                                        <div class="col-12 p-4 rounded-3" style="background: var(--background-1);">
                                            <div class="col-12 p-0">
                                                الرصيد الكلي
                                            </div>
                                            @php $wallet=\App\Models\Wallet::where('user_id',Auth()->user()->id)->first(); @endphp

                                            <span class="font-2 font-lg-6 text-success" style="font-weight:bold;">
                                                {{ isset($wallet) ? $wallet->balance : 0 }}
                                            </span>
                                            <div class="font-small">دولار أمريكي</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6 p-2">
                                        <div class="col-12 p-4 rounded-3" style="background: var(--background-1);">
                                            <div class="col-12 p-0">
                                                الرصيد القابل للسحب
                                            </div>
                                            <span class="font-2 font-lg-6 text-success" style="font-weight:bold;">
                                                {{ isset($wallet) ? $wallet->balance : 0 }}

                                            </span>
                                            <div class="font-small">دولار أمريكي</div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 p-2">
                                        <div class="col-12 p-4 rounded-3" style="background: var(--background-1);">
                                            <div class="col-12 p-0">
                                                الرصيد المسحوب
                                            </div>
                                            <span class="font-2 font-lg-6 text-success" style="font-weight:bold;">
                                                {{ isset($wallet) ? $wallet->withdrawn_balance : 0 }}

                                            </span>
                                            <div class="font-small">دولار أمريكي</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 row p-0">
                                    <div class="col-12 p-2 row">
                                        <div class="col-12 p-0 main-box">
                                            <div class="col-12 px-0 row">
                                                <div class="col-8 py-3 ps-3 ">
                                                    الأرباح آخر {{ $days }} أيام
                                                </div>
                                                <div class="col-4 p-2">
                                                    <form method="GET">
                                                        <select class="form-control" name="days"
                                                            onchange="$(this).closest('form').submit()">
                                                            <option {{ $days == 7 ? 'selected' : '' }} value="7">7
                                                                أيام</option>
                                                            <option {{ $days == 30 ? 'selected' : '' }} value="30">30
                                                                يوم</option>
                                                        </select>
                                                    </form>
                                                </div>
                                                <div class="col-12 "
                                                    style="min-height: 1px;background: var(--border-color);"></div>
                                            </div>
                                            <div class="col-12 p-3">
                                                <canvas id="new_revenue"
                                                    style="height: 161px; display: block; box-sizing: border-box; width: 249px;"
                                                    width="499" height="322">
                                                </canvas>
                                            </div>
                                        </div>
                                        <div class="col-12 px-0 py-2 row">
                                            <div class="col-12 col-lg-6 py-2 pe-lg-2 ps-lg-0 px-0">
                                                <div class="col-12 px-4 py-2 rounded-3"
                                                    style="background: #2196f3;color: #fff;">
                                                    <div class="col-12 p-0">
                                                        أرباح اليوم
                                                    </div>

                                                    <span class="font-2 font-lg-6"
                                                        style="font-weight:bold;">{{ $toDayEarnings }}</span>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 p-0">
                                    <div class="col-12 col-lg-12 p-2">
                                        <div class="col-12 p-0 main-box">
                                            <div class="col-12 px-0">
                                                <div class="col-12 px-3 py-3" style="position:relative;">
                                                    <div class="spinner-grow text-primary" role="status"
                                                        style="position: absolute;top: 11px;left: 14px;">
                                                        <span class="visually-hidden"></span>
                                                    </div>
                                                    أكثر المقالات مشاهدة
                                                </div>
                                                <div class="col-12 "
                                                    style="min-height: 1px;background: var(--border-color);"></div>
                                            </div>
                                            <div class="col-12 p-2">
                                                <table class="table   table-hover">
                                                    <tbody id="sortable-table">
                                                        @foreach ($articles as $article)
                                                            <tr>
                                                                <td><a
                                                                        href="https://play.google.com/store/apps/details?id=com.kosingames.storemanagersimulator&amp;hl=ar&amp;gl=US">محاكي
                                                                        {{ $article->title }}</a></td>
                                                                <td style="width:88px"><a
                                                                        href="{{ route('article.show', ['article' => $article]) }}">
                                                                        <span
                                                                            class="btn  btn-outline-success btn-sm font-1 mx-1">
                                                                            <span class="fas fa-search"></span> عرض
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach




                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-rtl/dist/chartjs-plugin-rtl.min.js"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('new_revenue').getContext('2d');

            // Prepare data passed from the controller
            var labels = {!! json_encode($revenueData->pluck('date')) !!}; // تواريخ الأيام المختارة
            var data = {!! json_encode($revenueData->pluck('total_earnings')) !!}; // Earnings for each date

            var newRevenueChart = new Chart(ctx, {
                type: 'line', // You can use 'bar' or 'line' depending on your preference
                data: {
                    labels: labels.reverse(), // عكس التواريخ لعرضها من اليمين لليسار
                    datasets: [{
                        label: 'الأرباح أخر ' + {{ $days }} + ' أيام',
                        data: data, // Y-axis data (earnings)
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'التاريخ'
                            },
                            reverse: true // عكس محور X لجعله من اليمين لليسار

                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'الأرباح (بالعملة)' // Arabic for "Earnings (in currency unit)"
                            },
                            position: 'right', // جعل محور Y على اليمين
                            beginAtZero: true,
                        }
                    }
                }
            });
        });
    </script>
@endsection
