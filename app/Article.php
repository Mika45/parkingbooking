<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	protected $table = 'ARTICLE';
	protected $primaryKey = 'article_id';

	protected $fillable = ['title', 'body', 'published_at', 'slug'];

}
