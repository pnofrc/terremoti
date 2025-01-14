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
    protected static ?string $model = Text::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                select::make('user_id')    
                    ->label('Author Entry')    
                    ->options(User::all()->pluck('name', 'id')) 
                    ->searchable() 
                    ->required(),

                TextInput::make('title')->required(),
                
                TextInput::make('author')->required(),
                TextInput::make('publication_year'),
                TextInput::make('publication_place'),
                TextInput::make('editor'),


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
                            'eco-novel' => 'Eco-novel',
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
                        ],
                        'POETRY' => [
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


                Repeater::make('geological_entities')
                    ->label('Geological Entities')
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
                            ->reactive(),


                        Radio::make('real_event')
                            ->options([
                                'real' => 'Real',
                                'fictional' => 'Fictional',
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
                                                'volcano' => 'Volcano',
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
                                                'volcano' => 'Volcano',
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
                                        TextInput::make('impacted')
                                            ->label('Impact areas of the eruption'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates'),
                                    ]),

                                Repeater::make('typology')
                                    ->label('Typology of volcanic eruption')
                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'effusive_eruption_magma' => 'Effusive eruption (magma)',
                                                'explosive_eruption_emission_of_lava' => 'Explosive eruption (Emission of lava)',
                                                'gases' => 'Gases',
                                                'ash_rainfall' => 'Ash rainfall',
                                                'lapilli' => 'Lapilli',
                                                'volcanic_bombs' => 'Volcanic bombs',
                                            ])
                                        ,

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
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),
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
                                                'landscape_changes' => 'Landscape changes',
                                                'destruction_of_plants' => 'Destruction of plants',
                                                'destruction_of_animal_species' => 'Destruction of animal species',
                                                'atmospheric_changes' => 'Atmospheric changes',
                                                'pollution' => 'Pollution',
                                                'chemical_waste' => 'Chemical Waste',
                                                'nuclear_waste' => 'Nuclear Waste',
                                                'other' => 'Other',
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
                                                'destruction_of_goods_commodities' => 'Destruction of goods/commodities',
                                                'destruction_of_facilities' => 'Destruction of facilities',
                                                'social_disruption' => 'Social Disruption',
                                                'trauma' => 'Trauma',
                                                'poverty' => 'Poverty',
                                                'harvest' => 'Harvest',
                                                'diseases' => 'Diseases',
                                                'depopulation_relocation' => 'Depopulation Relocation',
                                                'forced_relocation' => 'Forced Relocation',
                                                'other' => 'other'
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'earthquake' && $get('real_event') === 'real'),



                        // FICTIONAL vulcano



                        Fieldset::make('fictional_volcano')
                            ->label('Fictional Volcano Event')
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
                                                'volcano' => 'Volcano',
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
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),

                                Radio::make('reference_volcanic_risk')
                                    ->options([
                                        'referenced' => 'referenced',
                                        'not-reference' => 'without reference',
                                    ])
                                    ->reactive(),

                                Repeater::make('attitude_individual')
                                    ->label('What is the individual attitude/strategy towards volcanic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add Character'),



                                Repeater::make('affects_individual')
                                    ->label('What are the individual affects towards volcanic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add Character'),




                                Repeater::make('attitude_collective')
                                    ->label('What is the collective attitude/strategy towards volcanic risk?')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),


                                Repeater::make('affects_collective')
                                    ->label('What are the collective affects towards volcanic risk?')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),

                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'volcano' && $get('real_event') === 'fictional'),




                        // FICTIONAL -- eruption

                        Fieldset::make('fictional_eruption')
                            ->label('Fictional Eruption Event')
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
                                                'volcano' => 'Volcano',
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
                                        TextInput::make('impacted')
                                            ->label('Impact areas of the eruption'),
                                        TextInput::make('latlng')
                                            ->label('Copy Paste coordinates'),
                                    ]),

                                Repeater::make('typology')
                                    ->label(' Typology of volcanic eruption')
                                    ->schema([
                                        Select::make('typology')
                                            ->options([
                                                'effusive_eruption_magma' => 'Effusive eruption (magma)',
                                                'explosive_eruption_emission_of_lava' => 'Explosive eruption (Emission of lava)',
                                                'gases' => 'Gases',
                                                'ash_rainfall' => 'Ash rainfall',
                                                'lapilli' => 'Lapilli',
                                                'volcanic_bombs' => 'Volcanic bombs',
                                            ])
                                        ,

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
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),


                                Radio::make('reference_volcanic_risk')
                                    ->options([
                                        'referenced' => 'referenced',
                                        'not-reference' => 'without reference',
                                    ])
                                    ->reactive(),

                                Repeater::make('attitude_individual')
                                    ->label('What is the individual attitude/strategy towards volcanic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add Character'),



                                Repeater::make('affects_individual')
                                    ->label('What are the individual affects towards volcanic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')

                                    ->createItemButtonLabel('Add Character'),

                                Repeater::make('attitude_collective')
                                    ->label('What is the collective attitude/strategy towards volcanic risk?')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_volcanic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),


                                Repeater::make('affects_collective')
                                    ->label('What are the collective affects towards volcanic risk?')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
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
                                                'changes_of_the_volcanos_shape' => "Changes of the volcano's shape",
                                                'landscape_changes' => 'Landscape changes',
                                                'destruction_of_plants' => 'Destruction of plants',
                                                'destruction_of_animal_species' => 'Destruction of animal species',
                                                'atmospheric_changes' => 'Atmospheric changes',
                                                'other' => 'Other',
                                            ])
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
                                                'destruction_of_goods_commodities' => 'Destruction of goods/commodities',
                                                'destruction_of_facilities' => 'Destruction of facilities',
                                                'social_disruption' => 'Social Disruption',
                                                'trauma' => 'Trauma',
                                                'poverty' => 'Poverty',
                                                'harvest' => 'Harvest',
                                                'diseases' => 'Diseases',
                                                'depopulation_relocation' => 'Depopulation Relocation',
                                                'forced_relocation' => 'Forced Relocation',
                                                'other' => 'other'
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),



                                Repeater::make('individual_reaction')
                                    ->label('Individual reaction to the event')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('reactions')
                                            ->options([
                                                'escape' => 'Escape',
                                                'immobility_paralysis' => 'Immobility Paralysis',
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add Reaction'),



                                Repeater::make('individual_affects_general')
                                    ->label('Individual affects')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('reactions')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add Reaction'),


                                Repeater::make('collective_reaction')
                                    ->label(' Collective reaction to the event')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
                                                'escape' => 'Escape',
                                                'immobility_paralysis' => 'Immobility Paralysis',
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add group'),


                                Repeater::make('collective_affects_general')
                                    ->label('Collective affects to the event')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
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
                                    ),

                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'eruption' && $get('real_event') === 'fictional'),





                        // FICTIONAL SEISMIC
                        Fieldset::make('fictional_seismic')
                            ->label('Fictional Seismic zone')
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
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
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
                                    ->label('What is the individual attitude/strategy towards seismic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add Character'),



                                Repeater::make('affects_individual')
                                    ->label('What are the individual affects towards seismic  risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')

                                    ->createItemButtonLabel('Add Character'),

                                Repeater::make('attitude_group')
                                    ->label('What is the collective attitude/strategy towards seismic risk?')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),


                                Repeater::make('affects_group')
                                    ->label('What are the collective affects towards seismic risk?')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),


                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'seismic_zone' && $get('real_event') === 'fictional'),



                        // FICTIONAL earthquake


                        Fieldset::make('fictional_earthquake')
                            ->label('Fictional Earthquake Event')
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

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),



                                Fieldset::make('place')
                                    ->label('Place of the earthquake')
                                    ->schema([
                                        TextInput::make('seismic_fault'),
                                        TextInput::make('country'),
                                        TextInput::make('region'),
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
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),

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
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add degree'),


                                Radio::make('reference_seismic_risk')
                                    ->options([
                                        'referenced' => 'referenced',
                                        'not-reference' => 'without reference',
                                    ])
                                    ->reactive(),


                                Repeater::make('attitude_individual')
                                    ->label('What is the individual attitude/strategy towards seismic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add Character'),



                                Repeater::make('affects_individual')
                                    ->label('What are the individual affects towards seismic risk?')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')

                                    ->createItemButtonLabel('Add Character'),

                                Repeater::make('attitude_group')
                                    ->label('What is the collective attitude/strategy towards seismic risk?')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->visible(fn(Get $get) => $get('reference_seismic_risk') === 'referenced')
                                    ->createItemButtonLabel('Add group'),


                                Repeater::make('affects_group')
                                    ->label('What are the collective affects towards seismic risk?')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
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
                                                'changes_of_the_volcanos_shape' => "Changes of the volcano's shape",
                                                'landscape_changes' => 'Landscape changes',
                                                'destruction_of_plants' => 'Destruction of plants',
                                                'destruction_of_animal_species' => 'Destruction of animal species',
                                                'atmospheric_changes' => 'Atmospheric changes',
                                                'other' => 'Other',
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),

                                Repeater::make('social_impact')
                                    ->label('Social impact of the earthquake')
                                    ->schema([
                                        Select::make('impact')
                                            ->options([
                                                'deaths' => 'Deaths',
                                                'destruction_of_goods_commodities' => 'Destruction of goods/commodities',
                                                'destruction_of_facilities' => 'Destruction of facilities',
                                                'social_disruption' => 'Social Disruption',
                                                'trauma' => 'Trauma',
                                                'poverty' => 'Poverty',
                                                'harvest' => 'Harvest',
                                                'diseases' => 'Diseases',
                                                'depopulation_relocation' => 'Depopulation Relocation',
                                                'forced_relocation' => 'Forced Relocation',
                                                'other' => 'other'
                                            ])
                                        ,

                                        TextInput::make('comment')
                                            ->label('Comment')
                                            ->placeholder('when quotations from historical sources are reported, use MLA quotation style (parentheses)')
                                    ])
                                    ->createItemButtonLabel('Add typology'),


                                Repeater::make('individual_reaction')
                                    ->label('Individual reaction to the event')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('reactions')
                                            ->options([
                                                'escape' => 'Escape',
                                                'immobility_paralysis' => 'Immobility Paralysis',
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add Reaction'),



                                Repeater::make('individual_affects_general')
                                    ->label('Individual affects')
                                    ->schema([
                                        TextInput::make('name'),

                                        TextInput::make('gender'),

                                        TextInput::make('age'),

                                        TextInput::make('social_class'),

                                        TextInput::make('native_place'),

                                        TextInput::make('nationality'),

                                        Select::make('reactions')
                                            ->options([
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add Reaction'),


                                Repeater::make('collective_reaction')
                                    ->label(' Collective reaction to the event')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
                                                'escape' => 'Escape',
                                                'immobility_paralysis' => 'Immobility Paralysis',
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
                                            ])
                                            ->multiple()
                                        ,
                                    ])
                                    ->createItemButtonLabel('Add group'),


                                Repeater::make('collective_affects_general')
                                    ->label('Collective affects to the event')
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
                                            ]),

                                        Select::make('attitude')
                                            ->options([
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
                                            ])
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
                                    ),

                            ])
                            ->visible(fn(Get $get) => $get('geological_entity_kind') === 'earthquake' && $get('real_event') === 'fictional'),
                    ])
                    ->createItemButtonLabel('Add Geological Entity'),

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

                        Repeater::make(name: 'personifications')
                            ->schema([
                                TextInput::make('personification')
                                    ->label('Add 10/15 personifications')
                                    ->placeholder('Write a new personification')
                                    ->maxLength(255),
                            ])
                            ->createItemButtonLabel('Add Personification'),

                        Repeater::make(name: 'simies')
                            ->schema([
                                TextInput::make('similes')
                                    ->label('Add 10/15 similes')
                                    ->placeholder('Write a new similes')
                                    ->maxLength(255),
                            ])
                            ->createItemButtonLabel('Add Similes'),


                        RichEditor::make('substantives')
                            ->label('Substantives related to the entity / phenomenon')
                            ->helperText('Hypernonyms or Hyponyms; Technical vs non-technical vocabulary; Foreign words; Loan Words, Calques; Neologisms; Archaisms'),

                        RichEditor::make('verbs_agency')
                            ->label('Verbs related to the characters’ agency')
                            ->helperText('predominance of active or passive forms'),

                        RichEditor::make('punctuation')
                            ->helperText('Uncommon punctuation marks (add manually); Lack of punctuation; Multiple Colons; Multiple Semicolons; Multiple commas, Multiple full stops, Multiple exclamation marks, Ellipsis; Hyphens, Dashes'),

                        TextInput::make('syntax')
                            ->helperText('Linear syntax; Broken syntax'),

                        RichEditor::make('morphological_peculiarities'),

                        RichEditor::make('uncommon_typography')

                    ]),

                Fieldset::make('SYMBOLIC/FIGURATIVE')
                    ->schema([
                        RichEditor::make('entity_symbols')
                            ->label('motifs, topoi, mythologemes (related to the entity/phenomenon)')
                            ->helperText('Locus horridus; Locus amoenus; Hell; Hades; Apocalypse; Cruel Nature; Deified Nature; Pagan Gods; Indigenous deities; Biblical God; Nemesis; Fire; Fireworks; Thunder; Death; Ruins; Hyperdisaster; Nature- machine'),

                        RichEditor::make('social_symbols')
                            ->label('motifs, topoi, mythologemes
(related to individuals / social groups / societies represented in the literary work)')
                            ->helperText('Ideal community; Civilisation; Technocracy; Panicked mob; colonisers; colonised people; Miracles; Violation of the laws of Nature'),
                    ]),

                Fieldset::make('CONCEPTUAL')
                    ->schema([
                        RichEditor::make('interpretation')
                            ->helperText('NOTA IMPORTANTE: Questo nodo viene visualizzato come una sezione espressa in maniera discorsiva; qui si metteranno in relazione i dati raccolti precedentemente e la loro interpretazione, creando collegamenti tra gli eventi, la loro rappresentazione letteraria e la loro risonanza culturale.
-NARRATIVA / TEATRO: considerare dimensione narratologica/drammatica (struttura, tempo, ritmo, narratore, focalizzazione, personaggi, dialoghi, discorso, temi) -POESIA: considerare io lirico, verso, strofa, metro, rima, ritmo, figure retoriche (morfologiche, sintattiche, semantiche, logiche)
- considerare TEMI e AFFECTS (es. trauma, resilienza, paura)'),

                    ]),


                Fieldset::make('BIBLIOGRAPHY')
                    ->schema([
                        RichEditor::make('bibliography')
                            ->label('References (MLA reference style-Bibliography)')

                            ->helperText('Insert here the references in extended form and in alphabetical order'),

                    ]),

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
