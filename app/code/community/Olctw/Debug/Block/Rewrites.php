<?php

class Olctw_Debug_Block_Rewrites extends Olctw_Debug_Block_Abstract {


    /**
     * Return all rewrites
     *
     * @return array All rwrites
     */
    protected function _loadRewrites()
    {
        $fileName = 'config.xml';
        $modules  = Mage::getConfig()->getNode('modules')->children();

        $return = array();
        foreach ($modules as $modName => $module) {
            if ($module->is('active')) {
                $configFile = Mage::getConfig()->getModuleDir('etc', $modName) . DS . $fileName;
                if (file_exists($configFile)) {
                    $xml = file_get_contents($configFile);
                    $xml = simplexml_load_string($xml);

                    if ($xml instanceof SimpleXMLElement) {
                        $return[$modName] = $xml->xpath('//rewrite');
                    }
                }
            }
        }

        return $return;
    }
    
    
    /**
     * Retrieve a collection of all rewrites
     *
     * @return Varien_Data_Collection Collection
     */
    public function getItems()
    {
        $items = array();
        $rewrites   = $this->_loadRewrites();

        foreach ($rewrites as $rewriteNodes) {
            foreach ($rewriteNodes as $n) {
                $nParent    = $n->xpath('..');
                $module     = (string) $nParent[0]->getName();
                $nSubParent = $nParent[0]->xpath('..');
                $component  = (string) $nSubParent[0]->getName();

                if (!in_array($component, array('blocks', 'helpers', 'models'))) {
                    continue;
                }

                $pathNodes = $n->children();
                foreach ($pathNodes as $pathNode) {
                    $path = (string) $pathNode->getName();
                    $completePath = $module.'/'.$path;

                    $rewriteClassName = (string) $pathNode;

                    $instance = Mage::getConfig()->getGroupedClassName(
                        substr($component, 0, -1),
                        $completePath
                    );
                    
                    $refObj = new ReflectionClass($rewriteClassName);

                    $items[$component][$completePath][] = array(
                        'object' => $rewriteClassName, //class that rewrites it
                        'file' => $refObj->getFileName(),
                        'active' => ($instance == $rewriteClassName)
                    );
                }
            }
        }
        ksort($items);
        return $items;
    }



    /*
     * Forked from http://marius-strajeru.blogspot.tw/2013/03/get-class-rewrites.html
     */

    protected function aaagetItems() {
        $folders = array('app/code/local/', 'app/code/community/'); //folders to parse
        $configFiles = array();
        foreach ($folders as $folder) {
            $files = glob($folder . '*/*/etc/config.xml'); //get all config.xml files in the specified folder
            if (is_array($files)) {
                $configFiles = array_merge($configFiles, $files); //merge with the rest of the config files
            }
        }
        $items = array(); //list of all rewrites

        foreach ($configFiles as $file) {
            $dom = new DOMDocument;
            $dom->loadXML(file_get_contents($file));
            $xpath = new DOMXPath($dom);
            $path = '//rewrite/*'; //search for tags named 'rewrite'
            $text = $xpath->query($path);
            foreach ($text as $rewriteElement) {
                $type = $rewriteElement->parentNode->parentNode->parentNode->tagName; //what is overwritten (model, block, helper)
                $parent = $rewriteElement->parentNode->parentNode->tagName; //module identifier that is being rewritten (core, catalog, sales, ...)
                $name = $rewriteElement->tagName; //element that is rewritten (layout, product, category, order)
                foreach ($rewriteElement->childNodes as $element) {
                    Zend_Debug::dump($element->textContent);
                    continue;
                    $refObj = new ReflectionClass($element->textContent);
                    if(!is_object($refObj)){
                        continue;
                    }
                    $items[$type][$parent . '/' . $name][] = array(
                        'object' => $element->textContent, //class that rewrites it
                        'file' => $refObj->getFileName(),
                    );
                }
            }
        }
        ksort($items);
        return $items;
    }

}

