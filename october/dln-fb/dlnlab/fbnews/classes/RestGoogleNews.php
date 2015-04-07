<?php

namespace DLNLab\FBNews\Classes;

use Auth;
use DB;
use Input;
use Response;
use Request;
use Redirect;
use Validator;
use Illuminate\Routing\Controller as BaseController;
use October\Rain\Support\ValidationException;
use DLNLab\FBNews\Classes\HelperNews;

require('HelperResponse.php');

class RestGoogleNews extends BaseController {

    public function getNews() {
        $data = get();
        $default = array (
            'topic' => ''
        );
        extract(array_merge($default, $data));

        $tp = '';
        switch($topic) {
            case 'giaitri':
                $tp = 'e';
                break;

            case 'thegioi':
                $tp = 'w';
                break;

            case 'vietnam':
                $tp = 'n';
                break;

            case 'kinhdoanh':
                $tp = 'b';
                break;

            case 'thethao':
                $tp = 's';
                break;
        }


    }

}