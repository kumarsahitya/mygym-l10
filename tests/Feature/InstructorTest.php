<?php

namespace Tests\Feature;

use App\Models\ClassType;
use App\Models\ScheduledClass;
use App\Models\User;
use Database\Seeders\ClassTypeSeeder;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstructorTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_is_redirected_to_instructor_dashboard(): void
    {
        // Given
        $user = User::factory()->create([
            'role' => 'instructor',
        ]);

        // When
        $response = $this->actingAs($user)->get('/dashboard');

        // Then
        $response->assertRedirectToRoute('instructor.dashboard');
        $this->followRedirects($response)->assertSeeText('Hey Instructor!');
    }

    public function test_instructor_can_schedule_a_class()
    {
        // Given
        $user = User::factory()->create([
            'role' => 'instructor',
        ]);
        $this->seed(ClassTypeSeeder::class);

        // When
        $datetime = new DateTime('tomorrow');
        $response = $this->actingAs($user)->post('/instructor/schedule', [
            'class_type_id' => ClassType::first()->id,
            'date' => $datetime->format('Y-m-d'),
            'time' => $datetime->format('H:i:s'),
        ]);

        // Then
        $this->assertDatabaseHas('scheduled_classes', [
            'class_type_id' => ClassType::first()->id,
            'date_time' => $datetime->format('Y-m-d H:i:s'),
        ]);
        $response->assertRedirectToRoute('schedule.index');
    }

    public function test_instructor_can_cancel_class()
    {
        // Given
        $user = User::factory()->create([
            'role' => 'instructor',
        ]);
        $this->seed(ClassTypeSeeder::class);
        $datetime = new DateTime('tomorrow');
        $scheduledClass = ScheduledClass::create([
            'instructor_id' => $user->id,
            'class_type_id' => ClassType::first()->id,
            'date_time' => $datetime->format('Y-m-d H:i:s'),
        ]);

        // When
        $response = $this->actingAs($user)->delete('/instructor/schedule/'.$scheduledClass->id);

        // Then
        $this->assertDatabaseMissing('scheduled_classes', [
            'id' => $scheduledClass->id,
        ]);
    }

    public function test_cannot_cancel_class_less_than_two_hours_before()
    {
        // Given
        $user = User::factory()->create([
            'role' => 'instructor',
        ]);
        $this->seed(ClassTypeSeeder::class);
        $scheduledClass = ScheduledClass::create([
            'instructor_id' => $user->id,
            'class_type_id' => ClassType::first()->id,
            'date_time' => now()->addHour(1)->minutes(0)->seconds(0),
        ]);

        // When
        $response = $this->actingAs($user)->get('/instructor/schedule');
        $response->assertDontSeeText('Cancel');

        $response = $this->actingAs($user)->delete('/instructor/schedule/'.$scheduledClass->id);

        // Then
        $this->assertDatabaseHas('scheduled_classes', [
            'id' => $scheduledClass->id,
        ]);
    }
}
