<?php

namespace App\Models;

use App\Enums\Status;
use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Model;

class FeatureRequests extends Model
{
	use HasSnowflakes;
	
	protected $casts = [
		'status' => Status::class,
	];
}
