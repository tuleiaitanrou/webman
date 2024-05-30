<?php

namespace Lei\Project;

use Lei\Project\rule\Model;
use Lei\Project\rule\Validate;

class App {



    private bool $force = false; //是否强制生成解析
    //需要过滤掉的数据
    private array $filterFields = ["created_at",'updated_at','deleted_at'];

    //是否启用软删除
    private bool $softDelete = false;

    private string $modelTemplate = "";
    private string $validateTemplate = "";


    public function __construct()
    {
        $this->modelTemplate =  __DIR__.DIRECTORY_SEPARATOR."rule".DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."model";
        $this->validateTemplate =  __DIR__.DIRECTORY_SEPARATOR."rule".DIRECTORY_SEPARATOR."template".DIRECTORY_SEPARATOR."validate";;
        //1,模板文件检查
        if(!file_exists($this->modelTemplate)){
            Utils::console("model模板文件不存在".$this->modelTemplate);
        }
        if(!file_exists($this->validateTemplate)){
            Utils::console("validate模板文件不存在".$this->modelTemplate);
        }
    }

    //生成文件
    public function run(string $tableName,string $layerName,bool $softDelete = false ) :void
    {
//        (new Model("aaaTest","test.v1.User"))->begin(false);
//        (new Validate("aaaTest",'test.v1.User'))->begin();
        (new Model($tableName,$layerName))->begin($softDelete);  //生成数据模型
        (new Validate($tableName,$layerName))->begin();     //生成验证器数据模型
    }


    //单独生成Model
    public function GenModel(string $tableName,string $layerName,bool $softDelete = true)
    {
        (new Model($tableName,$layerName))->begin($softDelete);  //生成数据模型
    }

    //单独生成Validate
    public function GenValidate(string $tableName,string $layerName)
    {
        (new Validate($tableName,$layerName))->begin();     //生成验证器数据模型
    }








}