<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportTypes = [
            'residents' => ['label' => 'ساکنین', 'description' => 'گزارش وضعیت ساکنین، وضعیت قرارداد و پرداخت‌ها'],
            'contracts' => ['label' => 'قراردادها', 'description' => 'وضعیت قراردادها، لغو شده‌ها و تمدیدها'],
            'payments' => ['label' => 'پرداخت‌ها', 'description' => 'گزارش درآمد، پرداخت‌های معوق و تسویه‌ها'],
            'maintenance' => ['label' => 'درخواست‌های فنی', 'description' => 'گزارش درخواست‌های تعمیراتی و روند پیگیری'],
            'visitors' => ['label' => 'بازدیدکنندگان', 'description' => 'گزارش مهمانان، بازدیدها و ثبت ورود/خروج'],
        ];

        $selectedType = $request->query('type', 'residents');
        if (!array_key_exists($selectedType, $reportTypes)) {
            $selectedType = 'residents';
        }

        $reportData = [
            'residents' => [
                'summary' => [
                    ['title' => 'ساکنین فعال', 'value' => '۴۸', 'detail' => '+۳ این ماه', 'icon' => 'la-users', 'color' => '#1a56db', 'bg' => 'rgba(26, 86, 219, 0.08)'],
                    ['title' => 'اتاق‌های اشغال‌شده', 'value' => '۲۰ / ۲۴', 'detail' => '۸۳٪ اشغال', 'icon' => 'la-home', 'color' => '#0ea5e9', 'bg' => 'rgba(14, 165, 233, 0.08)'],
                    ['title' => 'قراردادهای فعال', 'value' => '۳۶', 'detail' => '۹۲٪ تمدید شده', 'icon' => 'la-file-text', 'color' => '#10b981', 'bg' => 'rgba(16, 185, 129, 0.08)'],
                    ['title' => 'پرداخت به‌موقع', 'value' => '۲۷', 'detail' => '۷۵٪', 'icon' => 'la-check-circle', 'color' => '#8b5cf6', 'bg' => 'rgba(168, 85, 247, 0.08)'],
                ],
                'tableHeaders' => ['نام ساکن', 'شماره اتاق', 'وضعیت', 'آخرین پرداخت'],
                'tableRows' => [
                    ['primary' => 'علی رضایی', 'secondary' => '۱۰۱', 'status' => 'فعال', 'meta' => 'حمل ۱۴۰۴'],
                    ['primary' => 'سارا احمدی', 'secondary' => '۱۰۲', 'status' => 'قرارداد جاری', 'meta' => 'جوزا ۱۴۰۴'],
                    ['primary' => 'مریم صفری', 'secondary' => '۱۰۵', 'status' => 'فعال', 'meta' => 'غبرگان ۱۴۰۴'],
                    ['primary' => 'مهدی صادقی', 'secondary' => '۱۰۸', 'status' => 'جدید', 'meta' => 'ارسال فاکتور'],
                ],
                'detailCards' => [
                    ['title' => 'اتاق خالی', 'value' => '۴', 'hint' => 'از ۲۴ اتاق'],
                    ['title' => 'ساکنین تمام وقت', 'value' => '۳۲', 'hint' => '۶۷٪ کل ساکنین'],
                ],
            ],
            'contracts' => [
                'summary' => [
                    ['title' => 'قراردادهای فعال', 'value' => '۳۶', 'detail' => '۹۲٪ تمدید', 'icon' => 'la-file-text-o', 'color' => '#0f172a', 'bg' => 'rgba(15, 23, 42, 0.08)'],
                    ['title' => 'قراردادهای جدید', 'value' => '۸', 'detail' => 'این ماه', 'icon' => 'la-plus-circle', 'color' => '#f59e0b', 'bg' => 'rgba(245, 158, 11, 0.08)'],
                    ['title' => 'لغو شده', 'value' => '۲', 'detail' => '۱ فوری', 'icon' => 'la-ban', 'color' => '#dc2626', 'bg' => 'rgba(220, 38, 38, 0.08)'],
                    ['title' => 'میانگین مدت', 'value' => '۹ ماه', 'detail' => 'پیشنهاد تمدید', 'icon' => 'la-clock-o', 'color' => '#2563eb', 'bg' => 'rgba(37, 99, 235, 0.08)'],
                ],
                'tableHeaders' => ['شماره قرارداد', 'ساکن', 'شروع', 'پایان'],
                'tableRows' => [
                    ['primary' => '#۱۲۳۴', 'secondary' => 'علی رضایی', 'status' => '۱۴۰۴/۱۲/۰۵', 'meta' => '۱۴۰۵/۱۲/۰۴'],
                    ['primary' => '#۱۲۳۵', 'secondary' => 'سارا احمدی', 'status' => '۱۴۰۴/۰۸/۱۲', 'meta' => '۱۴۰۵/۰۸/۱۱'],
                    ['primary' => '#۱۲۳۶', 'secondary' => 'مریم صفری', 'status' => '۱۴۰۳/۱۲/۱۵', 'meta' => '۱۴۰۴/۱۲/۱۴'],
                    ['primary' => '#۱۲۳۷', 'secondary' => 'مهدی صادقی', 'status' => '۱۴۰۴/۰۵/۲۰', 'meta' => '۱۴۰۵/۰۵/۱۹'],
                ],
                'detailCards' => [
                    ['title' => 'قراردادهای قابل تمدید', 'value' => '۱۰', 'hint' => 'تا ۳۰ روز آینده'],
                    ['title' => 'پیشنهاد تمدید', 'value' => '۷', 'hint' => 'ارسال شده'],
                ],
            ],
            'payments' => [
                'summary' => [
                    ['title' => 'درآمد ماه', 'value' => '۱۵۶,۰۰۰', 'detail' => '۹ از ۱۲ پرداخت', 'icon' => 'la-money', 'color' => '#16a34a', 'bg' => 'rgba(22, 163, 74, 0.08)'],
                    ['title' => 'پرداخت معوق', 'value' => '۵', 'detail' => '۲۰٪', 'icon' => 'la-clock', 'color' => '#ea580c', 'bg' => 'rgba(234, 88, 12, 0.08)'],
                    ['title' => 'تراکنش‌های موفق', 'value' => '۴۲', 'detail' => '۹۸٪ موفق', 'icon' => 'la-thumbs-up', 'color' => '#0ea5e9', 'bg' => 'rgba(14, 165, 233, 0.08)'],
                    ['title' => 'پرداخت نقدی', 'value' => '۳۵', 'detail' => '۷۰٪', 'icon' => 'la-credit-card', 'color' => '#8b5cf6', 'bg' => 'rgba(168, 85, 247, 0.08)'],
                ],
                'tableHeaders' => ['نام ساکن', 'ماه', 'مبلغ', 'وضعیت'],
                'tableRows' => [
                    ['primary' => 'علی رضایی', 'secondary' => 'حمل ۱۴۰۴', 'status' => '۱۵۶,۰۰۰', 'meta' => 'پرداخت شده'],
                    ['primary' => 'سارا احمدی', 'secondary' => 'جوزا ۱۴۰۴', 'status' => '۱۶۸,۰۰۰', 'meta' => 'پرداخت شده'],
                    ['primary' => 'مریم صفری', 'secondary' => 'سرطان ۱۴۰۴', 'status' => '۱۴۲,۰۰۰', 'meta' => 'معوق'],
                    ['primary' => 'مهدی صادقی', 'secondary' => 'اسد ۱۴۰۴', 'status' => '۱۳۸,۰۰۰', 'meta' => 'در حال بررسی'],
                ],
                'detailCards' => [
                    ['title' => 'جمع درآمد', 'value' => '۹۶۰,۰۰۰', 'hint' => '۶ ماه اخیر'],
                    ['title' => 'پرداخت‌های آنلاین', 'value' => '۳۹', 'hint' => '۸۲٪ کل'],
                ],
            ],
            'maintenance' => [
                'summary' => [
                    ['title' => 'درخواست‌های باز', 'value' => '۵', 'detail' => '۱ فوری', 'icon' => 'la-wrench', 'color' => '#ea580c', 'bg' => 'rgba(234, 88, 12, 0.08)'],
                    ['title' => 'پاسخ داده شده', 'value' => '۱۸', 'detail' => '۷۲٪ تکمیل', 'icon' => 'la-check-circle', 'color' => '#16a34a', 'bg' => 'rgba(22, 163, 74, 0.08)'],
                    ['title' => 'درخواست جدید', 'value' => '۴', 'detail' => 'این هفته', 'icon' => 'la-plus-circle', 'color' => '#0ea5e9', 'bg' => 'rgba(14, 165, 233, 0.08)'],
                    ['title' => 'متوسط زمان', 'value' => '۲.۵ روز', 'detail' => 'تا حل', 'icon' => 'la-clock-o', 'color' => '#2563eb', 'bg' => 'rgba(37, 99, 235, 0.08)'],
                ],
                'tableHeaders' => ['کد درخواست', 'بخش', 'اولویت', 'وضعیت'],
                'tableRows' => [
                    ['primary' => '#M102', 'secondary' => 'برق', 'status' => 'فوری', 'meta' => 'در حال بررسی'],
                    ['primary' => '#M103', 'secondary' => 'لوله‌کشی', 'status' => 'عادی', 'meta' => 'تکمیل شده'],
                    ['primary' => '#M104', 'secondary' => 'در و پنجره', 'status' => 'عادی', 'meta' => 'باز'],
                    ['primary' => '#M105', 'secondary' => 'نظافت', 'status' => 'پرایوریته', 'meta' => 'در حال انجام'],
                ],
                'detailCards' => [
                    ['title' => 'متوسط زمان پاسخ', 'value' => '۴ ساعت', 'hint' => 'از ثبت تا بررسی'],
                    ['title' => 'درخواست‌های حل شده', 'value' => '۱۸', 'hint' => '۷۲٪'],
                ],
            ],
            'visitors' => [
                'summary' => [
                    ['title' => 'بازدیدکنندگان', 'value' => '۱۲۵', 'detail' => 'این ماه', 'icon' => 'la-user-plus', 'color' => '#0ea5e9', 'bg' => 'rgba(14, 165, 233, 0.08)'],
                    ['title' => 'بازدیدهای تایید شده', 'value' => '۹۴', 'detail' => '۷۵٪', 'icon' => 'la-check', 'color' => '#16a34a', 'bg' => 'rgba(22, 163, 74, 0.08)'],
                    ['title' => 'بازدیدکننده VIP', 'value' => '۷', 'detail' => 'این هفته', 'icon' => 'la-star', 'color' => '#f59e0b', 'bg' => 'rgba(245, 158, 11, 0.08)'],
                    ['title' => 'مهمان معوق', 'value' => '۲', 'detail' => 'بررسی نشده', 'icon' => 'la-clock', 'color' => '#ea580c', 'bg' => 'rgba(234, 88, 12, 0.08)'],
                ],
                'tableHeaders' => ['نام مهمان', 'ساکن میزبان', 'تاریخ', 'وضعیت'],
                'tableRows' => [
                    ['primary' => 'نادر موسوی', 'secondary' => 'علی رضایی', 'status' => '۱۴۰۴/۰۶/۰۲', 'meta' => 'تایید شده'],
                    ['primary' => 'زهرا کریمی', 'secondary' => 'سارا احمدی', 'status' => '۱۴۰۴/۰۶/۰۵', 'meta' => 'در انتظار'],
                    ['primary' => 'پویا عباسی', 'secondary' => 'مریم صفری', 'status' => '۱۴۰۴/۰۶/۰۷', 'meta' => 'بازدید شده'],
                    ['primary' => 'مهسا فراهانی', 'secondary' => 'مهدی صادقی', 'status' => '۱۴۰۴/۰۶/۱۰', 'meta' => 'منقضی شده'],
                ],
                'detailCards' => [
                    ['title' => 'بازدیدهای روزانه', 'value' => '۳۴', 'hint' => 'میانگین هفته'],
                    ['title' => 'مهمانان VIP', 'value' => '۷', 'hint' => 'رزرو شده'],
                ],
            ],
        ];

        $report = $reportData[$selectedType];

        return view('reports.index', compact('reportTypes', 'selectedType', 'report'));
    }

    public function residentReport()
    {
        // Sample data for the resident report
        $residents = [
            ['name' => 'علی رضایی', 'room' => '۱۰۱', 'status' => 'فعال', 'last_payment' => '۱۴۰۴/۰۶/۰۵'],
            ['name' => 'سارا احمدی', 'room' => '۱۰۲', 'status' => 'قرارداد جاری', 'last_payment' => '۱۴۰۴/۰۶/۰۳'],
            ['name' => 'مریم صفری', 'room' => '۱۰۵', 'status' => 'فعال', 'last_payment' => '۱۴۰۴/۰۶/۰۷'],
            ['name' => 'مهدی صادقی', 'room' => '۱۰۸', 'status' => 'جدید', 'last_payment' => '۱۴۰۴/۰۶/۰۱'],
        ];

        return view('reports.resident_reports', compact('residents'));
    }
    public function paymentReport()
    {
        // Sample data for the payment report
        $payments = [
            ['resident' => 'علی رضایی', 'month' => 'حمل ۱۴۰۴', 'amount' => '۱۵۶,۰۰۰', 'status' => 'پرداخت شده'],
            ['resident' => 'سارا احمدی', 'month' => 'جوزا ۱۴۰۴', 'amount' => '۱۶۸,۰۰۰', 'status' => 'پرداخت شده'],
            ['resident' => 'مریم صفری', 'month' => 'سرطان ۱۴۰۴', 'amount' => '۱۴۲,۰۰۰', 'status' => 'معوق'],
            ['resident' => 'مهدی صادقی', 'month' => 'اسد ۱۴۰۴', 'amount' => '۱۳۸,۰۰۰', 'status' => 'در حال بررسی'],
        ];

        return view('reports.payment_reports', compact('payments'));
    }
}
