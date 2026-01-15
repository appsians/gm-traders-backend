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



/**
 * Check plant health - returns "Healthy" or "Unhealthy"
 */
private function checkPlantHealth($imageBase64)
{
    $instructionPrompt = <<<PROMPT
    Look at the image and determine whether the plant is healthy or unhealthy.
    If the plant shows any signs of disease, pests, or abnormal appearance, respond with exactly one word: Unhealthy.
    If the plant looks normal and healthy, respond with exactly one word: Healthy.
    Do not add any explanations or extra text—only respond with one word.
PROMPT;

    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o', // Using gpt-4o as gpt-5.2 may not be available
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $instructionPrompt],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => "data:image/jpeg;base64,{$imageBase64}",
                            ],
                        ],
                    ],
                ],
            ],
            'max_tokens' => 100,
        ]);

        // Handle response - check if it's an object or array
        if (is_object($response)) {
            $output = $response->choices[0]->message->content ?? '';
        } else {
            $output = $response['choices'][0]['message']['content'] ?? '';
        }

        return trim($output);
    } catch (\Throwable $e) {
        \Log::error('OpenAI API Error in checkPlantHealth', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
        throw $e;
    }
}

/**
 * Detailed plant diagnosis - returns full diagnostic report
 */
private function diagnosePlant($imageBase64)
{
    $instructionPrompt = <<<PROMPT
    You are a plant disease expert. Analyze the image and provide diagnosis in this EXACT format. Copy this structure precisely:
    **Disease Identified:** [Disease Name] (likely [Alternative Name if applicable])
    Based on the image, the leaves show [describe visible symptoms]. This fungal disease is caused by [pathogen name] species and spreads during [conditions].
    
    **Symptoms You Can See**
    • [Specific symptom 1 - be detailed about color, shape, location]
    • [Specific symptom 2 - describe progression or pattern]
    • [Specific symptom 3 - mention affected plant parts]
    • [Specific symptom 4 - note any secondary effects]
    
    **Treatment (Pesticides/Fungicides)**
    CRITICAL: Different diseases require different numbers of treatments. DO NOT default to 3 treatments.
    - Some diseases are effectively managed with just 2 treatments
    - Other diseases may require 4, 5, or even more treatments for proper control
    - Base your decision on the SPECIFIC disease identified, not on a pattern
    First, determine how many treatments are appropriate for THIS disease, then list them.
    For each treatment, use this format:
    **[Number]. [Pesticide/Fungicide Name] [X]% [Formulation Type]**
    • **Dose:** [X] ml per litre of water (or g per litre)
    • [Brief note about effectiveness or usage]
    
    **How to Use (Spray Program)**
    Follow this schedule for fast control:
    Create a spray program that matches the number of treatments you listed above. Each step shows WHEN to spray (timing), not the spray interval.
    Format each step showing the application timing:
    **Step [Number] ([Timing - when to apply this spray])**
    • Spray **[Pesticide/Fungicide Name]** ([dose])
    The timing shows when to apply each spray (e.g., Immediate, After X days). The spray interval (how often to repeat) is already listed in the Treatment section above.
    The X X days should be generic use your thinking so we can use treatement accordingly like 1,2,3,4 ... etc should be generic
    Format: Put step header on one line, spray instruction on next line, blank line between steps.
    
    **Extra Tips for Prevention**
    • [Specific prevention tip 1 - e.g., "Remove severely infected leaves from the orchard"]
    • [Specific prevention tip 2 - e.g., "Avoid water standing on leaves"]
    • [Specific prevention tip 3 - e.g., "Maintain proper pruning for air circulation"]
    • [Specific prevention tip 4 - e.g., "Spray Bordeaux mixture 1% in winter after pruning"]
    
    ---
    CRITICAL FORMATTING REQUIREMENTS:
    4. Start with "**Disease Identified:**" (if diseased) or "**Plant Health Status:**"
    5. Add blank line after disease name, then 2-3 sentence explanation
    6. Use " **Symptoms You Can See**" with blank line before bullets
    7. Use " **Treatment (Pesticides/Fungicides)**" with blank line before numbered items
    8. CRITICAL: Determine the appropriate number of treatments for THIS SPECIFIC disease - DO NOT default to 3!
    9. The number of treatments should vary: some diseases need 2, others need 4, 5, or more
    10. Each treatment MUST have: Number, Name, %, Formulation on first line in bold
    11. Each treatment MUST have blank line, then bullets for Dose and other details
    12. Use " **How to Use (Spray Program)**" with "Follow this schedule for fast control:"
    13. CRITICAL: Create spray program steps that EXACTLY MATCH the number of treatments (not always 3!)
    14. Each spray step MUST be formatted as:
      **Step X (Timing)**
      • Spray **Name** (dose)
      This means the step header is on one line, then you press ENTER to create a new line, then add the bullet point.
      DO NOT put the step header and bullet on the same line!
    15. Use " **Extra Tips for Prevention**" with blank line before bullets
    16. Maintain exact spacing and blank lines as shown in template
    17. Each step in the spray program MUST have a line break between the step number and the bullet point
    18. REMINDER: Different diseases = different treatment counts. Think about what THIS disease needs!
PROMPT;

    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o', // Using gpt-4o as gpt-5.2 may not be available
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $instructionPrompt],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => "data:image/jpeg;base64,{$imageBase64}",
                            ],
                        ],
                    ],
                ],
            ],
            'max_tokens' => 2500,
        ]);

        // Handle response - check if it's an object or array
        if (is_object($response)) {
            $output = $response->choices[0]->message->content ?? '';
        } else {
            $output = $response['choices'][0]['message']['content'] ?? '';
        }

        return trim($output);
    } catch (\Throwable $e) {
        \Log::error('OpenAI API Error in diagnosePlant', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
        throw $e;
    }
}

/**
 * Main pipeline: Check health first, then diagnose if unhealthy
 */
public function analyzeImage(Request $request)
{
    $validator = Validator::make($request->all(), [
        'image' => 'required|image|max:15360',
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

    try {
        // Step 1: Check health
        $healthStatus = $this->checkPlantHealth($imageBase64);
        
        \Log::info('Health Check Result', ['status' => $healthStatus]);

        // Step 2: Only call diagnose_plant if unhealthy
        if (strtolower(trim($healthStatus)) === 'unhealthy') {
            \Log::info('Plant is unhealthy. Performing detailed diagnosis...');
            
            $detailedReport = $this->diagnosePlant($imageBase64);
            
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $detailedReport,
                'health_status' => $healthStatus
            ], 200);
        } else {
            // Plant is healthy
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => 'The plant is healthy. No further diagnosis needed.',
                'health_status' => $healthStatus
            ], 200);
        }
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


