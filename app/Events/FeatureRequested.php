<?php

namespace App\Events;

use App\Enums\Status;
use App\Models\FeatureRequests;
use App\States\FeatureRequestState;
use App\States\UserRequestsState;
use Thunk\Verbs\Attributes\Autodiscovery\AppliesToState;
use Thunk\Verbs\Event;

#[AppliesToState(FeatureRequestState::class, 'feature_request_id')]
#[AppliesToState(UserRequestsState::class, 'user_id')]
class FeatureRequested extends Event
{
	public ?int $feature_request_id = null;
	
	public function __construct(
		public int $user_id,
		public string $title,
		public string $details,
		public int $priority,
	) {
	}
	
	public function validate(UserRequestsState $state)
	{
		$this->assert(! isset($state->priorities[$this->priority]), 'You already have a request at this priority level.');
		$this->assert(count($state->priorities) <= 5, 'You can only have 5 active requests at a time.');
	}
	
	public function applyToUser(UserRequestsState $state)
	{
		$state->priorities[$this->priority] = true;
	}
	
	public function applyToFeature(FeatureRequestState $state)
	{
		$state->status = Status::New;
	}
	
	public function handle()
	{
		FeatureRequests::create([
			'id' => $this->feature_request_id,
			'title' => $this->title,
			'details' => $this->details,
			'priority' => $this->priority,
			'status' => Status::New,
		]);
	}
}
