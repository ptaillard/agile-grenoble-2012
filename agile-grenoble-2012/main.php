<?php
/**
 * Doogies Dokuwiki Template
 *
 * You should leave the doctype at the very top - It should
 * always be the very first line of a document.
 *
 * @link   http://wiki.splitbrain.org/wiki:tpl:templates
 * @author Andreas Gohr <andi@splitbrain.org>
 * @author Robert Rackl
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

//get needed language array
include DOKU_TPLINC."lang/en/lang.php"; 
//overwrite English language values with available translations
if (!empty($conf["lang"]) &&
    $conf["lang"] != "en" &&
    file_exists(DOKU_TPLINC."/lang/".$conf["lang"]."/lang.php")){
    //get language file (partially translated language files are no problem
    //cause non translated stuff is still existing as English array value)
    include DOKU_TPLINC."/lang/".$conf["lang"]."/lang.php";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>
    <?php echo strip_tags($conf['title'])?>
    [<?php tpl_pagetitle()?>]
  </title>

  <?php tpl_metaheaders()?>

  <link rel="shortcut icon" href="<?php echo DOKU_TPL?>images/favicon.ico" />

  <?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?>

 <?php $cssfile = dirname(__FILE__).'/stylesheets/'.$ID.'.css'; ?>
  <?php if ( file_exists($cssfile) ) { ?>
    <?php $cssfile = DOKU_TPL.'stylesheets/'.$ID.'.css'; ?>
    <?php echo "<link rel=\"stylesheet\" media=\"all\" type=\"text/css\" href=\"".$cssfile."\"/>"; ?>
  <?php } ?>

  <?php $jsfile = dirname(__FILE__).'/javascripts/'.$ID.'.js'; ?>
  <?php if ( file_exists($jsfile) ) { ?>
    <?php $jsfile = DOKU_TPL.'javascripts/'.$ID.'.js'; ?>
    <?php echo "<script type=\"text/javascript\" src=\"".$jsfile."\"></script>"; ?>
  <?php } ?>

</head>

<?php
/**
 * prints a horizontal navigation bar (composed of <li> items and some CSS tricks)
 * with the current active item highlited
 */
function tpl_tabnavi(){
  global $ID;
  global $ACT;
  global $lang;
  global $YearConf;

  $navbar_tabs = array();
  $navbar = tpl_getConf('navbar');
  if(array_key_exists($YearConf, $navbar))
  {
    $get_year = $navbar[$YearConf];
    $title_nb = count($get_year["title"]);
    for($i=0; $i < $title_nb; $i++)
    {
      $title = $get_year["title"][$i];
      $target = $get_year["target"][$i];
      $navbar_tabs[$title] = $YearConf.$target;
    }
  }

  $current_page = manage_start_page();

  echo("<ul>\n");
  foreach ($navbar_tabs as $title => $target) {
    // only add tab if title and target are filled.
    if (empty($title) || empty($target)) {
      continue;
    }

    //check is user has enough rights to view target page (taken from fulltext.php)
    $targetID = cleanID($target);
    if (isHiddenPage($targetID) || auth_quickaclcheck($targetID) < AUTH_READ) {
      continue;
    }

    echo '<li';
    if (strcasecmp($current_page, $target) == 0 && $ACT == 'show') {  // if current page == this tab then show active style
      echo ' id="current"><div id="current_inner">'.$title.'</div>';
    } else {
      echo '>';
      tpl_link(wl($targetID), $title);  
    }
    echo "</li>\n";
  }
  // add link to recent page, if template config variable 'navbar_recent' is true
  if (tpl_getConf('navbar_recent')) {
    if ($ACT == 'recent') {
      echo('<li id="current"><div id="current_inner">'.$lang['btn_recent'].'</div></li>');
    } else {
      echo('<li>'); tpl_actionlink('recent','','',$lang['btn_recent']); echo("</li>\n");
    }
  }
  echo("</ul>\n");
}

function display_admin_options()
{
  if(isset($_SERVER['REMOTE_USER']))
  {
    echo "<div class='bar-admin' id='bar-admin__top'>";
    echo "<div class='bar-admin-left' id='bar-admin__topleft'>";
    tpl_button('edit');
    tpl_button('history');
    tpl_button('revert');
    echo "</div>";

    echo "<div class='bar-admin-right' id='bar-admin__topright'>";
    tpl_button('subscribe');
    tpl_button('subscribens');
    tpl_button('admin');
    tpl_button('profile');
    tpl_button('login');
    tpl_button('index');

    tpl_button('recent');
    tpl_searchform();
    echo "&nbsp;";
    echo "</div>";

    echo "<div class='clearer'></div>";
    echo "</div>";
  }
}

function extract_year_conf()
{
  global $ID;
  global $YearConf;

  $posFirst = strpos($ID, ":");
  $YearConf = substr($ID, 0, $posFirst);
  if(empty($YearConf) || !is_numeric($YearConf))
  {
    $YearConf = tpl_getConf('default_year');
  }
  $YearConf = (string)$YearConf;
}

function add_year_logo()
{
  global $YearConf;
  echo "<div class='logo".$YearConf."'>";
}

function add_text_agile()
{
  echo "<div class='pagename'>";
  echo "</div>";
}

function manage_start_page()
{
  global $ID;
  $current_page = $ID;
  if(strcasecmp($current_page, "start") == 0)
  {
    $current_page = tpl_getConf('default_year').":".$current_page;
  }
  return $current_page;
}

?>

<body>
<?php 
  html_msgarea();
  extract_year_conf();
?>
<div class="dokuwiki">
  <!-- login state -->
  <div class="user">
    <?php tpl_userinfo()?>
  </div>

  <div class="clearer"></div>

  <div class="stylehead">
    <div class="header">
      <div class="header_left"></div>
        <?php add_year_logo() ?>
      </div>
      <div class="header_right"></div>
      <?php add_text_agile() ?>

      <div id="tabnavi" class="tabnavi">
        <?php tpl_tabnavi() ?>
      </div>
      
      <div class="clearer"></div>
      <?php /*old includehook*/ @include(dirname(__FILE__).'/header.html')?>

    </div>  
  </div>
  <?php flush()?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>

  <?php display_admin_options() ?>

  <div class="page">
    <div class="contentpage">
      <!-- ......... wikipage start ......... -->
      <?php tpl_content()?>
      <!-- ......... wikipage stop  ......... -->
    </div>
  </div>
  
  <div class="clearer">&nbsp;</div>

  <?php flush()?>

  <?php display_admin_options() ?>
 
  <!-- footer -->  
  <div class="stylefoot">

    <?php /*old includehook*/ @include(dirname(__FILE__).'/pagefooter.html')?>

    <div class="bar" id="bar__bottom">
      
      <!-- page metadata -->
      <div class="meta">
        <!--
        <div class="doc">
          <?php 
            global $conf;
            global $auth;
            global $lang;
            if($conf['useacl'] && $auth){
              if($_SERVER['REMOTE_USER']){
                tpl_pageinfo();
              }
            }
          ?>
        </div>
        -->
      <!--  page actions -->
      <div class="bar-left" id="bar__bottomleft"> 
        <div class="bar-yearmenu">
          <?php tpl_include_page('yearmenu'); ?>
        </div>
      </div>

      <div class="clearer"></div>
      
    </div>

  </div>

</div>

<?php /*old includehook*/ @include(dirname(__FILE__).'/footer.html')?>

<div class="no">
    <?php /* provide DokuWiki housekeeping, required in all templates */ tpl_indexerWebBug()?>
</div>

</body>
</html>
