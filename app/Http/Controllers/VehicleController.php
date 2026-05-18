<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Requests\StoreVehicleRequest;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = auth()->user()->vehicles;
        return view('driver.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('driver.vehicles.create');
    }

    public function store(StoreVehicleRequest $request)
    {
        Vehicle::create([
            'user_id' => auth()->id(),
            'brand' => $request->brand,
            'model' => $request->model,
            'color' => $request->color,
            'plate_number' => $request->plate_number,
            'seats_total' => $request->seats_total
        ]);

        return redirect()->route('driver.vehicles.index')
            ->with('success', 'Véhicule ajouté avec succès !');
    }

    public function edit(Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);
        
        return view('driver.vehicles.edit', compact('vehicle'));
    }

    public function update(StoreVehicleRequest $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);
        
        $vehicle->update($request->validated());
        
        return redirect()->route('driver.vehicles.index')
            ->with('success', 'Véhicule modifié avec succès !');
    }

    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);
        
        $vehicle->delete();
        
        return redirect()->route('driver.vehicles.index')
            ->with('success', 'Véhicule supprimé avec succès !');
    }
}