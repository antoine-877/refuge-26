<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Shelter;
use App\Models\Tag;
use App\Enums\Species;
use App\Http\Requests\UpdateAnimalRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AnimalController extends Controller
{
    public function index(Request $request): View
    {
        $query = Animal::query()
            ->where('is_adopted', false)
            ->orderBy('name');

        // Filtre par espèce si la valeur est connue
        $species = $request->query('espece');

        if ($species !== null) {
            $knownSpecies = collect(Species::cases())
                ->contains(fn($case) => $case->value === $species);

            if ($knownSpecies) {
                $query->where('species', $species);
            }
        }

        $animals = $query->get();

        return view('animals.index', compact('animals'));
    }

    public function show(Animal $animal): View
    {
        $animal->load(['shelter', 'tags']);

        return view('animal.show', ['animal' => $animal]);
    }

    public function create(): View
    {
        $species = Species::cases();
        $shelters = Shelter::all();
        $tags = Tag::all();

        return view('animals.create', compact(
            'species',
            'shelters',
            'tags'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],

            'species' => [
                'required',
                Rule::enum(Species::class),
            ],

            'shelter_id' => [
                'required',
                'integer',
                'exists:shelters,id',
            ],

            'birth_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'tags' => ['nullable', 'array'],

            'tags.*' => [
                'integer',
                'exists:tags,id',
            ],
        ]);

        // Récupère les tags séparément
        $tagIds = $validated['tags'] ?? [];

        unset($validated['tags']);

        // Crée l'animal dans la base de données
        $animal = Animal::create($validated);

        // Associe les tags à l'animal
        $animal->tags()->sync($tagIds);

        // Redirige vers la fiche de l'animal créé
        return redirect()
            ->route('animals.show', $animal->id)
            ->with('success', 'L\'animal a été ajouté.');
    }

    public function edit(Animal $animal): View
    {
        return view('animal.edit', [
            'animal' => $animal,
            'species' => Species::cases(),
            'tags' => Tag::all(),
        ]);
    }

    public function update(UpdateAnimalRequest $request, Animal $animal): RedirectResponse
    {
        $validated = $request->validated();

        $tagIds = $validated['tags'] ?? [];

        unset($validated['tags']);

        $animal->update($validated);

        $animal->tags()->sync($tagIds);

        return redirect()
            ->route('animal.show', $animal)
            ->with('status', "L'animal a été modifié.");
    }

    public function adopt(Animal $animal): RedirectResponse
    {
        if (!$animal->isAdopted()) {
            $animal->adopted_at = today();
            $animal->save();
        }
        return redirect()
            ->route('animal.show', $animal)
            ->with('status', "{$animal->name} a trouvé une famille.");
    }

    public function destroy(Animal $animal): RedirectResponse
    {
        $animal->delete();

        return redirect()
            ->route('animal.index')
            ->with('status', "L'animal a été supprimé.");
    }
}
