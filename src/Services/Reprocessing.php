<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;
class Reprocessing
{
    private static function getReprocessData(int $id)
    {
        $data = DB::table('invTypeMaterials as m')
            ->select('m.materialTypeID', 't.groupID', 'm.quantity', 't.typeName')
            ->LeftJoin('invTypes as t', 'm.materialTypeID', '=', 't.typeID')
            ->where('m.typeID', '=', $id)
            ->get();
        return $data;
    }

    private static function getMaterialInfo(int $id)
    {
        $data = DB::table('invTypes')
            ->select('groupID', 'mass', 'volume', 'portionSize')
            ->where('typeID', '=', $id)
            ->pluck();
        return $data;
    }

    public static function ReprocessOreByTypeId(int $typeId, int $quantity)
    {
        $ore = self::getMaterialInfo($typeId);
        $p_size = $ore->portionSize;
        $r_count = intval($quantity / $p_size);
        $r_rest = $quantity % $p_size;
        $rep = self::getReprocessData($typeId);
        $result = [];
        foreach($rep as $r)
        {
            $result[$r->materialTypeID] = $r->quantity * $r_count;
        }
        if (!$r_rest)
        {
            $result[$typeId] = $r_rest;
        }
        return $result;
    }
}