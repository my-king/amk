<?php
/**
 * Description of TWin8TemplateHelper
 *
 * @author igorsantos
 */
class TWin8Helper {
    
    public static function displayToolBar(array $icons = array()){
        return TToolBarHelper::getInstancia()->getToolBar($icons);
    }
    
     public static function displayBreadCrumb(){
        return TBreadCrumbHelper::getInstancia()->getBreadCrumb();
    }
    
    public static function displayIniStart($image,$url = "Principal") {
        
        return "<div id='ini-start'>
                    <div id='start'>
                        <a href='".PATH_URL."index.php?{$url}'>
                            <img src='{$image}' width='120px' height='75px'>
                        </a>
                    </div>
                </div>";
    }
    
}

?>
