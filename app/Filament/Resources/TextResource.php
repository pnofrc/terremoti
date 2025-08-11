<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TextResource\Pages;
use App\Filament\Resources\TextResource\RelationManagers;
use App\Models\Text;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Boolean;
use Filament\Forms\Components\Radio;
use \Filament\Forms\Get;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\NumberInput;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;


class TextResource extends Resource
{

    public static array $risks = [
    'calm' => 'Calm',
    'happiness' => 'Happiness',
    'fear' => 'Fear',
    'anxiety' => 'Anxiety',
    'apprehension' => 'Apprehension',
    'discomfort' => 'Discomfort',
    'distress' => 'Distress',
    'unease' => 'Unease',
    'terror' => 'Terror',
    'panic' => 'Panic',
    'malaise' => 'Malaise',
    'prayer' => 'Prayer',
    'fatalism' => 'Fatalism',
    'heroism' => 'Heroism',
    'cowardice' => 'Cowardice',
    'depression' => 'Depression',
    'pessimism' => 'Pessimism',
    'madness' => 'Madness',
    'trust' => 'Trust',
    'distrust' => 'Distrust',
    'awareness' => 'Awareness',
    'unawareness' => 'Unawareness',
    'acceptance' => 'Acceptance',
    'avoidance' => 'Avoidance',
    'mitigation' => 'Mitigation',
    'adaptation' => 'Adaptation',
    'compensation' => 'Compensation',
    'denial' => 'Denial',
    'disregard' => 'Disregard',
    'scepticism' => 'Scepticism',
    'trust_in_authorities' => 'Trust in authorities',
    'distrust_in_authorities' => 'Distrust in authorities',
    'carelessness'=>'carelessness',
    'recklessness'=>'recklessness',
    'caution'=>'caution',

    'wonder'=> 'Wonder', 
    'curiosity'=> 'Curiosity', 
    'fascination'=> 'Fascination',
    'loss_of_consciousness' => 'Loss of consciousness',

    'awe' => 'Awe',
    'superstition' => 'Superstition',
    'underestimation' => 'Underestimation',
    'rationality' => 'Rationality',
    'faith_in_risk_prediction_systems' => 'Faith in risk prediction systems',


   ];

public static array $events = [
    'escape' => 'Escape',
    'immobility' => 'Immobility',
    'paralysis' => 'Paralysis',
    'fight_for_survival' => 'Fight for survival',
    'surrender' => 'Surrender',
    'intervention' => 'Intervention',
    'passiveness' => 'Passiveness',
    'order' => 'Order',
    'disorder' => 'Disorder',
    'cooperation' => 'Cooperation',
    'hindrance' => 'Hindrance',
    'solidarity' => 'Solidarity',
    'self_absorption' => 'Self-absorption',
    'loss_of_consciousness' => 'Loss of consciousness',
    'prayer' => 'Prayer',
    'fatalism' => 'Fatalism',
    'heroism' => 'Heroism',
    'cowardice' => 'Cowardice',
    'fear' => 'Fear',
    'terror' => 'Terror',
    'panic' => 'Panic',
    'empathy' => 'Empathy',
    'astonishment' => 'Astonishment',
    'anxiety' => 'Anxiety',
    'unease' => 'Unease',
    'discomfort' => 'Discomfort',
    'distress' => 'Distress',
    'malaise' => 'Malaise',
    'rage' => 'Rage',
    'sadness' => 'Sadness',
    'despair' => 'Despair',
    'neurosis' => 'Neurosis',
    'trauma' => 'Trauma',
    'post_traumatic_stress_disorder' => 'Post-traumatic stress disorder',
    'scepticism' => 'Scepticism',
    'doubt' => 'Doubt',
    'resignation' => 'Resignation',
    'survival_instinct' => 'Survival instinct',
    'euphoria' => 'Euphoria',
    'dysphoria' => 'Dysphoria',
    'trust' => 'Trust',
    'distrust' => 'Distrust',
    'madness' => 'Madness',
    'wonder' => 'Wonder',
    'curiosity' => 'Curiosity',
    'fascination' => 'Fascination',

    'helplessness' => 'Helplessness',
    'pragmatism' => 'Pragmatism',
    'concealment_of_information' => 'Concealment of information',
    'sharing_of_information' => 'Sharing of information',
    'underestimation' => 'Underestimation',
    'naivety' => 'Naivety',
    'irony' => 'Irony',
    'rationality' => 'Rationality',
    'irrationality' => 'Irrationality',
    'alarm' => 'Alarm',

];

    protected static ?string $model = Text::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')    
                    ->label('Author Entry')    
                    ->options(User::all()->pluck('name', 'id')) 
                    ->searchable() 
                    ->required(),

                TextInput::make('title')->required(),
                
                TextInput::make('author')->required(),
                TextInput::make('publication_year'),
                TextInput::make('publication_place'),
                TextInput::make('editor')->label('publisher'),

                TextInput::make('collection')->label('Collection'),
                TextInput::make('magazine')->label('Journal / Magazine'),


                Select::make('genre')
                    ->searchable()
                    ->multiple()
                    ->options([
                        'NARRATIVE' => [
                            'historical-novel' => 'Historical novel',
                            'adventure-novel' => 'Adventure novel',
                            'gothic-novel' => 'Gothic novel',
                            'psychological-novel' => 'Psychological novel',
                            'philosophical-novel' => 'Philosophical novel',
                            'biographical-novel' => 'Biographical novel',
                            'autobiographical-novel' => 'Autobiographical novel',
                            'eco-fiction' => 'Eco-fiction',
                            'utopian-novel' => 'Utopian novel',
                            'dystopian-novel' => 'Dystopian novel',
                            'sci-fi-novel' => 'Sci-fi novel',
                            'political-fantastic-novel' => 'Political fantastic novel',
                            'cyberpunk-novel' => 'Cyberpunk novel',
                            'coming-of-age-novel' => 'Coming of age novel',
                            'social-novel' => 'Social novel',
                            'novel-of-manners' => 'Novel of manners',
                            'detective-novel' => 'Detective novel',
                            'horror-novel' => 'Horror novel',
                            'noir-novel' => 'Noir novel',
                            'fantasy-novel' => 'Fantasy novel',
                            'epic-novel' => 'Epic novel',
                            'novella' => 'Novella',
                            'short-story' => 'Short story',
                            'fairy-tale' => 'Fairy tale',

                            'non-fiction' => 'Non-fiction',
                            'essay'=>'Essay',
                            'letter'=>'Letter',


                            'sci-fi' => 'Sci-fi',
                            'dystopian' => 'Dystopian',
                            'thriller' => 'Thriller',
                            'mystery' => 'Mystery',
                            'first-person-account' => 'First-person account',
                            'autobiography' => 'Autobiography',
                            'article' => 'Article',
                            'biofiction' => 'Biofiction',

                        ],
                        'POETRY' => [
                            'poetry' => 'poetry',
                            'sonnet' => 'Sonnet',
                            'lyric' => 'Lyric',
                            'ballad' => 'Ballad',
                            'ode' => 'Ode',
                            'eco-poem' => 'Eco-poem',
                            'pastoral' => 'Pastoral',
                            'elegy' => 'Elegy',
                            'satire' => 'Satire',
                            'dramatic-monologue' => 'Dramatic monologue',

                            'narrative-poem' => 'Narrative Poem',
                            'didactic-poem' => 'Didactic Poem',
                            'epic-poetry' => 'Epic Poetry',
                        ],
                        'DRAMA' => [
                            'comedy' => 'Comedy',
                            'tragedy' => 'Tragedy',
                            'tragicomedy' => 'Tragicomedy',
                        ],
                        'TRAVEL LITERATURE & other' => [
                            'travelogue' => 'Travelogue',
                            'memoir' => 'Memoir',
                            'diary' => 'Diary',
                        ]

                    ]),

            Fieldset::make('Geological Entities and Phenomena')
            ->schema([
                Repeater::make('geological_entities')
                    ->label('Geological Entities and Phenomena')
                    ->schema([
                        Select::make('geological_entity_kind')
                            ->options(
                                [
                                    'volcano' => 'Volcano',
                                    'eruption' => 'Volcanic eruption',
                                    'seismic_zone' => 'Seismic zone',
                                    'earthquake' => 'Earthquake'
                                ]
                            )
                            ->reactive()
                            ,


                        Radio::make('real_event')
                            ->label('entity/event')
                            ->options([
                                'real' => 'Real',
                                'literary' => 'Literary',
                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind'))
                            ->reactive(),


                        // REAL EVENT - VOLCANO

                        Fieldset::make('real_event_volcano')
                            ->label('Real Volcano Event')
                            ->schema([
                                TextInput::make('event_name')
                                    ->label('Name of the Volcano zone'),

                                Repeater::make('typology')
                                    ->label('Typology of volcano')
                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'terrestrial' => 'Terrestrial',
                                                'submarine' => 'Submarine',
                                                'stratovolcano' => 'Stratovolcano',
                                                'explosive' => 'Explosive',
                                                'effusive' => 'Effusive',
                                                'complex' => 'Complex',
                                                'caldera' => 'Caldera',
                                            ]),

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Fieldset::make('place')
                                    ->label('Volcano Place')
                                    ->schema([
                                        TextInput::make('base'),
                                        TextInput::make('country'),
                                        TextInput::make('region'),
                                        TextInput::make('time'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates'),
                                    ]),


                                Repeater::make('degree_anthropization')
                                    ->label('Degree of Anthropization')
                                    ->helperText('(mentioned in historical sources, the media, scientific databases and websites)')
                                    ->schema([
                                        Select::make('attitude')
                                            ->options([
                                                'remote-dwellings' => 'Remote dwellings',
                                                'huts' => 'Huts',
                                                'shelters' => 'Shelters',
                                                'houses' => 'Houses',
                                                'villas' => 'Villas',
                                                'country-houses' => 'Country houses',
                                                'factories' => 'Factories',
                                                'shops' => 'Shops',
                                                'company-premises' => 'Company Premises',
                                                'offices' => 'Offices',
                                                'facilities' => 'Facilities',
                                                'public-buildings' => 'Public Buildings',
                                                'temples' => 'Temples',
                                                'churches' => 'Churches',
                                                'schools' => 'Schools',
                                                'hospitals' => 'Hospitals',
                                                'streets' => 'Streets',
                                                'squares' => 'Squares',
                                                'arenas' => 'Arenas',
                                                'settlements' => 'Settlements',
                                                'villages' => 'Villages',
                                                'towns' => 'Towns',
                                                'cities' => 'Cities',
                                                'metropolis' => 'Metropolis',
                                                'megalopolis' => 'Megalopolis',
                                                'nuclear-power-plants' => 'Nuclear power plants',
                                                'dams' => 'Dams',
                                                'tent-camps' => 'Tent camps',
                                                'tent-cities' => 'Tent cities',
                                                'slums' => 'Slums',
                                                'heritage-sites' => 'Heritage Sites',
                                                'sea-coast' => 'Sea coast',
                                                'river-shores' => 'River shores',
                                                'lake-shores' => 'Lake shores',
                                                'public-sites' => 'Public buildings and sites',
                                                'religious-sites' => 'Religious buildings and sites',
                                                'cultural-sites'  => 'Cultural heritage sites',
                                                'tourist-places'  => 'Tourist places',
                                                'correctional-facilities'  => 'Correctional facilities',
                                         'agricultural-areas' => 'Agriculture areas',
                                                'farming-areas'  => 'Farming areas'

                                            ]),

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree')

                            ])

                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'volcano' && $get('real_event') === 'real'),






                        // REAL EVENT - ERUPTION
                        Fieldset::make('real_eruption')
                            ->label('Real Eruption Event')
                            ->schema([
                                TextInput::make('event_name')
                                    ->label('Name of the eruption'),

                                Repeater::make('typology_volcano_of_eruption')
                                    ->label('Typology of volcano')
                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'terrestrial' => 'Terrestrial',
                                                'submarine' => 'Submarine',
                                                'stratovolcano' => 'Stratovolcano',
                                                'explosive' => 'Explosive',
                                                'effusive' => 'Effusive',
                                                'complex' => 'Complex',
                                                'caldera' => 'Caldera',
                                                
                                                'other' => 'Other'
                                            ]),

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Fieldset::make('place')
                                    ->label('Volcano Place')
                                    ->schema([
                                        TextInput::make('base'),
                                        TextInput::make('country'),
                                        TextInput::make('region'),
                                        TextInput::make('impacted')
                                            ->label('Impact areas of the eruption'),
                                            TextInput::make('time'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates'),
                                    ]),

                                Repeater::make('typology')
                                    ->label('Typology of volcanic eruption')
                                    ->schema([
                                        Select::make('typology')
                                        ->options([
                                            'effusive' => 'Effusive eruption',
                                            'explosive' => 'Explosive eruption',
                                            'other' => 'Other',
                                        ])
                                        ->reactive(),
                                    
                                    Select::make('sub_typology')
                                        ->label('Sub-tipology (Not mandatory)')
                                        ->options(function (callable $get) {
                                            $typology = $get('typology');
                                    
                                            return match ($typology) {
                                                'effusive' => [
                                                    'emission_of_lava' => 'Emission of lava',
                                                    
                                                ],
                                                'explosive' => [
                                                    'gases' => 'Gases',
                                                    'ash_rainfall' => 'Ash rainfall',
                                                    'lapilli' => 'Lapilli',
                                                    'volcanic_bombs' => 'Volcanic bombs',
                                                    'pumice_stones' => 'Emission of pumice stones',
                                                ],
                                                default => [],
                                            };
                                        })
                                        ->reactive()
                                        ->visible(fn (callable $get) => in_array($get('typology'), ['effusive', 'explosive'])),
                                    
                                        

                                        // Select::make('explosive_eruption_typology')->options(
                                        //         ['gases' => 'Gases',
                                        //         'ash_rainfall' => 'Ash rainfall',
                                        //         'lapilli' => 'Lapilli',
                                        //         'volcanic_bombs' => 'Volcanic bombs',
                                        //         'pumice_stones'=>'emission of pumice stones']
                                        // )->visible(fn(Get $get) => $get('typology') === 'explosive_eruption'),

                                        // Select::make('explosive_eruption_typology')->options(
                                        //     ['emission_of_lava' => 'Emission of lava']
                                        // )->visible(fn(Get $get) => $get('typology') === 'effusive_eruption'),

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Repeater::make('degree_anthropization')
                                    ->label('Degree of Anthropization')
                                    ->helperText('(mentioned in historical sources, the media, scientific databases and websites)')
                                    ->schema([
                                        Select::make('attitude')
                                            ->options([
                                                'remote-dwellings' => 'Remote dwellings',
                                                'huts' => 'Huts',
                                                'shelters' => 'Shelters',
                                                'houses' => 'Houses',
                                                'villas' => 'Villas',
                                                'country-houses' => 'Country houses',
                                                'factories' => 'Factories',
                                                'shops' => 'Shops',
                                                'company-premises' => 'Company Premises',
                                                'offices' => 'Offices',
                                                'facilities' => 'Facilities',
                                                'public-buildings' => 'Public Buildings',
                                                'temples' => 'Temples',
                                                'churches' => 'Churches',
                                                'schools' => 'Schools',
                                                'hospitals' => 'Hospitals',
                                                'streets' => 'Streets',
                                                'squares' => 'Squares',
                                                'arenas' => 'Arenas',
                                                'settlements' => 'Settlements',
                                                'villages' => 'Villages',
                                                'towns' => 'Towns',
                                                'cities' => 'Cities',
                                                'metropolis' => 'Metropolis',
                                                'megalopolis' => 'Megalopolis',
                                                'nuclear-power-plants' => 'Nuclear power plants',
                                                'dams' => 'Dams',
                                                'tent-camps' => 'Tent camps',
                                                'tent-cities' => 'Tent cities',
                                                'slums' => 'Slums',
                                                'heritage-sites' => 'Heritage Sites',
                                                'sea-coast' => 'Sea coast',
                                                'river-shores' => 'River shores',
                                                'lake-shores' => 'Lake shores',
                                                'public-sites' => 'Public buildings and sites',
                                                'religious-sites' => 'Religious buildings and sites',
                                                'cultural-sites'  => 'Cultural heritage sites',
                                                'tourist-places'  => 'Tourist places',
                                                'correctional-facilities'  => 'Correctional facilities',
                                                'agricultural-areas' => 'Agriculture areas',
                                                'farming-areas'  => 'Farming areas'
                                            ])
                                        ,

                                        

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),

                                    Repeater::make('ecological_impact')
                                    ->label('Ecological impact of the eruption')
                                    ->schema([
                                        Select::make('impact')
                                            ->options([
                                                   'earthquake' => 'Earthquake',
                                                'changes_of_the_volcanos_shape' => "Changes of the volcano's shape",
                                                'physical_landscape_changes' => 'Physical landscape changes',
                                                'destruction_of_plants' => 'Destruction of plants',
                                                'destruction_of_animal_species' => 'Destruction of animal species',
                                                'atmospheric_changes' => 'Atmospheric changes',
                                                'tsunami' => 'Tsunami',
                                                'other' => 'Other',
                                             ]
                                            )
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Repeater::make('social_impact')
                                    ->label('Social impact of the eruption')
                                    ->schema([
                                        Select::make('impact')
                                            ->options([
                                                'deaths' => 'Deaths',
                                                'injuries' => 'Injuries',
                                                'destruction_of_goods' => 'Destruction of goods/commodities',
                                                'resource_depletion' => 'Resource depletion',
                                                'destruction_of_dwellings' => 'Destruction of dwellings',
                                                'destruction_of_public_buildings' => 'Destruction of public buildings',
                                                'destruction_of_facilities' => 'Destruction of facilities',
                                                'destruction_of_cultural_heritage' => 'Destruction of cultural heritage (materials and sites)',
                                                'social_disruption' => 'Social disruption',
                                                'trauma' => 'Trauma',
                                                'poverty' => 'Poverty',
                                                'harvest' => 'Harvest',
                                                'diseases' => 'Diseases',
                                                'depopulation' => 'Depopulation',
                                                'repopulation' => 'Repopulation',
                                                'relocation' => 'Relocation',
                                                'forced_relocation' => 'Forced Relocation',
                                                'recovery' => 'Recovery',
                                                'war' => 'War',
                                                'conflict' => 'Conflict'
                                            ]
                                            )
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),
                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'eruption' && $get('real_event') === 'real'),



                        // REAL EVENT - seismic

                        Fieldset::make('real_seismic')
                            ->label('Real Seismic zone')

                            ->schema([
                                TextInput::make('event_name')
                                    ->label('Name of the seismic zone'),

                                Repeater::make('typology')
                                    ->label('Typology  Seismic zone')

                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'nw_se_trending_oblique_slip_faults' => 'NW–SE-trending oblique-slip faults',
                                                'ne_sw_trending_oblique_slip_faults' => 'NE–SW-trending oblique-slip faults',
                                                'e_w_trending_normal_faults' => 'E–W-trending normal faults',
                                            ]),

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),


                                Fieldset::make('place')
                                    ->label('Seismic zone Place')
                                    ->schema([
                                        TextInput::make('seismic_fault'),
                                        TextInput::make('country'),
                                        TextInput::make('region'),
                                        TextInput::make('time'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates'),
                                    ]),

                                Repeater::make('degree_anthropization')
                                    ->label('Degree of Anthropization')
                                    ->helperText('(mentioned in historical sources, the media, scientific databases and websites)')
                                    ->schema([
                                        Select::make('attitude')
                                            ->options([
                                                'remote-dwellings' => 'Remote dwellings',
                                                'huts' => 'Huts',
                                                'shelters' => 'Shelters',
                                                'houses' => 'Houses',
                                                'villas' => 'Villas',
                                                'country-houses' => 'Country houses',
                                                'factories' => 'Factories',
                                                'shops' => 'Shops',
                                                'company-premises' => 'Company Premises',
                                                'offices' => 'Offices',
                                                'facilities' => 'Facilities',
                                                'public-buildings' => 'Public Buildings',
                                                'temples' => 'Temples',
                                                'churches' => 'Churches',
                                                'schools' => 'Schools',
                                                'hospitals' => 'Hospitals',
                                                'streets' => 'Streets',
                                                'squares' => 'Squares',
                                                'arenas' => 'Arenas',
                                                'settlements' => 'Settlements',
                                                'villages' => 'Villages',
                                                'towns' => 'Towns',
                                                'cities' => 'Cities',
                                                'metropolis' => 'Metropolis',
                                                'megalopolis' => 'Megalopolis',
                                                'nuclear-power-plants' => 'Nuclear power plants',
                                                'dams' => 'Dams',
                                                'tent-camps' => 'Tent camps',
                                                'tent-cities' => 'Tent cities',
                                                'slums' => 'Slums',
                                                'heritage-sites' => 'Heritage Sites',
                                                'sea-coast' => 'Sea coast',
                                                'river-shores' => 'River shores',
                                                'lake-shores' => 'Lake shores',
                                                'public-sites' => 'Public buildings and sites',
                                                'religious-sites' => 'Religious buildings and sites',
                                                'cultural-sites'  => 'Cultural heritage sites',
                                                'tourist-places'  => 'Tourist places',
                                                'correctional-facilities'  => 'Correctional facilities',
                                                'agricultural-areas' => 'Agriculture areas',
                                                'farming-areas'  => 'Farming areas'
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),
                            ])

                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'seismic_zone' && $get('real_event') === 'real'),

                        // REAL EVENT - eartquake

                        Fieldset::make('real_earthquake')
                            ->label('Real Earthquake Event')
                            ->schema([
                                TextInput::make('event_name')
                                    ->label('Name of the earthquake'),


                                Fieldset::make('place')
                                    ->label('Place of the earthquake')
                                    ->schema([
                                        TextInput::make('seismic_fault'),
                                        TextInput::make('country'),
                                        TextInput::make('region'),
                                        TextInput::make('time'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates of the epicentre'),
                                        TextInput::make('impacted')
                                            ->label('Impact area of the earthquake (cities, etc..)'),
                                    ]),


                                Repeater::make('typology')
                                    ->label('Typology of earthquake')

                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'tectonic_earthquake' => 'Tectonic earthquake',
                                                'volcanic_earthquake' => 'Volcanic earthquake',
                                                'collapse_earthquake' => 'Collapse earthquake',
                                                'man_made_earthquake' => 'Man-made earthquake',
                                            ]),

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),




                                TextInput::make('earthquake_magnitude')
                                    ->label('Magnitude of the earthquake'),


                                Repeater::make('degree_anthropization')
                                    ->label('Degree of Anthropization')
                                    ->helperText('(mentioned in historical sources, the media, scientific databases and websites)')
                                    ->schema([
                                        Select::make('attitude')
                                            ->options([
                                                'remote-dwellings' => 'Remote dwellings',
                                                'huts' => 'Huts',
                                                'shelters' => 'Shelters',
                                                'houses' => 'Houses',
                                                'villas' => 'Villas',
                                                'country-houses' => 'Country houses',
                                                'factories' => 'Factories',
                                                'shops' => 'Shops',
                                                'company-premises' => 'Company Premises',
                                                'offices' => 'Offices',
                                                'facilities' => 'Facilities',
                                                'public-buildings' => 'Public Buildings',
                                                'temples' => 'Temples',
                                                'churches' => 'Churches',
                                                'schools' => 'Schools',
                                                'hospitals' => 'Hospitals',
                                                'streets' => 'Streets',
                                                'squares' => 'Squares',
                                                'arenas' => 'Arenas',
                                                'settlements' => 'Settlements',
                                                'villages' => 'Villages',
                                                'towns' => 'Towns',
                                                'cities' => 'Cities',
                                                'metropolis' => 'Metropolis',
                                                'megalopolis' => 'Megalopolis',
                                                'nuclear-power-plants' => 'Nuclear power plants',
                                                'dams' => 'Dams',
                                                'tent-camps' => 'Tent camps',
                                                'tent-cities' => 'Tent cities',
                                                'slums' => 'Slums',
                                                'heritage-sites' => 'Heritage Sites',
                                                'sea-coast' => 'Sea coast',
                                                'river-shores' => 'River shores',
                                                'lake-shores' => 'Lake shores',
                                                'public-sites' => 'Public buildings and sites',
                                                'religious-sites' => 'Religious buildings and sites',
                                                'cultural-sites'  => 'Cultural heritage sites',
                                                'tourist-places'  => 'Tourist places',
                                                'correctional-facilities'  => 'Correctional facilities',
                                                'agricultural-areas' => 'Agriculture areas',
                                                'farming-areas'  => 'Farming areas'
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),

                                Repeater::make('ecological_impact')
                                    ->label('Ecological impact of the earthquake')
                                    ->schema([
                                        Select::make('impact')
                                            ->options([
                                                 // 'changes_of_volcano_shape' => 'Changes of the volcano’s shape',
                                                'physical_landscape_changes' => 'Physical landscape changes',
                                                'destruction_of_plants' => 'Destruction of plants',
                                                'destruction_of_animal_species' => 'Destruction of animal species',
                                                'atmospheric_changes' => 'Atmospheric changes',
                                                'soil_changes' => 'Soil changes',
                                                'soil_degradation' => 'Soil degradation',
                                                'pollution' => 'Pollution',
                                                'sea_pollution' => 'Sea pollution',
                                                // 'earthquake' => 'Earthquake',
                                                'tsunami' => 'Tsunami',
                                                'chemical_waste' => 'Chemical Waste',
                                                'nuclear_waste' => 'Nuclear Waste',
                                                'other' => 'Other'
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Repeater::make('social_impact')
                                    ->label('Social impact of the earthquake')
                                    ->helperText('on the human world (data derived from chronicles, notebooks, the media, scientific databases, websites)')
                                    ->schema([
                                        Select::make('impact')
                                            ->options([
                                                'deaths' => 'Deaths',
                                                'injuries' => 'Injuries',
                                                'destruction_of_goods' => 'Destruction of goods/commodities',
                                                'resource_depletion' => 'Resource depletion',
                                                'destruction_of_dwellings' => 'Destruction of dwellings',
                                                'destruction_of_public_buildings' => 'Destruction of public buildings',
                                                'destruction_of_facilities' => 'Destruction of facilities',
                                                'destruction_of_cultural_heritage' => 'Destruction of cultural heritage (materials and sites)',
                                                'social_disruption' => 'Social disruption',
                                                'trauma' => 'Trauma',
                                                'poverty' => 'Poverty',
                                                'harvest' => 'Harvest',
                                                'diseases' => 'Diseases',
                                                'depopulation' => 'Depopulation',
                                                'repopulation' => 'Repopulation',
                                                'relocation' => 'Relocation',
                                                'forced_relocation' => 'Forced Relocation',
                                                 'war' => 'War',
                                                'conflict' => 'Conflict',
                                                'recovery' => 'Recovery'
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'earthquake' && $get('real_event') === 'real'),



                        // literary vulcano



                        Fieldset::make('literary_volcano')
                            ->label('Literary Volcano Event')
                            ->schema([
                                TextInput::make('volcano_name')
                                    ->label('Name of the volcano'),

                                Repeater::make('typology')
                                    ->label('Typology of volcano')
                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'terrestrial' => 'Terrestrial',
                                                'submarine' => 'Submarine',
                                                'stratovolcano' => 'Stratovolcano',
                                                'explosive' => 'Explosive',
                                                'effusive' => 'Effusive',
                                                'complex' => 'Complex',
                                                'caldera' => 'Caldera',
                                            ]),

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),


                                Fieldset::make('place')
                                    ->label('Volcano Place')
                                    ->schema([
                                        TextInput::make('base'),
                                        TextInput::make('country'),
                                        TextInput::make('region'),
                                        TextInput::make('time'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates'),
                                    ]),


                                Repeater::make('degree_anthropization')
                                    ->label('Degree of Anthropization')
                                    ->helperText('(mentioned in historical sources, the media, scientific databases and websites)')
                                    ->schema([
                                        Select::make('attitude')
                                            ->options([
                                                'remote-dwellings' => 'Remote dwellings',
                                                'huts' => 'Huts',
                                                'shelters' => 'Shelters',
                                                'houses' => 'Houses',
                                                'villas' => 'Villas',
                                                'country-houses' => 'Country houses',
                                                'factories' => 'Factories',
                                                'shops' => 'Shops',
                                                'company-premises' => 'Company Premises',
                                                'offices' => 'Offices',
                                                'facilities' => 'Facilities',
                                                'public-buildings' => 'Public Buildings',
                                                'temples' => 'Temples',
                                                'churches' => 'Churches',
                                                'schools' => 'Schools',
                                                'hospitals' => 'Hospitals',
                                                'streets' => 'Streets',
                                                'squares' => 'Squares',
                                                'arenas' => 'Arenas',
                                                'settlements' => 'Settlements',
                                                'villages' => 'Villages',
                                                'towns' => 'Towns',
                                                'cities' => 'Cities',
                                                'metropolis' => 'Metropolis',
                                                'megalopolis' => 'Megalopolis',
                                                'nuclear-power-plants' => 'Nuclear power plants',
                                                'dams' => 'Dams',
                                                'tent-camps' => 'Tent camps',
                                                'tent-cities' => 'Tent cities',
                                                'slums' => 'Slums',
                                                'heritage-sites' => 'Heritage Sites',
                                                'sea-coast' => 'Sea coast',
                                                'river-shores' => 'River shores',
                                                'lake-shores' => 'Lake shores',
                                                'public-sites' => 'Public buildings and sites',
                                                'religious-sites' => 'Religious buildings and sites',
                                                'cultural-sites'  => 'Cultural heritage sites',
                                                'tourist-places'  => 'Tourist places',
                                                'correctional-facilities'  => 'Correctional facilities',
                                                'agricultural-areas' => 'Agriculture areas',
                                                'farming-areas'  => 'Farming areas'
                                            ])
                                        ,

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),

                                Radio::make('reference_volcanic_risk')
                                    ->options([
                                        'referenced' => 'referenced',
                                        'not-reference' => 'without reference',
                                    ])
                                    ->reactive(),

                                Repeater::make('attitude_individual')
                                    ->label('What is the individual affects/attitude/strategy towards volcanic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options(self::$risks)
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add Character'),



                                Repeater::make('attitude_collective')
                                    ->label('What is the collective affect/attitude/strategy towards volcanic risk?')
                                    ->schema([
                                        Select::make('group')
                                            ->options([
                                                'humans' => 'Humans',
                                                'aliens' => 'Aliens',
                                                'white_people' => 'White people',
                                                'black_people' => 'Black people',
                                                'indigenous_people' => 'Indigenous people',
                                                'old_people' => 'Old People',
                                                'elders' => 'Elders',
                                                'adults' => 'Adults',
                                                'young_people' => 'Young People',
                                                'men' => 'Men',
                                                'women' => 'Women',
                                                'boys' => 'Boys',
                                                'girls' => 'Girls',
                                                'children' => 'Children',
                                                'nobles' => 'Nobles',
                                                'aristocrats' => 'Aristocrats',
                                                'middle_class_people' => 'Middle-class people',
                                                'working_class_people' => 'Working class people',
                                                'officers' => 'The officers',
                                                'army' => 'The army',
                                                'civil_defense' => 'The civil defense',
                                                'masters' => 'Masters',
                                                'servants' => 'Servants',
                                                'crowd' => 'The crowd',
                                                'population' => 'The population',
                                                'slaves' => 'Slaves',
                                                'politicians' => 'Politicians',
                                                'philosophers' => 'Philosophers',
                                                'scholars' => 'Scholars',
                                                'educated_people' => 'Educated people',
                                                'uneducated_people' => 'Uneducated people',
                                                'business_people' => 'Business people',
                                                'common_people' => 'Common people',
                                                'wealthy_people' => 'Wealthy people',
                                                'poor_people' => 'Poor people',
                                                'religious_people' => 'Religious people',
                                                'atheists' => 'Atheists',
                                                'believers' => 'Believers',
                                                'pagan_priests' => 'Pagan Priests',
                                                'christian_priests' => 'Christian Priests',
                                                'travellers' => 'Travellers',
                                                'settlers' => 'Settlers',
                                                'colonists' => 'Colonists',
                                                'adventurers' => 'Adventurers',
                                                'explorers' => 'Explorers',
                                                'colonisers' => 'Colonisers',
                                                'colonised_people' => 'Colonised people',
                                                'scientists' => 'Scientists',
                                                'nonhuman_beings' => 'Nonhuman beings',
                                                'nonbinary_people' => 'Nonbinary people',
                                                'patricians' => 'Patricians',
                                                'plebeians' => 'Plebeians',
                                                'eccentric' => 'Eccentric People',
                                                'magician' => 'People with magical power',
                                                'erudite' => 'Erudite people',

                                                'nonhuman-beings' => 'Nonhuman beings',
                                                'animals' => 'Animals',
                                                'volcanologists' => 'Volcanologists',
                                                'geologists' => 'Geologists',
                                                'journalists' => 'Journalists',
                                                'the-media' => 'The media',
                                                'civil-defense' => 'Civil defense',
                                                'rescuers' => 'Rescuers',
                                                'businesspeople' => 'Businesspeople',
                                                'tourists' => 'Tourists',
                                                
                                            ]),

                                        Select::make('attitude')
                                            ->options( self::$risks)
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),



                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'volcano' && $get('real_event') === 'literary'),




                        // literary -- eruption

                        Fieldset::make('literary_eruption')
                            ->label('Literary Eruption Event')
                            ->schema([
                                TextInput::make('event_name')
                                    ->label('Name of the eruption'),

                                Repeater::make('typology_volcano_of_eruption')
                                    ->label('Typology of volcano')
                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'terrestrial' => 'Terrestrial',
                                                'submarine' => 'Submarine',
                                                'stratovolcano' => 'Stratovolcano',
                                                'explosive' => 'Explosive',
                                                'effusive' => 'Effusive',
                                                'complex' => 'Complex',
                                                'caldera' => 'Caldera',
                                            ]),

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Fieldset::make('place')
                                    ->label('Volcano Place')
                                    ->schema([
                                        TextInput::make('base'),
                                        TextInput::make('country'),
                                        TextInput::make('region'),
                                        TextInput::make('impacted')
                                            ->label('Impact areas of the eruption'),
                                            TextInput::make('time'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates'),
                                    ]),

                                Repeater::make('typology')
                                    ->label(' Typology of volcanic eruption')
                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'Effusive eruption' => [
                                                    'emission_of_lava' => 'Emission of lava'
                                                  
                                            ],
                                                'Explosive eruption' => [
                                                      'gases' => 'Gases',
                                                        'ash_rainfall' => 'Ash rainfall',
                                                        'lapilli' => 'Lapilli',
                                                        'volcanic_bombs' => 'Volcanic bombs',
                                                        'pumice_stones'=>'emission of pumice stones'
                                                ],
                                                'other' => 'other'
                                            ])->reactive(),
                                        

                                       
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Repeater::make('degree_anthropization')
                                    ->label('Degree of Anthropization')
                                    ->helperText('(mentioned in historical sources, the media, scientific databases and websites)')
                                    ->schema([
                                        Select::make('attitude')
                                            ->options([
                                                'remote-dwellings' => 'Remote dwellings',
                                                'huts' => 'Huts',
                                                'shelters' => 'Shelters',
                                                'houses' => 'Houses',
                                                'villas' => 'Villas',
                                                'country-houses' => 'Country houses',
                                                'factories' => 'Factories',
                                                'shops' => 'Shops',
                                                'company-premises' => 'Company Premises',
                                                'offices' => 'Offices',
                                                'facilities' => 'Facilities',
                                                'public-buildings' => 'Public Buildings',
                                                'temples' => 'Temples',
                                                'churches' => 'Churches',
                                                'schools' => 'Schools',
                                                'hospitals' => 'Hospitals',
                                                'streets' => 'Streets',
                                                'squares' => 'Squares',
                                                'arenas' => 'Arenas',
                                                'settlements' => 'Settlements',
                                                'villages' => 'Villages',
                                                'towns' => 'Towns',
                                                'cities' => 'Cities',
                                                'metropolis' => 'Metropolis',
                                                'megalopolis' => 'Megalopolis',
                                                'nuclear-power-plants' => 'Nuclear power plants',
                                                'dams' => 'Dams',
                                                'tent-camps' => 'Tent camps',
                                                'tent-cities' => 'Tent cities',
                                                'slums' => 'Slums',
                                                'heritage-sites' => 'Heritage Sites',
                                                'sea-coast' => 'Sea coast',
                                                'river-shores' => 'River shores',
                                                'lake-shores' => 'Lake shores',
                                                'public-sites' => 'Public buildings and sites',
                                                'religious-sites' => 'Religious buildings and sites',
                                                'cultural-sites'  => 'Cultural heritage sites',
                                                'tourist-places'  => 'Tourist places',
                                                'correctional-facilities'  => 'Correctional facilities',
                                                'agricultural-areas' => 'Agriculture areas',
                                                'farming-areas'  => 'Farming areas'
                                            ])
                                        ,

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),


                                Radio::make('reference_volcanic_risk')
                                    ->options([
                                        'referenced' => 'referenced',
                                        'not-reference' => 'without reference',
                                    ])
                                    ->reactive(),

                                Repeater::make('attitude_individual')
                                    ->label('What is the individual affect/attitude/strategy towards volcanic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options(self::$risks)
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add Character'),



                                Repeater::make('attitude_collective')
                                    ->label('What is the collective affect/attitude/strategy towards volcanic risk?')
                                    ->schema([
                                        Select::make('group')
                                            ->options([
                                                'humans' => 'Humans',
                                                'aliens' => 'Aliens',
                                                'white_people' => 'White people',
                                                'black_people' => 'Black people',
                                                'indigenous_people' => 'Indigenous people',
                                                'old_people' => 'Old People',
                                                'elders' => 'Elders',
                                                'adults' => 'Adults',
                                                'young_people' => 'Young People',
                                                'men' => 'Men',
                                                'women' => 'Women',
                                                'boys' => 'Boys',
                                                'girls' => 'Girls',
                                                'children' => 'Children',
                                                'nobles' => 'Nobles',
                                                'aristocrats' => 'Aristocrats',
                                                'middle_class_people' => 'Middle-class people',
                                                'working_class_people' => 'Working class people',
                                                'officers' => 'The officers',
                                                'army' => 'The army',
                                                'civil_defense' => 'The civil defense',
                                                'masters' => 'Masters',
                                                'servants' => 'Servants',
                                                'crowd' => 'The crowd',
                                                'population' => 'The population',
                                                'slaves' => 'Slaves',
                                                'politicians' => 'Politicians',
                                                'philosophers' => 'Philosophers',
                                                'scholars' => 'Scholars',
                                                'educated_people' => 'Educated people',
                                                'uneducated_people' => 'Uneducated people',
                                                'business_people' => 'Business people',
                                                'common_people' => 'Common people',
                                                'wealthy_people' => 'Wealthy people',
                                                'poor_people' => 'Poor people',
                                                'religious_people' => 'Religious people',
                                                'atheists' => 'Atheists',
                                                'believers' => 'Believers',
                                                'pagan_priests' => 'Pagan Priests',
                                                'christian_priests' => 'Christian Priests',
                                                'travellers' => 'Travellers',
                                                'settlers' => 'Settlers',
                                                'colonists' => 'Colonists',
                                                'adventurers' => 'Adventurers',
                                                'explorers' => 'Explorers',
                                                'colonisers' => 'Colonisers',
                                                'colonised_people' => 'Colonised people',
                                                'scientists' => 'Scientists',
                                                'nonhuman_beings' => 'Nonhuman beings',
                                                'nonbinary_people' => 'Nonbinary people',
                                                'patricians' => 'Patricians',
                                                'plebeians' => 'Plebeians',
                                                'eccentric' => 'Eccentric People',
                                                'magician' => 'People with magical power',
                                                'erudite' => 'Erudite people',

                                                'nonhuman-beings' => 'Nonhuman beings',
                                            'animals' => 'Animals',
                                            'volcanologists' => 'Volcanologists',
                                            'geologists' => 'Geologists',
                                            'journalists' => 'Journalists',
                                            'the-media' => 'The media',
                                            'civil-defense' => 'Civil defense',
                                            'rescuers' => 'Rescuers',
                                            'businesspeople' => 'Businesspeople',
                                            'tourists' => 'Tourists',
                                            ]),

                                        Select::make('attitude')
                                            ->options(self::$risks)
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),

                                Repeater::make('ecological_impact')
                                    ->label('Ecological impact of the eruption')
                                    ->schema([
                                        Select::make('impact')
                                            ->options([
                                                'earthquake' => 'Earthquake',
                                               'changes_of_the_volcanos_shape' => "Changes of the volcano's shape",
                                                'physical_landscape_changes' => 'Physical landscape changes',
                                                'destruction_of_plants' => 'Destruction of plants',
                                                'destruction_of_animal_species' => 'Destruction of animal species',
                                                'atmospheric_changes' => 'Atmospheric changes',
                                                'tsunami' => 'Tsunami',
                                                'other' => 'Other',
                                             ]
                                            )
                                        ,

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Repeater::make('social_impact')
                                    ->label('Social impact of the eruption')
                                    ->schema([
                                        Select::make('impact')
                                            ->options([
                                                'deaths' => 'Deaths',
                                                'injuries' => 'Injuries',
                                                'destruction_of_goods' => 'Destruction of goods/commodities',
                                                'resource_depletion' => 'Resource depletion',
                                                'destruction_of_dwellings' => 'Destruction of dwellings',
                                                'destruction_of_public_buildings' => 'Destruction of public buildings',
                                                'destruction_of_facilities' => 'Destruction of facilities',
                                                'destruction_of_cultural_heritage' => 'Destruction of cultural heritage (materials and sites)',
                                                'social_disruption' => 'Social disruption',
                                                'trauma' => 'Trauma',
                                                'poverty' => 'Poverty',
                                                'harvest' => 'Harvest',
                                                'diseases' => 'Diseases',
                                                'depopulation' => 'Depopulation',
                                                'repopulation' => 'Repopulation',
                                                'relocation' => 'Relocation',
                                                'forced_relocation' => 'Forced Relocation',
                                                 'war' => 'War',
                                                'conflict' => 'Conflict',
                                                'recovery' => 'Recovery'
                                            ]
                                            )
                                        ,       ])
                                    ->createItemButtonLabel('Add typology'),



                                Repeater::make('individual_reaction')
                                    ->label('Individual affects/strategies to the event')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('reactions')
                                            ->options(self::$events)
                                            ->multiple()
                                            ->searchable()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add Reaction'),



                                Repeater::make('collective_affects_general')
                                    ->label('General Collective affects/reactions to the event')
                                    ->schema([
                                        Select::make('group')
                                            ->options([
                                                'humans' => 'Humans',
                                                'aliens' => 'Aliens',
                                                'white_people' => 'White people',
                                                'black_people' => 'Black people',
                                                'indigenous_people' => 'Indigenous people',
                                                'old_people' => 'Old People',
                                                'elders' => 'Elders',
                                                'adults' => 'Adults',
                                                'young_people' => 'Young People',
                                                'men' => 'Men',
                                                'women' => 'Women',
                                                'boys' => 'Boys',
                                                'girls' => 'Girls',
                                                'children' => 'Children',
                                                'nobles' => 'Nobles',
                                                'aristocrats' => 'Aristocrats',
                                                'middle_class_people' => 'Middle-class people',
                                                'working_class_people' => 'Working class people',
                                                'officers' => 'The officers',
                                                'army' => 'The army',
                                                'civil_defense' => 'The civil defense',
                                                'masters' => 'Masters',
                                                'servants' => 'Servants',
                                                'crowd' => 'The crowd',
                                                'population' => 'The population',
                                                'slaves' => 'Slaves',
                                                'politicians' => 'Politicians',
                                                'philosophers' => 'Philosophers',
                                                'scholars' => 'Scholars',
                                                'educated_people' => 'Educated people',
                                                'uneducated_people' => 'Uneducated people',
                                                'business_people' => 'Business people',
                                                'common_people' => 'Common people',
                                                'wealthy_people' => 'Wealthy people',
                                                'poor_people' => 'Poor people',
                                                'religious_people' => 'Religious people',
                                                'atheists' => 'Atheists',
                                                'believers' => 'Believers',
                                                'pagan_priests' => 'Pagan Priests',
                                                'christian_priests' => 'Christian Priests',
                                                'travellers' => 'Travellers',
                                                'settlers' => 'Settlers',
                                                'colonists' => 'Colonists',
                                                'adventurers' => 'Adventurers',
                                                'explorers' => 'Explorers',
                                                'colonisers' => 'Colonisers',
                                                'colonised_people' => 'Colonised people',
                                                'scientists' => 'Scientists',
                                                'eccentric' => 'Eccentric People',
                                                'magician' => 'People with magical power',
                                                'erudite' => 'Erudite people',
                                                'patricians' => 'Patricians',
                                                'plebeians' => 'Plebeians',

                                                'nonhuman-beings' => 'Nonhuman beings',
                                                'animals' => 'Animals',
                                                'volcanologists' => 'Volcanologists',
                                                'geologists' => 'Geologists',
                                                'journalists' => 'Journalists',
                                                'the-media' => 'The media',
                                                'civil-defense' => 'Civil defense',
                                                'rescuers' => 'Rescuers',
                                                'businesspeople' => 'Businesspeople',
                                                'tourists' => 'Tourists',
                                            ]),

                                        Select::make('attitude')
                                            ->options(
                                                self::$events
                                            )
                                            ->multiple()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add group'),



                                Select::make('phase_emphisized')
                                    ->label('Which phase of the disaster is emphasized?')
                                    ->options(
                                        [
                                            'pre_disaster' => 'Pre-disaster (causes / context)',
                                            'disaster' => 'Disaster (phenomenal and social dynamics)',
                                            'post_disaster' => 'Post-disaster (consequences)',
                                        ]
                                    )->multiple(),

                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'eruption' && $get('real_event') === 'literary'),





                        // literary SEISMIC
                        Fieldset::make('literary_seismic')
                            ->label('Literary Seismic zone')
                            ->schema([
                                TextInput::make('event_name')
                                    ->label('Name of the seismic zone'),

                                Repeater::make('typology')
                                    ->label('Typology  Seismic zone')

                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'nw_se_trending_oblique_slip_faults' => 'NW–SE-trending oblique-slip faults',
                                                'ne_sw_trending_oblique_slip_faults' => 'NE–SW-trending oblique-slip faults',
                                                'e_w_trending_normal_faults' => 'E–W-trending normal faults',
                                            ]),

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),



                                Fieldset::make('place')
                                    ->label('Seismic zone Place')
                                    ->schema([
                                        TextInput::make('seismic_fault'),
                                        TextInput::make('country'),
                                        TextInput::make('region'),
                                        TextInput::make('time'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates'),
                                    ]),

                                Repeater::make('degree_anthropization')
                                    ->label('Degree of Anthropization')
                                    ->helperText('(mentioned in historical sources, the media, scientific databases and websites)')
                                    ->schema([
                                        Select::make('attitude')
                                            ->options([
                                                'remote-dwellings' => 'Remote dwellings',
                                                'huts' => 'Huts',
                                                'shelters' => 'Shelters',
                                                'houses' => 'Houses',
                                                'villas' => 'Villas',
                                                'country-houses' => 'Country houses',
                                                'factories' => 'Factories',
                                                'shops' => 'Shops',
                                                'company-premises' => 'Company Premises',
                                                'offices' => 'Offices',
                                                'facilities' => 'Facilities',
                                                'public-buildings' => 'Public Buildings',
                                                'temples' => 'Temples',
                                                'churches' => 'Churches',
                                                'schools' => 'Schools',
                                                'hospitals' => 'Hospitals',
                                                'streets' => 'Streets',
                                                'squares' => 'Squares',
                                                'arenas' => 'Arenas',
                                                'settlements' => 'Settlements',
                                                'villages' => 'Villages',
                                                'towns' => 'Towns',
                                                'cities' => 'Cities',
                                                'metropolis' => 'Metropolis',
                                                'megalopolis' => 'Megalopolis',
                                                'nuclear-power-plants' => 'Nuclear power plants',
                                                'dams' => 'Dams',
                                                'tent-camps' => 'Tent camps',
                                                'tent-cities' => 'Tent cities',
                                                'slums' => 'Slums',
                                                'heritage-sites' => 'Heritage Sites',
                                                'sea-coast' => 'Sea coast',
                                                'river-shores' => 'River shores',
                                                'lake-shores' => 'Lake shores',
                                                'public-sites' => 'Public buildings and sites',
                                                'religious-sites' => 'Religious buildings and sites',
                                                'cultural-sites'  => 'Cultural heritage sites',
                                                'tourist-places'  => 'Tourist places',
                                                'correctional-facilities'  => 'Correctional facilities',
                                                'agricultural-areas' => 'Agriculture areas',
                                                'farming-areas'  => 'Farming areas'
                                            ])
                                        ,

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),


                                Radio::make('reference_seismic_risk')
                                    ->label('Reference to the perception of a seismic risk')
                                    ->options([
                                        'referenced' => 'referenced',
                                        'not-reference' => 'without reference',
                                    ])
                                    ->reactive(),

                                Repeater::make('attitude_individual')
                                    ->label('What is the individual affect/attitude/strategy towards the seismic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options(self::$risks)
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add Character'),




                                Repeater::make('attitude_group')
                                    ->label('What is the collective affect/attitude/strategy towards seismic risk?')
                                    ->schema([
                                        Select::make('group')
                                            ->options([
                                                'humans' => 'Humans',
                                                'aliens' => 'Aliens',
                                                'white_people' => 'White people',
                                                'black_people' => 'Black people',
                                                'indigenous_people' => 'Indigenous people',
                                                'old_people' => 'Old People',
                                                'elders' => 'Elders',
                                                'adults' => 'Adults',
                                                'young_people' => 'Young People',
                                                'men' => 'Men',
                                                'women' => 'Women',
                                                'boys' => 'Boys',
                                                'girls' => 'Girls',
                                                'children' => 'Children',
                                                'nobles' => 'Nobles',
                                                'aristocrats' => 'Aristocrats',
                                                'middle_class_people' => 'Middle-class people',
                                                'working_class_people' => 'Working class people',
                                                'officers' => 'The officers',
                                                'army' => 'The army',
                                                'civil_defense' => 'The civil defense',
                                                'masters' => 'Masters',
                                                'servants' => 'Servants',
                                                'crowd' => 'The crowd',
                                                'population' => 'The population',
                                                'slaves' => 'Slaves',
                                                'politicians' => 'Politicians',
                                                'philosophers' => 'Philosophers',
                                                'scholars' => 'Scholars',
                                                'educated_people' => 'Educated people',
                                                'uneducated_people' => 'Uneducated people',
                                                'business_people' => 'Business people',
                                                'common_people' => 'Common people',
                                                'wealthy_people' => 'Wealthy people',
                                                'poor_people' => 'Poor people',
                                                'religious_people' => 'Religious people',
                                                'atheists' => 'Atheists',
                                                'believers' => 'Believers',
                                                'pagan_priests' => 'Pagan Priests',
                                                'christian_priests' => 'Christian Priests',
                                                'travellers' => 'Travellers',
                                                'settlers' => 'Settlers',
                                                'colonists' => 'Colonists',
                                                'adventurers' => 'Adventurers',
                                                'explorers' => 'Explorers',
                                                'colonisers' => 'Colonisers',
                                                'colonised_people' => 'Colonised people',
                                                'scientists' => 'Scientists',
                                                'nonhuman_beings' => 'Nonhuman beings',
                                                'nonbinary_people' => 'Nonbinary people',
                                                'patricians' => 'Patricians',
                                                'plebeians' => 'Plebeians',
                                                'eccentric' => 'Eccentric People',
                                                'magician' => 'People with magical power',
                                                'erudite' => 'Erudite people',

                                                'nonhuman-beings' => 'Nonhuman beings',
                                                'animals' => 'Animals',
                                                'volcanologists' => 'Volcanologists',
                                                'geologists' => 'Geologists',
                                                'journalists' => 'Journalists',
                                                'the-media' => 'The media',
                                                'civil-defense' => 'Civil defense',
                                                'rescuers' => 'Rescuers',
                                                'businesspeople' => 'Businesspeople',
                                                'tourists' => 'Tourists',
                                            ]),

                                        Select::make('attitude')
                                            ->options(self::$risks)
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),


                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'seismic_zone' && $get('real_event') === 'literary'),



                        // literary earthquake


                        Fieldset::make('literary_earthquake')
                            ->label('Literary Earthquake Event')
                            ->schema([
                                TextInput::make('event_name')
                                    ->label('Name of the earthquake'),



                                Repeater::make('typology')
                                    ->label('Typology of earthquake')

                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'tectonic_earthquake' => 'Tectonic earthquake',
                                                'volcanic_earthquake' => 'Volcanic earthquake',
                                                'collapse_earthquake' => 'Collapse earthquake',
                                                'man_made_earthquake' => 'Man-made earthquake',
                                            ]),

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),



                                Fieldset::make('place')
                                    ->label('Place of the earthquake')
                                    ->schema([
                                        TextInput::make('seismic_fault'),
                                        TextInput::make('country'),
                                        TextInput::make('region'),
                                        TextInput::make('time'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates of the epicentre'),
                                        TextInput::make('impacted')
                                            ->label('Impact area of the earthquake (cities, etc..)'),
                                    ]),






                                TextInput::make('earthquake_magnitude')
                                    ->label('Magnitude of the earthquake'),

                                Repeater::make('degree_anthropization')
                                    ->label('Degree of Anthropization')
                                    ->helperText('(mentioned in historical sources, the media, scientific databases and websites)')
                                    ->schema([
                                        Select::make('attitude')
                                            ->options([
                                                'remote-dwellings' => 'Remote dwellings',
                                                'huts' => 'Huts',
                                                'shelters' => 'Shelters',
                                                'houses' => 'Houses',
                                                'villas' => 'Villas',
                                                'country-houses' => 'Country houses',
                                                'factories' => 'Factories',
                                                'shops' => 'Shops',
                                                'company-premises' => 'Company Premises',
                                                'offices' => 'Offices',
                                                'facilities' => 'Facilities',
                                                'public-buildings' => 'Public Buildings',
                                                'temples' => 'Temples',
                                                'churches' => 'Churches',
                                                'schools' => 'Schools',
                                                'hospitals' => 'Hospitals',
                                                'streets' => 'Streets',
                                                'squares' => 'Squares',
                                                'arenas' => 'Arenas',
                                                'settlements' => 'Settlements',
                                                'villages' => 'Villages',
                                                'towns' => 'Towns',
                                                'cities' => 'Cities',
                                                'metropolis' => 'Metropolis',
                                                'megalopolis' => 'Megalopolis',
                                                'nuclear-power-plants' => 'Nuclear power plants',
                                                'dams' => 'Dams',
                                                'tent-camps' => 'Tent camps',
                                                'tent-cities' => 'Tent cities',
                                                'slums' => 'Slums',
                                                'heritage-sites' => 'Heritage Sites',
                                                'sea-coast' => 'Sea coast',
                                                'river-shores' => 'River shores',
                                                'lake-shores' => 'Lake shores',
                                                'public-sites' => 'Public buildings and sites',
                                                'religious-sites' => 'Religious buildings and sites',
                                                'cultural-sites'  => 'Cultural heritage sites',
                                                'tourist-places'  => 'Tourist places',
                                                'correctional-facilities'  => 'Correctional facilities',
                                                'agricultural-areas' => 'Agriculture areas',
                                                'farming-areas'  => 'Farming areas'
                                            ])
                                        ,

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),


                                Radio::make('reference_seismic_risk')
                                    ->options([
                                        'referenced' => 'referenced',
                                        'not-reference' => 'without reference',
                                    ])
                                    ->reactive(),


                                Repeater::make('attitude_individual')
                                    ->label('What is the individual affect/attitude/strategy towards the seismic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options(self::$risks)
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add Character'),


                                Repeater::make('attitude_group')
                                    ->label('What is the collective affect/attitude/strategy towards seismic risk?')
                                    ->schema([
                                        Select::make('group')
                                            ->options([
                                                'humans' => 'Humans',
                                                'aliens' => 'Aliens',
                                                'white_people' => 'White people',
                                                'black_people' => 'Black people',
                                                'indigenous_people' => 'Indigenous people',
                                                'old_people' => 'Old People',
                                                'elders' => 'Elders',
                                                'adults' => 'Adults',
                                                'young_people' => 'Young People',
                                                'men' => 'Men',
                                                'women' => 'Women',
                                                'boys' => 'Boys',
                                                'girls' => 'Girls',
                                                'children' => 'Children',
                                                'nobles' => 'Nobles',
                                                'aristocrats' => 'Aristocrats',
                                                'middle_class_people' => 'Middle-class people',
                                                'working_class_people' => 'Working class people',
                                                'officers' => 'The officers',
                                                'army' => 'The army',
                                                'civil_defense' => 'The civil defense',
                                                'masters' => 'Masters',
                                                'servants' => 'Servants',
                                                'crowd' => 'The crowd',
                                                'population' => 'The population',
                                                'slaves' => 'Slaves',
                                                'politicians' => 'Politicians',
                                                'philosophers' => 'Philosophers',
                                                'scholars' => 'Scholars',
                                                'educated_people' => 'Educated people',
                                                'uneducated_people' => 'Uneducated people',
                                                'business_people' => 'Business people',
                                                'common_people' => 'Common people',
                                                'wealthy_people' => 'Wealthy people',
                                                'poor_people' => 'Poor people',
                                                'religious_people' => 'Religious people',
                                                'atheists' => 'Atheists',
                                                'believers' => 'Believers',
                                                'pagan_priests' => 'Pagan Priests',
                                                'christian_priests' => 'Christian Priests',
                                                'travellers' => 'Travellers',
                                                'settlers' => 'Settlers',
                                                'colonists' => 'Colonists',
                                                'adventurers' => 'Adventurers',
                                                'explorers' => 'Explorers',
                                                'colonisers' => 'Colonisers',
                                                'colonised_people' => 'Colonised people',
                                                'scientists' => 'Scientists',
                                                'nonhuman_beings' => 'Nonhuman beings',
                                                'nonbinary_people' => 'Nonbinary people',
                                                'patricians' => 'Patricians',
                                                'plebeians' => 'Plebeians',
                                                'eccentric' => 'Eccentric People',
                                                'magician' => 'People with magical power',
                                                'erudite' => 'Erudite people',

                                                'nonhuman-beings' => 'Nonhuman beings',
                                                'animals' => 'Animals',
                                                'volcanologists' => 'Volcanologists',
                                                'geologists' => 'Geologists',
                                                'journalists' => 'Journalists',
                                                'the-media' => 'The media',
                                                'civil-defense' => 'Civil defense',
                                                'rescuers' => 'Rescuers',
                                                'businesspeople' => 'Businesspeople',
                                                'tourists' => 'Tourists',
                                            ]),

                                        Select::make('attitude')
                                            ->options(self::$risks)
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),


                              

                                Repeater::make('ecological_impact')
                                    ->label('Ecological impact of the earthquake')
                                    ->schema([
                                        Select::make('impact')
                                            ->options([
                                                // 'changes_of_volcano_shape' => 'Changes of the volcano’s shape',
                                                'physical_landscape_changes' => 'Physical landscape changes',
                                                'destruction_of_plants' => 'Destruction of plants',
                                                'destruction_of_animal_species' => 'Destruction of animal species',
                                                'atmospheric_changes' => 'Atmospheric changes',
                                                'soil_changes' => 'Soil changes',
                                                'soil_degradation' => 'Soil degradation',
                                                'pollution' => 'Pollution',
                                                'sea_pollution' => 'Sea pollution',
                                                // 'earthquake' => 'Earthquake',
                                                'tsunami' => 'Tsunami',
                                                'chemical_waste' => 'Chemical Waste',
                                                'nuclear_waste' => 'Nuclear Waste',
                                                'other' => 'Other'
                                            ])
                                        ,

                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Repeater::make('social_impact')
                                    ->label('Social impact of the earthquake')
                                    ->schema([
                                        Select::make('impact')
                                            ->options([
                                                'deaths' => 'Deaths',
                                                'injuries' => 'Injuries',
                                                'destruction_of_goods' => 'Destruction of goods/commodities',
                                                'resource_depletion' => 'Resource depletion',
                                                'destruction_of_dwellings' => 'Destruction of dwellings',
                                                'destruction_of_public_buildings' => 'Destruction of public buildings',
                                                'destruction_of_facilities' => 'Destruction of facilities',
                                                'destruction_of_cultural_heritage' => 'Destruction of cultural heritage (materials and sites)',
                                                'social_disruption' => 'Social disruption',
                                                'trauma' => 'Trauma',
                                                'poverty' => 'Poverty',
                                                'harvest' => 'Harvest',
                                                'diseases' => 'Diseases',
                                                'depopulation' => 'Depopulation',
                                                'repopulation' => 'Repopulation',
                                                'relocation' => 'Relocation',
                                                'forced_relocation' => 'Forced Relocation',
                                                 'war' => 'War',
                                                'conflict' => 'Conflict',
                                                'recovery' => 'Recovery'
                                            ])
                                        ,

                                        // TextInput::make('comment')
                                        //     ->label('Comment')
                                        //     ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),


                                Repeater::make('individual_reaction')
                                    ->label('Individual reaction/affects to the event')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('reactions')
                                            ->options(self::$events)
                                            ->multiple()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add Reaction'),



                                Repeater::make('collective_affects_general')
                                    ->label('Collective affects/strategies to the event')
                                    ->schema([
                                        Select::make('group')
                                            ->options([
                                                'humans' => 'Humans',
                                                'aliens' => 'Aliens',
                                                'white_people' => 'White people',
                                                'black_people' => 'Black people',
                                                'indigenous_people' => 'Indigenous people',
                                                'old_people' => 'Old People',
                                                'elders' => 'Elders',
                                                'adults' => 'Adults',
                                                'young_people' => 'Young People',
                                                'men' => 'Men',
                                                'women' => 'Women',
                                                'boys' => 'Boys',
                                                'girls' => 'Girls',
                                                'children' => 'Children',
                                                'nobles' => 'Nobles',
                                                'aristocrats' => 'Aristocrats',
                                                'middle_class_people' => 'Middle-class people',
                                                'working_class_people' => 'Working class people',
                                                'officers' => 'The officers',
                                                'army' => 'The army',
                                                'civil_defense' => 'The civil defense',
                                                'masters' => 'Masters',
                                                'servants' => 'Servants',
                                                'crowd' => 'The crowd',
                                                'population' => 'The population',
                                                'slaves' => 'Slaves',
                                                'politicians' => 'Politicians',
                                                'philosophers' => 'Philosophers',
                                                'scholars' => 'Scholars',
                                                'educated_people' => 'Educated people',
                                                'uneducated_people' => 'Uneducated people',
                                                'business_people' => 'Business people',
                                                'common_people' => 'Common people',
                                                'wealthy_people' => 'Wealthy people',
                                                'poor_people' => 'Poor people',
                                                'religious_people' => 'Religious people',
                                                'atheists' => 'Atheists',
                                                'believers' => 'Believers',
                                                'pagan_priests' => 'Pagan Priests',
                                                'christian_priests' => 'Christian Priests',
                                                'travellers' => 'Travellers',
                                                'settlers' => 'Settlers',
                                                'colonists' => 'Colonists',
                                                'adventurers' => 'Adventurers',
                                                'explorers' => 'Explorers',
                                                'colonisers' => 'Colonisers',
                                                'colonised_people' => 'Colonised people',
                                                'scientists' => 'Scientists',
                                                'eccentric' => 'Eccentric People',
                                                'magician' => 'People with magical power',
                                                'erudite' => 'Erudite people',
                                                'patricians' => 'Patricians',
                                                'plebeians' => 'Plebeians',

                                                'nonhuman-beings' => 'Nonhuman beings',
                                                'animals' => 'Animals',
                                                'volcanologists' => 'Volcanologists',
                                                'geologists' => 'Geologists',
                                                'journalists' => 'Journalists',
                                                'the-media' => 'The media',
                                                'civil-defense' => 'Civil defense',
                                                'rescuers' => 'Rescuers',
                                                'businesspeople' => 'Businesspeople',
                                                'tourists' => 'Tourists',

                                            ]),

                                        Select::make('attitude')
                                            ->options(self::$events)
                                            ->multiple()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add group'),


                                Select::make('phase_emphisized')
                                    ->label('Which phase of the disaster is emphasized?')
                                    ->options(
                                        [
                                            'pre_disaster' => 'Pre-disaster (causes / context)',
                                            'disaster' => 'Disaster (phenomenal and social dynamics)',
                                            'post_disaster' => 'Post-disaster (consequences)',
                                        ]
                                    )->multiple(),

                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'earthquake' && $get('real_event') === 'literary'),
                    ])
                    ->createItemButtonLabel('Add Geological Entity'),
                ])->columns(1),

                Fieldset::make('Linguistic')

                    ->schema([
                        Repeater::make('keywords')
                            ->schema([
                                TextInput::make('keyword')
                                    ->label('Add 10/15 keywords')
                                    ->placeholder('Write a new keyword')
                                    ->maxLength(255),
                            ])
                            ->createItemButtonLabel('Add Keyword'),

                        Repeater::make(name: 'metaphors')
                            ->schema([
                                TextInput::make('metaphor')
                                    ->label('Add 10/15 metaphors')
                                    ->placeholder('Write a new metaphor')
                                    ->maxLength(255),
                            ])
                            ->createItemButtonLabel('Add Metaphor'),

                        Repeater::make(name: 'personification')
                            ->schema([
                                TextInput::make('personification')
                                    ->label('Add 10/15 personifications')
                                    ->placeholder('Write a new personification')
                                    ->maxLength(255),
                            ])
                            ->createItemButtonLabel('Add Personification'),

                        Repeater::make(name: 'similes')
                            ->schema([
                                TextInput::make('similes')
                                    ->label('Add 10/15 similes')
                                    ->placeholder('Write a new similes')
                                    ->maxLength(255),
                            ])
                            ->createItemButtonLabel('Add Similes'),


                        RichEditor::make('substantives')
                            ->label('Significant words and phrases related to the entity/phenomenon'),

                        RichEditor::make('verbs_agency')
                            ->label('Significant words and phrases related to the characters’ agency'),

               
                        Select::make('punctuation')
                        ->multiple()
                        ->options([
                            'uncummon_punctuation'=>'Uncommon punctuation marks (add manually)',
                            'lack_punctuation'=>'Lack of punctuation',
                            'multiple_colons'=>'Multiple Colons',
                            'multiple_semicolons'=>'Multiple Semicolons',
                            'multiple_commas'=>'Multiple commas',
                            'multiple_stops'=>'Multiple full stops',
                            'multiple_exl'=>'Multiple exclamation marks',
                            'high_frequency_punctuation_marks'=>'high frequency of some particular punctuation marks',
                            'ellipsis'=>'Ellipsis',
                            'hypens'=>'Hyphens',
                            'dashes'=>'Dashes',
                            'no_peculiarities' => 'No Peculiarities'
                        ]),

                        Select::make('syntax')
                        ->multiple()
                        ->options([
                            'parataxis' => 'Parataxis',
                            'hypotaxis' => 'Hypotaxis',
                            'simple_sentences' => 'Simple sentences',
                            'complex_verbal_phrases' => 'Complex verb phrases',
                            'complex_noun_phrases' => 'Complex noun phrases',
                            'unconventional_position' => 'Unconventional position of phrases in sentence',
                            'high_frequency_connectives' => 'High frequency of textual connectives (coordinating conjunctions, adverbs)',
                            'high_frequency_spoken_language' => 'High frequency of phenomena of the spoken language'
                        ]),
                        

                        Select::make('morphological_peculiarities')
                        ->multiple()
                        ->options([
                            'preference_for_nouns_adjectives' => 'Preference for nouns and adjectives',
                            'preference_for_verbs_adverbs' => 'Preference for verbs and adverbs',
                            'high_frequency_passive_forms' => 'High frequency of passive forms',
                            'high_frequency_abstract_neutral_indefinite' => 'High frequency of abstracts, neutral, indefinite forms',
                            'high_frequency_spoken_language' => 'High frequency of phenomena of the spoken language'
                        ]),
                        


                        Select::make('phonteics_prosody')
                        ->label('Phonetics and prosody')
                        ->multiple()
                        ->options([
                            'sound_related_word_choice' => 'Sound-related word choice (onomatopoeia, rhyme, alliteration)',
                            'relevance_of_word_accent' => 'Relevance of word accent',
                            'relevance_of_language_rhythm' => 'Relevance of language rhythm'
                        ]),
                        
                        

                    ]),

                Fieldset::make('SYMBOLIC/FIGURATIVE')
                    ->schema([
                      
                        Select::make('symbols')
                            ->label('Motifs, Topoi, Mythologemes')
                            ->multiple()
                            ->helperText('related to the entity/phenomenon and to individuals / social groups / societies represented in the literary work')
                            ->options([
                                'locus_horridus' => 'Locus horridus',
                                'locus_amoenus' => 'Locus amoenus',
                                'hell' => 'Hell',
                                'hades' => 'Hades',
                                'apocalypse' => 'Apocalypse',
                                'cruel_nature' => 'Cruel Nature',
                                'deified_nature' => 'Deified Nature',
                                'deities' => 'Deities',
                                'gods' => 'Gods',
                                'nemesis' => 'Nemesis',
                                'fire' => 'Fire',
                                'fireworks' => 'Fireworks',
                                'thunder' => 'Thunder',
                                'death' => 'Death',
                                'ruins' => 'Ruins',
                                'war' => 'War',
                                'hyperdisaster' => 'Hyperdisaster',
                                'nature_machine' => 'Nature-machine',
                                'ideal_community' => 'Ideal community',
                                'civilisation' => 'Civilisation',
                                'technocracy' => 'Technocracy',
                                'panicked_mob' => 'Panicked mob',
                                'colonisers' => 'Colonisers',
                                'colonised_people' => 'Colonised people',
                                'miracles' => 'Miracles',
                                'violation_of_laws_of_nature' => 'Violation of the laws of Nature',
                                'superstition' => 'Superstition',
                                'prophecy' => 'Prophecy',
                                'violation_of_taboos' => 'Violation of taboos',

                                'corrupted_civilisation' => 'Corrupted civilisation',
                                'hubris' => 'Hubris',
                                'the_downfall_of_society' => 'The downfall of society',
                                'the_end_of_the_world' => 'The end of the world',
                                'evil' => 'Evil',
                                'mythical_creatures' => 'Mythical creatures',
                                'magics' => 'Magics',
                                'curse' => 'Curse',
                                'supernatural' => 'Supernatural',

                            ]),
                            
                    ])->columns(1),

                Fieldset::make('CONCEPTUAL')
                    ->schema([
                        RichEditor::make('interpretation')
                            ->helperText('NOTA IMPORTANTE: Questo nodo viene visualizzato come una sezione espressa in maniera discorsiva; qui si metteranno in relazione i dati raccolti precedentemente e la loro interpretazione, creando collegamenti tra gli eventi, la loro rappresentazione letteraria e la loro risonanza culturale.
-NARRATIVA / TEATRO: considerare dimensione narratologica/drammatica (struttura, tempo, ritmo, narratore, focalizzazione, personaggi, dialoghi, discorso, temi) -POESIA: considerare io lirico, verso, strofa, metro, rima, ritmo, figure retoriche (morfologiche, sintattiche, semantiche, logiche)
- considerare TEMI e AFFECTS (es. trauma, resilienza, paura)'),

                    ])->columns(1),


                    

                Fieldset::make('BIBLIOGRAPHY')
                    ->schema([
                        Repeater::make('bibliography')
                                ->label('Bibliography Source')
                                ->schema([
                                    Select::make('source')
                                        ->options([
                                            'primary_sources' => 'Primary sources',
                                            'secondary_sources' => 'Secondary sources'
                                        ]),
                                        
                                    RichEditor::make('bibliography')
                                        ->label('References (MLA reference style-Bibliography)')
                                        ->helperText('Insert here the references in extended form and in alphabetical order'),

                                ])
                                ->createItemButtonLabel('Add bibliography'),
                    ])->columns(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('author'),
                textcolumn::make('user.name')    
                    ->label('Author Entry')    
                    ->sortable(),

                
            ])
            ->filters([
                
                SelectFilter::make('user')            ->label('User')            ->relationship('user', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTexts::route('/'),
            'create' => Pages\CreateText::route('/create'),
            'edit' => Pages\EditText::route('/{record}/edit'),
        ];
    }
}
