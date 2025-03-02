<?php

namespace Database\Factories;

use App\Models\Worksheet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class WorksheetFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Retrieve the full list of words and definitions.
        $wordList = $this->getWordList();
        $totalWords = count($wordList);

        // Determine how many schema entries to create (up to 10 or the total available words).
        $count = rand(2, min(10, $totalWords));

        // array_rand returns a single key if $count == 1, so ensure we always have an array.
        $keys = array_rand($wordList, $count);
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        // Prepare the list of words with their definitions.
        $words = [];
        foreach ($keys as $key) {
            $words[] = [
                'word' => $key,
                'definition' => $wordList[$key],
            ];
        }

        return [
            'name' => fake()->words(3, true),
            'type' => Worksheet::TYPE_WORD_MATCH,
            'schema' => collect($words)->map(function ($item, $index) {
                return [
                    'id' => Str::uuid(),
                    'word' => $item['word'],
                    'definition' => $item['definition'],
                ];
            })->toArray(),
        ];
    }

    /**
     * Returns a list of words with their definitions.
     *
     * @return array
     */
    protected function getWordList(): array
    {
        return [
            'dog' => 'A domesticated carnivorous mammal known for loyalty and companionship.',
            'cat' => 'A small, typically furry carnivorous mammal often kept as a pet.',
            'tree' => 'A perennial plant with an elongated trunk supporting branches and leaves.',
            'castle' => 'A large fortified building or group of buildings with thick walls.',
            'ocean' => 'A vast expanse of salt water covering a significant portion of the earth.',
            'mountain' => 'A large natural elevation of the earth’s surface rising abruptly from its surroundings.',
            'river' => 'A natural watercourse flowing towards an ocean, sea, lake, or another river.',
            'forest' => 'A large area dominated by trees and undergrowth.',
            'bird' => 'A warm-blooded egg-laying vertebrate distinguished by feathers and flight.',
            'flower' => 'The reproductive structure of a plant, often colorful and fragrant.',
            'book' => 'A set of written, printed, or blank pages fastened together along one side.',
            'computer' => 'An electronic device for storing and processing data according to instructions.',
            'phone' => 'A device that converts sound into electrical signals for communication.',
            'car' => 'A road vehicle, typically with four wheels, used for transporting passengers.',
            'bicycle' => 'A human-powered vehicle with two wheels, propelled by pedaling.',
            'train' => 'A series of connected vehicles that travel on railways to transport people or goods.',
            'airplane' => 'A powered flying vehicle with fixed wings.',
            'boat' => 'A small vessel designed for traveling on water.',
            'house' => 'A building designed for human habitation.',
            'garden' => 'A piece of ground used for cultivating flowers, vegetables, or other plants.',
            'city' => 'A large and densely populated urban area.',
            'country' => 'A nation with its own government, occupying a particular territory.',
            'desert' => 'A barren area with little precipitation and sparse vegetation.',
            'sky' => 'The expanse of air over any given point on the earth.',
            'cloud' => 'A visible mass of condensed water vapor floating in the atmosphere.',
            'rain' => 'Water droplets that fall from clouds as precipitation.',
            'snow' => 'Frozen water vapor in the form of ice crystals that fall from the sky.',
            'wind' => 'The natural movement of air relative to the surface of the earth.',
            'fire' => 'The rapid oxidation of a material in the exothermic chemical process of combustion.',
            'earth' => 'The planet on which we live, or the soil that covers its surface.',
            'water' => 'A clear, tasteless liquid essential for all known forms of life.',
            'gold' => 'A yellow precious metal often used in jewelry and decoration.',
            'silver' => 'A shiny white precious metal valued for its luster and conductivity.',
            'copper' => 'A reddish-brown metal used in electrical wiring and plumbing.',
            'iron' => 'A strong, hard magnetic metal used to make tools and construction materials.',
            'stone' => 'A small piece of rock or mineral.',
            'diamond' => 'A precious gemstone known for its exceptional hardness and brilliance.',
            'ruby' => 'A precious gemstone of a deep red color.',
            'sapphire' => 'A precious gemstone, typically blue, known for its beauty.',
            'emerald' => 'A precious gemstone renowned for its rich green color.',
            'pearl' => 'A smooth, rounded gem produced within the soft tissue of a living shelled mollusk.',
            'marble' => 'A metamorphic rock prized for its beauty and used in sculpture and architecture.',
            'quartz' => 'A hard, crystalline mineral composed of silicon dioxide.',
            'granite' => 'A common, hard igneous rock used in construction and monuments.',
            'limestone' => 'A sedimentary rock mainly composed of calcium carbonate from marine organisms.',
            'chalk' => 'A soft, white, porous sedimentary rock used for writing on blackboards.',
            'paper' => 'A thin material produced by pressing together moist fibers, used for writing or printing.',
            'pen' => 'A writing instrument that dispenses ink to mark a surface.',
            'pencil' => 'A tool for writing or drawing, typically consisting of graphite encased in wood.',
            'ink' => 'A colored fluid used for writing, drawing, or printing.',
            'brush' => 'An implement with bristles used for cleaning, painting, or grooming.',
            'canvas' => 'A heavy-duty fabric used as a surface for painting.',
            'painting' => 'The practice or art of applying paint to a surface to create an image.',
            'sculpture' => 'The art of creating three-dimensional forms by carving, modeling, or assembling materials.',
            'violin' => 'A string instrument played with a bow, known for its expressive tone.',
            'piano' => 'A large keyboard instrument that produces sound by striking strings with hammers.',
            'guitar' => 'A fretted musical instrument with typically six strings, played by strumming or plucking.',
            'drum' => 'A percussion instrument sounded by striking a membrane with sticks or hands.',
            'flute' => 'A woodwind instrument that produces sound from the flow of air across an opening.',
            'trumpet' => 'A brass instrument known for its bright, penetrating sound.',
            'saxophone' => 'A woodwind instrument made of brass, played with a single-reed mouthpiece.',
            'cello' => 'A bowed string instrument with a deep, rich tone, larger than a violin.',
            'harp' => 'A large, multi-stringed musical instrument played by plucking the strings.',
            'microphone' => 'An instrument that converts sound waves into electrical signals for amplification.',
            'speaker' => 'A device that converts electrical signals into audible sound.',
            'radio' => 'A device for receiving or transmitting radio broadcasts.',
            'television' => 'An electronic system for transmitting visual images and sound to a receiver.',
            'film' => 'A medium for recording and reproducing moving images, or the art form associated with it.',
            'camera' => 'A device for capturing images, either as still photographs or moving images.',
            'photograph' => 'An image created by capturing light on a light-sensitive surface.',
            'picture' => 'A visual representation of a person, scene, or object, typically produced on a surface.',
            'mirror' => 'A reflective surface, usually made of glass coated with a metal amalgam.',
            'clock' => 'A device used to measure and indicate the passage of time.',
            'watch' => 'A small timepiece worn on the wrist or carried in a pocket.',
            'calendar' => 'A system for organizing days for social, religious, or administrative purposes.',
            'map' => 'A diagrammatic representation of an area of land or sea, showing physical features.',
            'globe' => 'A spherical representation of the earth or another celestial body.',
            'planet' => 'A celestial body orbiting a star, large enough to be rounded by its own gravity.',
            'star' => 'A luminous celestial body made of plasma that emits light and heat.',
            'comet' => 'A celestial object composed of ice, dust, and rock that displays a visible coma.',
            'asteroid' => 'A small rocky body orbiting the sun, often found in the asteroid belt.',
            'meteor' => 'A small body from space that burns upon entering the earth’s atmosphere.',
            'galaxy' => 'A vast collection of stars, gas, dust, and dark matter bound together by gravity.',
            'universe' => 'The totality of space, time, matter, and energy that exists.',
            'theory' => 'A well-substantiated explanation of some aspect of the natural world, based on evidence.',
            'science' => 'The systematic study of the structure and behavior of the physical and natural world.',
            'art' => 'The expression or application of creative skill and imagination, typically in a visual form.',
            'literature' => 'Written works, especially those considered to have artistic or intellectual value.',
            'poetry' => 'Literary work in which the expression of feelings and ideas is given intensity through rhythmic language.',
            'drama' => 'A composition in which conflicts are portrayed through dialogue and performance.',
            'comedy' => 'A genre of literature or performance intended to be humorous or amusing.',
            'tragedy' => 'A serious drama that typically involves the downfall of a noble character.',
            'mystery' => 'A genre dealing with the solution of a crime or the unraveling of secrets.',
            'history' => 'A record or account of past events and times.',
            'geography' => 'The study of the physical features of the earth and its atmosphere.',
            'biology' => 'The science that studies living organisms and their life processes.',
            'chemistry' => 'The branch of science concerned with the properties, composition, and reactions of matter.',
            'physics' => 'The natural science that studies matter, energy, and the interactions between them.',
            'mathematics' => 'The abstract science of number, quantity, and space.',
            'algorithm' => 'A set of rules or processes to be followed in calculations or problem-solving.'
        ];
    }

}
