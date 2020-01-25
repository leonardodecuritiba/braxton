<?php

namespace App\Traits;


use App\Models\Users\User;

trait AuthorTrait {


	public function getShortAuthorName()
	{
		return $this->author->getShortName();
	}

	public function getAuthorName()
	{
		return $this->author->getName();
	}

	public function author()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

}