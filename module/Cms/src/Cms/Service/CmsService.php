<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Von den Grundlagen bis zur fertigen Anwendung"
 * von Ralf Eggert ist im Addison-Wesley Verlag erschienen. 
 * ISBN 978-3-8273-2994-3
 * 
 * @package    Cms
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.awl.de/2994
 */

/**
 * namespace definition and usage
 */
namespace Cms\Service;

use Cms\Form\ContentBlockForm;
use Cms\Form\ContentBlockFormInterface;

/**
 * Cms Service
 * 
 * @package    Cms
 */
class CmsService implements CmsServiceInterface
{
    /**
     * Load content block
     *
     * @param string $block
     * @return string
     */
    public function loadBlock($block)
    {
        // build file name
        $fileName = LUIGI_ROOT . '/data/cms/' . $block . '.html';
        
        // check file
        if (!file_exists($fileName)) {
            return '';
        }
        
        // get content
        $content = implode('', file($fileName));
        
        // return content
        return $content;
    }
    
    /**
     * Get form data
     *
     * @param array $data
     * @return array
     */
    public function getFormData($data)
    {
        // validate form
        $form = new ContentBlockForm();
        $form->addHiddenElement('url');
        $form->addHiddenElement('block');
        $form->addHiddenElement('content');
        $form->setData($data);
        $form->isValid();
        
        return $form->getData();
    }
    
    /**
     * Get form
     *
     * @param string $block
     * @param string $url
     * @return ContentBlockFormInterface
     */
    public function getForm($block, $url)
    {
        $form = new ContentBlockForm('block_' . $block);
        $form->addHiddenElement('url', $url);
        $form->addHiddenElement('block', $block);
        $form->addHiddenElement('content');
        $form->addButtonElement(
            'cms_edit_' . $block, 'Bearbeiten', 
            'cmsEditContentBlock(\'' . $block . '\');', false
        );
        $form->addButtonElement(
            'cms_save_' . $block, 'Speichern',
            'cmsSaveContentBlock(\'' . $block . '\');'
        );
        $form->addButtonElement(
            'cms_cancel_' . $block, 'Abbrechen',
            'cmsCancelContentBlock(\'' . $block . '\');'
        );
        $form->prepare();
        
        return $form;
    }
    
    /**
     * Save content block
     *
     * @param string $block
     * @param string $content
     * @return string
     */
    public function saveBlock($block, $content)
    {
        // build file name
        $fileName = LUIGI_ROOT . '/data/cms/' . $block . '.html';
    
        // write data to file
        file_put_contents($fileName, $content);
        
        return true;
    }
}
