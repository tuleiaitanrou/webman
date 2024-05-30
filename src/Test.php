<?php

namespace Lei\Project;

use Lei\Project\rule\Model;
use Lei\Project\rule\Validate;

class Test {



    public function unit()
    {
        (new Model("aaaTest","test.v1.User"))->begin(false);
        (new Validate("aaaTest",'test.v1.User'))->begin();

    }




}