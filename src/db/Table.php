<?php

namespace Tulei\Project\db;


use think\Exception;
use think\facade\Db;
class Table {
    private string $tableName = "";  //数据库表名称
    private array $columns = [];  //表列

    public  function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        $result = Db::query('SHOW FULL COLUMNS FROM `' . $this->tableName . '`');
        if($result) $this->columns = $result;
//        throw new Exception("数据不存在！");
    }

    /**
     * @return array
     * 获取表的列信息
     */
    public  function getColumns():array
    {
        return $this->columns;
    }

    /**
     * @return array
     * 获取列的全部字段
     */
    public function getFields():array
    {
        $columns =  $this->columns;
        $result = [];
        foreach ($columns as $key => $value){
            $result[] = $value['Field'];
        }
        return $result;
    }




}