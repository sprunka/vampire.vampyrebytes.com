<?php

namespace VampireAPI\Generate;

use Faker\Factory;
use Faker\Generator as Generator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;

class PhysicalDescription extends AbstractRoute
{
    protected Generator $faker;

    public function __construct(Factory $faker)
    {
        $this->faker = $faker::create();
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $skinToneChoices = [
            'porcelain',
            'fair',
            'light',
            'light olive',
            'olive',
            'medium',
            'tan',
            'caramel',
            'dark',
            'deep',
            'ebony',
            'pale',
            'peaches and cream',
            'rosy',
            'ruddy',
            'freckled',
            'sun-kissed',
            'tawny',
            'bronzed',
            'golden',
            'amber',
            'chestnut',
            'mahogany',
            'coffee',
            'espresso'
        ];
        $hairColorChoices = [
            'black',
            'brown',
            'dark brown',
            'light brown',
            'dirty blonde',
            'blonde',
            'golden blonde',
            'platinum blonde',
            'strawberry blonde',
            'red',
            'auburn',
            'chestnut',
            'mahogany',
            'copper',
            'russet',
            'bronze',
            'silver',
            'gray',
            'white',
            'salt and pepper',
            'pastel pink',
            'hot pink',
            'fuchsia',
            'lavender',
            'purple',
            'violet',
            'indigo',
            'blue',
            'navy blue',
            'teal',
            'mint green',
            'lime green',
            'emerald green',
            'forest green',
            'olive green',
            'yellow',
            'golden',
            'orange',
            'peach',
            'coral',
            'apricot',
            'caramel',
            'chocolate',
            'mocha',
            'honey',
            'beige',
            'dyed black',
            'dyed brown',
            'dyed blonde',
            'dyed red',
            'dyed purple',
        ];
        $facialFeaturesChoices = [
            'High cheekbones',
            'Deep-set eyes',
            'None',
            'Prominent eyebrows',
            'Large nose',
            'Crooked nose',
            'None',
            'Thin lips',
            'Full lips',
            'Pointed chin',
            'Square jaw',
            'Double chin',
            'Moles',
            'Freckles',
            'None',
            'Dimples',
            'Cleft chin',
            'Facial hair',
            'None',
            'Rosy cheeks',
            'None',
            'Laugh lines',
            'Wrinkles',
            'Crow\'s feet',
            'Bags under eyes',
            'Eye bags',
            'Dark circles under eyes',
            'Pierced ears',
            'Tattoos',
            'Scars',
            'Burn marks',
            'Birthmarks',
            'None',
            'None',
            'Bushy eyebrows',
            'Earlobes that stick out',
            'Widows peak',
        ];
        $noticeableMarkingChoices = [
            "Facial tattoo, nose ring",
            "None",
            "Neck tattoo, lip piercing",
            "Shoulder tattoo, belly button piercing",
            "Scar above right eyebrow, nose stud",
            "Birthmark on neck, eyebrow piercing",
            "Back tattoo, tongue piercing",
            "Chest tattoo, septum piercing",
            "Scar on chin, ear gauges",
            "None",
            "Wrist tattoo, eyebrow piercing",
            "Birthmark on hand, lip ring",
            "None",
            "Chest tattoo, belly button piercing",
            "Scar on left cheek, nose stud",
            "Back tattoo, navel piercing",
            "Wrist tattoo, tongue piercing",
            "Birthmark on forehead, ear gauges",
            "Tattoo on upper arm, septum piercing",
            "Scar on jaw, eyebrow piercing",
            "Birthmark on neck, nose ring",
            "Chest tattoo, lip piercing",
            "Scar on forehead, ear stud",
            "Back tattoo, belly button piercing",
            "None",
            "Wrist tattoo, nose ring",
            "Birthmark on forearm, tongue piercing",
            "Tattoo on bicep, eyebrow piercing",
            "Scar on nose, septum piercing",
            "Birthmark on cheek, lip ring",
            "Chest tattoo, ear gauges",
            "Scar on temple, nose stud",
            "Tattoo on shoulder, navel piercing",
            "Birthmark on chin, eyebrow piercing",
            "Wrist tattoo, ear gauges",
            "Scar on neck, lip piercing",
            "Birthmark on wrist, nose ring",
            "Back tattoo, septum piercing",
            "Tattoo on forearm, tongue piercing",
            "Birthmark on jaw, eyebrow piercing",
            "Chest tattoo, nose stud",
            "Scar on ear, lip ring",
            "Tattoo on back, belly button piercing",
            "Birthmark on forehead, septum piercing",
            "Wrist tattoo, nose stud",
            "None",
            "Scar on forehead, tongue piercing",
            "Tattoo on upper arm, ear gauges",
            "Birthmark on neck, eyebrow piercing",
            "Chest tattoo, lip ring",
            "Scar on chin, navel piercing",
            "Tattoo on chest, nose ring",
            "Birthmark on arm, eyebrow piercing",
            "Wrist tattoo, septum piercing",
            "None",
            "Scar on cheek, lip piercing",
            "Tattoo on lower back, tongue piercing",
            "Birthmark on shoulder, nose stud"
        ];
        $eyeColorChoices = [
            'Brown',
            'Hazel',
            'Amber',
            'Green',
            'Blue',
            'Gray',
            'Honey',
            'Olive',
            'Dark Brown',
            'Light Brown',
            'Light Blue',
            'Light Green',
            'Dark Green',
            'Dark Blue',
            'Black',
            'Golden Brown',
            'Dark Gray',
            'Light Gray',
            'Violet',
            'Turquoise',
            'Aqua',
            'Steel Blue',
            'Emerald Green',
            'Slate Gray',
            'Deep Blue',
            'cat eyes',
            'snake eyes',
            'spider web',
            'dragon eyes',
            'swirl',
            'holographic',
            'glitter',
            'cracked glass',
            'vampire eyes',
            'electric shock'
        ];
        $clothingStyleChoices = [
            'Casual',
            'Business casual',
            'Casual',
            'Business casual',
            'Casual',
            'Business casual',
            'Casual',
            'Business casual',
            'Formal',
            'Athletic',
            'Athletic',
            'Goth',
            'Goth',
            'Goth',
            'Goth',
            'Goth',
            'Goth',
            'Vintage',
            'Retro',
            'Punk',
            'Punk',
            'Punk',
            'Hipster',
            'Preppy',
            'Country',
            'Military Surplus',
            'Sporty',
            'Surf',
            'Skater',
            'Hip hop',
            'Rave',
            'Glam',
            'Elegant'
        ];

        // Generate!
        $apparentAge = $this->faker->numberBetween(18, 84) . ' years old.';
        $heightCM = $this->faker->numberBetween(147, 190);
        $heightIN = round($heightCM * 0.393700787);
        $weightKG = $this->faker->numberBetween(45, 100);
        $weightLB = round($weightKG * 2.20462);
        $bmi = round($weightKG / pow($heightCM / 100, 2),2);
        $build = ucwords($this->faker->randomElement($this->estimateBuild($bmi)));
        $skinTone = ucwords($this->faker->randomElement($skinToneChoices));
        $eyeColor = ucwords($this->faker->randomElement($eyeColorChoices));
        $hairColor = ucwords($this->faker->randomElement($hairColorChoices));
        $facialFeatures = ucwords($this->faker->randomElement($facialFeaturesChoices));
        $noticeableMarkings = ucfirst($this->faker->randomElement($noticeableMarkingChoices));
        $clothingStyle = ucwords($this->faker->randomElement($clothingStyleChoices));

        return [
            'age' => $apparentAge,
            'height' => $heightCM . ' cm / ' . $heightIN . ' inches.',
            'weight' => $weightKG . ' kg / ' . $weightLB . ' lbs.',
            'bmi' => $bmi,
            'build' => $build,
            'skinTone' => $skinTone,
            'eyeColor' => $eyeColor,
            'hairColor' => $hairColor,
            'facialFeatures' => $facialFeatures,
            'noticeableMarkings' => $noticeableMarkings,
            'clothingStyle' => $clothingStyle,

        ];
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        return parent::outputResponse($response, $this->generate());
    }

    private function estimateBuild(float $bmi): array
    {
        $bmis = [  'Underweight' => ['Fragile', 'Gangly', 'Lanky', 'Lean', 'Scrawny', 'Skeletal', 'Slender', 'Slight', 'Thin', 'Waif'],
            'Normal' => ['Athletic', 'Average', 'Fit', 'Healthy', 'Muscular', 'Ripped', 'Sinewy', 'Solid', 'Strong', 'Toned'],
            'Overweight' => ['Big-boned', 'Brawny', 'Broad', 'Burly', 'Chubby', 'Fleshy', 'Husky', 'Large', 'Plump', 'Stocky'],
            'Obese' => ['Bulky', 'Corpulent', 'Flabby', 'Heavyset', 'Jumbo', 'Obese', 'Overweight', 'Paunchy', 'Plethoric', 'Tubby']
        ];

        if($bmi < 18.5) {
            return $bmis['Underweight'];
        }
        if($bmi < 25) {
            return $bmis['Normal'];
        }
        if($bmi < 30) {
            return $bmis['Overweight'];
        }
        return $bmis['Obese'];
    }
}
