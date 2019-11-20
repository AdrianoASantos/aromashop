<?php

namespace MF;

use Rain\Tpl;

class PageAdmin{

    private $tpl;
    private $options = array();
    private $defaults = array(
        "data"=>array(),
        "header"=>true,
        "footer"=>true
    );

    public function __construct($opt = array()){
        $this->options = array_merge($this->defaults, $opt);

        $config = array(
            "tpl_dir"=>$_SERVER['DOCUMENT_ROOT'] . "/views/admin/",
            "cache_dir"=>$_SERVER['DOCUMENT_ROOT'] . "/viewscache/",
            "debug"=>false
        );

        Tpl::configure($config);

        $this->tpl = new Tpl();

        $this->setdata($this->options['data']);

        if($this->options['header'] === true ){
            $this->tpl->draw("header");
        }
    }

    public function setData($data = array()){
        foreach($data as $key => $value){
            $this->tpl->assign($key,$value);
        }
    }

    public function setTpl($name , $data =array(), $returnHTML = false){
        $this->setData($data);

        return $this->tpl->draw($name,$returnHTML);
    }

    public function __destruct(){
        if($this->options['footer'] === true){
            $this->tpl->draw("footer");
        }
    }


}












?>