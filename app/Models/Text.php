<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $fillable = [
        'user_id','title', 'author', 'publication_year', 'publication_place', 'editor', 'genre', 'collection', 'magazine',
        'geological_entities', 'keywords', 'metaphors', 'personifications', 'similes', 'substantives',
        'verbs_agency', 'punctuation', 'syntax', 'morphological_peculiarities', 'uncommon_typography',
       'symbols', 'interpretation', 'bibliography'
    ];


    // protected $fillable = [
    //     'title', 'author', 'publication_year', 'publication_place', 'editor', 'genre',
    //     'geological_entity_kind', 'real_event', 'degree_anthropization', 'place', 'event_name',
    //     'typology', 'typology_volcano_of_eruption', 'reference_volcanic_risk', 'attitude_individual',
    //     'attitude_collective', 'ecological_impact', 'social_impact', 'affects_individual', 'affects_collective',
    //     'earthquake_magnitude', 'individual_reaction', 'individual_affects_general', 'collective_reaction',
    //     'individual_strategies', 'collective_strategies', 'collective_affects', 'collective_affects_general',
    //     'phase_emphisized', 
    //     'keywords', 'metaphors', 'personifications', 'similes', 'substantives',
    //     'verbs_agency', 'punctuation', 'syntax', 'morphological_peculiarities', 'uncommon_typography',
    //     'entity_symbols', 'social_symbols', 'interpretation', 'bibliography'
    // ];


    // protected $casts = [
    //     'genre' => 'array',
    //     'degree_anthropization' => 'array',
    //     'place' => 'array',
    //     'typology' => 'array',
    //     'typology_volcano_of_eruption' => 'array',
    //     'attitude_individual' => 'array',
    //     'attitude_collective' => 'array',
    //     'ecological_impact' => 'array',
    //     'social_impact' => 'array',
    //     'affects_individual' => 'array',
    //     'affects_collective' => 'array',
    //     'individual_reaction' => 'array',
    //     'individual_affects_general' => 'array',
    //     'collective_reaction' => 'array',
    //     'individual_strategies' => 'array',
    //     'collective_strategies' => 'array',
    //     'collective_affects' => 'array',
    //     'keywords' => 'array',
    //     'metaphors' => 'array',
    //     'personifications' => 'array',
    //     'similes' => 'array',
    // ];

    protected $casts = [
        'genre' => 'array',
        'geological_entities' => 'array',
        // 'degree_anthropization' => 'array',
        // 'place' => 'array',
        // 'typology' => 'array',
        // 'typology_volcano_of_eruption' => 'array',
        // 'attitude_individual' => 'array',
        // 'attitude_collective' => 'array',
        // 'ecological_impact' => 'array',
        // 'social_impact' => 'array',
        // 'affects_individual' => 'array',
        // 'affects_collective' => 'array',
        // 'individual_reaction' => 'array',
        // 'individual_affects_general' => 'array',
        // 'collective_reaction' => 'array',
        // 'individual_strategies' => 'array',
        // 'collective_strategies' => 'array',
        // 'collective_affects' => 'array',
        'keywords' => 'array',
        'metaphors' => 'array',
        'personifications' => 'array',
        'similes' => 'array',
        'bibliography' =>  'array',
        'symbols' =>  'array',
       'morphological_peculiarities' =>  'array',
       'syntax' =>  'array',
       'punctuation'=>  'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
