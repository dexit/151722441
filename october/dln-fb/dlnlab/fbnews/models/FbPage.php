<?php namespace DLNLab\FBNews\Models;

use Model;
use DLNLab\FBNews\Classes\HelperNews;

/**
 * FbPage Model
 */
class FbPage extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'dlnlab_fbnews_fb_pages';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'category' => ['DLNLab\FBNews\Models\FbCategory'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    public static $app_id     = FB_APP_ID;
    public static $app_secret = FB_APP_SECRET;
    public static $api_url    = 'https://graph.facebook.com/v2.2/';
    public static $limit = 50;
    
    public function beforeSave() {
        unset($this->attributes['fb_link']);
    }
    
    public function category() {
        return $this->belongsTo('DLNLab\FBNews\Models\FbCategory');
    }
    
    public function getCategoryOptions() {
		return FbCategory::getNameList();
	}
    
    /*public function getFBIDAttribute() {
        $fb_id = (! empty($this->attributes['fb_id'])) ? $this->attributes['fb_id'] : '';
        return "<a href='https://www.facebook.com/{$fb_id}' target='_blank' onclick='javascript:void(0)'>https://www.facebook.com/{$fb_id}</a>";
    }*/
    
    public static function get_fb_feeds($fb_page_id = '') {
        if (! $fb_page_id)
            return false;
        
        $url = self::$api_url . $fb_page_id . '/feed?limit=' . self::$limit . '&access_token=' . self::get_fb_access_token();
        $obj = json_decode(HelperNews::curl($url));
        
        $batches_like    = array();
        $batches_comment = array();
        $items    = array();
        $item_ids = array();
        if (! empty($obj->data) && is_array($obj->data)) {
            foreach ($obj->data as $i => $item) {
                $shares     = (! empty($item->shares->count)) ? $item->shares->count : 0;
                $timestamp  = \Carbon\Carbon::now()->toDateTimeString();
                $items[]    = array(
                    'fb_id'     => (! empty($item->id)) ? $item->id : 0,
                    'object_id' => (! empty($item->object_id)) ? $item->object_id : 0,
                    'name'      => (! empty($item->name)) ? $item->name : '',
                    'message'   => (! empty($item->message)) ? $item->message : '',
                    'picture'   => (! empty($item->picture)) ? $item->picture : '',
                    'source'    => (! empty($item->source)) ? $item->source : '',
                    'type'      => (! empty($item->type)) ? $item->type : '',
                    'share_count' => $shares,
                    'created_at'  => $timestamp,
                    'updated_at'  => $timestamp,
                );
                $item_ids[] = $item->object_id;
                
                $batch = new \stdClass;
                $batch->method = 'GET';
                $batch->relative_url = $item->object_id . '/likes?summary=1';
                $batches_like[] = $batch;
                
                $batch = new \stdClass;
                $batch->method = 'GET';
                $batch->relative_url = $item->object_id . '/comments?summary=1';
                $batches_comment[] = $batch;
            }
            
            // Get facebook like meta information
            $url = self::$api_url . '?batch=' . urlencode(json_encode($batches_like)) . '&access_token=' . self::get_fb_access_token() . '&method=post';
            $objs = json_decode(HelperNews::curl($url));
			if (! empty($objs)) {
				foreach ($objs as $i => $obj) {
					if ($obj->body) {
						$body = json_decode($obj->body);
						
						$items[$i]['like_count'] = isset($body->summary->total_count) ? $body->summary->total_count : 0;
					}
				}
			}
            
            // Get facebook like meta information
            $url = self::$api_url . '?batch=' . urlencode(json_encode($batches_comment)) . '&access_token=' . self::get_fb_access_token() . '&method=post';
            $objs = json_decode(HelperNews::curl($url));
			
			if (! empty($objs)) {
				foreach ($objs as $i => $obj) {
					if ($obj->body) {
						$body = json_decode($obj->body);
						
						$items[$i]['comment_count'] = isset($body->summary->total_count) ? $body->summary->total_count : 0;
					}
				}
			}
            $records = FbFeed::whereIn('object_id', $item_ids)->get();
            if (count($records)) {
                foreach ($items as $i => $item) {
                    if ($item) {
                        foreach ($records as $j => $record) {
                            if ($item['object_id'] == $record->object_id) {
                                
                                if (( $item['share_count'] != $record->share_count 
                                || $item['like_count'] != $record->like_count
                                || $item['comment_count'] != $record->comment_count )) {
                                    $record->share_count = $item['share_count'];
                                    $record->like_count = $item['like_count'];
                                    $record->comment_count = $item['comment_count'];
                                    $record->save();
                                    
                                    var_dump($item['object_id']);
                                }
                                
                                unset($items[$i]);
                            }
                        }
                    }
                }
            }
            
            if (count($items)) {
                FbFeed::insert($items);
            }
        }
    }
    
    public static function get_fb_access_token() {
        return self::$app_id . '|' . self::$app_secret;
    }
    
    public static function get_fb_page_infor($page_link = '') {
        if (empty($page_link))
            return false;
        
        $obj = null;
        $url = self::$api_url . '?id=' . $page_link . '&access_token=' . self::get_fb_access_token();
        $obj = json_decode(HelperNews::curl($url));
        
        if (! empty($obj->id)) {
            $record = self::where('fb_id', '=', $obj->id)->first();
            if (empty($record)) {
                $record = new self;
            }
            $record->name  = (isset($obj->name)) ? $obj->name : '';
            $record->fb_id = (isset($obj->id)) ? $obj->id : '';
            $record->like  = (isset($obj->likes)) ? $obj->likes : 0;
            $record->talking_about = (isset($obj->talking_about)) ? $obj->talking_about : 0;
            $record->save();
        }

        return $obj;
    }
    
    public static function get_fb_user_infor($fb_uid, $access_token) {
        $url = self::$api_url . $fb_uid . '?access_token=' . $access_token;
        $obj = json_decode(HelperNews::curl($url));
        return $obj;
    }
}