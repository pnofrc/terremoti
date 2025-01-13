<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('texts', function (Blueprint $table) {
            $table->id(); // auto incrementing ID primary key
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->string('publication_year')->nullable();
            $table->string('publication_place')->nullable();
            $table->string('editor')->nullable();
            $table->json('genre')->nullable();
            $table->json('geological_entities')->nullable();
            // $table->string('geological_entity_kind')->nullable();
            // $table->string('real_event')->nullable();
            // $table->json('degree_anthropization')->nullable();
            // $table->json('place')->nullable();
            // $table->string('event_name')->nullable();
            // $table->json('typology')->nullable();
            // $table->json('typology_volcano_of_eruption')->nullable();
            // $table->string('reference_volcanic_risk')->nullable();
            // $table->json('attitude_individual')->nullable();
            // $table->json('attitude_collective')->nullable();
            // $table->json('ecological_impact')->nullable();
            // $table->json('social_impact')->nullable();
            // $table->json('affects_individual')->nullable();
            // $table->json('affects_collective')->nullable();
            // $table->string('earthquake_magnitude')->nullable();
            // $table->json('individual_reaction')->nullable();
            // $table->json('individual_affects_general')->nullable();
            // $table->json('collective_reaction')->nullable();
            // $table->json('individual_strategies')->nullable();
            // $table->json('collective_strategies')->nullable();
            // $table->json('collective_affects')->nullable();
            // $table->string('collective_affects_general')->nullable();
            // $table->string('phase_emphisized')->nullable();
            $table->json('keywords')->nullable();
            $table->json('metaphors')->nullable();
            $table->json('personifications')->nullable();
            $table->json('similes')->nullable();
            $table->longText('substantives')->nullable();
            $table->longText('verbs_agency')->nullable();
            $table->longText('punctuation')->nullable();
            $table->string('syntax')->nullable();
            $table->longText('morphological_peculiarities')->nullable();
            $table->longText('uncommon_typography')->nullable();
            $table->longText('entity_symbols')->nullable();
            $table->longText('social_symbols')->nullable();
            $table->longText('interpretation')->nullable();
            $table->longText('bibliography')->nullable();
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('texts');
    }
}
