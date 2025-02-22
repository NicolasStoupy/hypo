<?php

namespace App\Repositories;

use App\Helpers\ConfigHelper;
use App\Models\Boxs;
use App\Models\Poney;
use App\Models\View_availaibility;
use App\Repositories\Interfaces\ICleanning;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CleanningRepository extends  BaseRepository implements ICleanning
{

    public function  __construct()
    {
        parent::__construct(new Boxs());

    }


    public function AssignPoneyBox($box_id, $poney_id)
    {
        $poney = Poney::findOrFail($poney_id);
        $poney->box_id= $box_id;
        $poney->save();
    }

    public function RemovePoneyBox($poney_id)
    {
        $poney = Poney::findOrFail($poney_id);
        $poney->box_id= null;
        $poney->save();
    }


    public function CleanBox($box_id)
    {
       $box = Boxs::findOrFail($box_id);
       $box->last_cleaning = now();
       $box->save();
    }

    public function NewBox()
    {
      $box = new Boxs();
        $box->last_cleaning = now();
        $box->save();
    }

    public function DeleteBox($id)
    {
        $box = Boxs::findOrFail($id);
        $box->delete();
    }
}
