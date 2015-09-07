<?php

namespace app\helpers;


class HandBook {

    public static function getRelation($type=null)
    {
        $relationType = [
          0 => 'Single',
          1 => 'Taken'
        ];

        if(is_numeric($type))
            return $relationType[$type];
        else return $relationType;
    }

    public static function getGender($type=null)
    {
        $relationType = [
            0 => 'Female',
            1 => 'Male'
        ];

        if(is_numeric($type))
            return $relationType[$type];
        else return $relationType;
    }

    public static function getWorkHeader($type=null)
    {
        $work = [
            0 => 'HEAD HONCHO AT',
            1 => 'doing the grind AT',
            2 => 'MY OWN BOSS AT',
            3 => 'MINION AT',
            4 => 'KIND OF A BIG DEAL AT',
            5 => 'JUST ANOTHER NUMBER AT',
            6 => 'TOP DOG AT',
            7 => 'BEAN COUNTER AT',
            8 => 'LIVE OFF MY DADDY',
            9 => 'LIVE OFF MY "DADDY"'
            //10 x At y
            //11 x
        ];

        if(is_numeric($type))
            return $work[$type];
        else return $work;
    }

    public static function getLoveHeader($type=null)
    {
        $love = [
            0 => 'UNICORNS',
            1 => 'CELINE DION',
            2 => 'DONUTS, DONUTS, DONUTS'
        ];

        if(is_numeric($type))
            return $love[$type];
        else return $love;
    }
    public static function formatDate($date){
        return date('m/d/Y', strtotime($date));
    }
} 