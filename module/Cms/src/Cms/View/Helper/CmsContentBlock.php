<?php
/**
 * ZF2 Buch Kapitel 22
 * 
 * Das Buch "Zend Framework 2 - Das Praxisbuch"
 * von Ralf Eggert ist im Galileo-Computing Verlag erschienen. 
 * ISBN 978-3-8362-2610-3
 * 
 * @package    Cms
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Alle Listings sind urheberrechtlich geschützt!
 * @link       http://www.zendframeworkbuch.de/ und http://www.galileocomputing.de/3460
 */

/**
 * namespace definition and usage
 */
namespace Cms\View\Helper;

use Cms\Service\CmsServiceInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Cms content block
 * 
 * Provides cms content block output and manipulation
 * 
 * @package    Cms
 */
class CmsContentBlock extends AbstractHelper
{
    /**
     * @var CmsServiceInterface
     */
    protected $cmsService;

    /**
     * Constructor
     *
     * @param  CmsServiceInterface $cmsService
     */
    public function __construct(CmsServiceInterface $cmsService)
    {
        $this->setCmsService($cmsService);
    }

    /**
     * Sets comment cmsService
     *
     * @param  CmsServiceInterface $cmsService
     * @return AbstractHelper
     */
    public function setCmsService(CmsServiceInterface $cmsService = null)
    {
        $this->cmsService = $cmsService;
        return $this;
    }
    
    /**
     * Returns CmsService
     *
     * @return CmsServiceInterface
     */
    public function getCmsService()
    {
        return $this->cmsService;
    }
    
    /**
     * Returns itself
     *
     * @return Cms 
     */
    public function __invoke($block, $url)
    {
        // get content
        $content = $this->getCmsService()->loadBlock($block);
        
        // check edit rights
        if (!$this->getView()->userIsAllowed('cms')) {
            return $content;
        }
        
        // add CKEditor JS
        $this->getView()->headScript()->appendFile(
            $this->getView()->basePath() . '/js/ckeditor/ckeditor.js', 
            'text/javascript'
        );
        
        // add CMS JS
        $this->getView()->headScript()->appendFile(
            $this->getView()->basePath() . '/js/cms.js',
            'text/javascript'
        );
        
        // set form action 
        $action = $this->getView()->url('cms', array('action' => 'save'));
        
        // get content block form
        $form = $this->getCmsService()->getForm($block, $url);
        $form->setAttribute('action', $action);
        
        // set uneditable block
        $start = '<div id="' . $block . '_uneditable" class="cms">';
        $start.= $content;
        $start.= '</div>';
        
        // create start html
        $start.= '<div id="' . $block . '" contenteditable="true" style="display: none;">';
        
        // create end html
        $end = '</div>';
        $end.= $this->getView()->form()->openTag($form);
        $end.= $this->getView()->formHidden($form->get('url'));
        $end.= $this->getView()->formHidden($form->get('block'));
        $end.= $this->getView()->formHidden($form->get('content'));
        $end.= $this->getView()->formButton($form->get('cms_edit_' . $block));
        $end.= $this->getView()->formButton($form->get('cms_save_' . $block));
        $end.= $this->getView()->formButton($form->get('cms_cancel_' . $block));
        $end.= $this->getView()->form()->closeTag();
        
        // return view helper
        return $start . $content . $end;
    }
}
