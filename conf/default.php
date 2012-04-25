<?php
/* configuration for navbar in Doogies Template
 * (This is a piece of PHP code so PHP syntax applies!)
 */

$conf['default_year'] = 2012;

$conf['navbar'] = 
  array("2012" =>
          array(
              "title" => array('Accueil', 'Sponsors', 'Orateurs', 'Programme', 'Inscription', 'Infos', 'Agile Innovation'),
              "target" => array(':start', ':sponsors', ':orateurs', ':programme', ':inscription', ':infos', ':innovation')
          ),
        "2011" =>
          array(
              "title" => array('Accueil', 'Sponsors', 'Orateurs', 'Programme', 'Inscription', 'Infos', 'Agile Innovation'),
              "target" => array(':start', ':sponsors', ':orateurs', ':programme', ':inscription', ':infos', ':innovation')
          ),
        "2010" =>
          array(
              "title" => array('Accueil', 'Sponsors', 'Orateurs', 'Programme', 'Inscription', 'Infos'),
              "target" => array(':start', ':sponsors', ':orateurs', ':programme', ':inscription', ':infos')
          )
      );

/*
$conf['navbar_tab1'] = array(
  'Home'        => 'Start', 
  'Blog'        => 'YourBlogPage',
  'Some Title'  => 'WikiPage',
  'Other Title' => 'OtherWikiPage'
);
*/

# Add link to recent changes as last tab. Title will be the localized title from $lang
$conf['navbar_recent'] = 0;

?>