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
            0 => 'Head honcho at',
            1 => 'Doing the grind at',
            2 => 'My own boss at',
            3 => 'Minion at',
            4 => 'Kind of a big deal at',
            5 => 'Just another number at',
            6 => 'Top dog at',
            7 => 'Bean counter at',
            8 => 'Live off my Daddy',
            9 => 'Live off my "Daddy"'
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
            0 => 'unicorns',
            1 => 'Celine Dion',
            2 => 'donuts, donuts, donuts'
        ];

        if(is_numeric($type))
            return $love[$type];
        else return $love;
    }
    public static function formatDate($date){
        return date('m/d/Y', strtotime($date));
    }
} 
