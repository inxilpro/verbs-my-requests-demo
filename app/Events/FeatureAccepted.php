<?php

namespace App\Events;

use App\Enums\Status;
use App\Models\FeatureRequests;
use App\States\FeatureRequestState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class FeatureAccepted extends Event
{
	public function __construct(
		#[StateId(FeatureRequestState::class)] public int $feature_request_id,
	) {
	}
	
	public function validate(FeatureRequestState $state)
	{
		$this->assert($state->status === Status::New, 'Status is not "new"');
	}
	
	public function apply(FeatureRequestState $state)
	{
		$state->status = Status::Accepted;
	}
	
	public function handle()
	{
		FeatureRequests::findOrFail($this->feature_request_id)
			->update(['status' => Status::Accepted]);
	}
}
