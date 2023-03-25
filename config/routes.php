<?php

/**
 * @OA\Info(
 *   title="OpenAPI Docs for VampyreBytes's Fifth Edition Vampire: the Masquerade API. -- Compatible with V5",
 *   description="This product was created under the Dark Pack license.",
 *   version="1.2.1",
 *   @OA\Contact(
 *     name="Vampyre Bytes",
 *     email="admin@vampyrebytes.com"
 *   )
 * )
 *
 * @OA\Server(
 *     url="https://v5api.vampyrebytes.com"
 * )
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

use VampireAPI\Generate\Gender;
use VampireAPI\Generate\Name;
use VampireAPI\Generate\NPC;
use VampireAPI\Generate\Occupation;
use VampireAPI\Generate\PhysicalDescription;
use VampireAPI\Generate\Resonance;
use VampireAPI\Generate\Vampires\TabulaRasa\Age;
use VampireAPI\Generate\Vampires\TabulaRasa\Attribute;
use VampireAPI\Generate\Vampires\TabulaRasa\Build;
use VampireAPI\Generate\Vampires\TabulaRasa\Conviction;
use VampireAPI\Generate\Vampires\TabulaRasa\Disciplines;
use VampireAPI\Generate\Vampires\TabulaRasa\Generation;
use VampireAPI\Generate\Vampires\TabulaRasa\Lesson;
use VampireAPI\Generate\Vampires\TabulaRasa\Memory;
use VampireAPI\Generate\Vampires\TabulaRasa\Predator;
use VampireAPI\Generate\Vampires\TabulaRasa\Sect;
use VampireAPI\Generate\Vampires\TabulaRasa\Clan;
use VampireAPI\Generate\Vampires\TabulaRasa\Skill;
use VampireAPI\Generate\Voice;

return function (App $app) {
    $app->get('/', function (
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write(json_encode(["Refer to the documentation at /openapi"], JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    });

    /**
     * @OA\Get(
     *     path="/openapi.json",
     *     summary="Returns the OpenAPI 3.0 documentation in JSON format.",
     *     tags={"Documentation"},
     *     @OA\Response(
     *         response="200",
     *         description="The OpenAPI 3.0 documentation in JSON format. This documentation provides details on all
     * available API endpoints, including request parameters, response data, and response codes. The file is generated
     * dynamically based on the API documentation provided in the code base.",
     *         @OA\JsonContent(
     *             type="object"
     *         )
     *     )
     * )
     */
    $app->get('/openapi.json', function ($request, $response, $args) {
        $swagger = OpenApi\Generator::scan([__DIR__]);
        $response->getBody()->write(json_encode($swagger, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    });
    $app->get('/openapi', function ($request, $response, $args) {
        $swagger = OpenApi\Generator::scan([__DIR__]);
        $response->getBody()->write(json_encode($swagger, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    });
    /**
     * @OA\Get(
     *     path="/openapi.yaml",
     *     summary="Returns the OpenAPI 3.0 documentation in YAML format.",
     *     tags={"Documentation"},
     *     @OA\Response(
     *         response="200",
     *         description="The OpenAPI 3.0 documentation in YAML format. This documentation provides details on all
     * available API endpoints, including request parameters, response data, and response codes. The file is generated
     * dynamically based on the API documentation provided in the code base.",
     *         @OA\MediaType(
     *             mediaType="application/x-yaml",
     *             @OA\Schema(
     *                 type="string"
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/openapi.yaml', function ($request, $response, $args) {
        $swagger = OpenApi\Generator::scan([__DIR__]);
        $response->getBody()->write($swagger->toYaml());
        return $response->withHeader('Content-Type', 'application/x-yaml');
    });

//Individual Generators
    /**
     * @OA\Get(
     *     path="/name/{type}/{gender}",
     *     summary="Generates a 'real world' name.",
     *     tags={"Generators"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description=">
     Name Part:
     * `first` - Given Name
     * `last` - Surname only (gender is ignored.)
     * `full` - Full Name (Given name + Surname only)
     * `null` - Full Name, possibly also including Titles and Suffixes",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default=null,
     *             nullable=true,
     *             enum={"full", "first", "last", null}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="gender",
     *         in="path",
     *         description=">
    Gender:
     * `male` - Names typically belonging to males as well as a few neutral that are common among AMAB persons. (This works with 'first', 'full', and null.)
     * `female` - Names typically belonging to females as well as a few neutral that are common among AFAB persons. (This works with 'first', 'full', and null.)
     * `neutral` - Names frequently chosen for being gender-neutral. (Please note that this only works with 'full' or 'first'. Does not work with null.)
     * `null` - Currently, only Male and Female names are available at this time. This does include several names that might be considered gender neutral.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="any",
     *             enum={"male", "female", "neutral", "any"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="A randomly generated name",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="John Doe")
     *         )
     *     )
     * )
     */
    $app->get('/name/{type}/{gender}', Name::class);

    /**
     * @OA\Get(
     *     path="/gender",
     *     summary="Generates a random gender",
     *     tags={"Generators"},
     *     @OA\Response(
     *         response="200",
     *         description="Random gender",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="gender",
     *                 type="string",
     *                 enum={
     *                     "Male",
     *                     "Female",
     *                     "Non-Binary",
     *                     "Genderqueer",
     *                     "Agender",
     *                     "Bigender",
     *                     "Androgynous",
     *                     "Intersex",
     *                     "Genderfluid",
     *                     "Neutrois",
     *                     "Pangender",
     *                     "Two-Spirit",
     *                     "Transgender"
     *                 }
     *              )
     *         )
     *     )
     * )
     */
    $app->get('/gender', Gender::class);

    /**
     * @OA\Get(
     *     path="/voice/{laban}",
     *     summary="Generates a Vocal pattern, based on, but not limited to, Laban Style for voice acting.",
     *     tags={"Generators"},
     *     @OA\Parameter(
     *         name="laban",
     *         in="path",
     *         description="Indicates whether to generate a voice pattern based on Laban (true) or a comprehensive set (false).",
     *         required=true,
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Possible Voice Variations.",
     *         @OA\JsonContent(
     *             @OA\Property(property="base_voice", type="string", example="Thrusting - Heavy, Indirect, Sudden", description="A string containing the base voice pattern, consisting of 3 factors and/or a Laban style."),
     *             @OA\Property(property="add_ons", type="object",
     *                 @OA\Property(property="Air Source", type="string", example="Nasal"),
     *                 @OA\Property(property="Air Variant", type="string", example="Dry"),
     *                 @OA\Property(property="Age Variant", type="string", example="Child"),
     *                 @OA\Property(property="Body Size", type="string", example="Large"),
     *                 @OA\Property(property="Tempo", type="string", example="Slow"),
     *                 @OA\Property(property="Tone", type="string", example="Friendly"),
     *                 @OA\Property(property="Impairments", type="string", example="Mild")
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/voice[/{laban}]', Voice::class);

    /**
     * @OA\Get(
     *     path="/physical_description/{gender}",
     *     summary="Generates a physical description",
     *     tags={"Generators"},
     *     @OA\Parameter(
     *         name="gender",
     *         in="path",
     *         description="The gender for which to generate the physical description. (Currently irrelevant.)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description=">
Physical description. The build descriptor should be roughly accurate for the calculated BMI.
* NB: Some of these descriptors may have different connotations and are not necessarily accurate or appropriate in all contexts.
It's important to use language thoughtfully and respectfully, and to avoid stigmatizing or derogatory terms.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="age", type="string", example="27 years old"),
     *             @OA\Property(property="height", type="string", example="177 cm / 70 inches"),
     *             @OA\Property(property="weight", type="string", example="68 kg / 150 lbs"),
     *             @OA\Property(property="bmi", type="number", format="float", example=19.31),
     *             @OA\Property(property="build", type="string", example="athletic"),
     *             @OA\Property(property="skinTone", type="string", example="fair"),
     *             @OA\Property(property="hairColor", type="string", example="brown"),
     *             @OA\Property(property="eyeColor", type="string", example="brown"),
     *             @OA\Property(property="facialFeatures", type="string", example="scar on left cheek"),
     *             @OA\Property(property="noticeableMarkings", type="string", example="tattoo on right arm"),
     *             @OA\Property(property="clothingStyle", type="string", example="casual")
     *         )
     *     )
     * )
     */
    $app->get('/physical_description[/{gender}]', PhysicalDescription::class);

    /**
     * @OA\Get(
     *     path="/resonance",
     *     summary="Generates a Blood Resonance (from a victim, for example).",
     *     tags={"Generators"},
     *     @OA\Response(
     *         response="200",
     *         description="Generates a random blood resonance.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="resonance",
     *                 type="string",
     *                 example="Choleric",
     *                 enum={"Sanguine", "Choleric", "Melancholic", "Phlegmatic", "Empty"}
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/resonance', Resonance::class);

    /**
     * @OA\Get(
     *     path="/occupation",
     *     summary="Generate a random occupation",
     *     tags={"Generators"},
     *     @OA\Response(
     *         response=200,
     *         description="Returns a JSON object with a random occupation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="occupation",
     *                 type="string",
     *                 description="The generated occupation"
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/occupation', Occupation::class);

//Collections
    /**
     * @OA\Get(
     *     path="/npc",
     *     summary="Generate a single NPC with randomized name, gender, physical descriptions, blood resonance, and voice",
     *     tags={"Collections"},
     *     @OA\Response(
     *         response="200",
     *         description="NPC information",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Alexandra"),
     *             @OA\Property(property="gender", type="string"),
     *             @OA\Property(
     *                 property="physicalDescription",
     *                 type="object",
     *                 @OA\Property(property="height", type="string", example="71 inches"),
     *                 @OA\Property(property="weight", type="string", example="150 pounds"),
     *                 @OA\Property(property="bmi", type="number", format="float", example=26.27),
     *                 @OA\Property(property="build", type="string", example="athletic"),
     *                 @OA\Property(property="skinTone", type="string", example="fair"),
     *                 @OA\Property(property="hairColor", type="string", example="brown"),
     *                 @OA\Property(property="eyeColor", type="string", example="brown")
     *             ),
     *             @OA\Property(
     *                 property="resonance",
     *                 type="string",
     *                 example="Choleric"
     *             ),
     *             @OA\Property(
     *                 property="vocal_tips",
     *                 type="object",
     *                 @OA\Property(
     *                     property="base_voice",
     *                     type="string",
     *                     example="Dabbing - Light, Direct, Sudden",
     *                     description="A string containing the base voice pattern, consisting of 3 factors and/or a Laban style."
     *                 ),
     *                 @OA\Property(property="add_ons", type="object",
     *                     @OA\Property(property="Air Source", type="string", example="Nasal"),
     *                     @OA\Property(property="Air Variant", type="string", example="Dry"),
     *                     @OA\Property(property="Age Variant", type="string", example="Child"),
     *                     @OA\Property(property="Body Size", type="string", example="Large"),
     *                     @OA\Property(property="Tempo", type="string", example="Slow"),
     *                     @OA\Property(property="Tone", type="string", example="Friendly"),
     *                     @OA\Property(property="Impairments", type="string", example="Mild")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/npc', NPC::class);
    /**
     * @OA\Get(
     *     path="/tabula-rasa/character",
     *     summary="Generate a single NPC with randomized name, gender, physical descriptions, blood resonance, and voice",
     *     tags={"Collections", "Tabula Rasa Build"},
     *     @OA\Response(
     *         response="200",
     *         description="PC information",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Alexandra"),
     *             @OA\Property(property="gender", type="string"),
     *             @OA\Property(
     *                 property="physicalDescription",
     *                 type="object",
     *                 @OA\Property(property="height", type="string", example="71 inches"),
     *                 @OA\Property(property="weight", type="string", example="150 pounds"),
     *                 @OA\Property(property="bmi", type="number", format="float", example=26.27),
     *                 @OA\Property(property="build", type="string", example="athletic"),
     *                 @OA\Property(property="skinTone", type="string", example="fair"),
     *                 @OA\Property(property="hairColor", type="string", example="brown"),
     *                 @OA\Property(property="eyeColor", type="string", example="brown")
     *             ),
     *             @OA\Property(
     *                 property="resonance",
     *                 type="string",
     *                 example="Choleric"
     *             ),
     *             @OA\Property(
     *                 property="vocal_tips",
     *                 type="object",
     *                 @OA\Property(
     *                     property="base_voice",
     *                     type="string",
     *                     example="Dabbing - Light, Direct, Sudden",
     *                     description="A string containing the base voice pattern, consisting of 3 factors and/or a Laban style."
     *                 ),
     *                 @OA\Property(property="add_ons", type="object",
     *                     @OA\Property(property="Air Source", type="string", example="Nasal"),
     *                     @OA\Property(property="Air Variant", type="string", example="Dry"),
     *                     @OA\Property(property="Age Variant", type="string", example="Child"),
     *                     @OA\Property(property="Body Size", type="string", example="Large"),
     *                     @OA\Property(property="Tempo", type="string", example="Slow"),
     *                     @OA\Property(property="Tone", type="string", example="Friendly"),
     *                     @OA\Property(property="Impairments", type="string", example="Mild")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    $app->get(pattern: '/tabula-rasa/character', callable: Build::class);

// Tabula Rasa CharGen
    /**
     * @OA\Get(
     *     path="/tabularasa/age/{type}",
     *     summary="Generate a vampire's Birth Year using the Tabula Rasa system.",
     *     tags={"Tabula Rasa - The Blood"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description="Type of age to generate. 'specific' will generate a full date of Embrace, 'year' will give you a year, 'general' will be a range.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="specific",
     *             enum={"specific", "year", "general"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="A randomly generated date of Embrace.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="range",
     *                 type="string",
     *                 example="1940 to 2005",
     *                 description="The Embrace range of the vampire."
     *             ),
     *             @OA\Property(
     *                 property="year",
     *                 type="string",
     *                 example="1985",
     *                 description="The specific year of the vampire's Embrace, if 'type' parameter is set to 'year'."
     *             ),
     *             @OA\Property(
     *                 property="exact_date",
     *                 type="string",
     *                 example="Friday, March 13th, 2020",
     *                 description="The full deathdate (Date of Embrace) of the vampire, if 'type' parameter is set to 'specific'."
     *             )
     *         )
     *     )
     * )
     */
    $app->get(pattern: '/tabularasa/age/{type}', callable: Age::class);
    /**
     * @OA\Get(
     *     path="/tabularasa/generation/{modifier}",
     *     summary="Generate a vampire's Generation using the Tabula Rasa system.",
     *     tags={"Tabula Rasa - The Blood"},
     *     @OA\Parameter(
     *         name="modifier",
     *         in="path",
     *         description="The Age modifier for this vampire, if any. Possible values are: '2006 to now', '1940 to 2005', or '1780 to 1940'.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"2006 to now", "1940 to 2005", "1780 to 1940"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Generates a vampire's Generation based on the Tabula Rasa system.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="generation",
     *                 type="string",
     *                 example="13th",
     *                 description="The vampire's Generation."
     *             )
     *         )
     *     )
     * )
     */
    $app->get(pattern: '/tabularasa/generation[/{modifier}]', callable: Generation::class);
    /**
     * @OA\Get(
     *     path="/tabularasa/sect/{modifier}",
     *     summary="Generate a vampire's Sect using the Tabula Rasa system.",
     *     tags={"Tabula Rasa - The Blood"},
     *     @OA\Parameter(
     *         name="modifier",
     *         in="path",
     *         description="The Age modifier for this vampire, if any. Possible values are: '2006 to now', '1940 to 2005', or '1780 to 1940'.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"2006 to now", "1940 to 2005", "1780 to 1940"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Generates a vampire's Sect based on the Tabula Rasa system.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="sect",
     *                 type="string",
     *                 example="Anarch",
     *                 description="The vampire's Sect."
     *             )
     *         )
     *     )
     * )
     */
    $app->get(pattern: '/tabularasa/sect/{modifier}', callable: Sect::class);
    /**
     * @OA\Get(
     *     path="/tabularasa/clan/{sect}",
     *     summary="Generate a vampire's Clan using the Tabula Rasa system.",
     *     tags={"Tabula Rasa - The Blood"},
     *     @OA\Parameter(
     *         name="sect",
     *         in="path",
     *         description="The vampire's Sect. Possible values are: 'Anarch', 'Camarilla', or 'Other'.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"Anarch", "Camarilla", "Other"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Generates a vampire's Clan based on the Tabula Rasa system.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="clan",
     *                 type="string",
     *                 example="Brujah",
     *                 description="The vampire's Clan."
     *             )
     *         )
     *     )
     * )
     */
    $app->get(pattern: '/tabularasa/clan/{sect}', callable: Clan::class);
// Tabula Rasa Memories and Lessons
    /**
     * @OA\Get(
     *     path="/tabularasa/memory/{memory}",
     *     summary="Generate a random memory based on the selected type",
     *     tags={"Tabula Rasa - Memories & Lessons"},
     *     @OA\Parameter(
     *         name="memory",
     *         in="path",
     *         required=true,
     *         description="The type of memory to generate",
     *         @OA\Schema(
     *             type="string",
     *             enum={
     *                 "what_was_happening",
     *                 "who_was_with_you",
     *                 "what_was_their_motive",
     *                 "where_did_it_happen",
     *                 "how_did_you_feel",
     *                 "how_did_it_end"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="A random memory of the selected type",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="{memory}",
     *                 type="string",
     *                 description="The generated memory"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid memory type provided",
     *         @OA\JsonContent(
     *             example={"error": true, "message": "Invalid memory type provided"}
     *         )
     *     )
     * )
     */
    $app->get(pattern: '/tabularasa/memory/{memory}', callable: Memory::class);

    /**
     * @OA\Get(
     *     path="/tabularasa/lesson/{type}",
     *     summary="Generate a lesson for a mortal or kindred vampire",
     *     tags={"Tabula Rasa - Memories & Lessons"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description="The type of lesson to generate, either 'mortal' or 'kindred'",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"mortal", "kindred"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="lesson",
     *                 type="string",
     *                 description="The generated lesson"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 description="Error message"
     *             )
     *         )
     *     )
     * )
     */
    $app->get(pattern: '/tabularasa/lesson/{type}', callable: Lesson::class);
    /**
     * @OA\Get(
     *     path="/tabularasa/memory",
     *     summary="Generate a random memory by rolling once on each memory table",
     *     tags={"Tabula Rasa - Memories & Lessons", "Collections"},
     *     @OA\Response(
     *         response="200",
     *         description="List of random memories",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="what_was_happening",
     *                 type="string",
     *                 description="The type of activity or event that was happening in the memory."
     *             ),
     *             @OA\Property(
     *                 property="who_was_with_you",
     *                 type="string",
     *                 description="The person or people who were with you in the memory."
     *             ),
     *             @OA\Property(
     *                 property="what_was_their_motive",
     *                 type="string",
     *                 description="The motive of the person or people who were with you in the memory."
     *             ),
     *             @OA\Property(
     *                 property="where_did_it_happen",
     *                 type="string",
     *                 description="The location where the memory took place."
     *             ),
     *             @OA\Property(
     *                 property="how_did_you_feel",
     *                 type="string",
     *                 description="The emotional state you were in during the memory."
     *             ),
     *             @OA\Property(
     *                 property="how_did_it_end",
     *                 type="string",
     *                 description="The outcome or resolution of the memory."
     *             )
     *         )
     *     )
     * )
     */
    $app->get(pattern: '/tabularasa/memory', callable: Memory::class);
    /**
     * @OA\Get(
     *     path="/tabularasa/memory/type/{type}",
     *     summary="Generate a random memory based on the selected type for Mortals or Kindred",
     *     tags={"Tabula Rasa - Memories & Lessons", "Collections"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         required=true,
     *         description="The type of entity for the memory generation",
     *         @OA\Schema(
     *             type="string",
     *             enum={
     *                 "mortal",
     *                 "kindred"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="A random memory of the selected type for the specified entity",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="memory",
     *                 type="string",
     *                 description="The generated memory"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid entity type provided",
     *         @OA\JsonContent(
     *             example={"error": true, "message": "Invalid entity type provided"}
     *         )
     *     )
     * )
     */
    $app->get('/tabularasa/memory/type/{type}', Memory::class);

// Tabula Rasa Attributes.
    /**
     * @OA\Get(
     *     path="/tabularasa/attribute",
     *     summary="Generate a random attribute",
     *     tags={"Tabula Rasa - Inspiration"},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="attribute",
     *                 type="string",
     *                 description="The generated attribute"
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/tabularasa/attribute', Attribute::class);
    /**
     * @OA\Get(
     *     path="/tabularasa/attributes/{type}",
     *     summary="Generate a random attribute",
     *     tags={"Tabula Rasa - Inspiration"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description="The type of attribute to generate (physical, social, or mental)",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"physical", "social", "mental"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="attribute",
     *                 type="string",
     *                 description="The generated attribute"
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/tabularasa/attributes/{type}', Attribute::class);
// Tabula Rasa Skills.
/**
 * @OA\Get(
 *     path="/tabularasa/skill",
 *     summary="Generate a random skill",
 *     tags={"Tabula Rasa - Inspiration"},
 *     @OA\Response(
 *         response="200",
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="skill",
 *                 type="string",
 *                 description="The generated skill"
 *             )
 *         )
 *     )
 * )
 */
    $app->get('/tabularasa/skill', Skill::class);
    /**
     * @OA\Get(
     *     path="/tabularasa/skills/{type}",
     *     summary="Generate a random skill",
     *     tags={"Tabula Rasa - Inspiration"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description="The type of attribute to generate (physical, social, or mental)",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"physical", "social", "mental"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="attribute",
     *                 type="string",
     *                 description="The generated attribute"
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/tabularasa/skills/{type}', Skill::class);
// Tabula Rasa Convictions.
    /**
     * @OA\Get(
     *     path="/tabularasa/conviction",
     *     summary="Generate a random conviction",
     *     tags={"Tabula Rasa - Inspiration"},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="ethic",
     *                 type="string",
     *                 description="Base Ethics of the Conviction"
     *             ),
     *             @OA\Property(
     *                 property="frequency",
     *                 type="string",
     *                 description="Frequency of the Conviction"
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/tabularasa/conviction', Conviction::class);
// Tabula Rasa Predator Types.
    /**
     * @OA\Get(
     *     path="/tabularasa/predator_type",
     *     summary="Generate a random predator type",
     *     tags={"Tabula Rasa - Inspiration"},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="predator_type",
     *                 type="string",
     *                 description="The generated predator type"
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/tabularasa/predator_type', Predator::class);
// Tabula Rasa Disciplines.
    /**
     * @OA\Get(
     *     path="/tabularasa/discipline/{clan}",
     *     summary="Generate a random discipline based on clan",
     *     tags={"Tabula Rasa - Inspiration"},
     *     @OA\Parameter(
     *         name="clan",
     *         in="path",
     *         description="The clan to generate discipline from.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={
     *                  "Banu Haqim", "Brujah", "Gangrel", "Hecata", "Lasombra",
     *                  "Malkavian", "Ministry", "Nosferatu", "Ravnos", "Salubri",
     *                  "Toreador", "Tremere", "Tzimisce", "Ventrue", "Caitiff"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="clan",
     *                 type="string",
     *                 description="This Discipline is 'in-clan' for this Clan, which may differ from the input."
     *             ),
     *             @OA\Property(
     *                 property="discipline",
     *                 type="string",
     *                 description="The generated discipline"
     *             )
     *         )
     *     )
     * )
     */
    $app->get('/tabularasa/discipline/{clan}', Disciplines::class);

};
