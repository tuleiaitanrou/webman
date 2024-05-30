<?php

namespace Tulei\Project;


const SP = DIRECTORY_SEPARATOR;

/**
 * 工具类
 */
class Utils {


    /**
     * @param $info
     * @param $type
     * @return void
     */
    public static  function console($info,$type = 0)
    {
        if($type == 0){
            echo "=======【ERROR】 ".$info." \n";
        }else{
            echo "=======【INFO】 ".$info."  \n";
        }
    }


    /*
     * 获取某个文件夹下的所有文件列表
     */
    public function getFiles($path,&$finename)
    {
        $resource = opendir($path);
        while ($rows = readdir($resource)){
            if( is_dir($path.SP.$rows) && $rows != "." && $rows != "..")
            {
                $this->getFiles($path.SP.$rows,$finename);
            }elseif($rows != "." && $rows != "..")
            {
                $finename[] = $rows;
            }
        }
    }


    /**
     * @param $name
     * @return string
     *
     * 文本数据解析
     * example admin.v1.Test  ==> /admin/v1/Test
     */
    public static function getLayerFileByLayerName($name):string
    {
        $tree = explode(".",$name);
        $treeFile = "";
        foreach ($tree as $key => $value){
            $treeFile = $treeFile.DIRECTORY_SEPARATOR.$value;
        }
        return $treeFile;
    }

    //获取命名空间  example  admin.v1.Test  ==>  admin\v1
    public static function getNamespaceByLayerName($name):string
    {
        $tree = explode(".",$name);
        $treeFile = "";
        array_pop($tree);
        foreach ($tree as $key => $value){
            $treeFile = "$treeFile\\$value";
        }
        return $treeFile;
    }

    //获取类名字     example  admin.v1.Test  ==>  Test
    public static function getClassNameByLayerName($name):string
    {
        $tree = explode(".",$name);
        return $tree[count($tree)-1];
    }


    public static function tableFieldReg($dbType):array
    {
        $type = preg_replace('/\(.*?\)/', '', $dbType);
        $result = array();
        preg_match("#\((.+?)\)#us", $dbType, $result);
        $value = "";
        if(count($result) > 0 ){
            $value =  $result[1];  //括号里面的内容
        }
        return [
            'type' => $type,
            'value' => $value
        ];
    }


}