<?php
class Template {

	var $subtemplates = array();
	var $tpldir = 'default';
	
	function parse_template($full_tpl_file_path,$full_cache_file_path,$tpldir){
		if($fp = @fopen($full_tpl_file_path, 'r')) {
			$template = @fread($fp, filesize($full_tpl_file_path));
			fclose($fp);
		} else {
			$this->error('template_notfound', $full_tpl_file_path);
		}
		$this->tpldir = $tpldir;
		
		for($i = 1; $i <= 5; $i++) {
			if(strexists($template, '{subtemplate')) {
				$template = preg_replace("/[\n\r\t]*(\<\!\-\-)?\{subtemplate\s+([a-z0-9_:\/]+)\}(\-\-\>)?[\n\r\t]*/ies", "\$this->loadsubtemplate('\\2')", $template);
			}
		}
		
		$template = preg_replace("/\{lang\s+(.+?)\}/ies", "\$this->languagevar('\\1')", $template);
		
		$template = "<? if(!defined('APP_PATH')) exit('Access Denied');?>\n$template";
		if(!@$fp = fopen($full_cache_file_path, 'w')) {
			$this->error('directory_notfound', dirname($full_cache_file_path));
		}
		
		flock($fp, 2);
		fwrite($fp, $template);
		fclose($fp);
	}
	
	function loadsubtemplate($file) {
		$tplfile = template($file, $this->tpldir, 1);
		if($content = @implode('', file($tplfile))) {
			$this->subtemplates[] = $tplfile;
			$content = str_replace("<? if(!defined('APP_PATH')) exit('Access Denied');?>\n", '', $content);
			return $content;
		} else {
			return '<!-- '.$file.' -->';
		}
	}
	
	function languagevar($var) {
		return T($var);
	}

	function error($message, $tplname) {
		spError($message.$tplname);
	}

}
?>