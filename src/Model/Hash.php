<?php

namespace Dudoserovich\ModifyChat\Model;

class Hash
{
    static public function pw_encode($password): string
    {
        $seed = '';
        for ($i = 1; $i <= 10; $i++)
            $seed .= substr('0123456789abcdef', rand(0,15), 1);
        return sha1($seed.$password.$seed).$seed;
    }

    static public function pw_check($password, $stored_value): bool
    {
        if (strlen($stored_value) != 50)
            return FALSE;
        $stored_seed = substr($stored_value,40,10);

        if (sha1($stored_seed.$password.$stored_seed).$stored_seed == $stored_value)
            return TRUE;
        else
            return FALSE;
    }
}