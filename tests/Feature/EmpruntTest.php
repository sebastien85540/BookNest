<?php

namespace Tests\Feature;

use App\Models\Emprunt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmpruntTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la base après chaque test

    /** @test */
    public function TC001_CreationEmpruntValide()
    {
        $response = $this->postJson('/api/emprunts', [
            'user_id' => 10,
            'livre_id' => 5,
            'date_emprunt' => '2025-03-10T09:00:00',
            'date_retour' => null,
            'statut' => 'en_cours',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['user_id' => 10, 'statut' => 'en_cours']);
    }

    /** @test */
    public function TC002_CreationInvalideChampManquant()
    {
        $response = $this->postJson('/api/emprunts', [
            'livre_id' => 5,
            'date_emprunt' => '2025-03-10T09:00:00',
            'statut' => 'en_cours',
        ]);

        $response->assertStatus(422)
        ->assertJsonValidationErrors(['user_id']);
    }

    /** @test */
    public function TC003_LectureEmpruntExistant()
    {
        $emprunt = Emprunt::factory()->create();

        $response = $this->getJson("/api/emprunts/{$emprunt->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $emprunt->id]);
    }

    /** @test */
    public function TC004_LectureEmpruntIntrouvable()
    {
        $response = $this->getJson('/api/emprunts/9999');

        $response->assertStatus(404);
    }

    /** @test */
    public function TC005_MiseAJourEmpruntStatut()
    {
        $emprunt = Emprunt::factory()->create([
            'statut' => 'en_cours'
        ]);

        $response = $this->putJson("/api/emprunts/{$emprunt->id}", [
            'date_retour' => '2025-03-12T14:00:00',
            'statut' => 'retourne',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['statut' => 'retourne']);
    }

    /** @test */
    public function TC006_MiseAJourInvalide()
    {
        $emprunt = Emprunt::factory()->create();

        $response = $this->putJson("/api/emprunts/{$emprunt->id}", [
            'date_emprunt' => 'abc',
        ]);

        $response->assertStatus(422)
        ->assertJsonValidationErrors(['date_emprunt']);
    }

    /** @test */
    public function TC007_SuppressionEmpruntExistant()
    {
        $emprunt = Emprunt::factory()->create();

        $response = $this->deleteJson("/api/emprunts/{$emprunt->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('emprunts', ['id' => $emprunt->id]);
    }

    /** @test */
    public function TC008_SuppressionEmpruntInexistant()
    {
        $response = $this->deleteJson('/api/emprunts/9999');

        $response->assertStatus(404);
    }
}
