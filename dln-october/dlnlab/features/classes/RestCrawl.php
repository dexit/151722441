<?php

namespace DLNLab\Features\Classes;

use Auth;
use DB;
use Input;
use Response;
use Controller as BaseController;
use DLNLab\Features\Models\CrawlLinks;
use DLNLab\Features\Models\CrawlEmails;
use DLNLab\Features\Models\CrawlPhones;
use Symfony\Component\DomCrawler\Crawler;

class RestCrawl extends BaseController {
	
	public static $parent_times = 20;
	public static $parent_links = array(
		'batdongsan_thue_nhatro'   => 'http://batdongsan.com.vn/cho-thue-nha-tro-phong-tro',
		'batdongsan_thue_nharieng' => 'http://batdongsan.com.vn/cho-thue-nha-rieng',
		'batdongsan_thue_chungcu'  => 'http://batdongsan.com.vn/cho-thue-can-ho-chung-cu',
	);
	
	public function postAddParentLinks() {
		$data = post();
		
		$results = array();
		if (!empty($data['type'])) {
			switch($data['type']) {
				case 'batdongsan':
					$arr_links = '';
					// Build index links
					foreach (self::$parent_links as $type => $link) {
						for($i = 0; $i < self::$parent_times; $i++) {
							$arr_links[] = ($i == 0) ? $link : $link . '/p' . $i;
						}
						$results = self::addLinks($type, $arr_links);
					}
					break;
			}
		}
		var_dump($results);
		return;
	}
	
	public function postLinks() {
		$data = post();
		
		if (! empty($data['action']) && ($data['action'] == 'detail')) {
			self::postAddDetailLinks($data);
		}
		
		if (! empty($data['action']) && ($data['action'] == 'add')) {
			self::postAddLinks($data);
		}
	}
	
	private static function postAddLinks($data = null) {
		// Get links from DB
		$results = null;
		
		$links   = CrawlLinks::where('type', '!=', 'batdongsan|link')->orderBy('crawl', 'asc')->take(100)->get();
		
		if ($links->count()) {
			foreach ($links as $link) {
				if ($link->link) {
					$arr_links = array();
					$html    = file_get_contents($link->link, false, self::getContext());
					$crawler = new Crawler();
					$crawler->addHtmlContent($html);

					// apply css selector filter
					$arr_links = $crawler->filter('.Main .search-productItem .p-title a')->each(function ($node, $i) {
						return 'http://batdongsan.com.vn' . $node->attr('href');
					});
					
					$results = self::addLinks('batdongsan|link', $arr_links);
					$link->crawl = $link->crawl + 1;
					$link->save();
				}
			}
		}
		
		var_dump($results);
	}
	
	private static function postAddDetailLinks($data = null) {
		// Get links detail
		$links = CrawlLinks::whereRaw('type = ? AND crawl = 0', array('batdongsan|link'))->take(100)->get();
		
		if ($links->count()) {
			foreach ($links as $link) {
				if (!empty($link->link)) {
					self::crawlDetail($link->link, $link);
					var_dump($link->link);
				}
			}
		}
		return;
	}
	
	private static function addLinks($type = '', $links = array()) {
		if (empty($type) || !is_array($links) || empty($links))
			return null;
		$arr_links = null;
		$arr_md5   = null;
		// Convert link to md5
		foreach ($links as $link) {
			$md5             = md5($link);
			$arr_links[$md5] = $link;
			$arr_md5[]       = $md5;
		}
		
		// Exclude link md5 exists in DB
		$link_exists = CrawlLinks::whereIn('md5', $arr_md5)->get();
		if (!empty($link_exists)) {
			foreach ( $arr_links as $md5 => $link ) {
				foreach ($link_exists as $item) {
					if ($item->md5 == $md5) {
						unset($arr_links[$md5]);
					}
				}
			}			
		}
		
		// Add link into DB
		$inserts = null;
		$date    = new \DateTime;
		
		if (! empty($arr_links)) {
			foreach ($arr_links as $md5 => $link) {
				$inserts[] = array(
					'type' => $type,
					'link' => $link,
					'md5'  => $md5,
					'updated_at' => $date,
					'created_at' => $date
				);
			}
		}
		
		if (!empty($inserts)) {
			CrawlLinks::insert($inserts);
		}
		
		return $arr_links;
	}
	
	private static function crawlDetail($link = '', $obj_link) {
		if (empty($link))
			return false;
		
		$html    = file_get_contents($link, false, self::getContext());
		$crawler = new Crawler();
		$crawler->addHtmlContent($html);

		// Get phone number
		$phone_number = '';
		if ($crawler->filter('#divCustomerInfo div[id$="contactPhone"] .right')->count()) {
			$phone_number = trim($crawler->filter('#divCustomerInfo div[id$="contactPhone"] .right')->first()->text());
		}
		
		// Get contact name
		$contact_name = '';
		if ($crawler->filter('#divCustomerInfo div[id$="contactName"] .right')->count()) {
			$contact_name = trim($crawler->filter('#divCustomerInfo div[id$="contactName"] .right')->first()->text());
		}
		
		// get contact email
		$contact_email = '';
		if ($crawler->filter('#divCustomerInfo div[id$="contactEmail"] .right')->count()) {
			$contact_email = html_entity_decode(trim($crawler->filter('#divCustomerInfo div[id$="contactEmail"] .right')->first()->text()));
			if (preg_match("/'mailto:([^']+)'/", $contact_email, $matches)) {
				$contact_email = $matches[1];
			}
		}
		
		DB::beginTransaction();
		try {
			if ($phone_number) {
				preg_replace("/[^0-9]/", '', $phone_number);
				$phone_number = str_replace(' ', '', $phone_number);
				$phone_number = str_replace('.', '', $phone_number);
				$phone = CrawlPhones::where('phone', '=', $phone_number)->first();
				if ($phone) {
					$phone->count = $phone->count + 1;
					$phone->data  = $phone->data . ',' . $obj_link->id;
					$phone->save();
				} else {
					$insert        = new CrawlPhones();
					$insert->count = 1;
					$insert->phone = $phone_number;
					$insert->own   = $contact_name ? strtolower($contact_name) : 'bạn';
					$insert->data  = $obj_link->id;
					$insert->save();
				}
			}
			
			if ($contact_email) {
				$email = CrawlEmails::where('email', '=', $contact_email)->first();
				if ($email) {
					$email->count = $email->count + 1;
					$email->data  = $email->data . ',' . $obj_link->id;
					$email->save();
				} else {
					$insert        = new CrawlEmails();
					$insert->count = 1;
					$insert->email = $contact_email;
					$insert->own   = $contact_name ? strtolower($contact_name) : 'bạn';
					$insert->data  = $obj_link->id;
					$insert->save();
				}
			}
			
			$obj_link->crawl = $obj_link->crawl + 1;
			$obj_link->save();
		} catch (Exception $ex) {
			DB::rollback();
		}
		DB::commit();
	}
	
	private static function getContext() {
		$options = array(
			'http' => array(
				'method' => "GET",
				'header' => "Accept-language: en\r\n" .
				"Cookie: foo=bar\r\n" . // check function.stream-context-create on php.net
				"User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
			)
		);
		$context = stream_context_create($options);
		return $context;
	}
}