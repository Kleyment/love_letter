<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    public $timestamps = false;

    public static function quiPeutPiocher($idpartie) {
      $tour=Tour::where('nbtour',\DB::table('tours')->max('nbtour'))->get()->first();
      if ($tour) {
        return 1;
      } else {
        return 1;
      }
    }

    public static function quiPeutDefausser() {
      return 1;
    }
}
