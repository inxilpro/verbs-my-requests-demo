<?php

use App\Events\FeatureRequested;
use App\Models\FeatureRequests;
use Thunk\Verbs\Exceptions\EventNotValidForCurrentState;
use Thunk\Verbs\Facades\Verbs;

it('can create a feature request', function () {
    verb($event = new FeatureRequested(
		user_id: 1,
		title: 'Make the my requests feature', 
		details: 'Pretty please',
		priority: 1
    ));
	
	Verbs::commit();
	
	$request = FeatureRequests::findOrFail($event->feature_request_id);
	
	expect($request->title)->toBe($event->title)
		->and($request->details)->toBe($event->details)
		->and($request->priority)->toBe(1);
});

it('you cannot request twice with the same priority', function() {
	verb(new FeatureRequested(
		user_id: 1,
		title: 'Make the my requests feature',
		details: 'Pretty please',
		priority: 1
	));
	verb(new FeatureRequested(
		user_id: 1,
		title: 'Another thing!',
		details: 'Pretty please',
		priority: 1
	));
})->throws(EventNotValidForCurrentState::class, 'You already have a request at this priority level.');

it('two users can have requests with the same priority', function() {
	verb(new FeatureRequested(
		user_id: 1,
		title: 'Make the my requests feature',
		details: 'Pretty please',
		priority: 1
	));
	verb(new FeatureRequested(
		user_id: 2,
		title: 'Another thing!',
		details: 'Pretty please',
		priority: 1
	));
})->throwsNoExceptions();
