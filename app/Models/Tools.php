<?php

namespace App\Models;

class Tools
{
    public function codeDeleted($code)
    {
        $deleted = session('currentDeleted');

        if(\in_array($code, $deleted)) {
            return true;
        }

        return false;
    }
}
