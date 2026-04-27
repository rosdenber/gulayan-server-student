<?php

namespace App\Http\Controllers;

use App\Models\PlantModel;
use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PlantController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    try {
      $perPage = $request->query('per_page', 15);
      $plants = PlantModel::paginate($perPage);

      return response()->json([
        'message' => 'Plant records retrieved successfully',
        'data' => $plants,
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Failed to retrieve plant records',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    try {
      // Validate the incoming request
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'variety' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'date_planted' => 'required|date',
        'seedling_count' => 'required|integer|min:1',
        'batch_name' => 'required|string|max:255',
        'starting_fund' => 'required|numeric|min:0',
        'seedling_source' => 'required|string|max:255',
      ]);

      // Create and save the new plant record
      $plant = PlantModel::create($validated);

      // Return success response with the created plant
      return response()->json([
        'message' => 'Plant record created successfully',
        'data' => $plant,
      ], 201);

    } catch (ValidationException $e) {
      // Return validation errors
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      // Return error response
      return response()->json([
        'message' => 'Failed to create plant record',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(PlantModel $plantController)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, PlantModel $plantController)
  {
    //TODO : implement update record functionality
    try {
      // Validate the incoming request (all fields optional for partial updates)
      $validated = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'variety' => 'sometimes|required|string|max:255',
        'notes' => 'nullable|string',
        'date_planted' => 'sometimes|required|date',
        'seedling_count' => 'sometimes|required|integer|min:1',
        'batch_name' => 'sometimes|required|string|max:255',
        'starting_fund' => 'sometimes|required|numeric|min:0',
        'seedling_source' => 'sometimes|required|string|max:255',
      ]);

      // Update the plant record with validated data
      $plantController->update($validated);

      // Return success response with the updated plant
      return response()->json([
        'message' => 'Plant record updated successfully',
        'data' => $plantController,
      ], 200);

    } catch (ValidationException $e) {
      // Return validation errors
      return response()->json([
        'message' => 'Validation failed',
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      // Return error response
      return response()->json([
        'message' => 'Failed to update plant record',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PlantModel $plant)
  {
    try {
      $plant->delete();

      return response()->json([
        'message' => 'Plant record deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Failed to delete plant record',
        'error' => $e->getMessage(),
      ], 500);
    }
  }
}
