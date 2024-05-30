<?php

namespace Lei\Project\rule;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Model extends Base {

    private string $tag = "Model";
    private  string $baseModelPath = "";


    public  function begin(bool $softDelete)
    {

        $replaceParams = [
            'className' => "$this->originClassName$this->tag",
            'namespace' => $this->namespaceName,
            'table_name' => $this->tableName,
            'softDelete' => $softDelete,  //是否软删除
            'field' => $this->fields,
        ];


        $loader = new FilesystemLoader($this->templateDir);
        $twig = new Environment($loader);
        $template =  $twig->render('model',$replaceParams);

        $class_file = app_path(DIRECTORY_SEPARATOR."model".$this->layerFile."$this->tag.php");

        if(!file_exists($class_file)){
            $position = strrpos($class_file,DIRECTORY_SEPARATOR);
            $path = substr($class_file,0,$position);
            if(!file_exists($path)){
                mkdir($path,0777,true);
            }
            $fp=fopen($class_file,"w+");//fopen()的其它开关请参看相关函数
            fputs($fp,$template);
            fclose($fp);
            echo "====【成功】Model文件 生成成功=====\n";
            echo "{$class_file}\n";
        }else{
            echo "=====【错误】Model文件 已存在  停止生成 =====\n";
        }

    }





}