<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Skill::create(['name' => 'Laravel', 'category' => 'Backend', 'proficiency' => 90, 'sort_order' => 0]);
    }

    private function makeProject(array $overrides = []): Project
    {
        return Project::create(array_merge([
            'title' => ['en' => 'Demo Project'],
            'slug' => 'demo-project',
            'problem' => ['en' => 'A problem statement.'],
            'what_i_built' => ['en' => 'The solution.'],
            'key_features' => ['en' => ['One', 'Two']],
            'tech_stack' => ['Laravel', 'MySQL'],
            'my_role' => ['en' => 'Solo developer'],
            'outcome' => ['en' => 'It shipped.'],
            'github_url' => 'https://github.com/example/demo',
            'is_public_github' => true,
            'featured' => true,
            'sort_order' => 1,
        ], $overrides));
    }

    public function test_home_page_renders_with_sections(): void
    {
        $this->makeProject();

        $this->get('/')
            ->assertOk()
            ->assertSee('id="about"', false)
            ->assertSee('id="skills"', false)
            ->assertSee('id="contact"', false)
            ->assertSee('Demo Project');
    }

    public function test_projects_index_and_case_study(): void
    {
        $this->makeProject();

        $this->get('/projects')->assertOk()->assertSee('Demo Project');

        $this->get('/projects/demo-project')
            ->assertOk()
            ->assertSeeInOrder(['Problem', 'What I Built', 'Key Features', 'Tech Stack', 'My Role', 'Outcome'])
            ->assertSee('View on GitHub');
    }

    public function test_unknown_project_slug_is_404(): void
    {
        $this->get('/projects/nope')->assertNotFound();
    }

    public function test_github_button_hidden_when_repo_is_private(): void
    {
        $this->makeProject(['is_public_github' => false]);

        $this->get('/projects/demo-project')
            ->assertOk()
            ->assertDontSee('View on GitHub');
    }

    public function test_locale_switch_applies_rtl(): void
    {
        $this->get('/language/ckb')->assertRedirect();

        $this->get('/')->assertSee('dir="rtl"', false);
    }

    public function test_contact_form_stores_a_valid_message(): void
    {
        $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'I would like to discuss a project with you.',
        ])->assertRedirect()->assertSessionHas('contact_status', 'ok');

        $this->assertDatabaseHas('contact_messages', ['email' => 'jane@example.com']);
    }

    public function test_contact_form_rejects_invalid_input(): void
    {
        $this->post('/contact', ['name' => '', 'email' => 'nope', 'message' => 'hi'])
            ->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertSame(0, ContactMessage::count());
    }

    public function test_contact_form_honeypot_silently_drops_bots(): void
    {
        $this->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'buy my stuff buy my stuff',
            'website' => 'http://spam.example',
        ])->assertRedirect();

        $this->assertSame(0, ContactMessage::count());
    }
}
