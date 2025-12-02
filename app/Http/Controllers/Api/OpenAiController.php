<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use OpenAI\Laravel\Facades\OpenAI;


class OpenAiController extends Controller
{




public function analyffzeImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|',
         [
        'image.unique' => 'fruit_id already exists, please enter a new one.',
    ]
    ]);





    if ($validate->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }


    // Convert uploaded image to Base64
    $image = base64_encode(file_get_contents($request->file('image')->getRealPath()));

    // Define the AI prompt
//     $prompt = <<<PROMPT
// You are an agriculture AI expert.
// Analyze the uploaded plant or fruit image and return the result strictly in JSON format with these keys:
// {
//   "name": "Plant or Fruit name",
//   "scientific_name": "Scientific name",
//   "health_risk": "Low / Medium / High - short reason",
//   "estimated_yield": "approx yield in kg or pieces per plant",
//   "health_score": "0-100",
//   "spray_need": "what spray needed or none",
//   "irrigation_need": "how much water needed today"
// }
// PROMPT;

    // Send to OpenAI
    $response = OpenAI::chat()->create([
        'model' => 'gpt-4o-mini',
        'messages' => [
            [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => $prompt],
                    [
                        'type' => 'image_url',
                        'image_url' => [
                            'url' => "data:image/jpeg;base64,{$image}",
                        ],
                    ],
                ],
            ],
        ],
    ]);

    // Extract only the assistant's JSON output (not full API response)
    $output = $response['choices'][0]['message']['content'] ?? null;

    // Try to decode the JSON returned by GPT
    $decoded = json_decode($output, true);

    // If GPT didnâ€™t return valid JSON, return as-is
    if (json_last_error() !== JSON_ERROR_NONE) {
        return response()->json(['error' => 'Invalid JSON format', 'raw_output' => $output], 200);
    }

    // âœ… Return your clean, structured design
    return response()->json($decoded, 200);
}


// public function analyzeImage(Request $request)
// {
//         $validator = Validator::make($request->all(), [
//         'image' => 'required|image|max:15360',
//     ], [
//         'image.required' => 'Please upload an image.',
//         'image.image'    => 'The file must be a valid image.',
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'status' => false,
//             'errors' => $validator->errors(),
//         ], 422);
//     }


//     // Convert uploaded image to Base64
//     $image = base64_encode(file_get_contents($request->file('image')->getRealPath()));

//     // Define AI prompt
// //     $prompt = <<<PROMPT
// // You are an agriculture AI expert.
// // Analyze the uploaded plant or fruit image and return the result strictly in JSON format with these keys:
// // {
// //   "name": "Plant or Fruit name",
// //   "scientific_name": "Scientific name",
// //   "health_risk": "Low / Medium / High - short reason",
// //   "estimated_yield": "approx yield in kg or pieces per plant",
// //   "health_score": "0-100",
// //   "spray_need": "what spray needed or none",
// //   "irrigation_need": "how much water needed today"
// // }
// // Do not include any text, explanation, or markdown code fences (like ```json).
// // Return only raw JSON.
// // PROMPT




//  $imageBase64 = base64_encode(file_get_contents($request->file('image')->getRealPath()));

//     $prompt = <<<PROMPT
// You are a plant identification expert. Analyze the base64 image below and return a JSON response exactly in this format:
// {
//   "name": "Plant or Fruit name",
//   "scientific_name": "Scientific name",
//   "health_risk": "Low / Medium / High - short reason",
//   "estimated_yield": "approx yield in kg or pieces per plant",
//   "health_score": "0-100",
//   "spray_need": "what spray needed or none",
//   "irrigation_need": "how much water needed today"
// }
// Image (base64): {$imageBase64}
// Make sure the output is valid JSON and matches the above structure.
// Do not include any extra text, explanation, or markdown.
// PROMPT;

//     // Send to OpenAI
//     $response = OpenAI::chat()->create([
//         'model' => 'gpt-4o-mini',
//         'messages' => [
//             [
//                 'role' => 'user',
//                 'content' => [
//                     ['type' => 'text', 'text' => $prompt],
//                     [
//                         'type' => 'image_url',
//                         'image_url' => [
//                             'url' => "data:image/jpeg;base64,{$image}",
//                         ],
//                     ],
//                 ],
//             ],
//         ],
//     ]);

//     // Get only the content
//     $output = $response['choices'][0]['message']['content'] ?? '';

//     // ðŸ§¹ Remove ```json and ``` if they exist
//     $cleanedOutput = preg_replace('/```(json)?|```/', '', trim($output));

//     // Try to decode clean JSON
//     $decoded = json_decode($cleanedOutput, true);

//     if (json_last_error() !== JSON_ERROR_NONE) {
//         return response()->json([
//             'error' => 'Invalid JSON format',
//             'raw_output' => $cleanedOutput,
//         ], 200);
//     }

//     // âœ… Return your clean structured data
//  return response()->json([
//     'status' => 'true',
//     'message' => ' success',
//     'data' => $decoded
// ]);
// }

public function analyzeImage(Request $request)
{
    $validator = Validator::make($request->all(), [
        'image' => 'required|image|max:15360',
        'user_prompt' => 'nullable|string|max:5000', // optional user prompt
    ], [
        'image.required' => 'Please upload an image.',
        'image.image'    => 'The file must be a valid image.',
    ]);

    if ($validator->fails()) {
        return "Error: " . $validator->errors()->first();
    }

    // Convert uploaded image to Base64
    $imageBase64 = base64_encode(file_get_contents($request->file('image')->getRealPath()));

    // Use user-provided prompt if available, otherwise default to expert prompt
    $userPrompt = $request->input('user_prompt');
    $prompt = $userPrompt ?: <<<PROMPT
You are a certified plant pathologist with extensive expertise in diagnosing plant diseases, identifying pathogens, and recommending scientifically proven treatments. Carefully analyze the provided plant image and deliver a complete, step-by-step diagnostic report Carefully analyze the provided plant image. Deliver a **step-by-step diagnostic report** where each section starts with a **clear heading**, followed by structured details. Do **not** start with a paragraph. Your response must include:
1. Disease Identification
2. Cause of Disease
3. Symptoms Observed
4. Risk Factors
5. Treatment Plan
6. Recommended Pesticides/Fungicides
7. Prevention Strategy
Deliver the final answer in a clean, structured, and easy-to-follow format in detail.

Make the report detailed, easy-to-follow, and professional
PROMPT;

    // Send to OpenAI
    $response = OpenAI::chat()->create([
        'model' => 'gpt-4o-mini',
        'messages' => [
            [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => $prompt],
                    [
                        'type' => 'image_url',
                        'image_url' => [
                            'url' => "data:image/jpeg;base64,{$imageBase64}",
                        ],
                    ],
                ],
            ],
        ],
    ]);

      $output = $response['choices'][0]['message']['content'] ?? 'No analysis available';

    // Return as JSON with success message and code 200
    return response()->json([
        'status' => true,
        'message' => 'success',
        'data' => $output
    ], 200);
}


// smart orchar

public function calculate(Request $request)
{
    $request->validate([
        'length' => 'required|string',
        'width' => 'required|string',
    ]);

    $length = $request->length;
    $width = $request->width;

    $prompt = "
You are an expert orchard planner.

The orchard dimensions are:
- Length: {$length} feet
- Width: {$width} feet

Spacing:
- Plant to plant distance: 3 feet
- Row to row distance: 8 feet

Based on this, calculate how many plants fit.

Then create **two JSON arrays**:
1. 'trellis' — all trellis-related materials
2. 'irrigation' — all irrigation-related materials

Each object must have:
- item (string)
- category (Trellis/Irrigation)
- quantity (integer)
- unit (string)
- image (URL or placeholder path like '/images/trellis/anchor.png')

Keep it short and simple (around 4–6 items per list).
Return only valid JSON in this format:
{
  \"trellis\": [
    {\"item\": \"Anchor\", \"category\": \"Trellis\", \"quantity\": 14, \"unit\": \"units\", \"image\": \"/images/trellis/anchor.png\"}
  ],
  \"irrigation\": [
    {\"item\": \"Polyend Cap\", \"category\": \"Irrigation\", \"quantity\": 14, \"unit\": \"units\", \"image\": \"/images/irrigation/polyendcap.png\"}
  ]
}
";




//   $prompt = <<<PROMPT
// You are an expert orchard planner and estimator.
// The orchard dimensions are:
// - Length: {$length} feet
// - Width: {$width} feet
// Spacing:
// - Plant to plant distance: 3 feet
// - Row to row distance: 8 feet

// 1. Calculate the exact number of plants that can fit.
// 2. Suggest and estimate all required Trellis and Irrigation materials (anchors, posts, wires, drip lines, pumps, connectors, etc.).
// 3. Compute realistic quantities and lengths based on the orchard size and spacing.
// 4. Assign approximate unit prices in PKR and compute total cost per item.
// 5. Provide a short purpose for each item.

// Return strictly valid JSON as a list of objects, each with fields:
// - item
// - category (Trellis / Irrigation)
// - quantity
// - length_ft (if applicable)
// - unit_price_pkr
// - total_cost_pkr
// - purpose
// PROMPT;


    $response = OpenAI::chat()->create([
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a professional orchard material estimator.'],
            ['role' => 'user', 'content' => $prompt],
        ],
    ]);

    $output = $response->choices[0]->message->content;

    // 🧹 Clean UTF-8 and extract only JSON content
    $output = mb_convert_encoding($output, 'UTF-8', 'UTF-8');
    $cleaned = preg_replace('/^[^{\[]+|[^}\]]+$/', '', $output);

    // Decode JSON safely
    $data = json_decode($cleaned, true);

    // If decode fails, show raw output for debugging
    if (json_last_error() !== JSON_ERROR_NONE) {
        $data = ['raw_output' => $output, 'error' => json_last_error_msg()];
    }

    // ✅ Encode back safely to avoid malformed UTF-8
   // return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
   return response()->json([
    'status' => true,
    'message' => 'Calculation completed successfully.',
    'data' => $data
], 200, [], JSON_UNESCAPED_UNICODE);
}



// public function calculate(Request $request)
// {
//     $request->validate([
//         'length' => 'required|numeric',
//         'width' => 'required|numeric',
//     ]);

//     $length = $request->length;
//     $width = $request->width;

//     // 🔹 Main text prompt for GPT
//     $prompt = <<<PROMPT
// You are an expert orchard planner and estimator.
// The orchard dimensions are:
// - Length: {$length} feet
// - Width: {$width} feet
// Spacing:
// - Plant to plant distance: 3 feet
// - Row to row distance: 8 feet
// 1. Calculate the exact number of plants that can fit.
// 2. Suggest and estimate all required Trellis and Irrigation materials, including anchors, posts, wires, drip lines, pumps, connectors, etc.
// 3. Compute realistic quantities and lengths based on the orchard size and spacing.
// 4. Assign approximate unit prices in PKR and compute total cost per item.
// 5. Provide a short purpose for each item.

// Return strictly valid JSON, as a list of objects, each with the fields:
// - item
// - category (Trellis / Irrigation)
// - quantity
// - length_ft (if applicable)

// - purpose
// PROMPT;

//     // 🔹 Step 1: Get JSON estimate from GPT
//     $response = OpenAI::chat()->create([
//         'model' => 'gpt-4o-mini',
//         'messages' => [
//             ['role' => 'system', 'content' => 'You are a professional orchard material estimator.'],
//             ['role' => 'user', 'content' => $prompt],
//         ],
//     ]);

//     $output = $response->choices[0]->message->content;

//     // 🔹 Clean JSON (removes stray text before/after JSON)
//     $cleaned = preg_replace('/^[^{\[]+|[^}\]]+$/', '', $output);
//     $data = json_decode($cleaned, true);

//     if (!$data) {
//         $data = ['raw_output' => $output];
//     }

//     // 🔹 Step 2: Generate orchard layout image via DALL·E
//     $imagePrompt = "A detailed top-view layout plan of an orchard measuring {$length}x{$width} feet with plants spaced 3ft apart and rows spaced 8ft apart, including trellis and irrigation lines, professional diagram style.";

//     try {
//     $imageResponse = OpenAI::images()->create([
//         'model' => 'dall-e-3', // ✅ correct model name
//         'prompt' => $imagePrompt,
//         'size' => '1024x1024',
//     ]);

//     $imageUrl = $imageResponse->data[0]->url;
//     } catch (\Exception $e) {
//     // fallback to stock image if OpenAI image gen fails
//     $imageUrl = "https://source.unsplash.com/1024x1024/?orchard,irrigation,trees";}

//     // 🔹 Step 3: Return both JSON and image
//     return response()->json([
//         'status' => true,
//         'message' => 'Orchard estimation generated successfully',
//         'data' => $data,
//         'image_url' => $imageUrl,
//     ]);
// }



// public function calculate(Request $request)
// {
//     $request->validate([
//         'length' => 'required|numeric',
//         'width' => 'required|numeric',
//     ]);

//     $length = $request->length;
//     $width = $request->width;

//     // 🧮 Step 1: Get orchard estimation from GPT
//     $prompt = <<<PROMPT
// You are an expert orchard planner and estimator.
// The orchard dimensions are:
// - Length: {$length} feet
// - Width: {$width} feet
// Spacing:
// - Plant to plant distance: 3 feet
// - Row to row distance: 8 feet
// 1. Calculate the exact number of plants that can fit.
// 2. Suggest and estimate all required Trellis and Irrigation materials, including anchors, posts, wires, drip lines, pumps, connectors, etc.
// 3. Compute realistic quantities and lengths based on the orchard size and spacing.
// 4. Assign approximate unit prices in PKR and compute total cost per item.
// 5. Provide a short purpose for each item.

// Return strictly valid JSON, as a list of objects, each with the fields:
// - item
// - category (Trellis / Irrigation)
// - quantity
// - length_ft (if applicable)
// - unit_price_pkr
// - total_cost_pkr
// - purpose
// PROMPT;

//     $response = OpenAI::chat()->create([
//         'model' => 'gpt-4o-mini',
//         'messages' => [
//             ['role' => 'system', 'content' => 'You are a professional orchard material estimator.'],
//             ['role' => 'user', 'content' => $prompt],
//         ],
//     ]);

//     $output = $response->choices[0]->message->content;
//     $cleaned = preg_replace('/^[^{\[]+|[^}\]]+$/', '', $output);
//     $data = json_decode($cleaned, true);
//     if (!$data) {
//         $data = [['raw_output' => $output]];
//     }

//     // 🌿 Step 2: Generate an image for each item using DALL·E 3 (or fallback)
//     $finalData = [];
//     foreach ($data as $item) {
//         $imagePrompt = "A realistic high-quality image of {$item['item']} used in orchard setup, category: {$item['category']}.";

//         try {
//             $imageResponse = OpenAI::images()->create([
//                 'model' => 'dall-e-3', // ✅ Correct model name
//                 'prompt' => $imagePrompt,
//                 'size' => '1024x1024',
//             ]);

//             $imageUrl = $imageResponse->data[0]->url;
//         } catch (\Exception $e) {
//             // fallback to Unsplash if OpenAI fails
//             $query = urlencode($item['item'] . ', orchard, agriculture');
//             $imageUrl = "https://source.unsplash.com/1024x1024/?" . $query;
//         }

//         // add image to each item
//         $item['image_url'] = $imageUrl;
//         $finalData[] = $item;
//     }

//     // ✅ Step 3: Return the structured JSON response
//     return response()->json([
//         'status' => true,
//         'message' => 'Orchard estimation generated successfully',
//         'data' => $finalData,
//     ]);
// }


public function calhhhculate(Request $request)
{
    $request->validate([
        'length' => 'required|string',
        'width' => 'required|string',
    ]);

    $length = $request->length;
    $width = $request->width;

    $prompt = "
You are an expert smart orchard planner.

The orchard dimensions are:
- Length: {$length} feet
- Width: {$width} feet

Spacing:
- Plant to plant distance: 3 feet
- Row to row distance: 8 feet

Based on this, calculate the number of plants that can be planted.

Then suggest and estimate **all required Trellis and Irrigation materials**, including anything typically used in such an orchard setup (you decide what is needed).

For each item, provide:
1. Item name
2. Category (Trellis / Irrigation)
3. Quantity / units
4. Length (if applicable)
5. Price per unit (approximate in PKR)
6. Total cost
7. Short purpose/description

Return the result strictly in **valid JSON format**, like this:
[
  {
    \"item\": \"Anchor\",
    \"category\": \"Trellis\",
    \"quantity\": 12,
    \"length_ft\": 60,
    \"unit_price_pkr\": 500,
    \"total_cost_pkr\": 6000,
    \"purpose\": \"Used for end support in trellis system\"
  }
]
";

    $response = OpenAI::chat()->create([
        'model' => 'gpt-4o-mini', // lightweight, cost-effective
        'messages' => [
            ['role' => 'system', 'content' => 'You are a professional orchard material estimator.'],
            ['role' => 'user', 'content' => $prompt],
        ],
    ]);

    $output = $response->choices[0]->message->content;

    // clean and decode JSON output
    $cleaned = preg_replace('/^[^{\[]+|[^}\]]+$/', '', $output);
    $data = json_decode($cleaned, true);

    if (!$data) {
        $data = ['raw_output' => $output];
    }

    return response()->json($data);
}

 
}


