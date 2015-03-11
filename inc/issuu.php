<?php

/* Simple Issuu Wordpress API
*  Author: Gavin Langdon (puttabutta@gmail.com)
*  Communicates with the Issuu JSON api to fetch latest issues neatly
*/

class Issuu_Document {
  private $json;
  function __construct($json) {
    $this->json = $json;
  }
  
  public function getURL() {
    return 'http://issuu.com/'.$this->getUsername().'/docs/'.$this->getName();
  }
  
  public function getThumb() {
    return '<img src="http://image.issuu.com/'.$this->getID().'/jpg/page_1_thumb_large.jpg">';
  }
  
  public function getTitle() {
    $t = str_replace('The Statesman', '', $this->json->title);
    $t = str_replace('Statesman', '', $t);
    $t = trim($t, ' :');
    return $t;
  }
  
  public function getID() {
    return $this->json->documentId;
  }
  
  public function getUsername() {
    return $this->json->username;
  }
  
  public function getName() {
    return $this->json->name;
  }
  
  public function getDate($format = 'F d, Y') {
    return date($format, strtotime($this->json->publishDate));
  }
  
  public function output() {
    $out = '';
    // Support the scriptless peons
    $out .= '<noscript><a href="'.$this->getURL().'">'.$this->getThumb().'<h1>'.$this->getTitle().'</h1></a></noscript>';
    $out .= '<a href="#" data-docId="'.$this->getID().'">'.$this->getThumb().'<h2>'.$this->getTitle().'</h2></a>';
    $out .= '<p>'.$this->getDate().'</p>';
    
    return $out;
  }
  public function outputLink() {
    $out = '';
    $out .= '<a href="'.$this->getURL().'">'.$this->getDate().'</a>';
    
    return $out;
  }
}


class Issuu_Request {
  private static $apikey = 'wglihwlyv81eqfxjsktu7dmmyapxn37p';
  private static $secret = 't2jk9r1r2xqiqyuhzgp0n35ksvjq64yi';
  
  protected $data;
  private $url;
  
  function __construct($req_arr) {
    $this->url = $this->getRequestURL($req_arr);
  }
  
  /** Issue the request to Issuu and return True if it succeeded */
  public function fetch() {
    $ret = json_decode(file_get_contents($this->url));
    
    $this->data = NULL;
    
    if ($ret->rsp->stat == 'ok') {
      $this->data = $ret->rsp->_content->result;
      return True;
    }
    return False;
  }
  
  private static function concatRequest($req_arr) { 
    ksort($req_arr);
    
    $ret = '';
    foreach ($req_arr as $key => $value) { 
      $ret .= $key.$value;
    }
    
    return self::$secret.$ret;
  }
  
  /* Use a hash of the secret and the request to sign the request.
   * Returns: a signed request (request with the signature field filled out) */
  private static function signRequest($req_arr) {    
    $req_arr['apiKey'] = self::$apikey;
    $req_arr['format'] = 'json';
    
    $req_arr['signature'] = md5(self::concatRequest($req_arr));
    
    return http_build_query($req_arr);
  }
  
  private static function getRequestURL($req_arr) {
    return 'http://api.issuu.com/1_0?'.self::signRequest($req_arr);
  }
}

class Issuu_List_Issues extends Issuu_Request {
  protected $page, $pagesize;
  function __construct($page = 0, $pagesize = 12) {
    $this->page = $page;
    $this->pagesize = $pagesize;
  
    parent::__construct(array('action' => 'issuu.documents.list',
    'startIndex' => $page * $pagesize,
    'responseParams' => 'documentId,title,publishDate,name,username',
    'documentStates' => 'A',
    'orgDocTypes' => 'pdf',
    'pageSize' => $pagesize,
    'documentSortBy' => 'publishDate',
    'resultOrder' => 'desc'));
  }
  
  protected function getDocuments() {
    $arr = array();
    foreach ($this->data->_content as $json) {
      $arr[] = new Issuu_Document($json->document);
    }
    return $arr;
  }
  
  public function getPostCount() {
    return $this->data->totalCount;
  }
  
  public function isMorePosts() {
    return (int)$this->data->more != 0;
  }
  
  private function pagination($needboth = False) {   
    if ($needboth && ($this->page <= 0 || !$this->isMorePosts())) {
      return;
    }
    
    $nextpage = $this->page + 1;
    $prevpage = $this->page - 1;
    
    $out = '';
    if ($this->isMorePosts()) {
      $out .= '<div class="nav-previous"><a href="'.get_page_link().$nextpage.'"><span class="meta-nav">&larr;</span> Older issues</a></div>';
    }
            
    if ($this->page > 0) {
      $out .= '<div class="nav-next"><a href="'.get_page_link().$prevpage.'">Newer issues <span class="meta-nav">&rarr;</span></a></div>';
    }
    
    return $out;
  }
  
  protected function getEmbedder() {
    return '<div id="issue-embed"><div id="issue-embed-interior"></div><div id="close-embed"></div></div>';
  }
  
  protected function getScript() {
    return '<script src="'.get_template_directory_uri().'/js/virtual-issues.js"></script>';
  }
  
  public function output() {
    $out = '';
		$out .= $this->getEmbedder();
    $out .= $this->pagination(True);

    $out .= '<ul id="virtual-issues">';

    foreach ($this->getDocuments() as $doc) {
      $out .= '<li>';
      $out .= $doc->output();
      $out .= '</li>';
    }

    $out .= '</ul>';

    $out .= $this->pagination();
    		    
    $out .= $this->getScript();
    
    return $out;
  }
}

class Issuu_Latest_Issue extends Issuu_List_Issues {
  function __construct() {
    parent::__construct(0, 1);
  }
  
  public function output() {
    $arr = $this->getDocuments();
    
    $out = '';
 		$out .= $this->getEmbedder();
    $out .= $arr[0]->output();
    $out .= $this->getScript();
    
    return $out;
  }

  public function outputLink() {
    $arr = $this->getDocuments();
    
    $out = '';
    $out .= $arr[0]->outputLink();
    
    return $out;
  }
}

  
?>