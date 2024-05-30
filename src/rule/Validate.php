<?php

namespace Lei\Project\rule;


use Lei\Project\Utils;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Validate extends Base {


    private string $tag = "Validate";
    private  string $baseModelPath = "";
    public  function begin()
    {

        //替换
        $replaceParams = [
            'className' => $this->originClassName.$this->tag,
            'namespace' => $this->namespaceName,
            'rule' => $this->getRules($this->layerName)['rule'],
            'create' =>  $this->getRules($this->layerName)['create'],
        ];



        $loader = new FilesystemLoader($this->templateDir);
        $twig = new Environment($loader);
        $template =  $twig->render('validate',$replaceParams);
        $class_file = app_path(DIRECTORY_SEPARATOR."validate".$this->layerFile."$this->tag.php");

        if(!file_exists($class_file)){
            $position = strrpos($class_file,DIRECTORY_SEPARATOR);
            $path = substr($class_file,0,$position);
            if(!file_exists($path)){
                mkdir($path,0777,true);
            }
            $fp=fopen($class_file,"w+");//fopen()的其它开关请参看相关函数
            fputs($fp,$template);
            fclose($fp);
            echo "====【成功】验证器 Validate 文件 生成成功=====\n";
            echo "{$class_file}\n";
        }else{
            echo "=====【错误】验证器 Validate 文件 已存在  停止生成 =====\n";
        }

    }


    //规则信息
    //phone email  array  accepted
    //  alpha  alphaNum  alphaDash  chs chsAlpha  chsAlphaNum  chsDash
    //   lower  upper
    //  activeUrl  url  ip
    //  dateFormat:format  date  datetime
    //mobile  idCard

    //生成验证器的相关规则
    private function getRules($layerDir):array
    {

        $columns = $this->columns;

        $rules = [];
        $createField = [];
        foreach ( $columns as  $index => $item){
            if($item['Field'] == 'id'){
                $rules[] = [
                    'key' => 'id|id',
                    'value' =>  "require|Model:".$layerDir.",id",
                ];
            }else{
                $ruleArray = [];
                if($item["Null"] == "NO"){  //Null  是否为空 （Yes,No）
                    $ruleArray[] = "require";
                    $createField[] = $item['Field'];
                }
                //Type  类型  int(11)  decimal(10,2)    提取括号内容 然后去掉括号里面的内容
                $s = Utils::tableFieldReg($item['Type']);
                if($s['type'] == 'int'){
                    $ruleArray[] = "integer";
                }
                if($s['type'] == 'decimal'){
                    $ruleArray[] = "float";
                }
                if($s['type'] == 'date'){
                    $ruleArray[] = "date";
                }
                if($s['type'] == 'datetime'){
                    $ruleArray[] = "datetime";
                }
                if($s['type'] == 'varchar'){
                    $ruleArray[] = "length:0,".$s['value'];
                }

                $rule = implode("|",$ruleArray);
                $rules[] = [
                    'key' => $item['Field']."|".$item['Comment'],
                    'value' => $rule
                ];

            }

        }


        return [
            'rule' => $rules,
            'create' => $createField,
        ];
    }


}