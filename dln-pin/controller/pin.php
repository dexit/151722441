<?php
/**
 *      [PinTuXiu] (C)2001-2099 ONightjar.com Pintuxiu.com.
 *      This is NOT a freeware, use is subject to license terms
 */
class pin extends basecontroller
{

	public function __construct() {
		parent::__construct();
		$this->seo_title(T('pin'));
	}

	public function index(){
		$num_per_page = $this->settings['ui_layout']['pin_pagenum'];
		$num_per_page = $num_per_page?$num_per_page:15;
		$tag =  $this->spArgs("tag");
		$keyword =  $this->spArgs("keyword");
		$wf =  $this->spArgs("wf");

		$ptx_share = spClass('ptx_share');
		$segment = spClass('Segment');

		if($this->page == 1){
			$guide['show'] = true;
			if($this->category_id){
				$ptx_tag = spClass('ptx_tag');
				$guide['tag_group'] = $ptx_tag->get_tag_group(" ptx_tag.category_id = '".$this->category_id."'");
			}
			$this->guide = $guide;
		}

		$args = array("page"=>"2","wf"=>"1");
		if($this->category_id){
			$conditions['category_id'] = $this->category_id;
			$args['cat']=$this->category_id;
			$ptx_category = spClass("ptx_category");
			$category = $ptx_category->find_category_byid($this->category_id);
			$this->seo_title($category['category_name_cn']);
			$this->seo_keyword(sysSubStr(str_replace(',', ' ', $category['category_hot_words']),100));
			$this->navmenu = $category['category_name_cn'];
		}
		if($tag){
			$conditions['keyword'] = $segment->convert_to_py($tag);
			$args['tag']=$tag;
			$this->seo_title($tag);
			$this->seo_keyword($tag);
			$this->navmenu = $tag;
		}
		if($this->settings['ui_layout']['orgin_post']){
			$conditions['orgin_post']=1;
		}
		if($keyword){
			$conditions['keyword'] = $segment->convert_to_py($keyword);
			$args['keyword']=$keyword;
			$this->seo_title($keyword);
			$this->seo_keyword($keyword);
			$this->navmenu = $keyword;
		}

		$this->nextpage_url = spUrl("pin","index", $args);
		$shares = $ptx_share->search($conditions,$this->page,$num_per_page);
		$this->pages = createTPages($ptx_share->spPager()->getPager(), 'pin', 'index',$conditions);
		$shares = $this->add_ads($shares);
		$this->waterfallView($shares,'pin');
		$need_header_footer = ($wf=='1')?false:true;
		$this->output("pin/index",$need_header_footer);
	}

	private function add_ads($shares){
		$show = rand(0, 1);
		if($show&&$this->settings['ui_pin']['pin_ad']&&$ads=$this->settings['pinpage_ad']){
			if($ad = rand_pop($ads)){
				$ad_share['share_type']='ad';
				$ad_share['key']=$ad['key'];
				$ad_share['ad_name']=$ad['ad_name'];
				$ad_share['width']=$ad['width'];
				$ad_share['height']=$ad['height'];
				$ad_share['ad_position']='pinpage_ad';
				$index = rand(0, array_length($shares)-1);
				array_splice($shares, $index, 0, array($ad_share));
			}
		}
		return $shares;
	}

	public function tgroup(){
		$num_per_page = $this->settings['ui_layout']['pin_pagenum'];
		$num_per_page = $num_per_page?$num_per_page:15;
		$tg =  $this->spArgs("tg");
		$wf =  $this->spArgs("wf");

		if(is_numeric($tg)){

			$ptx_share = spClass('ptx_share');
			$segment = spClass('Segment');

			if($this->page == 1&&$tg){
				$ptx_tag = spClass('ptx_tag');
				$this->tag_group = $ptx_tag->get_tag_group(" ptx_tag.tag_id = '".$tg."'");
				$tag_group = ($this->tag_group[0])?$this->tag_group[0]:NULL;
			}

			$args = array("page"=>"2","wf"=>"1");
			if($tag_group){
				$this->seo_title($tag_group['tag_group_name_cn'].$tag_group['category_name_cn']);
				$this->seo_keyword(sysSubStr(str_replace(',', ' ', $tag_group['tags']),100));
				$conditions['keyword'] = $segment->convert_to_py(str_replace(',', ' ', $tag_group['tags']));
				$args['tg']=$tg;
				if($this->settings['ui_layout']['orgin_post']){
					$conditions['orgin_post']=1;
				}
				$this->tgroup = $tag_group;
				$this->nextpage_url = spUrl("pin","tgroup", $args);
				$shares = $ptx_share->search($conditions,$this->page,$num_per_page);
				$this->pages = createTPages($ptx_share->spPager()->getPager(), 'pin', 'tgroup',$conditions);
				$shares = $this->add_ads($shares);
				$this->waterfallView($shares,'pin');
				$need_header_footer = ($wf=='1')?false:true;
				$this->output("pin/index",$need_header_footer);
			}

		}
	}

	public function color(){
		$color=$this->spArgs("idx");
		$conditions['color'] = $color;
		$this->current_color=$color;
		$this->output_pin('color', " ptx_share.create_time DESC ",$conditions);
	}

	public function hot(){
		$this->seo_title(T('hot_pin'));
		$this->output_pin('hot', " ptx_share.total_likes DESC ");
	}

	public function lastest(){
		$this->seo_title(T('lastest_pin'));
		$this->output_pin('lastest', " ptx_share.create_time DESC ");
	}

	public function goods(){
		$conditions['type'] = 'goods';
		$this->output_pin('goods', " ptx_share.create_time DESC ",$conditions);
	}

	public function video(){
		$conditions['type'] = 'video';
		$this->output_pin('video', " ptx_share.create_time DESC ",$conditions);
	}

	public function share(){
		$conditions['type'] = 'share';
		$this->output_pin('share', " ptx_share.create_time DESC ",$conditions);
	}
	
	public function article(){
		$conditions['type'] = 'article';
		$this->output_pin('article', " ptx_share.create_time DESC ",$conditions);
	}
	
	private function output_pin($action,$order,$conditions=array()){
		$num_per_page = $this->settings['ui_layout']['pin_pagenum'];
		$num_per_page = $num_per_page?$num_per_page:15;
		$ptx_share = spClass('ptx_share');
		$wf =  $this->spArgs("wf");

		if($this->page == 1){
			$guide['show'] = true;
			if($this->category_id){
				$ptx_tag = spClass('ptx_tag');
				$guide['tag_group'] = $ptx_tag->get_tag_group(" ptx_tag.category_id = '".$this->category_id."'");
			}
			$this->guide = $guide;
		}
		$args = array();
		if($conditions['color']){
			$args['idx']=$conditions['color'];
		}
		$args['page']='2';
		$args['wf']='1';
		if($this->category_id){
			$conditions['category_id'] = $this->category_id;
			$args['cat']=$this->category_id;
		}
		if($this->settings['ui_layout']['orgin_post']){
			$conditions['orgin_post']=1;
		}

		$this->nextpage_url = spUrl("pin",$action, $args);
		$shares = $ptx_share->search($conditions,$this->page,$num_per_page,null,$order);
		$this->pages = createTPages($ptx_share->spPager()->getPager(), 'pin', $action,$conditions);
		$shares = $this->add_ads($shares);
		$this->waterfallView($shares,'pin');
		$need_header_footer = ($wf=='1')?false:true;
		$this->output("pin/index",$need_header_footer);
	}

}

