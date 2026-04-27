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
  public function index()
  {
    //TODO : implement load all the records
    //TODO : implement pagination when loading all the records
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
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(PlantModel $plant)
  {
    //TODO : implement delete record functionality
  }
}
