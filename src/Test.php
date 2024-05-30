<?php

namespace Tulei\Project;

use Tulei\Project\rule\Model;
use Tulei\Project\rule\Validate;

class Test {



    public function unit()
    {
        (new Model("aaaTest","test.v1.User"))->begin(false);
        (new Validate("aaaTest",'test.v1.User'))->begin();

    }




}