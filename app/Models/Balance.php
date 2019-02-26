<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit($value)
    {
        $this->amount += number_format($value, 2, '.', '');
        $deposit = $this->save();

        return $deposit;
    }
}
