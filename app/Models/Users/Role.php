<?php

namespace App\Models\Users;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    static public function getAlltoSelectList(array $fields = ['id', 'display_name'], $api = false)
    {
        $op = self::get()->map(function ($s) use ($fields) {
            return [
                'id' => $s->{$fields[0]},
                'description' => $s->{$fields[1]}
            ];
        });
        return ($api) ? $op : $op->pluck('description', 'id');
    }

}