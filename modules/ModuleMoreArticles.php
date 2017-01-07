<?php


class ModuleMoreArticles extends \Module{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_more_articles';


    /**
     * Display a wildcard in the back end
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {

            /** @var \BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['customer_calendar'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {

         if (!\Input::get('articles') ){
             return '';
         }

        global $objPage;
        $t = 'tl_article';

        $current_article_id = $this->getCurrentArticleId();

        $arrOptions = array(
            'limit'     => $this->article_limit,
            'column'    => array("$t.id!=? AND $t.pid=?"),
            'value'     => array($current_article_id, $objPage->id)
           // 'order' =>"$t.sorting",

        );
        $objArticles = \Contao\ArticleModel::findPublishedByPidAndColumn($objPage->id,'main',$arrOptions );

        $articles = $objArticles->fetchAll();


        foreach($articles as $k=>$j) {
/*            if ($current_article_id == $articles[$k]['id']){
                unset($articles[$k]);
            }*/
            if ($articles[$k]['addImage']==1) {
                $objFile = \FilesModel::findByPk($articles[$k]['singleSRC']);

                if ($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path)) {
                    $arrImage = array();
                } else {
                    $articles[$k]['singleSRC'] = $objFile->path;

                    $arrImage = array
                    (
                        'addImage' => $articles[$k]['addImage'],
                        'singleSRC' => $articles[$k]['singleSRC'],
                        'alt' => $articles[$k]['alt'],

                    );
                }

                parent::addImageToTemplate($this->Template, $arrImage);
            }
         }


        $this->Template->headline   = $this->headline;
        $this->Template->articles   = $articles;
        $this->Template->page_title = $objPage->title;
        $this->Template->page_href  = $objPage->getFrontendUrl();
        //echo '<pre>';print_r($this->Template->articles );echo '</pre>';
    }

    function getCurrentArticleId(){
        global $objPage;

        if ($this->Input->get("articles")!=="")
        {
            $articleAlias=$this->Input->get("articles");
            $articleId=$this->Database->prepare("SELECT id FROM tl_article WHERE alias=? ORDER BY sorting ASC")
                ->limit(1)
                ->execute($articleAlias);
            return $articleId->id;
        }

        return 0;
    }
}

?>