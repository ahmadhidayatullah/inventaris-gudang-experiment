<?php

namespace App\Helpers;

class MyHelper
{
    public static function isCurrentRespone($uri, $output = 'active'){

        if (is_array($uri)) {
            foreach ($uri as $u) {
                if (Route::is($u)) {
                    return $output;
                }
            }
        } else {
            if (Route::is($uri)) {
                return $output;
            }
        }

    }

    public static function formatMessage($message, $type)
    {
        return '<div class="alert alert-' . $type . ' alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <strong>' . $message . ' </strong>
    </div>';
    }

    public static function toRupiah($number)
    {
        if ($number >= 0) {
            return 'Rp. ' . number_format($number, 0, ',', '.');
        } else {
            $input = abs($number) * -1;
            $result = number_format($input);
            return 'Rp. ' . $result;
        }
    }

    public static function countInstrukturQuota($jam,$user)
    {
        $count = 0;
        $data = \App\Models\PesertaKursus::where([
            ['instruktur','=',$user],
            ['is_done','=',0],
            ['jam_mulai_id','=',$jam]
        ])->get();
            
        foreach ($data as $key => $value) {
            $count = $count + $value->jumlah_pertemuan;
        }
        return $count;
    }

}

