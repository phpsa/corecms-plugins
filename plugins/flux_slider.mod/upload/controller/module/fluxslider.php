<?php

class ControllerModuleFluxslider extends \Core\Controller {

    public function index($setting) {
        static $module = 0;

        $this->load->model('cms/banner');
        $this->load->model('tool/image');

        $this->document->addStyle('view/plugins/fluxslider/flux.css');
        $this->document->addScript('view/plugins/fluxslider/flux.js');


        $data['autoplay'] = $setting['autoplay'];
        $data['pagination'] = $setting['pagination'];
        $data['controls'] = $setting['controls'];
        $data['captions'] = $setting['captions'];
        $data['delay'] = $setting['delay'];
        
        $data['banners'] = array();

      //  debugPre($setting);
      //  exit;
        
        $results = $this->model_cms_banner->getBanner($setting['banner_id']);

        foreach ($results as $result) {
            if (is_file(DIR_IMAGE . $result['image'])) {
                if($setting['crop']){
                    $image = $this->model_tool_image->resizeCrop($result['image'], $setting['width'], $setting['height']);
                  
                }else{
                    $image = $this->model_tool_image->resizeExact($result['image'], $setting['width'], $setting['height']);
                }
                $data['banners'][] = array(
                    'title' => $result['title'],
                    'link' => $result['link'],
                    'image' => $image
                );
            }
        }

        $data['module'] = $module++;



        return $this->render('module/fluxslider.phtml', $data);
    }

}

