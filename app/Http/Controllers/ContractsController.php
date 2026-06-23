<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractsController extends Controller
{
    public function ContractsRegister(Request $request)
    {
        $defaultRules = '۱. ساکن موظف است قوانین داخلی خوابگاه را رعایت نماید.
۲. پرداخت اجاره‌بها باید در زمان مقرر انجام شود.
۳. استفاده از امکانات عمومی با احترام و نظافت همراه باشد.
۴. ورود مهمان تنها با اجازه مدیریت و طبق ضوابط مجاز است.
۵. در صورت تخطی، مدیریت حق اتخاذ اقدامات قانونی را دارد.';
        $storedRules = $request->session()->get('contract_rules', $defaultRules);
        return view('contracts.contracts_register', compact('storedRules'));
    }

    public function ContractsRules(Request $request)
    {
        $rulesText = $request->session()->get('contract_rules', '');
        return view('contracts.contracts_rules', compact('rulesText'));
    }

    public function SaveContractRules(Request $request)
    {
        $request->session()->put('contract_rules', $request->input('contract_rules', ''));
        return redirect()->route('contracts.rules')->with('status', 'قوانین قرارداد با موفقیت ذخیره شد. اکنون می‌توانید آن را ویرایش کنید.');
    }

    public function ContractsList()
    {
        return view('contracts.contracts_list');
    }
}