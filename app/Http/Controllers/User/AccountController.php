<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\BusinessUser;
use App\Models\EntriesApprove;
use App\Models\EntriesItemsApprove;
use App\Models\EntriesItemsNotApprove;
use App\Models\EntriesNotApprove;
use App\Models\EntryType;
use App\Models\FinancialYear;
use App\Models\Group;
use App\Models\Ledger;
use App\Models\Project;
use App\Models\ReportCode;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;
use Vonage\Voice\NCCO\Action\Input;

class AccountController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $assets   = ['datatable'];
        $accounts = Account::all();
        return view('backend.user.account.list', compact('accounts', 'assets'));
    }

    public function chartOfAccounts(){
        $assets   = ['datatable'];
        $groups = Group::OrderBy('code','asc')->get();
        $entryTypes = EntryType::where('status',1)->get();
        return view('backend.user.account.chart_of_account', compact('groups', 'assets','entryTypes'));
    }

    public function createAccountGroup(Request $request){
        // Get Group Hierarchy
        $data['groups'] = Group::getParentGroup();
        $data['alert_col'] = 'col-lg-10 offset-lg-1';
        if (!$request->ajax()) {
            return view('backend.user.account.group_create', compact('data'));
        } else {
            return view('backend.user.vendor.modal.create');
        }
    }

    public function getNextNumber(){
        $id = $_GET['id'];
        $lastCode = DB::table('groups')->where('parent_id', $id)->orderBy('id', 'desc')->first();
        if ($lastCode){
            $codeArray = explode('-', $lastCode->code);
            $newCode = end($codeArray);
            $newCode += 1;
            $newCode = sprintf("%02d", $newCode);
            $lastIndex = preg_replace('/-[^-]*$/', '', $lastCode->code);

            return $lastIndex."-$newCode";
        }else{
            $parentCode = DB::table('groups')->where('id', $id)->first();
            return $parentCode->code."-01";
        }
    }

    public function storeGroup(Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'parent_id'    => 'required',
            'group_code'    => 'required',
            'group_name'  => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('accounts_create_group')
                ->withErrors($validator)
                ->withInput();
        }

        if ($input){
            /* Transaction Start Here */
            DB::beginTransaction();
            try {
                $groupInput['parent_id'] = $input['parent_id'];
                $groupInput['code'] = $input['group_code'];
                $groupInput['name'] = $input['group_name'];
                if ($group = Group::create($groupInput)) {
                    $group->save();
                }

                DB::commit();
                return redirect()->route('chart_of_accounts')->with('success', _lang('Saved Successfully'));
            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                print($e->getMessage());
                exit();
                Session::flash('danger', $e->getMessage());
            }
        }
    }

    public function accountCreateLedger(){
        $data['groups'] = Group::getParentGroup();
        $data['projects'] = Project::where('status',1)->select('name','id')->get();
        return view('backend.user.account.ledger_create', compact('data'));
    }

    public function getNextNumberLedger(){
        $id = $_GET['id'];
        $group = DB::table('groups')->where('id', $id)->first();
        if ($group){
            $groupCode = $group->code;
            $lastLedger = DB::table('ledgers')->where('group_id', $id)->orderBy('id', 'desc')->first();
            if ($lastLedger){
                $codeArray = explode('-', $lastLedger->code);
                $newCode = end($codeArray);
                $newCode += 1;
                $newCode = sprintf("%04d", $newCode);
                return $groupCode."-$newCode";
            }else{
                return $groupCode."-0001";
            }
        }
    }

    public function storeLedger(Request $request){
        $input = $request->all();
        if ($input){
            /* Transaction Start Here */
            DB::beginTransaction();
            try {
                $ledgerInput['group_id'] = $input['parent_id'];
                $ledgerInput['name'] = $input['name'];
                $ledgerInput['code'] = $input['code'];
                $ledgerInput['op_balance'] = $input['op_balance'];
                $ledgerInput['op_balance_dc'] = $input['op_balance_dc'];
                $ledgerInput['type'] = isset($input['type']) && $input['type'] == 1?1:0;
                $ledgerInput['reconciliation'] = isset($input['reconciliation']) && $input['reconciliation'] == 1?1:0;
                $ledgerInput['notes'] = $input['notes'];
                $ledgerInput['project_id'] = $input['project_id'];
                $ledgerInput['business_id'] = $input['businessList'][0]->business_type_id;
                $ledgerInput['user_id'] = Auth::user()->id;

                if ($ledger = ledger::create($ledgerInput)) {
                    $ledger->save();
                }

                DB::commit();
                return redirect()->route('chart_of_accounts')->with('success', _lang('Saved Successfully'));
            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                print($e->getMessage());
                exit();
                Session::flash('danger', $e->getMessage());
            }
        }
    }

    public function ledgerEdit($id){
        $data['ledger'] = Ledger::find($id);
        $data['groups'] = Group::getParentGroup();
        $data['projects'] = Project::where('status',1)->select('name','id')->get();
        return view('backend.user.account.ledger_edit', compact('data'));
    }

    public function ledgerUpdate(Request $request,$id){
        $input = $request->all();
        Ledger::find($id)->update(array(
            'group_id'=>$input['parent_id'],
            'name'=>$input['name'],
            'code'=>$input['code'],
            'op_balance'=>$input['op_balance'],
            'op_balance_dc'=>$input['op_balance_dc'],
            'type' => isset($input['type']) && $input['type'] == 1?1:0,
            'reconciliation' => isset($input['reconciliation']) && $input['reconciliation'] == 1?1:0,
            'notes' => $input['notes'],
            'project_id' => $input['project_id']
        ));
        return redirect()->route('chart_of_accounts')->with('success', _lang('Saved Successfully'));
    }

    public function createEntries_BK($entryID,$entryName){
        $data['ledgers'] = Ledger::getLedgerDropdown()->toArray();
        $data['projects'] = Project::where('status',1)->select('name','id')->get();
        $deleteEntries = EntriesNotApprove::whereNull('dr_total')->orWhere('dr_total','0.00')->select('id')->first();
        if ($deleteEntries){
            $deleteEntriesItems = EntriesItemsNotApprove::where('entry_id',$deleteEntries->id)->get();
            foreach ($deleteEntriesItems as $item){
                EntriesItemsNotApprove::find($item->id)->delete();
            }
            EntriesNotApprove::whereNull('dr_total')->orWhere('dr_total','0.00')->delete();
        }
        $newEntries = EntriesNotApprove::create([
            'dr_total'=>0.00,
            'cr_total'=>0.00
        ]);
        return view('backend.user.account.entries_create', compact('data','newEntries','entryID','entryName'));
    }

    public function createEntries($entryID,$entryName){
        $data['ledgers'] = Ledger::getLedgerDropdown()->toArray();
        $data['projects'] = Project::where('status',1)->select('name','id')->get();
        $getBusiness = BusinessUser::where('user_id',Auth::user()->id)->first();

        $uuID = (string) Str::uuid();
        $newEntries = EntriesNotApprove::create([
            'uu_id'=>$uuID,
            'business_id'=>$getBusiness->business_id,
            'user_id'=>Auth::user()->id,
            'entry_type_id'=>$entryID,
            'date'=>date('Y-m-d'),
            'dr_total'=>0.00,
            'cr_total'=>0.00
        ]);
        if ($newEntries){
            for ($i=1;$i<=2;$i++){
                EntriesItemsNotApprove::create([
                    'entry_id'=>$newEntries->id,
                    'uu_id'=>(string) Str::uuid(),
                    'business_id'=>$getBusiness->business_id,
                    'user_id'=>Auth::user()->id,
                    'dr_total'=>0.00,
                    'cr_total'=>0.00
                ]);
            }
        }

        return redirect()->route('entries_edit',$uuID);
    }

    public function ledgerNumberUniqueCheck(){
        $number = $_GET['legderNumber'];
        $getNumber = EntriesNotApprove::where('number',$number)->first();
        $response['message'] = 'success';
        if ($getNumber){
            $response['message'] = 'exists';
        }
        return $response;
    }

    public function entriesItemAdded(){
        $dc = $_GET['dc'];
        $ledgerID = $_GET['ledgerID'];
        $amount = $_GET['amount'];
        $narration = $_GET['narration'];
        $currentBalance = $_GET['currentBalance'];
        $entry_id = $_GET['entry_id'];
        $newEntries = EntriesItemsNotApprove::create([
            'entry_id'=>$entry_id,
            'ledger_id'=>$ledgerID,
            'amount'=>$amount,
            'dc'=>$dc,
            'narration'=>$narration,
            'current_balance'=>$currentBalance,
        ]);
        $response['message'] = 'error';
        if ($newEntries){
            $response['message'] = 'success';
        }
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$entry_id)->get();
        $response['content'] = '';
        $totalCredit = 0;
        $totalDebit = 0;
        if ($entriesItems){
            foreach ($entriesItems as $item){
                $totalDebit = ($totalDebit + ($item->dc=='D'?$item->amount:0));
                $totalCredit = ($totalCredit + ($item->dc=='C'?$item->amount:0));
            }
            $response['difference'] = $totalDebit-$totalCredit;
            $view = \Illuminate\Support\Facades\View::make('backend.user.account.entries_table_body',compact('entriesItems','totalDebit','totalCredit'));
            $contents = $view->render();
            $response['content'] = $contents;
        }

        return $response;
    }

    public function getCurrentBalance(){
        $ledgerID = $_GET['ledgerID'];
        $currentDebit = DB::select("SELECT SUM(`amount`) as `totalDebit` FROM `entryitems_notapproved` WHERE `ledger_id`=$ledgerID && `dc`='D'");
        $currentCredit = DB::select("SELECT SUM(`amount`) as `totalCredit` FROM `entryitems_notapproved` WHERE `ledger_id`=$ledgerID && `dc`='C'");
        $currentBalance = ($currentCredit[0]->totalCredit?$currentCredit[0]->totalCredit:0)-($currentDebit[0]->totalDebit?$currentDebit[0]->totalDebit:0);
        $response['currentBalance'] = $currentBalance;
        return $response;
    }

    public function storeEntries(Request $request){
        $input = $request->all();
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$input['entry_id'])->get();
        $totalDR = 0;
        $totalCR = 0;
        foreach ($entriesItems as $item){
            $totalDR = ($totalDR+($item->dc=='D'?$item->amount:0));
            $totalCR = ($totalCR+($item->dc=='C'?$item->amount:0));
        }
        $getBusiness = BusinessUser::where('user_id',Auth::user()->id)->first();
        EntriesNotApprove::find($input['entry_id'])->update([
            'business_id'=>$getBusiness->business_id,
            'user_id'=>Auth::user()->id,
            'number'=>$input['number'],
            'date'=>$input['invoice_date'],
            'project_id'=>$input['project_id'],
            'entry_type_id'=>$input['entry_type_id'],
            'tag_id'=>$input['tags'],
            'dr_total'=>$totalDR,
            'cr_total'=>$totalCR,
            'notes'=>$input['notes']
        ]);

        $entriesItems = EntriesItemsNotApprove::where('entry_id',$input['entry_id'])->get();
        foreach ($entriesItems as $entry){
            EntriesItemsNotApprove::find($entry->id)->update([
                'business_id'=>$getBusiness->business_id,
                'user_id'=>Auth::user()->id
            ]);
        }
        return redirect()->route('entries_list')->with('success', _lang('Saved Successfully'));
    }

    public function addedEmptyEntriesItem(){
        $entryID = $_GET['entry_id'];
        $getBusiness = BusinessUser::where('user_id',Auth::user()->id)->first();
        if ($entryID){
            EntriesItemsNotApprove::create([
                'entry_id'=>$entryID,
                'uu_id'=>(string) Str::uuid(),
                'business_id'=>$getBusiness->business_id,
                'user_id'=>Auth::user()->id,
                'dr_total'=>0.00,
                'cr_total'=>0.00
            ]);
        }
        $response['content'] = '';
        $ledgers = Ledger::getLedgerDropdown()->toArray();
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$entryID)->get();
        $data['users'] = User::where('status',1)->select('name','id')->get();
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($entriesItems as $item){
            $totalDebit = ($totalDebit + ($item->dc=='D'?$item->amount:0));
            $totalCredit = ($totalCredit + ($item->dc=='C'?$item->amount:0));
        }
        $view = \Illuminate\Support\Facades\View::make('backend.user.account.entries_table_body',compact('entriesItems','totalDebit','totalCredit','ledgers','data'));
        $contents = $view->render();
        $response['content'] = $contents;
        return $response;
    }

    public function removeEntriesItem(){
        $id = $_GET['entriesItemID'];
        $entriItem = EntriesItemsNotApprove::find($id);
        $entriItemId = $entriItem->entry_id;
        $entriItem->delete();

        $entriesItems = EntriesItemsNotApprove::where('entry_id',$entriItemId)->get();
        $response['content'] = '';
        $ledgers = Ledger::getLedgerDropdown()->toArray();
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$entriItemId)->get();
        $data['users'] = User::where('status',1)->select('name','id')->get();
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($entriesItems as $item){
            $totalDebit = ($totalDebit + ($item->dc=='D'?$item->amount:0));
            $totalCredit = ($totalCredit + ($item->dc=='C'?$item->amount:0));
        }
        $view = \Illuminate\Support\Facades\View::make('backend.user.account.entries_table_body',compact('entriesItems','totalDebit','totalCredit','ledgers','data'));
        $contents = $view->render();
        $response['content'] = $contents;
        $response['difference'] = $totalDebit-$totalCredit;
        return $response;
    }

    public function entriesList(){
        $assets   = ['datatable'];
        $data['ledgers'] = Ledger::getLedgerDropdown()->toArray();
        $data['projects'] = Project::where('status',1)->select('name','id')->get();
        $deleteEntries = EntriesNotApprove::where('status',0)->select('id')->first();
        if ($deleteEntries){
            $deleteEntriesItems = EntriesItemsNotApprove::where('entry_id',$deleteEntries->id)->get();
            foreach ($deleteEntriesItems as $item){
                EntriesItemsNotApprove::find($item->id)->delete();
            }
            EntriesNotApprove::where('status',0)->delete();
        }
        $entries = EntriesNotApprove::OrderBy('id','desc')->get();
        $entryTypes = EntryType::where('status',1)->get();
        $input = '';
        return view('backend.user.account.entries_list', compact('entries','assets','entryTypes','data','input'));
    }

    public function entriesView($id){
        $entries = EntriesNotApprove::where('uu_id',$id)->first();
        $entryType = EntryType::find($entries->entry_type_id);
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$entries->id)->get();
        return view('backend.user.account.entries_view', compact('entries','entriesItems','entryType'));
    }

    public function entriesEdit($UUID){
        $data['ledgers'] = Ledger::getLedgerDropdown()->toArray();
        $data['projects'] = Project::where('status',1)->select('name','id')->get();
        $data['entries'] = EntriesNotApprove::where('uu_id',$UUID)->first();
        $data['entryType'] = EntryType::find($data['entries']->entry_type_id);
        $data['users'] = User::where('status',1)->select('name','id')->get();
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$data['entries']->id)->get();
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($entriesItems as $item){
            $totalDebit = ($totalDebit + ($item->dc=='D'?$item->amount:0));
            $totalCredit = ($totalCredit + ($item->dc=='C'?$item->amount:0));
        }
        return view('backend.user.account.entries_edit', compact('data','entriesItems','totalDebit','totalCredit'));
    }

    public function entriesEdit_BK($id){
        $data['ledgers'] = Ledger::getLedgerDropdown()->toArray();
        $data['projects'] = Project::where('status',1)->select('name','id')->get();
        $data['entries'] = EntriesNotApprove::find($id);
        $data['entryType'] = EntryType::find($data['entries']->entry_type_id);
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$id)->get();
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($entriesItems as $item){
            $totalDebit = ($totalDebit + ($item->dc=='D'?$item->amount:0));
            $totalCredit = ($totalCredit + ($item->dc=='C'?$item->amount:0));
        }
        return view('backend.user.account.entries_edit', compact('data','entriesItems','totalDebit','totalCredit'));
    }

    public function entriesItemsInlineUpdate(){
        $rowID = $_GET['rowID'];
        $fieldName = $_GET['fieldName'];
        $value = $_GET['value'];
        $updateItem = EntriesItemsNotApprove::find($rowID);
        if ($fieldName == 'debit'){
            $updateItem->update([
                'amount' => $value,
                'dc' => 'D'
            ]);
        }
        if ($fieldName == 'credit'){
            $updateItem->update([
                'amount' => $value,
                'dc' => 'C'
            ]);
        }
        if ($fieldName == 'narration'){
            $updateItem->update([
                'narration' => $value
            ]);
        }
        if ($fieldName == 'user_id'){
            $updateItem->update([
                'assign_user' => $value
            ]);
        }
        if ($fieldName == 'ledger_id'){
            $currentDebit = DB::select("SELECT SUM(`amount`) as `totalDebit` FROM `entryitems_notapproved` WHERE `ledger_id`=$value && `dc`='D'");
            $currentCredit = DB::select("SELECT SUM(`amount`) as `totalCredit` FROM `entryitems_notapproved` WHERE `ledger_id`=$value && `dc`='C'");
            $currentBalance = ($currentCredit[0]->totalCredit?$currentCredit[0]->totalCredit:0)-($currentDebit[0]->totalDebit?$currentDebit[0]->totalDebit:0);
            $updateItem->update([
                'ledger_id' => $value,
                'current_balance' => $currentBalance
            ]);
        }

        $response['content'] = '';
        $ledgers = Ledger::getLedgerDropdown()->toArray();
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$updateItem->entry_id)->get();
        $data['users'] = User::where('status',1)->select('name','id')->get();
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($entriesItems as $item){
            $totalDebit = ($totalDebit + ($item->dc=='D'?$item->amount:0));
            $totalCredit = ($totalCredit + ($item->dc=='C'?$item->amount:0));
        }
        $view = \Illuminate\Support\Facades\View::make('backend.user.account.entries_table_body',compact('entriesItems','totalDebit','totalCredit','ledgers','data'));
        $contents = $view->render();
        $response['content'] = $contents;
        $response['difference'] = $totalDebit-$totalCredit;
        return $response;
    }



    public function updateEntries(Request $request){
        $input = $request->all();
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$input['entry_id'])->get();
        $totalDR = 0;
        $totalCR = 0;
        foreach ($entriesItems as $item){
            $totalDR = ($totalDR+($item->dc=='D'?$item->amount:0));
            $totalCR = ($totalCR+($item->dc=='C'?$item->amount:0));
        }
        EntriesNotApprove::find($input['entry_id'])->update([
            'number'=>$input['number'],
            'date'=>$input['invoice_date'],
            'project_id'=>$input['project_id'],
            'tag_id'=>$input['tags'],
            'dr_total'=>$totalDR,
            'cr_total'=>$totalCR,
            'notes'=>$input['notes'],
            'status' => 1
        ]);
        if($entriesItems){
            foreach ($entriesItems as $item){
                EntriesItemsNotApprove::find($item->id)->update([
                    'project_id' => $input['project_id']
                ]);
            }
        }
        return redirect()->route('entries_list')->with('success', _lang('Saved Successfully'));
    }

    public function entriesApprove($id){
        $entries = EntriesNotApprove::where('uu_id',$id)->first();
        $entriesItems = EntriesItemsNotApprove::where('entry_id',$entries->id)->get();
        $entry = EntriesApprove::create([
            'business_id'=>$entries->business_id,
            'uu_id'=>$entries->uu_id,
            'user_id'=>$entries->user_id,
            'number'=>$entries->number,
            'date'=>$entries->date,
            'project_id'=>$entries->project_id,
            'entry_type_id'=>$entries->entry_type_id,
            'tag_id'=>$entries->tag_id,
            'dr_total'=>$entries->dr_total,
            'cr_total'=>$entries->cr_total,
            'notes'=>$entries->notes
        ]);
        foreach ($entriesItems as $item){
            EntriesItemsApprove::create([
                'entry_id'=>$entry->id,
                'uu_id'=>$item->uu_id,
                'assign_user'=>$item->assign_user,
                'ledger_id'=>$item->ledger_id,
                'business_id'=>$item->business_id,
                'user_id'=>$item->user_id,
                'amount'=>$item->amount,
                'dc'=>$item->dc,
                'reconciliation_date'=>$item->reconciliation_date,
                'narration'=>$item->narration,
                'project_id'=>$item->project_id,
                'current_balance'=>$item->current_balance,
            ]);
            EntriesItemsNotApprove::find($item->id)->delete();
        }
        $entries->delete();
        return redirect()->route('entries_approve_list')->with('success', _lang('Saved Successfully'));
    }

    public function entriesApproveList(){
        $assets   = ['datatable'];
        $entries = EntriesApprove::OrderBy('id','desc')->get();
        $entryTypes = EntryType::where('status',1)->get();
        return view('backend.user.account.entries_approve_list', compact('entries','assets','entryTypes'));
    }

    public function entriesApproveView($id){
        $entries = EntriesApprove::where('uu_id',$id)->first();
        $entryType = EntryType::find($entries->entry_type_id);
        $entriesItems = EntriesItemsApprove::where('entry_id',$entries->id)->get();
        return view('backend.user.account.entries_approve_view', compact('entries','entriesItems','entryType'));
    }

    public function groupEdit($id){
        $data['group'] = Group::find($id);
        $data['groups'] = Group::getParentGroup();
        return view('backend.user.account.group_edit', compact('data'));
    }

    public function groupUpdate(Request $request,$id){
        $input = $request->all();
        $validator = Validator::make($input, [
            'parent_id'    => 'required',
            'group_code'    => 'required',
            'group_name'  => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('group_edit',$id)
                ->withErrors($validator)
                ->withInput();
        }
        $group = Group::find($id);
        if ($input && $group){
            /* Transaction Start Here */
            DB::beginTransaction();
            try {
                $group->update([
                    'parent_id' => $input['parent_id'],
                    'code' => $input['group_code'],
                    'name' => $input['group_name']
                ]);
                $group->save();

                DB::commit();
                return redirect()->route('chart_of_accounts')->with('success', _lang('Saved Successfully'));
            } catch (\Exception $e) {
                //If there are any exceptions, rollback the transaction`
                DB::rollback();
                print($e->getMessage());
                exit();
                Session::flash('danger', $e->getMessage());
            }
        }
    }

    public function entriesFilter(Request $request){
        $input = $request->all();
        $assets   = ['datatable'];
        $data['ledgers'] = Ledger::getLedgerDropdown()->toArray();
        $data['projects'] = Project::where('status',1)->select('name','id')->get();
        $entryTypes = EntryType::where('status',1)->get();
        $entries = EntriesNotApprove::OrderBy('entries_notapproved.id','desc');

        if ($request->has('ladger_id') && $request->ladger_id !='' && !empty($request->ladger_id)) {
            $entries = $entries->leftjoin('entryitems_notapproved','entryitems_notapproved.entry_id','=','entries_notapproved.id');
            $entries->where('entryitems_notapproved.ledger_id', $request->ladger_id);
        }
        if ($request->has('date_range') && !empty($request->date_range) && $request->date_range !='') {
            $date_range = explode(" - ", $request->date_range);
            $entries = $entries->whereBetween('entries_notapproved.date', [$date_range[0], $date_range[1]]);
        }
        if ($request->has('number') && !empty($request->number) && $request->number !='') {
            $entries = $entries->where('entries_notapproved.number', $request->number);
        }
        if ($request->has('project_id') && !empty($request->project_id) && $request->project_id !='') {
            $entries = $entries->where('entries_notapproved.project_id', $request->project_id);
        }
        if ($request->has('tag_id') && !empty($request->tag_id) && $request->tag_id !='') {
            $entries = $entries->where('entries_notapproved.tag_id', $request->tag_id);
        }
        if ($request->has('type') && !empty($request->type) && $request->type !='') {
            $entries = $entries->where('entries_notapproved.entry_type_id', $request->type);
        }
        $entries = $entries->get();
        return view('backend.user.account.entries_list', compact('entries','assets','entryTypes','data','input'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        if (!$request->ajax()) {
            return back();
        } else {
            return view('backend.user.account.modal.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_name'    => 'required|max:50',
            'opening_date'    => 'required|date',
            'account_number'  => 'nullable|max:50',
            'currency'        => 'required',
            'opening_balance' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('accounts.create')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        DB::beginTransaction();

        $account                  = new Account();
        $account->account_name    = $request->input('account_name');
        $account->opening_date    = $request->input('opening_date');
        $account->account_number  = $request->input('account_number');
        $account->currency        = $request->input('currency');
        $account->description     = $request->input('description');
        $account->opening_balance = $request->input('opening_balance');
        $account->save();
        $account->currency = $account->currency . ' (' . currency_symbol($account->currency) . ')';

        if ($account->opening_balance > 0) {
            $transaction              = new Transaction();
            $transaction->trans_date  = $request->input('opening_date');
            $transaction->account_id  = $account->id;
            $transaction->dr_cr       = 'cr';
            $transaction->type        = 'income';
            $transaction->amount      = $request->opening_balance;
            $transaction->description = _lang('Account Opneing Balance');

            $transaction->save();
        }

        DB::commit();

        if (!$request->ajax()) {
            return redirect()->route('accounts.create')->with('success', _lang('Saved Successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Saved Successfully'), 'data' => $account, 'table' => '#accounts_table']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $account = Account::find($id);
        if (!$request->ajax()) {
            return back();
        } else {
            return view('backend.user.account.modal.view', compact('account', 'id'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $account = Account::find($id);
        if (!$request->ajax()) {
            return back();
        } else {
            return view('backend.user.account.modal.edit', compact('account', 'id'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'account_name'   => 'required|max:50',
            'opening_date'   => 'required|date',
            'account_number' => 'nullable|max:50',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('accounts.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $account                 = Account::find($id);
        $account->account_name   = $request->input('account_name');
        $account->opening_date   = $request->input('opening_date');
        $account->account_number = $request->input('account_number');
        $account->description    = $request->input('description');

        $account->save();
        $account->currency = $account->currency . ' (' . currency_symbol($account->currency) . ')';

        if (!$request->ajax()) {
            return redirect()->route('accounts.index')->with('success', _lang('Updated Successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Updated Successfully'), 'data' => $account, 'table' => '#accounts_table']);
        }

    }

    public function convert_due_amount(Request $request, $accountId, $amount) {
        $account      = Account::find($accountId);
        $rawAmount    = convert_currency($request->activeBusiness->currency, $account->currency, $amount);
        $formatAmount = formatAmount($rawAmount, currency_symbol($account->currency));
        return response()->json(['rawAmount' => $rawAmount, 'formatAmount' => $formatAmount]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::beginTransaction();

        $account = Account::find($id);
        try {
            Transaction::where('account_id', $id)
                ->where('transaction_category_id', null)
                ->where('ref_id', null)
                ->delete();
            $account->delete();

            DB::commit();
            return redirect()->route('accounts.index')->with('success', _lang('Deleted Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('accounts.index')->with('error', _lang('Sorry, This account is already exists in transactions'));
        }
    }




    public function reportBalanceSheet(Request $request){
        $assets   = ['datatable'];
        $reportCode = ReportCode::select(['id','label','code','white_space'])->where('report_for','bl')->orderBy('code','ASC')->get();
        return view('backend.user.reports.balance_sheet', compact('reportCode', 'assets'));
    }


    public function reportBalanceSheetBK(Request $request){
        $assets   = ['datatable'];
        $groups = Group::OrderBy('code','asc')->get();
        $entryTypes = EntryType::where('status',1)->get();

        $financialYear = FinancialYear::getFinancialCurrentYear();
        $getTransactions = [];

        $array = [
            '01','01-01','01-02','02','02-01','02-02'
        ];

        foreach ($array as $value){
            $groupCode = $value;
            $getTransactionsNotAsset = EntriesItemsApprove::getFinancialYearWiseTransctions($financialYear['fy_start'],$financialYear['fy_end'],$groupCode);
            if ($getTransactionsNotAsset){
                $group = Group::where('code',$groupCode)->select(['name','code'])->first();
                $getTransactionsNotAsset[0]['group_name'] = $group->name;
                $getTransactionsNotAsset[0]['group_space'] = strlen(str_replace("-" , "" , $group->code));
                array_push($getTransactions,$getTransactionsNotAsset[0]);
            }
        }
        return view('backend.user.reports.balance_sheet', compact('groups', 'assets','entryTypes','getTransactions'));
    }
}
