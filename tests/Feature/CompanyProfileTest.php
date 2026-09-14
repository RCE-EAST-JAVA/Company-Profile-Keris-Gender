<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Project;
use App\Models\Staff;
use Tests\TestCase;

class CompanyProfileTest extends TestCase
{
    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_programs_page_returns_successful_response(): void
    {
        $response = $this->get('/programs');
        $response->assertStatus(200);
    }

    public function test_program_detail_page_returns_successful_response(): void
    {
        $project = Project::first();
        $this->assertNotNull($project);
        $this->assertNotEmpty($project->slug);

        $responseSlug = $this->get("/programs/{$project->slug}");
        $responseSlug->assertStatus(200);

        $responseId = $this->get("/programs/{$project->id}");
        $responseId->assertStatus(200);
    }

    public function test_publications_page_returns_successful_response(): void
    {
        $response = $this->get('/publications');
        $response->assertStatus(200);
    }

    public function test_publication_detail_page_returns_successful_response(): void
    {
        $article = Article::where('status', 'published')->first();
        $this->assertNotNull($article);

        $response = $this->get("/publications/{$article->slug}");
        $response->assertStatus(200);
    }

    public function test_people_page_returns_successful_response(): void
    {
        $response = $this->get('/people');
        $response->assertStatus(200);
    }

    public function test_people_detail_page_returns_successful_response(): void
    {
        $staff = Staff::first();
        $this->assertNotNull($staff);
        $this->assertNotEmpty($staff->slug);

        $responseSlug = $this->get("/people/{$staff->slug}");
        $responseSlug->assertStatus(200);

        $responseId = $this->get("/people/{$staff->id}");
        $responseId->assertStatus(200);
    }
}
