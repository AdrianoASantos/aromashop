<?php

namespace MF;

use Rain\Tpl;

class Page {

    private $tpl;
    private $options = array();
    private $defaults = array(
        "data"=>array()
    );

    public function __construct($opt = array()){
        $this->options = array_merge($this->defaults, $opt);

        $config = array(
            "tpl_dir"=>$_SERVER['DOCUMENT_ROOT']. "/views/site/",
            "cache_dir"=>$_SERVER['DOCUMENT_ROOT']. "/viewscache/",
            "debug"=>false
        );

        Tpl::configure($config);

        $this->tpl = new Tpl();

        $this->setData($this->options['data']);

        $this->tpl->draw("header");
    }

    public function setData($data = array()){
        foreach ($data as $key => $value) {
            $this->tpl->assign($key,$value);
        }
    }

    public function setTpl($name, $data = array(), $returnHtml = false){
        $this->setData($data);

        return $this->tpl->draw($name,$returnHtml);
    }

    public function __destruct(){
        $this->tpl->draw("footer");
    }

}





?>