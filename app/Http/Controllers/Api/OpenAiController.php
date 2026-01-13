<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;


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
    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $prompt ?? 'Analyze this image'],
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

        // Handle response - check if it's an object or array
        if (is_object($response)) {
            $output = $response->choices[0]->message->content ?? null;
        } else {
            $output = $response['choices'][0]['message']['content'] ?? null;
        }
    } catch (\Throwable $e) {
        \Log::error('OpenAI API Error in analyffzeImage', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'exception_class' => get_class($e),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'error' => 'Failed to analyze image',
            'message' => config('app.debug') ? $e->getMessage() : 'An error occurred while processing your request.'
        ], 500);
    }

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

public function analyzlleImage(Request $request)
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
//     $prompt = $userPrompt ?: <<<PROMPT
// You are a certified plant pathologist with extensive expertise in diagnosing plant diseases, identifying pathogens, and recommending scientifically proven treatments. Carefully analyze the provided plant image and deliver a complete, step-by-step diagnostic report Carefully analyze the provided plant image. Deliver a **step-by-step diagnostic report** where each section starts with a **clear heading**, followed by structured details. Do **not** start with a paragraph. Your response must include:
// 1. Disease Identification
// 2. Cause of Disease
// 3. Symptoms Observed
// 4. Risk Factors
// 5. Treatment Plan
// 6. Recommended Pesticides/Fungicides
// 7. Prevention Strategy
// Deliver the final answer in a clean, structured, and easy-to-follow format in detail.

// Make the report detailed, easy-to-follow, and professional
// PROMPT;

// $prompt = $userPrompt ?: <<<PROMPT
// You are a certified plant pathologist with extensive expertise in diagnosing plant diseases, identifying pathogens, and recommending scientifically proven treatments. Carefully analyze the provided plant image.

// ### IMPORTANT HEALTH CHECK
// Before generating the report below, first determine whether the plant in the image is **HEALTHY** or **UNHEALTHY**.

// - If the plant is **HEALTHY**, return ONLY this short message:

// **Status:** Healthy  
// **Message:** No disease or infection detected. The plant looks normal and healthy.

// Do NOT generate the diagnostic report if the plant is healthy.

// - If the plant is **UNHEALTHY**, then continue with the full report below.

// ### FULL REPORT (Only if the plant is unhealthy)
// Deliver a complete, step-by-step diagnostic report. Each section must start with a clear heading. Do not start with a paragraph. Your response must include:

// 1. Disease Identification  
// 2. Cause of Disease 
//  how to recognize it

// 3. Symptoms Observed  
// 4. Risk Factors  
// 5. Treatment Plan (with spray timing and intervals)  
// 6. Recommended Fungicides/Pesticides (with dosage)  
// 7. Future Prevention Strategy (including nearby juniper control)  
// 8. Medicine Name  
// 9. Add a protectant(optional but very effective)



// Deliver the final answer in a clean, structured, and easy-to-follow format in detail.

// Make the report detailed, easy-to-follow, and professional.
// PROMPT;


$prompt = $userPrompt ?: <<<PROMPT
### :white_check_mark: IMPORTANT HEALTH CHECK
Before generating the report below, first determine whether the plant in the image is **HEALTHY** or **UNHEALTHY**.
- If the plant is **HEALTHY**, return ONLY this short message (and NOTHING else):
**Status:** Healthy
**Message:** No disease, infection, pest damage, nutrient deficiency, mechanical injury, or environmental stress detected. Leaves are intact, green, properly shaped, and structurally normal.
Do NOT generate the diagnostic report if the plant is healthy.
- If the plant is **UNHEALTHY**, then continue with the full report below.
---
### :white_check_mark: FULL REPORT (Only if the plant is unhealthy)
Deliver a complete, step-by-step diagnostic report. Each section must start with a clear heading. Do NOT start with a paragraph. Your response must include:
	1.	Identify the exact disease name.
	2.	Tell me the symptoms and cause.
	3.	Recommend the best pesticide (chemical or organic).
	4.	Give clear instructions on how to use the pesticide — mixing dose, spray interval, and precautions.
	5.	Suggest additional care or management practices to avoid this disease in the future.
Here is the image: [UPLOAD IMAGE]”
You MUST format the output EXACTLY like ChatGPT mobile style:
 Use **ALL CAPS bold titles** to simulate big headings and icons on heading .
 Example: **:mag_right: DISEASE IDENTIFICATION**
 Use blue diamond bullets (:small_blue_diamond:) .
- Use bold labels inside bullets when needed.
- Maintain clean spacing exactly
// Deliver the final answer in a clean, structured, professional, and easy-to-follow format with full technical clarity.
PROMPT;



   // Send to OpenAI
    try {
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

        // Handle response - check if it's an object or array
        if (is_object($response)) {
            $output = $response->choices[0]->message->content ?? 'No analysis available';
        } else {
            $output = $response['choices'][0]['message']['content'] ?? 'No analysis available';
        }

        // Return as JSON with success message and code 200
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $output
        ], 200);
    } catch (\Throwable $e) {
        \Log::error('OpenAI API Error in analyzlleImage', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'exception_class' => get_class($e),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Failed to analyze image. Please try again.',
            'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while processing your request.'
        ], 500);
    }
    
    
   
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


    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a professional orchard material estimator.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        // Handle response - check if it's an object or array
        if (is_object($response)) {
            $output = $response->choices[0]->message->content ?? '';
        } else {
            $output = $response['choices'][0]['message']['content'] ?? '';
        }
    } catch (\Throwable $e) {
        \Log::error('OpenAI API Error in calculate', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'exception_class' => get_class($e),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Failed to calculate orchard materials. Please try again.',
            'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while processing your request.'
        ], 500);
    }

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

    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini', // lightweight, cost-effective
            'messages' => [
                ['role' => 'system', 'content' => 'You are a professional orchard material estimator.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        // Handle response - check if it's an object or array
        if (is_object($response)) {
            $output = $response->choices[0]->message->content ?? '';
        } else {
            $output = $response['choices'][0]['message']['content'] ?? '';
        }
    } catch (\Throwable $e) {
        \Log::error('OpenAI API Error in calhhhculate', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'exception_class' => get_class($e),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'error' => 'Failed to calculate orchard materials',
            'message' => config('app.debug') ? $e->getMessage() : 'An error occurred while processing your request.'
        ], 500);
    }

    // clean and decode JSON output
    $cleaned = preg_replace('/^[^{\[]+|[^}\]]+$/', '', $output);
    $data = json_decode($cleaned, true);

    if (!$data) {
        $data = ['raw_output' => $output];
    }

    return response()->json($data);
}


// public function analyzeImage(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'image' => 'required|image|max:15360',
//         'user_prompt' => 'nullable|string|max:5000', // optional user prompt
//     ], [
//         'image.required' => 'Please upload an image.',
//         'image.image'    => 'The file must be a valid image.',
//     ]);
//     if ($validator->fails()) {
//         return "Error: " . $validator->errors()->first();
//     }
//     // Convert uploaded image to Base64
//     $imageBase64 = base64_encode(file_get_contents($request->file('image')->getRealPath()));
//     // Use user-provided prompt if available, otherwise default to expert prompt
//     $userPrompt = $request->input('user_prompt');

// $prompt = $userPrompt ?: <<<PROMPT

// IMPORTANT FIRST CHECK:
// If the image does NOT contain a plant, leaf, crop, tree, or any plant part,
// then DO NOT analyze disease and DO NOT use the formats below.

// Instead, respond ONLY with this exact message:

// **Error:** Invalid image. Please upload a plant or leaf image only.
// otherwise 

// You are a plant disease expert. Analyze the image and provide diagnosis in this EXACT format. Copy this structure precisely:
// **Disease Identified:** [Disease Name] (likely [Alternative Name if applicable])
// Based on the image, the leaves show [describe visible symptoms]. This fungal disease is caused by [pathogen name] species and spreads during [conditions].
//  **Symptoms You Can See**
// • [Specific symptom 1 - be detailed about color, shape, location]
// • [Specific symptom 2 - describe progression or pattern]
// • [Specific symptom 3 - mention affected plant parts]
// • [Specific symptom 4 - note any secondary effects]
//  **Treatment (Pesticides/Fungicides)**
// CRITICAL: Different diseases require different numbers of treatments. DO NOT default to 3 treatments.
// - Some diseases are effectively managed with just 2 treatments
// - Other diseases may require 4, 5, or even more treatments for proper control
// - Base your decision on the SPECIFIC disease identified, not on a pattern
// First, determine how many treatments are appropriate for THIS disease, then list them.
// For each treatment, use this format:
// **[Number]. [Pesticide/Fungicide Name] [X]% [Formulation Type]**
// • **Dose:** [X] ml per litre of water (or g per litre)
// • [Brief note about effectiveness or usage]
//  **How to Use (Spray Program)**
// Follow this schedule for fast control:
// Create a spray program that matches the number of treatments you listed above. Each step shows WHEN to spray (timing), not the spray interval.
// Format each step showing the application timing:
// **Step [Number] ([Timing - when to apply this spray])**
// • Spray **[Pesticide/Fungicide Name]** ([dose])
// The timing shows when to apply each spray (e.g., Immediate, After X days). The spray interval (how often to repeat) is already listed in the Treatment section above.
// The X X days should be generic use your thinking so we can use treatement accordingly like 1,2,3,4 ... etc should be generic
// Format: Put step header on one line, spray instruction on next line, blank line between steps.
//  **Extra Tips for Prevention**
// • [Specific prevention tip 1 - e.g., "Remove severely infected leaves from the orchard"]
// • [Specific prevention tip 2 - e.g., "Avoid water standing on leaves"]
// • [Specific prevention tip 3 - e.g., "Maintain proper pruning for air circulation"]
// • [Specific prevention tip 4 - e.g., "Spray Bordeaux mixture 1% in winter after pruning"]
// ---
// **IF THE PLANT IS HEALTHY (NO DISEASE DETECTED):**
// Use this simplified format instead:
// **Plant Health Status:** Healthy
// The plant appears to be in good health with no visible signs of disease. The leaves show normal color, texture, and structure with no spots, lesions, discoloration, or fungal growth.
//  **General Care Tips**
// • Water properly based on plant type and season
// • Maintain good sunlight exposure for optimal growth
// • Remove dead or damaged leaves occasionally
// • Ensure proper spacing between plants for air circulation
// • Monitor regularly for early signs of disease or pests
// **DO NOT include Treatment, Spray Program, or Prevention sections if the plant is healthy!**
// ---
// CRITICAL FORMATTING REQUIREMENTS:
// 1. FIRST: Determine if the plant is diseased or healthy
// 2. If DISEASED: Use the full format above with all sections
// 3. If HEALTHY: Use ONLY the simplified healthy format (no treatments!)
// 4. Start with "**Disease Identified:**" (if diseased) or "**Plant Health Status:**" (if healthy)
// 5. Add blank line after disease name, then 2-3 sentence explanation
// 6. Use " **Symptoms You Can See**" with blank line before bullets
// 7. Use " **Treatment (Pesticides/Fungicides)**" with blank line before numbered items
// 8. CRITICAL: Determine the appropriate number of treatments for THIS SPECIFIC disease - DO NOT default to 3!
// 9. The number of treatments should vary: some diseases need 2, others need 4, 5, or more
// 10. Each treatment MUST have: Number, Name, %, Formulation on first line in bold
// 11. Each treatment MUST have blank line, then bullets for Dose and other details
// 12. Use " **How to Use (Spray Program)**" with "Follow this schedule for fast control:"
// 13. CRITICAL: Create spray program steps that EXACTLY MATCH the number of treatments (not always 3!)
// 14. Each spray step MUST be formatted as:
//   **Step X (Timing)**
//   • Spray **Name** (dose)
//   This means the step header is on one line, then you press ENTER to create a new line, then add the bullet point.
//   DO NOT put the step header and bullet on the same line!
// 15.   **Extra Tips for Prevention**" with blank line before bullets
// 16. Maintain exact spacing and blank lines as shown in template
// 17. Each step in the spray program MUST have a line break between the step number and the bullet point
// 18. REMINDER: Different diseases = different treatment counts. Think about what THIS disease needs!
// """

// PROMPT;
//     // Send to OpenAI
//     $response = OpenAI::chat()->create([
//         'model' => 'gpt-5.2',
//         'messages' => [
//             [
//                 'role' => 'user',
//                 'content' => [
//                     ['type' => 'text', 'text' => $prompt],
//                     [
//                         'type' => 'image_url',
//                         'image_url' => [
//                             'url' => "data:image/jpeg;base64,{$imageBase64}",
//                         ],
//                     ],
//                 ],
//             ],
//         ],
//     ]);
//       $output = $response['choices'][0]['message']['content'] ?? 'No analysis available';
//     // Return as JSON with success message and code 200
//     return response()->json([
//         'status' => true,
//         'message' => 'success',
//         'data' => $output
//     ], 200);
// }


public function analyzeImage(Request $request)
{
    $validator = Validator::make($request->all(), [
        'image' => 'required|image|max:15360',
        'user_prompt' => 'nullable|string|max:5000',
    ], [
        'image.required' => 'Please upload an image.',
        'image.image'    => 'The file must be a valid image.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first()
        ], 422);
    }

    // Convert image to Base64
    $imageBase64 = base64_encode(
        file_get_contents($request->file('image')->getRealPath())
    );

   
           $dbPrompt = \DB::table('prompts')->where('id', 1)->value('text');

    // Use user input if provided, otherwise DB prompt
    $userPrompt = $request->input('user_prompt');
    $prompt = $userPrompt ?: $dbPrompt;
        
//     <<<PROMPT
// YOU ARE A PROFESSIONAL AGRICULTURE, PLANT DISEASE & CROP NUTRITION EXPERT AI.

// ========================
// STEP 1 – IMAGE VALIDATION (MANDATORY)
// ========================
// First, carefully inspect the image.

// IF the image does NOT clearly contain ANY of the following:
// - Plant
// - Leaf
// - Fruit
// - Crop
// - Tree
// - Any plant part

// THEN respond with ONLY this exact text and NOTHING ELSE:

// **Error:** Invalid image. Please upload a plant or leaf image only.

// DO NOT add explanations.
// DO NOT analyze disease.
// DO NOT guess.

// ========================
// STEP 2 – PLANT IDENTIFICATION
// ========================
// If image IS agriculture-related, clearly identify:
// - Plant Category: Plant / Leaf / Fruit / Crop / Tree
// - Plant Name (common name)

// ========================
// STEP 3 – ISSUE CLASSIFICATION
// ========================
// Decide clearly whether the plant shows:
// - Disease
// - Pest attack
// - Nutrient deficiency
// - Combination of disease + nutrient stress
// - Or is Healthy

// This decision MUST be stated clearly.

// ========================
// OUTPUT FORMAT (STRICT – DO NOT CHANGE)
// ========================

// **Issue Identified:** [Disease / Pest / Nutrient Deficiency / Healthy]

// Write 2–3 sentences describing visible symptoms and overall plant condition.

//  **Plant Category**
// • Category: [Plant / Leaf / Fruit / Crop / Tree]
// • Plant Name: [Name]
// • Growth Stage (estimated): Vegetative / Flowering / Fruiting

//  **Visible Symptoms**
// • [Leaf color, spots, burns, curling, deformation]
// • [Distribution and progression]
// • [Effect on plant growth or yield]

//  **Cause Analysis**
// • Primary Cause: [Fungal / Bacterial / Viral / Pest / Nutrient imbalance]
// • Specific Cause: [Pathogen / Insect / Nutrient name]
// • Supporting Factors: [Soil, irrigation, weather, management]

// ========================



// IF DISEASE OR PEST IS PRESENT
// ========================
// Include this section ONLY if disease or pest is identified.
// ========================


// //  TREATMENT (MEDICINES) 
// // Based on the image analysis, suggest real, field-used pesticides, fungicides, or insecticides. Each chemical must be **bold**, with exact dose, purpose, and why it should be used. Include a stepwise spray program.

// // For each treatment:

// // ********** [Number]. **[Active Ingredient / Chemical Name] [X]% [Formulation]** **********
// // • Purpose: Fungicide / Insecticide / Bactericide – specify the type of control  
// // • Dose: [Exact ml or g per litre]  
// // • Why Use: Explain mode of action and reason for selection

// // ********** SPRAY PROGRAM **********
// // Provide a systematic spray sequence with the following format:

// //  STEP 1 (IMMEDIATE)
// // • Spray **[Product Name]** at [Exact Dose]  
// // • Purpose: Immediate suppression of pathogen or pest  
// // • Notes: Coverage and timing instructions

// //  STEP 2 (IMMEDIATE) 
// // • Spray **[Product Name]** at [Exact Dose]  
// // • Purpose: Reinforce initial control  
// // • Notes: Include resistance management instructions

// //     STEP 3 (IMMEDIATE) 
// // • Spray **[Product Name]** at [Exact Dose]  
// // • Purpose: Consolidate control for persistent pests/diseases  
// // • Notes: Ensure coverage on all plant parts

// //  STEP 4 (AFTER 5–7 DAYS) 
// // • Spray **[Alternate Product Name]** at [Exact Dose]  
// // • Purpose: Rotation to prevent resistance  
// // • Notes: Monitor symptoms and adjust treatment if needed


//   TREATMENT (CHEMICAL CONTROL) 

// Best fungicides (choose any ONE and rotate):

// 1. **Mancozeb 75% WP** – 2.5 to 3 g per liter of water  
// 2. **Captan 50% WP** – 2 g per liter  
// 3. **Difenoconazole 25% EC** – 0.5 ml per liter  
// 4. **Hexaconazole 5% EC** – 1 ml per liter  
// 5. **Myclobutanil 10% W** – 0.5 g per liter  

// Notes (this note is not showing in output) :  
// - Select any one product for the first spray and rotate with others in subsequent sprays to prevent resistance.  
// - Ensure complete coverage of affected leaves and stems.  
// - Follow safety precautions and manufacturer instructions.


// MANDATORY NUTRIENT STATEMENT
// ========================
// This section MUST ALWAYS be included, regardless of disease or plant health.

//  **Nutrient Status & Management**
// Explain the role and requirement of EACH nutrient clearly with each point start in next line proper grammer rule clean formate result:

// **1. Nitrogen (N)**
// // • Role: Leaf growth, chlorophyll formation
// // • Recommended Source: Urea / Calcium Nitrate
// // • Foliar Dose: 1–2 g per litre
// // • Soil Dose: As per crop requirement
// // • Reason: Supports vegetative growth and recovery

// Role:
// Dose:
// Sprays:
// Interval:
// Last Spray
// **2. Phosphorus (P)**
// // • Role: Root development, energy transfer
// // • Recommended Source: DAP / MAP
// // • Soil Application: As recommended
// // • Reason: Improves root strength and early growth

// Role:
// Dose:
// Sprays:
// Interval:
// Last Spray

// **3. Potassium (K)**
// // • Role: Stress tolerance, quality, disease resistance
// // • Recommended Source: SOP / Potassium Nitrate
// // • Foliar Dose: 1–2 g per litre
// // • Reason: Enhances resistance and yield quality

// Role:
// Dose:
// Sprays:
// Interval:
// Last Spray

// **4. Calcium (Ca)**
// // • Role: Cell wall strength, fruit firmness
// // • Recommended Source: Calcium Nitrate
// // • Foliar Dose: 1 g per litre
// // • Reason: Prevents physiological disorders

// Dose:
// Role:
// Sprays:
// Interval:
// Last Spray

// **5. Magnesium (Mg)**

// Role:
// Dose:
// Sprays:
// Interval:
// Last Spray
// // • Role: Chlorophyll formation
// // • Recommended Source: Magnesium Sulphate
// // • Foliar Dose: 2 g per litre
// // • Reason: Prevents interveinal chlorosis

// **6. Micronutrients (Zn, Fe, Mn, B)**

// Role:
// Dose:
// Sprays:
// Interval:
// Last Spray
// // • Role: Enzyme activation and metabolic balance
// // • Recommended Source: Chelated Micronutrient Mix
// // • Foliar Dose: 0.5–1 g per litre
// // • Reason: Prevents hidden hunger and deficiency symptoms





// ========================
// PREVENTION & CARE (MANDATORY)
// ========================
// This section MUST ALWAYS be included in detail .

// • Maintain balanced nutrition throughout crop cycle
// • Avoid water stress and poor drainage
// • Ensure proper spacing and air circulation
// • Remove weak or infected plant parts
// • Monitor crop weekly for early symptoms

// ========================
// FINAL RULES
// ========================
// - Nutrient section is NOT optional
// - Use clear, professional language
// - No emojis, no extra commentary
// - Explain every point clearly


// ✅ Final Rules for AI Output:

// Always use numbered headings and bold keywords.

// Grammar must be professional not show (*) in heading and clear each (.) bolat start with next line each point start in next line and bold heading  give complete line formate  .

// Include all sections,





// PROMPT;

    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o',
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
            'temperature' => 0.2,
        ]);

        // Handle response - check if it's an object or array
        if (is_object($response)) {
            $output = $response->choices[0]->message->content ?? 'No analysis available';
        } else {
            $output = $response['choices'][0]['message']['content'] ?? 'No analysis available';
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $output
        ], 200);
    } catch (\Throwable $e) {
        // Log the full error details
        \Log::error('OpenAI API Error in analyzeImage', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'exception_class' => get_class($e),
            'trace' => $e->getTraceAsString(),
            'previous' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null,
        ]);

        // Check if it's a specific OpenAI error
        $errorMessage = 'Failed to analyze image. Please try again.';
        if (config('app.debug')) {
            $errorMessage = $e->getMessage();
            // If it's the "choices" error, provide more context
            if (strpos($e->getMessage(), 'choices') !== false) {
                $errorMessage = 'OpenAI API returned an unexpected response format. This may indicate an API error, invalid API key, or quota issue.';
            }
        }

        return response()->json([
            'status' => false,
            'message' => $errorMessage,
            'error' => config('app.debug') ? [
                'message' => $e->getMessage(),
                'type' => get_class($e),
            ] : 'An error occurred while processing your request.'
        ], 500);
    }
}


 
}


