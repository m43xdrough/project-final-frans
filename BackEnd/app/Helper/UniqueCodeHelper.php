<?php

namespace App\Helpers;

use App\Models\MasterMaterial;
use App\Models\MasterMember;

use App\Models\TransResep;
use App\Models\TransSOH;

class UniqueCodeHelper
{
    public static function generateCustomerCode()
    {
        //$lastCounter = MasterMember::selectRaw('MAX(SUBSTRING(kode, 3, 8)) as customer_code')->first();

        $lastCounter = MasterMember::withTrashed(true)->orderBy('id', 'desc')->first();

        try {
            if ($lastCounter->id) $increment = (int)$lastCounter->id + 1;
            else $increment = 1;
        } catch (\Throwable $th) {
            $increment = 1;
        }

        $NoUrut = 'CU' . str_pad($increment, 8, 0, STR_PAD_LEFT);
        return $NoUrut;
    }

    public static function generateReceiptCode()
    {
        //$lastCounter = TransResep::selectRaw('MAX(SUBSTRING(noresep, 3, 8)) as receipt_code')->first();

        $lastCounter = TransResep::withTrashed(true)->orderBy('id', 'desc')->first();

        try {
            if ($lastCounter->id) $increment = (int)$lastCounter->id + 1;
            else $increment = 1;
        } catch (\Throwable $th) {
            $increment = 1;
        }

        return 'CR' . str_pad($increment, 8, 0, STR_PAD_LEFT);
    }

    public static function generateMaterialCode()
    {
        //$lastReceipt = MasterMaterial::selectRaw('MAX(SUBSTRING(kdbarang, 3, 8)) as material_code')->first();

        $lastCounter = MasterMaterial::withTrashed(true)->orderBy('id', 'desc')->first();

        try {
            if ($lastCounter->id) $increment = (int)$lastCounter->id + 1;
            else $increment = 1;
        } catch (\Throwable $th) {
            $increment = 1;
        }


        return 'MB' . str_pad($increment, 8, 0, STR_PAD_LEFT);
    }

    public static function generateSalesOrderCode()
    {
        $month = date('m');
        $year  = date('y');

        $lastReceipt = TransSOH::selectRaw('MAX(SUBSTRING(notrans, 4, 7)) as notrans_code')
            ->whereRaw("SUBSTRING(notrans, 10, 2) = '{$month}'")
            ->whereRaw("SUBSTRING(notrans, 13, 2) = '{$year}'")
            //->toSql();
            ->first();
        //die($year . '-' . $lastReceipt);

        if ($lastReceipt->notrans_code) $increment = (int)$lastReceipt->notrans_code + 1;
        else $increment = 1;
        //die($increment);
        $increment = str_pad($increment, 5, 0, STR_PAD_LEFT);
        //die("TSO{$increment}/{$month}/{$year}");
        return "TSO{$increment}/{$month}/{$year}";
    }
}
