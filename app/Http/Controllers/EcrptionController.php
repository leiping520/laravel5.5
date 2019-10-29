<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Crypt;

use Request;

class EcrptionController extends Controller
{
    //

    public function index(Request $request)
    {
        echo 12345;
//dd($request::keys());
//       echo $encrypter->encrypt('3456786545') . '</br>';
       echo Crypt::encrypt('3456786545');



    }


}
