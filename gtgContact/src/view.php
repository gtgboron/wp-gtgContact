<?php
class GtgContactView{
    private $pluginPath;

    function __construct($path){
        $this->$pluginPath = $path;
        
    }
    public function SettingSectionCallbackFunction() {
        $this->Render('admin/settings-main-title');
    }
    public function TitleCallbackFunction(){
        $this->Render('admin/settings-title');
    }
    public function Address1CallbackFunction(){
        $this->Render('admin/settings-address-1');
    }
    public function Address2CallbackFunction(){
        $this->Render('admin/settings-address-2');
    }
    public function Address3CallbackFunction(){
        $this->Render('admin/settings-address-3');
    }
    public function Telephone1CallbackFunction(){
        $this->Render('admin/settings-telephone-1');
    }
    public function Telephone2CallbackFunction(){
        $this->Render('admin/settings-telephone-2');
    }
    public function EmailCallbackFunction(){
        $this->Render('admin/settings-email');
    }
    public function MapCallbackFunction(){
        $this->Render('admin/settings-map');
    }
    public function Render($path,$args=array(),$render=1){
        ob_start();
        include  $this->$pluginPath . 'templates/'.$path.'.php';
        $content = ob_get_contents();
        ob_end_clean();
        
        if(!$render)
            return $content;
        echo $content;
    }
}