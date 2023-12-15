<?php

namespace App\Models;

use App\Traits\MultiTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EntriesItemsApprove extends Model {

    protected $table = 'entryitems';

    protected $fillable = [
        'entry_id', 'ledger_id', 'amount', 'dc', 'reconciliation_date', 'narration', 'project_id','current_balance','business_id','user_id','uu_id','assign_user'
    ];

    public static function getFinancialYearWiseTransctions($startDate,$endDate,$groupCode){
        return self::select([
                        'entryitems.id',
                        'entryitems.entry_id',
                        'groups.name as group_name',
                        'groups.parent_id as parent_id',
                        'parent.name as parent_name',
                        'parent.parent_id as parent_parent_id',
                        'parent_parent.name as parent_parent_name',
                        'parent_parent.parent_id as parent_parent_parent_id',
                        'parent_parent_parent.name as parent_parent_parent_name',
                        'parent_parent_parent.parent_id as parent_parent_parent_parent_id',
                        DB::raw(" LEFT (groups.code, 2) as first_two_char"),
                        DB::raw('SUM(entryitems.amount) as total_amount'),
                        'entryitems.amount',
                        'entryitems.dc',
                        'entryitems.current_balance',
                        'project.name as project_name',
                        'ledgers.name as ledger_name',
                        'ledgers.code as ledger_code',
                        'ledgers.op_balance',
                        'entries.number as entry_number',
                        'entries.date as entry_date',
                        'entries.dr_total',
                        'entries.cr_total'
                    ])
                    ->join('entries','entries.id','=','entryitems.entry_id')
                    ->join('ledgers','ledgers.id','=','entryitems.ledger_id')
                    ->join('groups','groups.id','=','ledgers.group_id')
                    ->join('groups as parent','parent.id','=','groups.parent_id')
                    ->join('groups as parent_parent','parent_parent.id','=','parent.parent_id')
                    ->join('groups as parent_parent_parent','parent_parent_parent.id','=','parent_parent.parent_id')
                    ->join('project','project.id','=','entryitems.project_id')
                    ->whereBetween('entries.date', [$startDate, $endDate])
                    ->where('groups.code', 'LIKE', $groupCode . '%')
                    ->orderBy('entryitems.id','DESC')
                    ->get()
                    ->toArray();
    }

    public static function getFinancialYearWiseCrDrTransctions($code){
        $financialYear = FinancialYear::getFinancialCurrentYear();
        $group = Group::where('code',$code)->first();
        if ($group && $financialYear){
            $totalCredit = self::getFinancialYearWiseTotalCredit($code,$financialYear['fy_start'],$financialYear['fy_end']);
            $totalDebit = self::getFinancialYearWiseTotalDebit($code,$financialYear['fy_start'],$financialYear['fy_end']);
        }
        $data = [
            'group_name' => ($group && $group->name)?$group->name:null,
            'group_code' => ($group && $group->code)?$group->code:null,
            'cr_total' => ($totalCredit && $totalCredit['cr_total']>0)?$totalCredit['cr_total']:0,
            'dr_total' => ($totalDebit && $totalDebit['dr_total']>0)?$totalDebit['dr_total']:0,
        ];
        return $data;
    }

    public static function getFinancialYearWiseTotalCredit($code,$fyStart,$fyEnd){
        $data = self::select([
            DB::raw(" LEFT (groups.code, 2) as first_two_char"),
            DB::raw('SUM(entryitems.amount) as total_amount'),
        ])
            ->join('entries','entries.id','=','entryitems.entry_id')
            ->join('ledgers','ledgers.id','=','entryitems.ledger_id')
            ->join('groups','groups.id','=','ledgers.group_id')
            ->whereBetween('entries.date', [$fyStart, $fyEnd])
            ->where('groups.code', 'LIKE', $code . '%')
            ->where('entryitems.dc', 'C')
            ->get()
            ->toArray();
        if (count($data)>0){
            return [
                'group_code' => $data[0]['first_two_char'],
                'cr_total' => $data[0]['total_amount']
            ];
        }else{
            return false;
        }
    }
    public static function getFinancialYearWiseTotalDebit($code,$fyStart,$fyEnd){
        $data = self::select([
            DB::raw(" LEFT (groups.code, 2) as first_two_char"),
            DB::raw('SUM(entryitems.amount) as total_amount'),
        ])
            ->join('entries','entries.id','=','entryitems.entry_id')
            ->join('ledgers','ledgers.id','=','entryitems.ledger_id')
            ->join('groups','groups.id','=','ledgers.group_id')
            ->whereBetween('entries.date', [$fyStart, $fyEnd])
            ->where('groups.code', 'LIKE', $code . '%')
            ->where('entryitems.dc', 'D')
            ->get()
            ->toArray();
        if (count($data)>0){
            return [
                'group_code' => $data[0]['first_two_char'],
                'dr_total' => $data[0]['total_amount']
            ];
        }else{
            return false;
        }
    }

}
