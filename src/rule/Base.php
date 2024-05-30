<?php

namespace Lei\Project\rule;


use Lei\Project\db\Table;
use Lei\Project\Utils;

class Base {

    protected  string $templateDir = "";

    protected  array $columns = []; //完整的列
    protected  array $fields = []; //全部字段
    protected string $originClassName = ""; //原始className   system.v1.Test ==> Test
    protected  string $namespaceName =""; //命名空间
    protected string   $layerFile;
    protected  string  $tableName = "";
    protected string $layerName = "";

    public function __construct(string $tableName,string $layerName)
    {
        $tableCon = new Table($tableName);
        $this->columns = $tableCon->getColumns();
        $this->fields = $tableCon->getFields();
        $this->namespaceName = Utils::getNamespaceByLayerName($layerName);
        $this->originClassName = Utils::getClassNameByLayerName($layerName);
        $this->layerFile = Utils::getLayerFileByLayerName($layerName);
        $this->tableName = $tableName;
        $this->layerName = $layerName;
        $this->templateDir = __DIR__ .DIRECTORY_SEPARATOR. 'template';
    }




}