<div class="modal fade" id="demoPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white py-2">
                <h5 class="modal-title white mb-0">
                    <i class="la la-file-text-o"></i>
                    <span id="demoPreviewModalTitleText">نمایش</span>
                </h5>
                <button type="button" class="close white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-3" id="demoPreviewModalBody" style="max-height:75vh;overflow-y:auto;background:#f5f6fa"></div>
            <div class="modal-footer py-2">
                <small class="text-muted mr-auto">نمونه دیمو</small>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.print()"><i class="la la-print"></i> چاپ</button>
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>

<style>
    .doc-paper {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 2rem 2.25rem;
        color: #2c3e50;
        line-height: 1.95;
        font-size: 0.95rem;
    }
    .doc-paper .doc-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #666EE8;
        margin-bottom: 0.25rem;
    }
    .doc-paper .doc-sub {
        font-size: 0.85rem;
        color: #6B6F82;
        margin-bottom: 1.5rem;
    }
    .doc-paper .doc-meta {
        font-size: 0.82rem;
        padding-bottom: 1rem;
        margin-bottom: 1.25rem;
        border-bottom: 2px solid #666EE8;
    }
    .doc-paper .doc-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #464855;
        margin: 1.5rem 0 0.75rem;
        padding-bottom: 0.35rem;
        border-bottom: 1px solid #e9ecef;
    }
    .doc-paper .doc-article {
        margin-bottom: 1rem;
        padding-right: 0.75rem;
        border-right: 3px solid #666EE8;
    }
    .doc-paper .doc-article-title {
        font-weight: 700;
        color: #464855;
        margin-bottom: 0.35rem;
    }
    .doc-paper .doc-article p {
        margin: 0;
        text-align: justify;
    }
    .doc-paper .doc-sign {
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px dashed #ced4da;
    }
    .doc-paper .sign-line {
        border-top: 1px solid #464855;
        width: 65%;
        margin: 2.5rem auto 0.35rem;
    }
</style>

<script>
(function () {
    function esc(s) { return (s || '—').toString(); }
    function ds(el) { return el ? el.dataset : {}; }
    function row(btn) {
        return btn.closest('tr[data-code]') || btn.closest('tr[data-number]') || btn.closest('tr[data-name]') || btn.closest('tr');
    }

    var articles = [
        { n: 1, t: 'پرداخت اجاره', b: 'ساکن متعهد است اجاره ماهانه را حداکثر تا تاریخ ۱۵ هر ماه به مدیریت خوابگاه پرداخت نماید. تأخیر بیش از ده روز مشمول جریمه مطابق تعرفه خوابگاه است.' },
        { n: 2, t: 'نظم و انضباط', b: 'رعایت سکوت در ساعات استراحت (۲۲:۰۰ تا ۰۶:۰۰) و پرهیز از ایجاد مزاحمت برای سایر ساکنین الزامی است.' },
        { n: 3, t: 'مهمان', b: 'ورود مهمان تنها با ثبت در سامانه و در ساعات ۰۸:۰۰ تا ۲۰:۰۰ مجاز است. ثبت زمان خروج بر عهده ساکن می‌باشد.' },
        { n: 4, t: 'امکانات مشترک', b: 'استفاده از آشپزخانه، حمام و اینترنت مطابق دستورالعمل خوابگاه بوده و ساکن موظف به حفظ نظافت فضاهای مشترک است.' },
        { n: 5, t: 'فسخ قرارداد', b: 'در صورت تخلف یا عدم پرداخت، مدیریت حق فسخ قرارداد و تخلیه اتاق را با رعایت مهلت مقرر خواهد داشت.' }
    ];

    function renderContract(d) {
        var arts = articles.map(function (a) {
            return '<div class="doc-article">' +
                '<div class="doc-article-title">ماده ' + a.n + ' — ' + a.t + '</div>' +
                '<p>' + a.b + '</p></div>';
        }).join('');

        return '<div class="doc-paper">' +
            '<div class="text-center mb-3">' +
                '<div class="doc-title">خوابگاه لیلیه</div>' +
                '<div class="doc-sub">قرارداد اجاره و استفاده از خوابگاه</div>' +
            '</div>' +
            '<div class="doc-meta">' +
                '<strong>شماره قرارداد:</strong> ' + esc(d.code) + ' &nbsp;|&nbsp; ' +
                '<strong>تاریخ:</strong> ' + esc(d.date) + ' &nbsp;|&nbsp; ' +
                '<strong>مدت:</strong> ' + esc(d.duration) + ' &nbsp;|&nbsp; ' +
                '<strong>وضعیت:</strong> ' + esc(d.status) +
            '</div>' +
            '<p class="text-justify mb-3">' +
                'این قرارداد فی‌مابین <strong>مدیریت خوابگاه لیلیه</strong> (طرف اول) و ' +
                '<strong>' + esc(d.name) + '</strong> فرزند <strong>' + esc(d.father) + '</strong> (طرف دوم) منعقد می‌گردد.' +
            '</p>' +
            '<div class="doc-section-title">مشخصات ساکن و محل اقامت</div>' +
            '<p class="mb-1"><strong>نام:</strong> ' + esc(d.name) + ' &nbsp;&nbsp; <strong>نام پدر:</strong> ' + esc(d.father) + '</p>' +
            '<p class="mb-1"><strong>شهر:</strong> ' + esc(d.city) + ' &nbsp;&nbsp; <strong>تلفن:</strong> <span dir="ltr">' + esc(d.phone) + '</span></p>' +
            '<p class="mb-1"><strong>اتاق:</strong> ' + esc(d.room) + ' &nbsp;&nbsp; <strong>شغل:</strong> ' + esc(d.occupation) + '</p>' +
            '<p class="mb-0"><strong>محل کار / تحصیل:</strong> ' + esc(d.location) + '</p>' +
            '<div class="doc-section-title">پرداخت اجاره</div>' +
            '<p class="mb-1"><strong>مبلغ پرداخت‌شده:</strong> ' + (d.paymentAmount && d.paymentAmount !== '0' ? esc(d.paymentAmount) + ' افغانی' : '—') + '</p>' +
            '<p class="mb-1"><strong>تعداد ماه پرداخت‌شده:</strong> ' + (d.monthsPaid && d.monthsPaid !== '0' ? esc(d.monthsPaid) + ' ماه' : '—') + '</p>' +
            '<p class="mb-3"><strong>وضعیت پرداخت:</strong> ' + esc(d.paymentStatus) + '</p>' +
            '<div class="doc-section-title">قوانین و تعهدات</div>' +
            '<p class="text-justify mb-3" style="font-size:0.9rem">' +
                'ساکن با مطالعه مفاد زیر، کلیه قوانین داخلی خوابگاه لیلیه را پذیرفته و متعهد به رعایت آن می‌باشد:' +
            '</p>' +
            arts +
            '<div class="doc-sign row">' +
                '<div class="col-6 text-center font-small-3">' +
                    '<div>امضاء مدیریت خوابگاه لیلیه</div><div class="sign-line"></div>' +
                '</div>' +
                '<div class="col-6 text-center font-small-3">' +
                    '<div>امضاء ساکن: ' + esc(d.name) + '</div><div class="sign-line"></div>' +
                '</div>' +
            '</div>' +
            '<p class="text-center font-small-3 mt-3 mb-0" style="color:#6B6F82">کابل، ناحیه ۱۰ — تماس: 0700000000 — نسخه دیمو</p>' +
        '</div>';
    }

    function renderSimple(title, rows, footer) {
        var trs = rows.map(function (r) {
            return '<tr><th class="font-weight-bold" style="width:32%">' + r[0] + '</th><td>' + r[1] + '</td></tr>';
        }).join('');
        return '<div class="doc-paper">' +
            '<div class="doc-title text-center mb-3">' + title + '</div>' +
            '<table class="table table-bordered table-sm mb-3">' + trs + '</table>' +
            (footer ? '<p class="text-justify mb-0 font-small-3">' + footer + '</p>' : '') +
        '</div>';
    }

    var builders = {
        contract: function (d) { return renderContract(d); },
        resident: function (d) {
            return renderSimple('پرونده ساکن', [
                ['کد', esc(d.code)], ['نام', esc(d.name)], ['نام پدر', esc(d.father)],
                ['شهر', esc(d.city)], ['اتاق', esc(d.room)], ['شغل', esc(d.occupation)],
                ['تلفن', '<span dir="ltr">' + esc(d.phone) + '</span>'], ['محل کار', esc(d.location)]
            ], 'این سند نمونه دیمو پرونده ساکن است.');
        },
        room: function (d) {
            return renderSimple('مشخصات اتاق', [
                ['شماره', esc(d.number)], ['ظرفیت', esc(d.capacity) + ' نفر'],
                ['نوع', esc(d.type)], ['وضعیت', esc(d.status)]
            ], 'ساکنین موظف به رعایت ظرفیت و نظافت اتاق هستند.');
        },
        visitor: function (d) {
            return renderSimple('برگه مهمان', [
                ['مهمان', esc(d.guest)], ['میزبان', esc(d.host)], ['اتاق', esc(d.room)],
                ['ورود', esc(d.checkin)], ['خروج', esc(d.checkout)], ['وضعیت', esc(d.status)]
            ], 'مهمان موظف به رعایت قوانین خوابگاه است.');
        },
        maintenance: function (d) {
            return renderSimple('درخواست تعمیرات', [
                ['ساکن', esc(d.resident)], ['اتاق', esc(d.room)], ['نوع', esc(d.type)],
                ['اولویت', esc(d.priority)], ['تاریخ', esc(d.date)], ['وضعیت', esc(d.status)]
            ], '<strong>شرح:</strong> ' + esc(d.desc));
        },
        announcement: function (d) {
            return '<div class="doc-paper">' +
                '<div class="doc-title text-center">' + esc(d.title) + '</div>' +
                '<p class="doc-sub text-center">' + esc(d.cat) + ' — ' + esc(d.date) + ' — ' + esc(d.status) + '</p>' +
                '<p class="text-justify mb-0" style="line-height:2">' + esc(d.text) + '</p></div>';
        }
    };

    var titles = {
        contract: 'نمایش قرارداد',
        resident: 'نمایش ساکن',
        room: 'نمایش اتاق',
        visitor: 'نمایش مهمان',
        maintenance: 'نمایش درخواست',
        announcement: 'نمایش اعلان'
    };

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.btn-demo-view');
        if (!btn) return;
        e.preventDefault();

        var type = btn.dataset.demoType || (btn.closest('[data-demo-type]') && btn.closest('[data-demo-type]').dataset.demoType);
        var r = row(btn);
        var d = Object.assign({}, ds(r), ds(btn));
        if (!type || !builders[type]) return;

        document.getElementById('demoPreviewModalTitleText').textContent = titles[type] || 'نمایش';
        document.getElementById('demoPreviewModalBody').innerHTML = builders[type](d);
        $('#demoPreviewModal').modal('show');
    });
})();
</script>
