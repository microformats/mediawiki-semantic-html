<?php
/** @class SemanticHTMLParser.
  * Simple function to take an element name, render its attributes and return
  * the complete HTML element to MediaWiki.
  * 
  * PHP < 5.3 requires each element to have its own callback method, but 
  * future versions could use the __callStatic magic method to handle
  * unlimited elements from the single array above, which could in turn be
  * separated into a tidy config file for super-easy administration.
  *
  * Notes: I'm new to MediaWiki hacking. Pretty sure there should be an
  * easier way to say ‘don't drop these elements’, rather than having to
  * re-render them. Oh well.
  * 
  * @author Ben Ward 
  */
class SemanticHTMLParser {

    private static $elements = array(
           'parseAbbr' => 'abbr',
           'parseAcronym' => 'acronym',
           'parseData' => 'data',
           'parseDfn' => 'dfn',
           'parseKbd' => 'kbd',
           'parseSamp' => 'samp',
           'parseTime' => 'time',
           'parseVar' => 'var',
        );

    // __callStatic isn't implemented until 5.3, so need explicit methods:
    public static function parseAbbr($text, $attributes, $parser) {
        return SemanticHTMLParser::parseElement('abbr', $text, $attributes, $parser);
    }
    public static function parseAcronym($text, $attributes, $parser) {
        return SemanticHTMLParser::parseElement('acronym', $text, $attributes, $parser);
    }
    public static function parseData($text, $attributes, $parser) {
        return SemanticHTMLParser::parseElement('data', $text, $attributes, $parser);
    }
    public static function parseDfn($text, $attributes, $parser) {
        return SemanticHTMLParser::parseElement('dfn', $text, $attributes, $parser);
    }
    public static function parseKbd($text, $attributes, $parser) {
        return SemanticHTMLParser::parseElement('kbd', $text, $attributes, $parser);
    }
    public static function parseSamp($text, $attributes, $parser) {
        return SemanticHTMLParser::parseElement('samp', $text, $attributes, $parser);
    }
    public static function parseTime($text, $attributes, $parser) {
        return SemanticHTMLParser::parseElement('time', $text, $attributes, $parser);
    }
    public static function parseVar($text, $attributes, $parser) {
        return SemanticHTMLParser::parseElement('var', $text, $attributes, $parser);
    }    
    
    private static function parseElement($element, $text, $attributes, $parser) {    
        $return = "<$element";
        if(is_array($attributes)) {
            foreach($attributes as $name=>$value) {
                $return .= " $name=\"$value\"";
            }
        }
        $text = $parser->recursiveTagParse( $text );
        $return .= ">$text</$element>";
        return $return;
    }
    
    public static function registerHooks() {
        global $wgParser;
        foreach(SemanticHTMLParser::$elements as $method=>$tag) {
            $wgParser->setHook($tag, array('SemanticHTMLParser', $method));
        }
    }
}
?>