<?php

/**
 * @OA\Info(
 *   title="OpenAPI Docs for VampyreBytes's Fifth Edition Vampire: the Masquerade API. -- Compatible with V5",
 *   description="This product was created under the Dark Pack license.",
 *   version="1.0.2",
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

// Name Generator
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
     *             default="full",
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
     *     tags={"Generators", "NPCs"},
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
     *     tags={"Generators", "NPCs"},
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
     *     tags={"Generators", "NPCs"},
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
     *     tags={"Generators", "NPCs"},
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
     *     tags={"Generators", "NPCs"},
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

    /**
     * @OA\Get(
     *     path="/npc",
     *     summary="Generate a single NPC with randomized name, gender, physical descriptions, blood resonance, and voice",
     *     tags={"Collections", "Generators", "NPCs"},
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

};
