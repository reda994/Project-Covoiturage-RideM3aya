<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation commune (Etape 1)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:passenger,driver'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Validation additionnelle pour Conducteurs (Etapes 2 & 3)
        if ($request->role === 'driver') {
            $request->validate([
                // Etape 2 : Permis de conduire
                'license_number' => ['required', 'string', 'max:50'],
                'license_issue_date' => ['required', 'date'],
                'license_category' => ['required', 'string', 'in:A,B,C,D'],
                'license_country' => ['required', 'string', 'max:100'],
                'license_photo_recto' => ['required', 'image', 'max:5120'],
                'license_photo_verso' => ['required', 'image', 'max:5120'],
                'license_selfie' => ['required', 'image', 'max:5120'],
                
                // Etape 3 : Véhicule
                'brand' => ['required', 'string', 'max:100'],
                'model' => ['required', 'string', 'max:100'],
                'year' => ['required', 'integer', 'between:2015,2025'],
                'color' => ['required', 'string', 'max:7'],
                'seats_total' => ['required', 'integer', 'between:4,9'],
                'fuel_type' => ['required', 'string', 'in:Essence,Diesel,Electrique,Hybride'],
                'consumption' => ['nullable', 'numeric', 'between:0,30'],
                'plate_number' => ['required', 'string', 'unique:vehicles,plate_number'],
                'carte_grise' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
                'insurance' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
                'insurance_expiry' => ['nullable', 'date'],
                'vehicle_photos' => ['nullable', 'array', 'max:6'],
                'vehicle_photos.*' => ['image', 'max:5120'],
                'options' => ['nullable', 'array'],
            ]);
        }

        // Traitement et stockage des fichiers
        $license_photo_recto_path = null;
        $license_photo_verso_path = null;
        $license_selfie_path = null;
        $carte_grise_path = null;
        $insurance_path = null;
        $vehicle_photos_paths = [];

        if ($request->role === 'driver') {
            if ($request->hasFile('license_photo_recto')) {
                $license_photo_recto_path = $request->file('license_photo_recto')->store('licenses', 'public');
            }
            if ($request->hasFile('license_photo_verso')) {
                $license_photo_verso_path = $request->file('license_photo_verso')->store('licenses', 'public');
            }
            if ($request->hasFile('license_selfie')) {
                $license_selfie_path = $request->file('license_selfie')->store('licenses', 'public');
            }
            if ($request->hasFile('carte_grise')) {
                $carte_grise_path = $request->file('carte_grise')->store('vehicles/documents', 'public');
            }
            if ($request->hasFile('insurance')) {
                $insurance_path = $request->file('insurance')->store('vehicles/documents', 'public');
            }
            if ($request->hasFile('vehicle_photos')) {
                foreach ($request->file('vehicle_photos') as $photo) {
                    $vehicle_photos_paths[] = $photo->store('vehicles/photos', 'public');
                }
            }
        }

        // Création de l'utilisateur
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ];

        if ($request->role === 'driver') {
            $userData = array_merge($userData, [
                'license_number' => $request->license_number,
                'license_issue_date' => $request->license_issue_date,
                'license_category' => $request->license_category,
                'license_country' => $request->license_country,
                'license_photo_recto' => $license_photo_recto_path,
                'license_photo_verso' => $license_photo_verso_path,
                'license_selfie' => $license_selfie_path,
            ]);
        }

        $user = User::create($userData);

        // Création du véhicule si Conducteur
        if ($request->role === 'driver') {
            $user->vehicles()->create([
                'brand' => $request->brand,
                'model' => $request->model,
                'year' => $request->year,
                'color' => $request->color,
                'seats_total' => $request->seats_total,
                'fuel_type' => $request->fuel_type,
                'consumption' => $request->consumption,
                'plate_number' => $request->plate_number,
                'carte_grise' => $carte_grise_path,
                'insurance' => $insurance_path,
                'insurance_expiry' => $request->insurance_expiry,
                'photos' => $vehicle_photos_paths,
                'options' => $request->options ?? [],
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
